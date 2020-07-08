"""
Code Example Extension for Python Markdown
=========================================
Markdown extension which allows to insert code examples as HTML escaped code and rendered code.
It extends Fenced Code Blocks
See <https://Python-Markdown.github.io/extensions/fenced_code_blocks>
for documentation.
Base extension code Copyright 2007-2008 [Waylan Limberg](http://achinghead.com/).
All changes Copyright 2008-2014 The Python Markdown Project
License: [BSD](http://www.opensource.org/licenses/bsd-license.php)
"""

from __future__ import absolute_import
from __future__ import unicode_literals
from markdown import Extension
from markdown.preprocessors import Preprocessor
from markdown.extensions.codehilite import CodeHilite, CodeHiliteExtension, parse_hl_lines
import re


class EzCodeExampleExtension(Extension):

    def extendMarkdown(self, md):
        """ Add EzCodeExampleBlockPreprocessor to the Markdown instance. """
        md.registerExtension(self)

        md.preprocessors.register(EzCodeExampleBlockPreprocessor(md), 'ez_code_example', 20)


class EzCodeExampleBlockPreprocessor(Preprocessor):
    FENCED_BLOCK_RE = re.compile(
    r'''^(?P<fence>(?:\[{2}code_example))[ ]*
(\{?\.?(?P<lang>[\w#.+-]*))?[ ]*
(hl_lines=(?P<quot>\"|\')(?P<hl_lines>[0-9 ]*?)(?P=quot))?[ ]*
(wrap=(?P<q2>\"|\')?(?P<wrap_tag>[\S\_\-]*?)(?P=q2)?)?[ ]*
(class=(?P<q3>\"|\')?(?P<wrap_class>.*?)(?P=q3)?)?[ ]*
\}?[ ]*
\n(?P<code>.*?)(?<=\n)(?P<end>(?:code_example\]{2}))[ ]*$''', re.MULTILINE | re.DOTALL | re.VERBOSE
    )
    CODE_WRAP = '<pre><code%s>%s</code></pre>'
    LANG_TAG = ' class="%s"'

    def __init__(self, md):
        super().__init__(md)

        self.checked_for_codehilite = False
        self.codehilite_conf = {}

    def run(self, lines):
        """ Match and store Fenced Code Blocks in the HtmlStash. """

        # Check for code hilite extension
        if not self.checked_for_codehilite:
            for ext in self.md.registeredExtensions:
                if isinstance(ext, CodeHiliteExtension):
                    self.codehilite_conf = ext.config
                    break

            self.checked_for_codehilite = True

        text = "\n".join(lines)
        while 1:
            m = self.FENCED_BLOCK_RE.search(text)

            if m:
                lang = ''
                wrap_tag = ''
                wrap_class = ''
                if m.group('lang'):
                    lang = self.LANG_TAG % m.group('lang')

                if m.group('wrap_tag'):
                    wrap_tag = m.group('wrap_tag')

                if m.group('wrap_class'):
                    wrap_class = m.group('wrap_class')

                # If config is not empty, then the codehighlite extension
                # is enabled, so we call it to highlight the code
                if self.codehilite_conf:
                    highliter = CodeHilite(
                        m.group('code'),
                        linenums=self.codehilite_conf['linenums'][0],
                        guess_lang=self.codehilite_conf['guess_lang'][0],
                        css_class=self.codehilite_conf['css_class'][0],
                        style=self.codehilite_conf['pygments_style'][0],
                        use_pygments=self.codehilite_conf['use_pygments'][0],
                        lang=(m.group('lang') or None),
                        noclasses=self.codehilite_conf['noclasses'][0],
                        hl_lines=parse_hl_lines(m.group('hl_lines'))
                    )

                    code = highliter.hilite()
                else:
                    code = self.CODE_WRAP % (lang, self._escape(m.group('code')))

                placeholder = self.md.htmlStash.store(code)

                text = '{}\n<div class="ez-code-example">{}</div> \n {}\n{}'\
                    .format(text[:m.start()], m.group('code'), placeholder, text[m.end():])

                if wrap_tag and wrap_class:
                    text = '<%s class="%s">\n%s\n</%s>' % (wrap_tag, wrap_class, text, wrap_tag)

            else:
                break
        return text.split("\n")

    def _escape(self, txt):
        """ basic html escaping """
        txt = txt.replace('&', '&amp;')
        txt = txt.replace('<', '&lt;')
        txt = txt.replace('>', '&gt;')
        txt = txt.replace('"', '&quot;')
        return txt


def makeExtension(**kwargs):  # pragma: no cover
    return EzCodeExampleExtension(**kwargs)
