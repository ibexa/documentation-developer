#!/usr/bin/env python3
"""
Update the llmstxt plugin configuration in plugins.yml based on mkdocs.yml nav structure.
This script converts the mkdocs navigation into a format suitable for the llmstxt plugin,
using glob patterns where possible to simplify the configuration.
"""

import yaml
from pathlib import Path
from collections import defaultdict


def group_files_by_directory(files):
    """
    Group files by their directory and check if they can be represented by glob patterns.
    Returns a dict mapping directory paths to file lists.
    """
    files_by_dir = defaultdict(list)
    
    for file in files:
        if isinstance(file, str):
            file_path = Path(file)
            directory = str(file_path.parent)
            files_by_dir[directory].append(file)
    
    return files_by_dir


def convert_to_glob_patterns(files):
    """
    Convert a list of files to glob patterns where appropriate.
    Returns a list that may contain glob patterns or individual files.
    
    Strategy:
    - If multiple files from same directory: use glob pattern for that directory
    - If single file or files from different dirs: list individually
    - Exception: Don't glob release_notes directory (we filter by version)
    """
    if not files:
        return []
    
    # Group by directory
    files_by_dir = group_files_by_directory(files)
    
    result = []
    processed_dirs = set()
    
    # For each directory, decide whether to use glob or list files
    for directory, dir_files in sorted(files_by_dir.items()):
        if directory in processed_dirs:
            continue
        
        # Don't use glob for release_notes - we want to filter by version
        if 'release_notes' in directory:
            result.extend(dir_files)
            processed_dirs.add(directory)
            continue
        
        # Use glob if we have 2+ markdown files in the same directory
        if len(dir_files) >= 2 and all(Path(f).suffix == '.md' for f in dir_files):
            if directory:  # Not root
                result.append(f"{directory}/*.md")
            else:
                result.append("*.md")
            processed_dirs.add(directory)
        else:
            # Add files individually
            result.extend(dir_files)
    
    return result


def process_nav_section(nav_item):
    """
    Process a nav section and return a dict/list structure for llmstxt config.
    Preserves the hierarchical structure from mkdocs.yml and uses glob patterns where possible.
    """
    if isinstance(nav_item, str):
        # Direct file reference
        return nav_item
    
    if isinstance(nav_item, dict):
        result = {}
        for key, value in nav_item.items():
            # Skip excluded sections
            if should_exclude_section(key):
                continue
            if isinstance(value, str):
                # Single file under this section
                result[key] = [value]
            elif isinstance(value, list):
                # Process list items
                has_nested_sections = any(isinstance(item, dict) for item in value)
                
                if has_nested_sections:
                    # Check if all nested sections are simple file mappings from same directory
                    # If so, we can use a glob instead
                    all_files = []
                    all_simple = True
                    
                    for item in value:
                        if isinstance(item, str):
                            all_files.append(item)
                        elif isinstance(item, dict):
                            # Check if this is a simple single-file mapping
                            if len(item) == 1:
                                item_key, item_value = next(iter(item.items()))
                                if isinstance(item_value, str):
                                    all_files.append(item_value)
                                elif isinstance(item_value, list) and len(item_value) == 1:
                                    all_files.append(item_value[0])
                                else:
                                    all_simple = False
                                    break
                            else:
                                all_simple = False
                                break
                    
                    # If all items are from same directory, use glob
                    if all_simple and all_files:
                        glob_patterns = convert_to_glob_patterns(all_files)
                        # If we got a single glob pattern, use it directly
                        if len(glob_patterns) == 1 and '*.md' in glob_patterns[0]:
                            result[key] = glob_patterns
                        else:
                            # Otherwise, process normally
                            nested_result = {}
                            direct_files = []
                            
                            for item in value:
                                if isinstance(item, str):
                                    direct_files.append(item)
                                elif isinstance(item, dict):
                                    processed = process_nav_section(item)
                                    if isinstance(processed, dict):
                                        nested_result.update(processed)
                            
                            # Convert direct files to globs where possible
                            if direct_files:
                                direct_files = convert_to_glob_patterns(direct_files)
                            
                            # If we have both direct files and nested sections
                            if direct_files and nested_result:
                                result[key] = direct_files
                                result.update(nested_result)
                            elif nested_result:
                                result[key] = nested_result
                            elif direct_files:
                                result[key] = direct_files
                    else:
                        # Contains nested sections - recurse normally
                        nested_result = {}
                        direct_files = []
                        
                        for item in value:
                            if isinstance(item, str):
                                direct_files.append(item)
                            elif isinstance(item, dict):
                                processed = process_nav_section(item)
                                if isinstance(processed, dict):
                                    nested_result.update(processed)
                        
                        # Convert direct files to globs where possible
                        if direct_files:
                            direct_files = convert_to_glob_patterns(direct_files)
                        
                        # If we have both direct files and nested sections
                        if direct_files and nested_result:
                            result[key] = direct_files
                            result.update(nested_result)
                        elif nested_result:
                            result[key] = nested_result
                        elif direct_files:
                            result[key] = direct_files
                else:
                    # Only contains direct file references
                    files = [item for item in value if isinstance(item, str)]
                    if files:
                        # Convert to glob patterns where possible
                        glob_patterns = convert_to_glob_patterns(files)
                        result[key] = glob_patterns
        
        return result
    
    return None


