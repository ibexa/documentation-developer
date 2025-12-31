#!/usr/bin/env python3
"""
Extract navigation from phpDocumentor-generated HTML files and load it dynamically.
This reduces each file from ~2.5MB to ~25KB by removing duplicated navigation.
"""

import re
import glob
import os
import sys


def extract_navigation(html):
    """
    Extract the navigation sidebar from HTML.
    phpDocumentor uses <div class="main_nav"> wrapper containing the sidebar.
    We extract just the inner content (without the main_nav wrapper itself)
    so we can inject it via innerHTML while keeping the wrapper in place.
    """
    # Extract the content inside main_nav (everything after opening div, before closing div)
    pattern = r'<div class="main_nav">\s*(.*?)\s*</div>\s*(?=\n\s*<div class="md-content")'
    
    match = re.search(pattern, html, re.DOTALL | re.IGNORECASE)
    if match:
        return match.group(1)
    
    return None


def create_nav_loader(relative_path=''):
    """
    Create JavaScript code to load navigation dynamically.
    Uses sessionStorage for caching across page loads.
    Preserves the main_nav wrapper structure for CSS and JS compatibility.
    """
    return f'''<div class="main_nav" id="nav-container">
    <div class="nav-loading-wrapper" style="padding: 2rem; text-align: center; color: #666;">
        <p>Loading navigation...</p>
    </div>
</div>

<script>
(function() {{
    var navPath = '{relative_path}shared-navigation.html';
    var cached = sessionStorage.getItem('phpdoc-nav');
    var navContainer = document.getElementById('nav-container');
    
    function loadNav(html) {{
        // Use innerHTML to replace content while keeping the nav-container div
        navContainer.innerHTML = html;
        
        // Restore scroll position if saved
        var scrollWrap = navContainer.querySelector('.md-sidebar__scrollwrap');
        if (scrollWrap) {{
            var scrollPos = sessionStorage.getItem('nav-scroll');
            if (scrollPos) {{
                scrollWrap.scrollTop = parseInt(scrollPos, 10);
            }}
            
            // Save scroll position on scroll
            scrollWrap.addEventListener('scroll', function() {{
                sessionStorage.setItem('nav-scroll', scrollWrap.scrollTop);
            }});
        }}
        
        // Highlight current page in navigation
        var currentPath = window.location.pathname;
        var links = navContainer.getElementsByTagName('a');
        for (var i = 0; i < links.length; i++) {{
            if (links[i].href && links[i].getAttribute('href') && 
                currentPath.endsWith(links[i].getAttribute('href'))) {{
                links[i].classList.add('current-page');
                links[i].style.fontWeight = 'bold';
            }}
        }}
    }}
    
    function handleError(err) {{
        console.error('Navigation load failed:', err);
        navContainer.innerHTML = '<div class="main_nav_content"><div style="padding: 1rem; color: #c00;">Navigation failed to load. <a href="index.html">Go to index</a></div></div><div class="main_nav__resize-handler"></div>';
    }}
    
    if (cached) {{
        // Use cached navigation
        loadNav(cached);
    }} else {{
        // Fetch navigation
        if (window.fetch) {{
            fetch(navPath)
                .then(function(r) {{ 
                    if (!r.ok) throw new Error('HTTP ' + r.status);
                    return r.text(); 
                }})
                .then(function(html) {{
                    sessionStorage.setItem('phpdoc-nav', html);
                    loadNav(html);
                }})
                .catch(handleError);
        }} else {{
            // Fallback for older browsers
            var xhr = new XMLHttpRequest();
            xhr.open('GET', navPath, true);
            xhr.onload = function() {{
                if (xhr.status >= 200 && xhr.status < 300) {{
                    sessionStorage.setItem('phpdoc-nav', xhr.responseText);
                    loadNav(xhr.responseText);
                }} else {{
                    handleError(new Error('HTTP ' + xhr.status));
                }}
            }};
            xhr.onerror = handleError;
            xhr.send();
        }}
    }}
}})();
</script>

<noscript>
    <div class="main_nav">
        <div class="main_nav_content">
            <div class="site-header" id="site-name">
                <a href=".">PHP API Reference</a>
            </div>
            <div style="padding: 1rem; background: #ffe; border: 1px solid #cc0;">
                <p><strong>JavaScript is disabled.</strong></p>
                <p>Navigation requires JavaScript. Please enable it or go to <a href="namespaces/ibexa-contracts.html"><code>Ibexa\\Contracts</code></a> to navigate.</p>
            </div>
        </div>
        <div class="main_nav__resize-handler"></div>
    </div>
</noscript>'''


