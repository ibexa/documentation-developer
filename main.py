import os
import pprint
import re
from mkdocs.structure.pages import Page
from mkdocs.utils import meta

CARDS_MARKDOWN_TEMPLATE = """
-  [%s](%s)
{.title}

    %s
{.description}
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
    def cards(pages, columns=1):
        current_page = env.variables.page
        absolute_url = current_page.abs_url
        url_parts = re.search("^/([^/]+)/([^/]+)/", absolute_url)
        (language, version) = url_parts.groups()

        if isinstance(pages, str):
            pages = [pages]
        cards_markdown = []
        for page in pages:
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
                cards_markdown.append(
                    CARDS_MARKDOWN_TEMPLATE % (
                        doc_meta['short'] or doc_meta['title'],
                        '/'.join((
                            '',
                            language,
                            version,
                            page
                        )),
                        doc_meta['description'] or "&nbsp;"
                    )
                )

        return """<div class="cards col-%s" markdown>%s</div>""" % (columns, "\n".join(cards_markdown))
