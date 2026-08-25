import os
import pprint
import re
from mkdocs.structure.pages import Page
from mkdocs.utils import meta
from typing import List

def _absolute_page_url(scheme, site, language, version, *parts):
    return scheme + '://' + '/'.join((site, language, version) + parts)


CARDS_TEMPLATE = """
<div class="card-wrapper">
    <div>
        <a href="%s" class="card">
            <div>
                <p class="title">%s</p>
                <p class="description">%s</p>
            </div>
        </a>
    </div>
</div>
"""


def define_env(env):
    """
    This is the hook for defining variables, macros and filters

    - variables: the dictionary that contains the environment variables
    - macro: a decorator function, to declare a macro.
    """

    @env.macro
    def include_file(filename, start_line=0, end_line=None, glue='', remove_indent=False):
        """
        DEPRECATED: Use include_code instead.
        Include a file,
        optionally indicating start_line and end_line (start counting from 0)
        optionally set a glue string to lead every string except the first one (can be used for indent)
        optionally remove common leading whitespace from all lines (remove_indent=True)
        The path is relative to the top directory of the documentation
        project.
        """
        full_filename = os.path.join(env.project_dir, filename)
        with open(full_filename, 'r') as f:
            lines = f.readlines()
        line_range = lines[start_line:end_line]

        if remove_indent:
            non_empty = [l for l in line_range if l.strip()]
            if non_empty:
                indent = min(len(l) - len(l.lstrip()) for l in non_empty)
                line_range = [l[indent:] if l.strip() else l for l in line_range]

        return glue.join(line_range)

    @env.macro
    def include_code(file_path, start_line=1, end_line=None, indent_level=0, remove_indent=False):
        """
        Include a file
        file_path (string): The path to the file from project root
        start_line (int): The line number to start including from (start counting from 1) - default is 1 (include first line)
        end_line (int or None): The line number to end including to. If None, include until the end of the file - default is None (include end of file)
        indent_level (int): The number of indent (4 spaces) to add to the beginning of each line - default is 0 (no indent added).
        remove_indent (bool): Whether to remove absolute indent, the maximum of leading whitespaces without breaking relative indent - default is False (no indent removed)
        """
        return include_file(file_path, start_line-1, end_line, '    ' * indent_level, remove_indent).rstrip()

    @env.macro
    def cards(pages, columns=1, style="cards", force_version=False):
        current_page = env.variables.page
        canonical = current_page.canonical_url
        url_parts = re.search(r"^(https?)://([^/]+)/([^/]+)/([^/]+)/", canonical)
        (scheme, site, language, version) = url_parts.groups()

        version = force_version or version
        version = os.getenv("READTHEDOCS_VERSION_NAME", version)

        rtd_canonical = os.getenv("READTHEDOCS_CANONICAL_URL", "")
        if rtd_canonical:
            rtd_domain = re.search("//([^/]+)/", rtd_canonical)
            if rtd_domain:
                site = rtd_domain.group(1)

        if isinstance(pages, str):
            pages = [pages]
        variables = env.conf.get('extra', {})
        var_start = env.config['j2_variable_start_string']
        var_end = env.config['j2_variable_end_string']
        cards = []
        for page_data in pages:
            if isinstance(page_data, tuple):
                page, custom_title, custom_description = page_data
            else:
                page = page_data
                custom_title = None
                custom_description = None

            path, hash = page.split("#") if "#" in page else (page, "")
            if hash:
                hash = '#' + hash

            is_external = path.startswith(("http://", "https://"))
            if is_external or path.endswith(".html"):
                if not (custom_title and custom_description):
                    raise ValueError(
                        "cards(): card %r must supply a title and a description - only "
                        "Markdown pages carry front matter to read them from." % path
                    )
                href = page if is_external else _absolute_page_url(
                    scheme, site, language, version, page
                )
                title = custom_title
                description = custom_description
            else:
                path = path.rstrip('/')
                content = open("docs/%s.md" % path, "r").read()
                match = re.search("^# (.*)", content, re.MULTILINE)
                current_meta = {
                    "title": match.groups()[0] if match else "",
                    "short": "",
                    "description": "",
                    **meta.get_data(content)[1],
                }
                href = _absolute_page_url(scheme, site, language, version, path, hash)
                title = custom_title or current_meta['short'] or current_meta['title']
                description = custom_description or current_meta['description'] or "&nbsp;"
                title = resolve_variables(title, var_start, var_end, variables)
                description = resolve_variables(description, var_start, var_end, variables)

            cards.append(
                CARDS_TEMPLATE % (
                    href,
                    title,
                    description
                )
            )

        return """<div class="%s col-%s">%s</div>""" % (style, columns, "\n".join(cards))

    @env.macro
    def version_to_anchor(version : str = '') -> str:
        return version.replace('.', '')

    @env.macro
    def release_notes_filters(header : str, categories : List[str]) -> str:
        validate_categories(categories)

        filters = "".join(
            ["""
            <div 
                class="release-notes-filters__visible-item release-notes-filters__visible-item--hidden" 
                data-filter="filter-{category_slug}"
            >
                {category}
                <button type="button" class="release-notes-filters__visible-item-remove"></button>
            </div>
            """.format(category_slug=slugify(category), category=category) for category in categories])
        
        categories_dropdown = "".join(
            ["""
                <div class="release-notes-filters__item">
                    <input type="checkbox" id="filter-{category_slug}" />
                    <label for="filter-{category_slug}">{category}</label>
                </div>
             """.format(category_slug=slugify(category), category=category) for category in categories]
        )

        return """
<div class="release-notes-header">
    <h1>{header}</h1>
    <div class="release-notes-filters">
        <div class="release-notes-filters__visible-items">
            {visible_filters}
        </div>
        <div class="release-notes-filters__widget">
            <button type="button" class="release-notes-filters__btn">
                <span class="release-notes-filters__btn-icon">
                    <svg width="16" height="16"><use xlink:href="../../images/icons.svg#filters" /></svg>
                </span>
                Filters
            </button>
            <div class="release-notes-filters__items">
                {categories_dropdown}
            </div>
        </div>
    </div>
</div>
        """.format(header=header, visible_filters=filters, categories_dropdown=categories_dropdown)

    @env.macro
    def release_note_entry_begin(header : str, date: str, categories : List[str]) -> str:
        validate_categories(categories)

        category_badges = "".join(
            [
                """
<div class="pill pill--{category_slug}" data-filter="{category_slug}"></div>
                """.format(category_slug=slugify(category), category=category) 
                for category in categories
            ]
        )

        return """
<div class="release-note" markdown="1">
## {header}
<div class="release-note__tags">
{category_badges}
</div>
<div class="release-note__date">{date}</div>
""".format(header=header, date=date, category_badges=category_badges)

    @env.macro
    def release_note_entry_end() -> str:
        return "</div>"

    def resolve_variables(text, var_start, var_end, variables):
        """Replace variable references (e.g. [[= var =]]) with variables."""
        pattern = re.escape(var_start) + r'\s*([\w.]+)\s*' + re.escape(var_end)
        def replacer(match):
            key = match.group(1).strip()
            if key not in variables:
                raise KeyError("Undefined variable '%s' used in cards macro" % key)
            return str(variables[key])
        return re.sub(pattern, replacer, text)

    def slugify(text: str) -> str:
        return text.lower().replace(' ', '-')

    def validate_categories(categories: List[str]) -> None:
        available_categories = ['Headless', 'Experience', 'Commerce', 'LTS Update', 'New feature', 'First release']

        for category in categories:
            if category not in available_categories:
                raise ValueError(
                    "Unknown category: {category}. Available categories are: {available_categories}".format(category=category, available_categories=" ".join(available_categories))
                    )


def on_pre_page_macros(env):
    """
    Resolve variable references in the page's description front matter field
    so that they are substituted before MkDocs renders the <meta> tag.
    """
    page = env._page
    if page.meta and 'description' in page.meta:
        page.meta['description'] = env.render(
            markdown=page.meta['description'],
            force_rendering=True
        )
