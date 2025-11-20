# PHP Include Review Tool - Usage Guide

## Overview

The `review_php_includes.py` tool helps you review all PHP code samples embedded in your documentation after code refactoring. It extracts 426 PHP includes from 799 markdown files and provides multiple ways to review them.

## What the Tool Does

1. **Scans** all markdown files in `docs/` for PHP `include_file()` calls
2. **Extracts** each code snippet to a separate `.php` file
3. **Generates** an interactive HTML report for visual review
4. **Creates** a JSON manifest for programmatic access

## Running the Tool

```bash
# Default - assumes MkDocs running on http://localhost:8105
~/python/bin/python3.13 review_php_includes.py

# Or specify custom MkDocs URL
~/python/bin/python3.13 review_php_includes.py http://localhost:8000
```

This creates the `review_output/` directory with:
- `report.html` - Interactive visual review interface
- `manifest.json` - Complete metadata for all snippets
- `snippets/` - 426 individual `.php` files

## Review Methods

### 1. Visual Review (Recommended First Step)

Open the HTML report in your browser:

```bash
open review_output/report.html
```

The report shows:
- **Statistics** - Total includes, partial includes, warnings
- **Filtering** - View all, only warnings, or only partial includes
- **Each snippet** with:
  - Source markdown file and line number
  - **Link to rendered MkDocs page** - Click to see how the page looks with the embedded code
  - Original `include_file()` call
  - Rendered PHP code
  - Line count and warnings
  - Link to extracted `.php` file

**Warnings flag:**
- ❌ File not found errors
- ⚠️ Empty output (no code extracted)
- ⚠️ Very short snippets (< 5 lines) - may indicate wrong line ranges

### 2. Static Analysis (Automated Issue Detection)

Run PHP static analysis tools on the extracted snippets to catch:
- Syntax errors
- Incomplete code blocks
- Missing imports/use statements
- Type errors
- Other structural issues

#### Option A: PHP Syntax Check (Quick)

```bash
# Check all snippets for syntax errors
for file in review_output/snippets/*.php; do
    php -l "$file" > /dev/null || echo "SYNTAX ERROR: $file"
done
```

#### Option B: PHPStan (Comprehensive)

If you have PHPStan installed:

```bash
# Run PHPStan on all snippets
phpstan analyse review_output/snippets/ --level 0 --no-progress
```

Start with level 0 and increase as needed. Errors often indicate:
- Wrong line ranges after refactoring
- Incomplete code blocks
- Missing context (classes/methods cut off)

#### Option C: PHP_CodeSniffer

```bash
# Check coding standards
phpcs review_output/snippets/
```

### 3. Programmatic Review

Use the `manifest.json` for custom analysis:

```bash
# Find all snippets with warnings
jq '.snippets[] | select(.warnings | length > 0) | {md_file, warnings}' review_output/manifest.json

# Find all partial includes (most at risk)
jq '.snippets[] | select(.end_line != "EOF") | {md_file, php_file, start_line, end_line}' review_output/manifest.json

# Find very short snippets
jq '.snippets[] | select(.line_count < 10) | {md_file, line_count}' review_output/manifest.json
```

## Tracing Issues Back to Source

Each snippet filename encodes its source:

```
administration__back_office__add_user_setting_md__snippet_001.php
└─────────────────────────┬──────────────────────┘  └────┬───┘
                     markdown path                   snippet #
```

Or use the manifest:

```bash
# Find which markdown file contains a specific snippet
jq '.snippets[] | select(.snippet_file == "FILENAME.php") | .md_file' review_output/manifest.json
```

## Recommended Workflow

1. **Run the tool** to generate the review output
2. **Open `report.html`** and filter by "Show Only Warnings" to catch obvious issues
3. **Run PHP syntax check** on all snippets to catch syntax errors
4. **Run PHPStan** (level 0) to catch structural issues
5. **Review flagged files** in the HTML report
6. **Use manifest.json** to find the source markdown file
7. **Fix line ranges** in the markdown files
8. **Re-run the tool** to verify fixes

## Common Issues to Look For

After code refactoring, watch for:

- **Syntax errors** - Indicates line range cuts off mid-statement
- **Missing class/function declarations** - Start line is now wrong
- **Incomplete methods** - End line is now wrong
- **Missing use statements** - Start line skips imports
- **Very short snippets** - May be extracting wrong section
- **Empty snippets** - File path or line range is completely wrong

## Example: Finding and Fixing an Issue

```bash
# 1. Run PHPStan and find error
phpstan analyse review_output/snippets/ --level 0 | grep "ERROR"
# Output: ERROR in commerce__order_management__order_management_api_md__snippet_150.php

# 2. Look up in manifest
jq '.snippets[] | select(.snippet_file == "commerce__order_management__order_management_api_md__snippet_150.php")' review_output/manifest.json
# Output shows: md_file: "commerce/order_management/order_management_api.md", line 57

# 3. Open markdown file
code docs/commerce/order_management/order_management_api.md +57

# 4. Check the include_file call and adjust line numbers
# 5. Re-run review tool to verify
```

## Statistics

- **Total markdown files scanned:** 799
- **Total PHP includes found:** 426
- **Partial includes (with line ranges):** 253 (61%)
- **Full file includes:** 173 (39%)
- **Unique PHP files referenced:** 217

The 253 partial includes are the most at risk after code refactoring.

## Notes

- The tool uses the same `include_file()` function as your MkDocs build
- Extracted snippets are standalone `.php` files (may have warnings about missing context - that's expected)
- Focus on syntax errors and structural issues, not style warnings
- Some snippets are intentionally partial (showing specific methods/sections)