def should_exclude_file(file_path):
    """
    Check if a file should be excluded based on its path or name.
    Excludes old version release notes and update documentation (pre-v4).
    """
    # Patterns to exclude from release notes and updates
    old_version_file_patterns = [
        # Release notes for v3.3 and older
        'ez_platform_v3.3', 'ez_platform_v3.2', 'ez_platform_v3.1', 'ez_platform_v3.0',
        'ez_platform_v2.5', 'ez_platform_v2.4', 'ez_platform_v2.3', 'ez_platform_v2.2',
        'ez_platform_v2.1', 'ez_platform_v2.0',
        'ez_platform_v1.13', 'ez_platform_v1.12', 'ez_platform_v1.11', 'ez_platform_v1.10',
        'ez_platform_v1.9', 'ez_platform_v1.8', 'ez_platform_v1.7',
        'ibexa_dxp_v3.3', 'ibexa_dxp_v3.2',
        # Deprecations for old versions
        'ez_platform_v3.0_deprecations',
        'ibexa_dxp_v4.0_deprecations',
        # Update guides for old versions (pre-v4)
        'from_1.x_2.x/', 'from_2.5/', 'from_3.3/',
    ]
    
    for pattern in old_version_file_patterns:
        if pattern in file_path:
            return True
    
    return False


def should_exclude_section(section_name):
    """
    Check if a section should be excluded based on exclusion rules.
    
    Exclusions:
    - Personalization
    - Update and release notes for versions older than v4 (3.3 and lower)
    - v4.0 deprecations
    """
    # Exclude Personalization
    if 'Personalization' in section_name or 'personalization' in section_name.lower():
        return True
    
    # Exclude v4.0 deprecations (but keep v5.0 deprecations)
    if 'v4.0 deprecations' in section_name or 'v4.0_deprecations' in section_name:
        return True
    
    # Exclude old version updates and releases (v3.3 and lower, v2.x, v1.x)
    old_version_patterns = [
        # Release notes for old versions
        'v3.3 LTS', 'v3.2', 'v3.1', 'v3.0',
        'v2.5', 'v2.4', 'v2.3', 'v2.2', 'v2.1', 'v2.0',
        'v1.13', 'v1.12', 'v1.11', 'v1.10', 'v1.9', 'v1.8', 'v1.7',
        # Update sections
        'from v1.13', 'from v2.', 'from 1.x', 'from 2.x',
        'Update from v1.13', 'Update from v2.5', 'Update from v3.3',
        # eZ Platform versions (all are pre-v4)
        'eZ Platform', 'ez Platform'
    ]
    
    for pattern in old_version_patterns:
        if pattern in section_name:
            return True
    
    return False