def extract_and_replace_navigation(directory='docs/api/php_api/php_api_reference'):
    """
    Main function to extract navigation and replace it in all HTML files.
    """
    
    pattern = os.path.join(directory, '**', '*.html')
    files = glob.glob(pattern, recursive=True)
    
    if not files:
        print(f"ERROR: No HTML files found in {directory}")
        return False
    
    print(f"Found {len(files)} HTML files\n")
    
    # Extract navigation from first file
    print("Extracting navigation from first file...")
    first_file = files[0]
    
    with open(first_file, 'r', encoding='utf-8') as f:
        html = f.read()
    
    nav_content = extract_navigation(html)
    
    if not nav_content:
        print("ERROR: Could not extract navigation. The HTML structure may be different than expected.")
        print("Please check the HTML file structure and update the extraction pattern.")
        return False
    
    # Save shared navigation file
    nav_file = os.path.join(directory, 'shared-navigation.html')
    with open(nav_file, 'w', encoding='utf-8') as f:
        f.write(nav_content)
    
    print(f"✓ Extracted navigation: {len(nav_content):,} bytes")
    print(f"✓ Saved to: {nav_file}\n")
    
    # Process all HTML files
    print("Processing HTML files...")
    total_original = 0
    total_modified = 0
    processed = 0
    
    for filepath in files:
        try:
            with open(filepath, 'r', encoding='utf-8') as f:
                html = f.read()
            
            original_size = len(html)
            
            # Calculate relative path from this file to the root directory
            file_dir = os.path.dirname(filepath)
            rel_path = os.path.relpath(directory, file_dir)
            if rel_path != '.':
                rel_path = rel_path.replace('\\', '/') + '/'
            else:
                rel_path = ''
            
            # Replace navigation with dynamic loader
            # Extract the entire main_nav structure
            nav_loader = create_nav_loader(rel_path)
            
            # Pattern to match the entire main_nav wrapper
            pattern = r'<div class="main_nav">.*?<div class="main_nav__resize-handler"></div>\s*</div>'
            
            # Use lambda to avoid backslash interpretation in replacement
            modified = re.sub(pattern, lambda m: nav_loader, html, flags=re.DOTALL | re.IGNORECASE, count=1)
            
            if modified == html:
                print(f"WARNING: Could not replace navigation in {filepath}")
                continue
            
            modified_size = len(modified)
            
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(modified)
            
            total_original += original_size
            total_modified += modified_size
            processed += 1
            
            # Print progress for every 100th file
            if processed % 100 == 0:
                print(f"[{processed}/{len(files)}] Processed {processed} files...")
        
        except Exception as e:
            print(f"ERROR processing {filepath}: {e}")
            continue
    
    # Summary
    total_saved = total_original - total_modified
    overall_reduction = (total_saved / total_original * 100) if total_original > 0 else 0
    
    print(f"\n{'='*60}")
    print(f"Navigation extraction complete!")
    print(f"{'='*60}")
    print(f"Files processed:     {processed}")
    print(f"Navigation file:     {nav_file}")
    print(f"Navigation size:     {len(nav_content):,} bytes ({len(nav_content) / 1024 / 1024:.2f} MB)")
    print(f"Original total size: {total_original:,} bytes ({total_original / 1024 / 1024 / 1024:.2f} GB)")
    print(f"Modified total size: {total_modified:,} bytes ({total_modified / 1024 / 1024 / 1024:.2f} GB)")
    print(f"Total saved:         {total_saved:,} bytes ({total_saved / 1024 / 1024 / 1024:.2f} GB)")
    print(f"Reduction:           {overall_reduction:.1f}%")
    print(f"\nNext steps:")
    print(f"1. Test the documentation in a browser")
    print(f"2. Commit the changes")
    
    return True


if __name__ == '__main__':
    # Allow directory to be passed as argument
    directory = sys.argv[1] if len(sys.argv) > 1 else 'docs/api/php_api/php_api_reference'
    
    if not os.path.exists(directory):
        print(f"ERROR: Directory {directory} does not exist")
        sys.exit(1)
    
    print(f"Extracting navigation from HTML files in: {directory}\n")
    
    success = extract_and_replace_navigation(directory)
    sys.exit(0 if success else 1)
