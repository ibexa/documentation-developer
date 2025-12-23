#!/usr/bin/env python3
r"""
Convert PHP API Reference HTML files to compact Markdown signatures.

Extracts: Class name and public method signatures
Filters: Only Ibexa\Contracts\* classes (public API)
Output: Single markdown file with signatures only
"""

import re
from pathlib import Path
from typing import List, Dict, Optional


def parse_class_file(html_path: Path) -> Optional[Dict]:
    """Parse a single HTML file and extract class info."""
    # Convert filename format to proper FQCN
    # Ibexa-Contracts-Core-Repository-ContentService.html -> Ibexa\Contracts\Core\Repository\ContentService
    fqcn = html_path.stem.replace('-', '\\')
    
    # Only process Ibexa\Contracts\* classes
    if not fqcn.startswith('Ibexa\\Contracts\\'):
        return None
    
    with open(html_path, 'r', encoding='utf-8') as f:
        html_content = f.read()
    
    # Extract extends/implements info
    extends = None
    implements = []
    
    # Look for "Extends" in header
    extends_match = re.search(r'<div class="content-header__subheader">\s*Extends\s*.*?<abbr[^>]*title="\\([^"]+)"', html_content, re.DOTALL)
    if extends_match:
        extends = extends_match.group(1)  # Keep single backslashes
    
    # Look for "Implements" in header - may have multiple interfaces
    implements_match = re.search(r'<div class="content-header__subheader">\s*Implements\s*(.*?)</div>', html_content, re.DOTALL)
    if implements_match:
        impl_html = implements_match.group(1)
        # Extract all abbr title attributes
        impl_titles = re.findall(r'<abbr[^>]*title="\\([^"]+)"', impl_html)
        implements = impl_titles  # Keep single backslashes
    
    # Extract all public and protected members (methods, constants, properties)
    members = []
    
    # Pattern for methods: must have method name followed by (
    method_pattern = r'<pre><code><span class="phpdocumentor-signature__visibility">(public|protected)\s*</span>(?:<span class="phpdocumentor-signature__static">static\s*</span>)?(?:<span class="phpdocumentor-signature__abstract">abstract\s*</span>)?.*?<span class="phpdocumentor-signature__name">([^<]+)</span>\s*<span>\(</span>(.*?)</code></pre>'
    
    # Pattern for constants: has = sign for assignment
    const_pattern = r'<pre><code><span class="phpdocumentor-signature__visibility">(public|protected)\s*</span><span class="phpdocumentor-signature__type">mixed\s*</span><span class="phpdocumentor-signature__name">([^<]+)</span>\s*=\s*'
    
    # Pattern for properties: type followed by variable name (with $)
    property_pattern = r'<pre><code><span class="phpdocumentor-signature__visibility">(public|protected)\s*</span>(?:<span class="phpdocumentor-signature__static">static\s*</span>)?<span class="phpdocumentor-signature__type">([^<]*?)</span>(?:<span[^>]*>\s*)?(\$[a-zA-Z_][a-zA-Z0-9_]*)'
    
    # Extract methods
    for match in re.finditer(method_pattern, html_content, re.DOTALL):
        visibility = match.group(1)
        signature_html = match.group(0)
        
        # Check for static or abstract
        is_static = 'phpdocumentor-signature__static' in signature_html
        is_abstract = 'phpdocumentor-signature__abstract' in signature_html
        
        clean_sig = clean_signature(signature_html)
        
        # Skip if cleanup failed
        if not clean_sig or len(clean_sig) < 10 or '(' not in clean_sig or ')' not in clean_sig:
            continue
        
        # Build prefix - visibility first, then type, then modifiers
        prefix = f"{visibility} function"
        if is_static:
            prefix += " static"
        if is_abstract:
            prefix += " abstract"
        
        members.append(f"{prefix} {clean_sig}")
    
    # Extract constants
    for match in re.finditer(const_pattern, html_content, re.DOTALL):
        visibility = match.group(1)
        const_name = match.group(2)
        
        # Find the full constant definition
        const_html_match = re.search(
            rf'<pre><code>.*?{re.escape(const_name)}.*?</code></pre>',
            html_content[match.start():match.start()+500],
            re.DOTALL
        )
        
        if const_html_match:
            clean_sig = clean_signature(const_html_match.group(0))
            if clean_sig and len(clean_sig) > 5:
                members.append(f"{visibility} const {clean_sig}")
    
    if not members:
        return None
    
    return {
        'fqcn': fqcn,
        'extends': extends,
        'implements': implements,
        'members': members
    }