def convert_nav_to_llmstxt_sections(nav_list):
    """
    Convert mkdocs nav list to llmstxt sections format.
    The llmstxt plugin expects a dict where each value is a list of file paths.
    Uses glob patterns where possible to simplify the configuration.
    Applies exclusion filters for certain sections.
    """
    sections = {}
    
    def extract_files(item):
        """Recursively extract file paths from nav structure."""
        files = []
        if isinstance(item, str):
            # Skip HTML files (external references) and excluded files
            if not item.endswith('.html') and not should_exclude_file(item):
                files.append(item)
        elif isinstance(item, list):
            for subitem in item:
                files.extend(extract_files(subitem))
        elif isinstance(item, dict):
            for key, value in item.items():
                # Don't filter nested sections - only filter at top level
                if isinstance(value, str):
                    # Skip HTML files (external references) and excluded files
                    if not value.endswith('.html') and not should_exclude_file(value):
                        files.append(value)
                elif isinstance(value, list):
                    for subitem in value:
                        files.extend(extract_files(subitem))
        return files
    
    for item in nav_list:
        if isinstance(item, dict):
            for section_name, section_content in item.items():
                # Skip excluded sections (only at top level)
                if should_exclude_section(section_name):
                    continue
                
                # Extract all files from this section
                files = []
                if isinstance(section_content, str):
                    files.append(section_content)
                elif isinstance(section_content, list):
                    files.extend(extract_files(section_content))
                
                if files:
                    # Convert to glob patterns where appropriate
                    glob_patterns = convert_to_glob_patterns(files)
                    sections[section_name] = glob_patterns
        elif isinstance(item, str):
            # Top-level file
            if 'Ibexa Developer Documentation' not in sections:
                sections['Ibexa Developer Documentation'] = []
            sections['Ibexa Developer Documentation'].append(item)
    
    return sections


def update_plugins_yml(plugins_path, mkdocs_path):
    """
    Update the llmstxt plugin configuration in plugins.yml based on mkdocs.yml nav.
    """
    # Read both files
    with open(plugins_path, 'r') as f:
        plugins_data = yaml.safe_load(f)
    
    with open(mkdocs_path, 'r') as f:
        mkdocs_data = yaml.safe_load(f)
    
    # Convert nav to sections
    nav = mkdocs_data.get('nav', [])
    new_sections = convert_nav_to_llmstxt_sections(nav)
    
    # Find and update llmstxt plugin
    plugins_list = plugins_data.get('plugins', [])
    for i, plugin in enumerate(plugins_list):
        if isinstance(plugin, dict) and 'llmstxt' in plugin:
            # Update sections while preserving other settings
            plugin['llmstxt']['sections'] = new_sections
            print(f"✓ Updated llmstxt plugin configuration")
            print(f"  Total sections: {len(new_sections)}")
            break
    else:
        print("✗ llmstxt plugin not found in plugins.yml")
        return False
    
    # Write back to file
    with open(plugins_path, 'w') as f:
        yaml.dump(plugins_data, f, default_flow_style=False, sort_keys=False, 
                  allow_unicode=True, width=120)
    
    print(f"✓ Updated {plugins_path}")
    return True


if __name__ == '__main__':
    script_dir = Path(__file__).parent
    plugins_path = script_dir / 'plugins.yml'
    mkdocs_path = script_dir / 'mkdocs.yml'
    
    if not plugins_path.exists():
        print(f"✗ plugins.yml not found at {plugins_path}")
        exit(1)
    
    if not mkdocs_path.exists():
        print(f"✗ mkdocs.yml not found at {mkdocs_path}")
        exit(1)
    
    print("Updating llmstxt configuration...")
    print(f"Reading from: {mkdocs_path}")
    print(f"Updating: {plugins_path}")
    print()
    
    success = update_plugins_yml(plugins_path, mkdocs_path)
    exit(0 if success else 1)
