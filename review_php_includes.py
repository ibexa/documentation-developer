#!/usr/bin/env python3
"""
PHP Include Review Tool
Extracts and reviews all PHP code snippets included via include_file() macro in markdown files.
"""

import os
import re
import json
from pathlib import Path
from typing import List, Dict, Tuple, Optional


class IncludeFileContext:
    """Mock environment context for include_file function"""
    def __init__(self, project_dir: str):
        self.project_dir = project_dir


def include_file(context: IncludeFileContext, filename: str, start_line: int = 0, end_line: Optional[int] = None, glue: str = '') -> str:
    """
    Include a file, optionally indicating start_line and end_line (start counting from 0)
    Replicated from main.py for standalone usage
    """
    full_filename = os.path.join(context.project_dir, filename)
    try:
        with open(full_filename, 'r', encoding='utf-8') as f:
            lines = f.readlines()
        line_range = lines[start_line:end_line]
        return glue.join(line_range)
    except FileNotFoundError:
        return f"ERROR: File not found: {full_filename}"
    except Exception as e:
        return f"ERROR: {str(e)}"


class PHPIncludeReviewer:
    def __init__(self, docs_dir: str, output_dir: str, mkdocs_url: str = "http://localhost:8105"):
        self.docs_dir = Path(docs_dir)
        self.output_dir = Path(output_dir)
        self.snippets_dir = self.output_dir / "snippets"
        self.project_dir = Path.cwd()
        self.context = IncludeFileContext(str(self.project_dir))
        self.mkdocs_url = mkdocs_url.rstrip('/')

        # Pattern to match include_file calls with .php files
        # Matches: [[= include_file('path/to/file.php') =]]
        # or: [[= include_file('path/to/file.php', 10, 20) =]]
        self.php_include_pattern = re.compile(
            r'\[\[=\s*include_file\(\s*[\'"]([^\'"]*\.php)[\'"](?:\s*,\s*(\d+))?(?:\s*,\s*(\d+))?\s*(?:,\s*[\'"][^\'"]*[\'"])?\s*\)\s*=\]\]'
        )

        self.results = []
        self.snippet_counter = 0

    def create_output_dirs(self):
        """Create output directory structure"""
        self.output_dir.mkdir(exist_ok=True)
        self.snippets_dir.mkdir(exist_ok=True)

    def find_markdown_files(self) -> List[Path]:
        """Find all markdown files in docs directory"""
        return sorted(self.docs_dir.rglob("*.md"))

    def sanitize_filename(self, md_file: Path, snippet_index: int) -> str:
        """Create a safe filename for extracted snippet"""
        # Get relative path from docs dir
        rel_path = md_file.relative_to(self.docs_dir)
        # Replace slashes and dots with underscores
        safe_name = str(rel_path).replace('/', '__').replace('.md', '_md')
        return f"{safe_name}__snippet_{snippet_index:03d}.php"

    def get_mkdocs_url(self, md_file: Path) -> str:
        """Convert markdown file path to MkDocs rendered URL"""
        # Get relative path from docs dir
        rel_path = md_file.relative_to(self.docs_dir)
        # Remove .md extension and convert to URL path
        url_path = str(rel_path).replace('.md', '').replace('\\', '/')
        # Build full URL: http://localhost:8105/en/latest/path/to/page/
        return f"{self.mkdocs_url}/en/latest/{url_path}/"

    def extract_php_includes(self, md_file: Path) -> List[Dict]:
        """Extract all PHP include_file calls from a markdown file and group by code block"""
        try:
            with open(md_file, 'r', encoding='utf-8') as f:
                content = f.read()
        except Exception as e:
            print(f"Error reading {md_file}: {e}")
            return []

        # Find all code blocks and their line ranges
        code_blocks = []
        in_code_block = False
        code_block_start = 0

        for i, line in enumerate(content.split('\n'), 1):
            if line.strip().startswith('```'):
                if not in_code_block:
                    code_block_start = i
                    in_code_block = True
                else:
                    code_blocks.append((code_block_start, i))
                    in_code_block = False

        # Find all include_file matches
        matches = list(self.php_include_pattern.finditer(content))
        if not matches:
            return []

        # Group matches by code block
        grouped_includes = []
        current_group = []
        current_block = None

        for match in matches:
            php_file = match.group(1)
            start_line = int(match.group(2)) if match.group(2) else 0
            end_line = int(match.group(3)) if match.group(3) else None
            line_number = content[:match.start()].count('\n') + 1

            # Find which code block this match belongs to
            match_block = None
            for block_start, block_end in code_blocks:
                if block_start <= line_number <= block_end:
                    match_block = (block_start, block_end)
                    break

            include_data = {
                'md_file': md_file,
                'md_line': line_number,
                'php_file': php_file,
                'start_line': start_line,
                'end_line': end_line,
                'full_match': match.group(0),
                'code_block': match_block
            }

            # Group consecutive includes in the same code block
            if match_block and match_block == current_block:
                current_group.append(include_data)
            else:
                # Save previous group if exists
                if current_group:
                    grouped_includes.append(current_group)
                # Start new group
                current_group = [include_data]
                current_block = match_block

        # Don't forget the last group
        if current_group:
            grouped_includes.append(current_group)

        # Flatten groups of 1 item, keep groups with multiple items grouped
        result = []
        for group in grouped_includes:
            if len(group) == 1:
                result.append(group[0])
            else:
                # Mark as grouped - use first item's line number for the group
                result.append({
                    'md_file': md_file,
                    'md_line': group[0]['md_line'],
                    'grouped': True,
                    'includes': group
                })

        return result

    def process_include(self, include_data: Dict, snippet_index: int) -> Dict:
        """Process a single include_file call or grouped includes and extract the code"""
        md_file = include_data['md_file']

        # Handle grouped includes
        if include_data.get('grouped'):
            includes = include_data['includes']

            # Combine all rendered code
            combined_code = []
            combined_matches = []
            php_files = []

            for inc in includes:
                php_file = inc['php_file']
                start_line = inc['start_line']
                end_line = inc['end_line']

                # Execute include_file to get rendered code
                rendered = include_file(self.context, php_file, start_line, end_line)
                combined_code.append(rendered)
                combined_matches.append(inc['full_match'])

                # Track unique php files
                file_ref = f"{php_file}:{start_line}-{end_line if end_line else 'EOF'}"
                php_files.append(file_ref)

            rendered_code = ''.join(combined_code)
            full_match = ''.join(combined_matches)
            php_file_display = f"{len(includes)} combined includes"

        else:
            # Single include
            php_file = include_data['php_file']
            start_line = include_data['start_line']
            end_line = include_data['end_line']

            # Execute include_file to get rendered code
            rendered_code = include_file(self.context, php_file, start_line, end_line)
            full_match = include_data['full_match']
            php_file_display = php_file
            php_files = [f"{php_file}:{start_line}-{end_line if end_line else 'EOF'}"]

        # Create snippet filename
        snippet_filename = self.sanitize_filename(md_file, snippet_index)
        snippet_path = self.snippets_dir / snippet_filename

        # Write extracted snippet to file
        with open(snippet_path, 'w', encoding='utf-8') as f:
            f.write(rendered_code)

        # Analyze snippet
        line_count = rendered_code.count('\n') + 1 if rendered_code else 0
        is_error = rendered_code.startswith('ERROR:')
        is_empty = len(rendered_code.strip()) == 0
        is_short = line_count < 5 and not is_error

        warnings = []
        if is_error:
            warnings.append("ERROR: Could not load file")
        if is_empty:
            warnings.append("WARNING: Empty output")
        if is_short:
            warnings.append(f"WARNING: Very short snippet ({line_count} lines)")

        # Determine if this is a partial include (has line ranges)
        if include_data.get('grouped'):
            # For grouped includes, check if ANY of them are partial
            is_partial = any(
                inc.get('end_line') is not None
                for inc in include_data['includes']
            )
        else:
            # For single includes, check if end_line is specified
            is_partial = include_data.get('end_line') is not None

        return {
            'md_file': str(md_file.relative_to(self.docs_dir)),
            'md_line': include_data['md_line'],
            'php_file': php_file_display,
            'php_files': php_files,  # List of all included files
            'grouped': include_data.get('grouped', False),
            'is_partial': is_partial,
            'start_line': include_data.get('start_line', 0) if not include_data.get('grouped') else None,
            'end_line': include_data.get('end_line', 'EOF') if not include_data.get('grouped') else 'EOF',
            'full_match': full_match,
            'snippet_file': snippet_filename,
            'snippet_path': str(snippet_path.relative_to(self.output_dir)),
            'rendered_code': rendered_code,
            'line_count': line_count,
            'warnings': warnings
        }

    def process_all_files(self):
        """Process all markdown files and extract PHP includes"""
        print("Finding markdown files...")
        md_files = self.find_markdown_files()
        print(f"Found {len(md_files)} markdown files")

        print("\nExtracting PHP includes...")
        total_includes = 0

        for md_file in md_files:
            includes = self.extract_php_includes(md_file)
            if includes:
                print(f"  {md_file.relative_to(self.docs_dir)}: {len(includes)} PHP includes")

            for include_data in includes:
                total_includes += 1
                self.snippet_counter += 1
                result = self.process_include(include_data, self.snippet_counter)
                self.results.append(result)

        print(f"\nTotal PHP includes found: {total_includes}")
        print(f"Snippets extracted to: {self.snippets_dir}")

    def generate_manifest(self):
        """Generate JSON manifest file"""
        manifest_path = self.output_dir / "manifest.json"

        manifest = {
            'total_snippets': len(self.results),
            'snippets': self.results
        }

        with open(manifest_path, 'w', encoding='utf-8') as f:
            json.dump(manifest, f, indent=2)

        print(f"Manifest written to: {manifest_path}")

    def generate_html_report(self):
        """Generate HTML report for visual review"""
        report_path = self.output_dir / "report.html"

        # Calculate statistics
        total = len(self.results)
        with_warnings = sum(1 for r in self.results if r['warnings'])
        partial_includes = sum(1 for r in self.results if r.get('is_partial', False))

        # Generate report HTML
        html = f"""<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Include Review Report</title>
    <style>
        * {{ margin: 0; padding: 0; box-sizing: border-box; }}
        body {{
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
            padding: 20px;
        }}
        .container {{ max-width: 1400px; margin: 0 auto; }}
        h1 {{
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #3498db;
        }}
        .stats {{
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }}
        .stat {{
            text-align: center;
        }}
        .stat-value {{
            font-size: 2.5em;
            font-weight: bold;
            color: #3498db;
        }}
        .stat-label {{
            color: #7f8c8d;
            font-size: 0.9em;
            text-transform: uppercase;
        }}
        .snippet {{
            background: white;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }}
        .snippet.has-warning {{
            border-left: 4px solid #e74c3c;
        }}
        .snippet-header {{
            padding: 15px 20px;
            background: #ecf0f1;
            border-bottom: 1px solid #ddd;
        }}
        .snippet-title {{
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }}
        .snippet-meta {{
            font-size: 0.85em;
            color: #7f8c8d;
            margin-top: 5px;
        }}
        .snippet-call {{
            font-family: 'Courier New', monospace;
            background: #fff;
            padding: 10px;
            border-left: 3px solid #3498db;
            margin: 10px 0;
            font-size: 0.9em;
            overflow-x: auto;
        }}
        .warnings {{
            background: #ffe6e6;
            color: #c0392b;
            padding: 10px 15px;
            margin: 10px 0;
            border-left: 3px solid #e74c3c;
        }}
        .warning-item {{
            margin: 5px 0;
        }}
        .snippet-code {{
            padding: 20px;
            background: #2d2d2d;
            color: #f8f8f2;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
            overflow-x: auto;
            max-height: 600px;
            overflow-y: auto;
        }}
        .snippet-code pre {{
            margin: 0;
            white-space: pre;
        }}
        .snippet-footer {{
            padding: 10px 20px;
            background: #ecf0f1;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }}
        .snippet-link {{
            color: #3498db;
            text-decoration: none;
            font-size: 0.9em;
        }}
        .snippet-link:hover {{
            text-decoration: underline;
        }}
        .line-count {{
            font-size: 0.9em;
            color: #7f8c8d;
        }}
        .filter-bar {{
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }}
        .filter-btn {{
            background: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
            font-size: 0.9em;
        }}
        .filter-btn:hover {{
            background: #2980b9;
        }}
        .filter-btn.active {{
            background: #e74c3c;
        }}
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Include Review Report</h1>

        <div class="stats">
            <div class="stat">
                <div class="stat-value">{total}</div>
                <div class="stat-label">Total Includes</div>
            </div>
            <div class="stat">
                <div class="stat-value">{partial_includes}</div>
                <div class="stat-label">Partial Includes</div>
            </div>
            <div class="stat">
                <div class="stat-value">{with_warnings}</div>
                <div class="stat-label">With Warnings</div>
            </div>
        </div>

        <div class="filter-bar">
            <button class="filter-btn" onclick="filterSnippets('all', this)">Show All</button>
            <button class="filter-btn" onclick="filterSnippets('warnings', this)">Show Only Warnings</button>
            <button class="filter-btn" onclick="filterSnippets('partial', this)">Show Partial Includes</button>
        </div>

        <div id="snippets">
"""

        # Add each snippet
        for i, result in enumerate(self.results, 1):
            has_warning = len(result['warnings']) > 0
            is_partial = result.get('is_partial', False)
            warning_class = 'has-warning' if has_warning else ''
            data_attrs = f"data-has-warning='{str(has_warning).lower()}' data-is-partial='{str(is_partial).lower()}'"

            warnings_html = ''
            if result['warnings']:
                warnings_items = ''.join(f"<div class='warning-item'>⚠️ {w}</div>" for w in result['warnings'])
                warnings_html = f'<div class="warnings">{warnings_items}</div>'

            # Get MkDocs URL for this markdown file
            md_file_path = self.docs_dir / result['md_file']
            mkdocs_url = self.get_mkdocs_url(md_file_path)

            # Escape HTML in code
            code_html = result['rendered_code'].replace('&', '&amp;').replace('<', '&lt;').replace('>', '&gt;')

            # Build source info for grouped vs single includes
            if result.get('grouped'):
                source_info = f"<strong>Combined snippet from {len(result['php_files'])} includes:</strong><br>"
                for php_file_ref in result['php_files']:
                    source_info += f"<code style='display: block; margin: 2px 0;'>{php_file_ref}</code>"
                lines_info = ""
            else:
                source_info = f"Source: <code>{result['php_file']}</code>"
                lines_info = f"| Lines: {result['start_line']}-{result['end_line']}"

            html += f"""
        <div class="snippet {warning_class}" {data_attrs}>
            <div class="snippet-header">
                <div class="snippet-title">
                    Snippet #{i}: {result['md_file']} (line {result['md_line']})
                    <a href="{mkdocs_url}" target="_blank" style="margin-left: 10px; color: #3498db; text-decoration: none;">📄 View rendered page</a>
                </div>
                <div class="snippet-meta">
                    {source_info}
                    {lines_info}
                </div>
                <div class="snippet-call">{result['full_match']}</div>
                {warnings_html}
            </div>
            <div class="snippet-code">
                <pre>{code_html}</pre>
            </div>
            <div class="snippet-footer">
                <a href="{result['snippet_path']}" class="snippet-link">📄 {result['snippet_file']}</a>
                <span class="line-count">{result['line_count']} lines</span>
            </div>
        </div>
"""

        html += """
        </div>
    </div>

    <script>
        function filterSnippets(filter, button) {
            const snippets = document.querySelectorAll('.snippet');
            const buttons = document.querySelectorAll('.filter-btn');

            // Update button states
            buttons.forEach(btn => btn.classList.remove('active'));
            if (button) {
                button.classList.add('active');
            }

            snippets.forEach(snippet => {
                if (filter === 'all') {
                    snippet.style.display = 'block';
                } else if (filter === 'warnings') {
                    snippet.style.display = snippet.dataset.hasWarning === 'true' ? 'block' : 'none';
                } else if (filter === 'partial') {
                    snippet.style.display = snippet.dataset.isPartial === 'true' ? 'block' : 'none';
                }
            });
        }
    </script>
</body>
</html>
"""

        with open(report_path, 'w', encoding='utf-8') as f:
            f.write(html)

        print(f"HTML report written to: {report_path}")

    def run(self):
        """Run the full review process"""
        print("=" * 60)
        print("PHP Include Review Tool")
        print("=" * 60)

        self.create_output_dirs()
        self.process_all_files()
        self.generate_manifest()
        self.generate_html_report()

        print("\n" + "=" * 60)
        print("Review complete!")
        print(f"Open the report: {self.output_dir / 'report.html'}")
        print(f"Run static analysis on: {self.snippets_dir}/*.php")
        print("=" * 60)


if __name__ == "__main__":
    import sys

    # Parse command line arguments
    mkdocs_url = "http://localhost:8105"
    if len(sys.argv) > 1:
        mkdocs_url = sys.argv[1]

    reviewer = PHPIncludeReviewer(
        docs_dir="docs",
        output_dir="review_output",
        mkdocs_url=mkdocs_url
    )
    reviewer.run()
