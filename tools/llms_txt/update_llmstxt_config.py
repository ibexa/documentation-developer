#!/usr/bin/env python3
"""
Update the llmstxt plugin configuration in plugins.yml based on mkdocs.yml nav structure.
This script converts the mkdocs navigation into a format suitable for the llmstxt plugin.

Files can be excluded from the llmstxt output by adding the following to their YAML frontmatter:

    exclude_from_llmstxt: true

This excludes the page from both llms.txt and llms-full.txt, skips generating its Markdown
version, and hides the page action buttons. There is no per-file control for excluding a page
from llms.txt only (both files are derived from the same `sections` config).
Files without this property are included by default.
"""

import re
import yaml
from pathlib import Path


def read_frontmatter(file_path):
    """
    Parse YAML frontmatter from a markdown file.
    Returns a dict of frontmatter values, or an empty dict if none is found.
    Handles files that begin with HTML comments before the frontmatter block.
    """
    try:
        content = Path(file_path).read_text(encoding='utf-8')
    except (OSError, UnicodeDecodeError):
        return {}

    # Strip leading HTML comments (e.g. <!-- vale ... -->)
    content = re.sub(r'\A(\s*<!--.*?-->\s*)+', '', content, flags=re.DOTALL)

    if not content.startswith('---'):
        return {}

    end = content.find('\n---', 3)
    if end == -1:
        return {}

    try:
        return yaml.safe_load(content[3:end]) or {}
    except yaml.YAMLError:
        return {}


def is_excluded(file_path, docs_dir):
    """
    Return True if the file has 'exclude_from_llmstxt: true' in its frontmatter.
    file_path is relative to docs_dir (as written in mkdocs nav).
    """
    full_path = Path(docs_dir) / file_path
    fm = read_frontmatter(full_path)
    return fm.get('exclude_from_llmstxt', False) is True


def convert_nav_to_llmstxt_sections(nav_list, docs_dir):
    """
    Convert mkdocs nav list to llmstxt sections format.
    Returns a dict mapping top-level section names to flat lists of file paths.
    Files with 'exclude_from_llmstxt: true' in their frontmatter are skipped.
    Sections that contain no remaining files are omitted.
    """
    sections = {}

    def extract_files(item):
        """Recursively extract included file paths from a nav item."""
        files = []
        if isinstance(item, str):
            if not item.endswith('.html') and not is_excluded(item, docs_dir):
                files.append(item)
        elif isinstance(item, list):
            for subitem in item:
                files.extend(extract_files(subitem))
        elif isinstance(item, dict):
            for value in item.values():
                if isinstance(value, str):
                    if not value.endswith('.html') and not is_excluded(value, docs_dir):
                        files.append(value)
                elif isinstance(value, list):
                    for subitem in value:
                        files.extend(extract_files(subitem))
        return files

    for item in nav_list:
        if isinstance(item, dict):
            for section_name, section_content in item.items():
                files = extract_files({section_name: section_content})
                if files:
                    sections[section_name] = files
        elif isinstance(item, str):
            if not item.endswith('.html') and not is_excluded(item, docs_dir):
                sections.setdefault('Ibexa Developer Documentation', []).append(item)

    return sections


def update_plugins_yml(plugins_path, mkdocs_path):
    """
    Update the llmstxt plugin configuration in plugins.yml based on mkdocs.yml nav.
    """
    with open(plugins_path, 'r') as f:
        plugins_data = yaml.safe_load(f)

    with open(mkdocs_path, 'r') as f:
        mkdocs_data = yaml.safe_load(f)

    # docs/ directory is resolved relative to mkdocs.yml location
    docs_dir = Path(mkdocs_path).parent / mkdocs_data.get('docs_dir', 'docs')

    nav = mkdocs_data.get('nav', [])
    new_sections = convert_nav_to_llmstxt_sections(nav, docs_dir)

    plugins_list = plugins_data.get('plugins', [])
    for plugin in plugins_list:
        if isinstance(plugin, dict) and 'llmstxt' in plugin:
            plugin['llmstxt']['sections'] = new_sections
            print(f"✓ Updated llmstxt plugin configuration")
            print(f"  Total sections: {len(new_sections)}")
            break
    else:
        print("✗ llmstxt plugin not found in plugins.yml")
        return False

    with open(plugins_path, 'w') as f:
        yaml.dump(plugins_data, f, default_flow_style=False, sort_keys=False,
                  allow_unicode=True, width=120)

    print(f"✓ Updated {plugins_path}")
    return True
