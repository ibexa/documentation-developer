import os
import pprint
import re
import urllib.request
from mkdocs.structure.pages import Page
from mkdocs.utils import meta

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
    def include_file(filename, start_line=0, end_line=None, glue=''):
        """
        Include a file,
        optionally indicating start_line and end_line (start counting from 0)
        optionally set a glue string to lead every string except the first one (can be used for indent)
        The path is relative to the top directory of the documentation
        project.
        """
        full_filename = os.path.join(env.project_dir, filename)
        with open(full_filename, 'r') as f:
            lines = f.readlines()
        line_range = lines[start_line:end_line]
        return glue.join(line_range)

    @env.macro
    def cards(pages, columns=1, style="cards", force_version=False):
        current_page = env.variables.page
        absolute_url = current_page.abs_url
        canonical = current_page.canonical_url
        url_parts = re.search("//([^/]+)/([^/]+)/([^/]+)/", canonical)
        (site, language, version) = url_parts.groups()
        version = force_version or version

        if isinstance(pages, str):
            pages = [pages]
        cards = []
        for page in pages:
            match = re.search("https://[^@/]+.ibexa.co", page)
            if match:
                with urllib.request.urlopen(page) as file:
                    content = file.read().decode('utf-8')
                    match = re.search("<meta property=\"og:title\" content=\"(.*)\"", content, re.MULTILINE)
                    if match:
                        title = match.groups()[0]
                    else:
                        title = ""
                    match = re.search("<meta property=\"og:description\" content=\"(.*)\"", content, re.MULTILINE)
                    if match:
                        description = match.groups()[0]
                    else:
                        description = ""
                    href = page
            else:
                with open("docs/%s.md" % page, "r") as doc_file:
                    doc = doc_file.read()
                    match = re.search("^# (.*)", doc, re.MULTILINE)
                    if match:
                        header = match.groups()[0]
                    else:
                        header = ""
                    default_meta = {
                        "title": header,
                        "short": "",
                        "description": ""
                    }
                    doc_meta = {
                        **default_meta,
                        **meta.get_data(doc)[1]
                    }
                    href = '/'.join((
                        '/',
                        site,
                        language,
                        version,
                        page
                    ))
                    title = doc_meta['short'] or doc_meta['title']
                    description = doc_meta['description'] or "&nbsp;"
            cards.append(
                CARDS_TEMPLATE % (
                    href,
                    title,
                    description
                )
            )

        return """<div class="%s col-%s">%s</div>""" % (style, columns, "\n".join(cards))
