#!/usr/bin/env python3
"""
CLI wrapper to update the llmstxt plugin configuration in plugins.yml based on mkdocs.yml nav structure.

The actual conversion logic lives in the installable ``llms_txt`` package;
this script just runs it against this repo's plugins.yml/mkdocs.yml.
"""

from pathlib import Path

from llms_txt.update_llmstxt_config import update_plugins_yml

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
