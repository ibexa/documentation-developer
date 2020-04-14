import markdown
from markdown.extensions.codehilite import CodeHiliteExtension
from mdx_ez_code_example import EzCodeExampleExtension

result = markdown.markdown('foo bar', extensions=[EzCodeExampleExtension()])
assert result == '<p>foo bar</p>'

input = '''
[[code_example {html}
<div class="parent">
<span class="span">test</span>
</div>
code_example]]
'''

expected = '''<p><div class="ez-code-example"><div class="parent">
<span class="span">test</span>
</div>
</div> 
 <pre><code class="html">&lt;div class=&quot;parent&quot;&gt;
&lt;span class=&quot;span&quot;&gt;test&lt;/span&gt;
&lt;/div&gt;
</code></pre></p>'''

result = markdown.markdown(input, extensions=[EzCodeExampleExtension()])
assert result == expected

input = '''
[[code_example {html hl_lines="2 11 12" wrap="div" class="test test2 test3"}
aaa
code_example]]
'''

expected = '''<div class="test test2 test3">

<p><div class="ez-code-example">aaa
</div> 
 <pre><code class="html">aaa
</code></pre></p>
</div>'''

#result = markdown.markdown(input, extensions=[CodeHiliteExtension(), EzCodeExampleExtension()])
result = markdown.markdown(input, extensions=[EzCodeExampleExtension()])
assert result == expected