def clean_signature(signature_html: str) -> str:
    """Clean HTML from a signature and return plain text with FQCNs."""
    # First, extract FQCN mappings from abbr tags before cleaning
    # Pattern: <abbr title="\Full\Namespace\ClassName">ShortName</abbr>
    fqcn_map = {}
    for match in re.finditer(r'<abbr[^>]*title="\\([^"]+)">([^<]+)</abbr>', signature_html):
        fqcn = match.group(1)
        short_name = match.group(2).strip()
        if short_name and fqcn and '::' not in short_name:  # Skip constant references
            fqcn_map[short_name] = fqcn
    
    # Remove all <span> and <a> tags but keep their content
    clean_sig = re.sub(r'<span[^>]*>', '', signature_html)
    clean_sig = re.sub(r'</span>', '', clean_sig)
    clean_sig = re.sub(r'<a[^>]*>', '', clean_sig)
    clean_sig = re.sub(r'</a>', '', clean_sig)
    clean_sig = re.sub(r'<abbr[^>]*>', '', clean_sig)
    clean_sig = re.sub(r'</abbr>', '', clean_sig)
    clean_sig = re.sub(r'<pre><code>', '', clean_sig)
    clean_sig = re.sub(r'</code></pre>', '', clean_sig)
    
    # Decode HTML entities
    clean_sig = clean_sig.replace('&nbsp;', ' ')
    clean_sig = clean_sig.replace('&#039;', "'")
    clean_sig = clean_sig.replace('&lt;', '<')
    clean_sig = clean_sig.replace('&gt;', '>')
    clean_sig = clean_sig.replace('&amp;', '&')
    clean_sig = clean_sig.replace('&quot;', '"')
    
    # Clean up whitespace
    clean_sig = ' '.join(clean_sig.split())
    clean_sig = clean_sig.strip()
    
    # Filter out garbage
    # Allow < and > for generic types, but check for HTML tags like <div, <span, etc.
    if re.search(r'<(?!string|int|mixed|bool|float|array|object)', clean_sig, re.IGNORECASE):
        # Has < followed by something that's not a generic type - likely HTML garbage
        if not re.search(r'<[a-zA-Z_\\]', clean_sig):  # Allow < followed by type name
            return None
    if 'class=' in clean_sig or '<div' in clean_sig or '<span' in clean_sig:
        return None
    
    # Remove visibility and modifier keywords (we add them as prefixes)
    # Remove from start repeatedly until none left
    while clean_sig.startswith(('public ', 'protected ', 'private ', 'static ', 'abstract ', 'final ')):
        clean_sig = re.sub(r'^(public|protected|private|static|abstract|final)\s+', '', clean_sig, count=1)
    
    # Replace short type names with FQCNs
    # We need to be careful to only replace type hints, not parameter/method names
    if fqcn_map:
        # Replace each short name with FQCN in type hint positions
        for short_name, fqcn in fqcn_map.items():
            # Escape special regex characters in short_name
            escaped_short = re.escape(short_name)
            # Double escape backslashes for regex replacement
            escaped_fqcn = fqcn.replace('\\', '\\\\')
            
            # Return type (after : )
            clean_sig = re.sub(
                rf':\s*{escaped_short}(\||<|&|\[|\]|\s|$)',
                rf': \\{escaped_fqcn}\1',
                clean_sig
            )
            
            # Parameter type (before $ or variable name)
            clean_sig = re.sub(
                rf'([(\[,]\s*){escaped_short}(\s+\$)',
                rf'\1\\{escaped_fqcn}\2',
                clean_sig
            )
            
            # Inside union types like Type1|Type2
            clean_sig = re.sub(
                rf'\|{escaped_short}(\s+\$|\|)',
                rf'|\\{escaped_fqcn}\1',
                clean_sig
            )
            
            # Inside generic types like array<ClassName> or iterable<Key, Value>
            clean_sig = re.sub(
                rf'<{escaped_short}(,|\||&|\>)',
                rf'<\\{escaped_fqcn}\1',
                clean_sig
            )
            clean_sig = re.sub(
                rf',\s*{escaped_short}(,|\>)',
                rf', \\{escaped_fqcn}\1',
                clean_sig
            )
    
    # Fix spacing around return type colon - should be ): not ) :
    clean_sig = re.sub(r'\)\s+:', '):', clean_sig)
    # Ensure space after colon in return type
    clean_sig = re.sub(r':\s+', ': ', clean_sig)
    
    return clean_sig


def format_class_markdown(class_data: Dict) -> str:
    """Format class data as markdown."""
    lines = []
    
    # Class header with inheritance info
    header = f"## {class_data['fqcn']}"
    if class_data.get('extends'):
        header += f" extends {class_data['extends']}"
    if class_data.get('implements'):
        header += f" implements {', '.join(class_data['implements'])}"
    lines.append(header)
    lines.append("")
    
    # Members (methods, constants, properties)
    if class_data['members']:
        for member in class_data['members']:
            lines.append(f"- `{member}`")
    else:
        lines.append("*(No public members)*")
    
    # Add extra blank line after each class entry
    lines.append("")
    lines.append("")
    return '\n'.join(lines)


def main():
    """Main converter function."""
    script_dir = Path(__file__).parent
    repo_root = script_dir.parent
    
    # Input: generated HTML files
    input_dir = repo_root / 'site' / 'api' / 'php_api' / 'php_api_reference' / 'classes'
    
    # Output: single markdown file
    output_file = repo_root / 'docs' / 'api' / 'php_api' / 'php_api_signatures.md'
    output_file.parent.mkdir(parents=True, exist_ok=True)
    
    if not input_dir.exists():
        print(f"Error: Input directory not found: {input_dir}")
        print("Please build the documentation first.")
        return 1
    
    print(f"Scanning {input_dir} for HTML files...")
    
    # Parse all class files
    class_data_list = []
    total_files = 0
    
    for html_file in sorted(input_dir.glob('*.html')):
        total_files += 1
        class_data = parse_class_file(html_file)
        if class_data:
            class_data_list.append(class_data)
    
    print(f"Processed {total_files} files")
    print(f"Extracted {len(class_data_list)} contract classes")
    
    # Sort by FQCN
    class_data_list.sort(key=lambda x: x['fqcn'])
    
    # Generate markdown
    with open(output_file, 'w', encoding='utf-8') as f:
        f.write("# PHP API Reference - Method Signatures\n\n")
        
        for class_data in class_data_list:
            f.write(format_class_markdown(class_data))
    
    # Print statistics
    output_size_kb = output_file.stat().st_size / 1024
    total_members = sum(len(c['members']) for c in class_data_list)
    
    print(f"\n✓ Generated: {output_file}")
    print(f"  Size: {output_size_kb:.1f} KB")
    print(f"  Classes: {len(class_data_list)}")
    print(f"  Members: {total_members}")
    print(f"  Avg members per class: {total_members / len(class_data_list):.1f}")
    
    return 0


if __name__ == '__main__':
    exit(main())
