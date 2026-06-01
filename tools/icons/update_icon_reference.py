#!/usr/bin/env python3
"""
Script to update the Icon Reference documentation with new icons from remote SVG file.
Downloads the icon file from the specified version's repository.
"""

import re
import xml.etree.ElementTree as ET
from pathlib import Path
from typing import List, Tuple
import subprocess
import os
import sys
import argparse
import urllib.request
import urllib.error


def extract_icon_ids_from_svg(svg_path: str) -> List[str]:
    """Extract icon IDs from the SVG file."""
    with open(svg_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Find all symbol elements with id attributes
    pattern = r'<symbol[^>]*id="([^"]*)"[^>]*>'
    matches = re.findall(pattern, content)
    
    # Remove duplicates and sort
    icon_ids = sorted(list(set(matches)))
    
    return icon_ids


def extract_single_icon_svg(svg_content: str, icon_id: str) -> str:
    """Extract a single icon's SVG content from the sprite."""
    # Find the symbol with the given ID
    pattern = rf'<symbol[^>]*id="{re.escape(icon_id)}"[^>]*>(.*?)</symbol>'
    match = re.search(pattern, svg_content, re.DOTALL)
    
    if not match:
        return None
    
    symbol_content = match.group(1)
    
    # Extract viewBox from the symbol
    viewbox_pattern = rf'<symbol[^>]*id="{re.escape(icon_id)}"[^>]*viewBox="([^"]*)"[^>]*>'
    viewbox_match = re.search(viewbox_pattern, svg_content)
    viewbox = viewbox_match.group(1) if viewbox_match else "0 0 32 32"
    
    # Create a standalone SVG
    standalone_svg = f'''<?xml version="1.0" encoding="UTF-8"?>
<svg viewBox="{viewbox}" xmlns="http://www.w3.org/2000/svg">
{symbol_content}
</svg>'''
    
    return standalone_svg


def generate_png_images(svg_path: str, icon_ids: List[str], output_dir: str) -> None:
    """Generate PNG images for each icon."""
    # Read the SVG sprite content
    with open(svg_path, 'r', encoding='utf-8') as f:
        svg_content = f.read()
    
    # Create output directory
    os.makedirs(output_dir, exist_ok=True)
    
    print(f"Generating PNG images for {len(icon_ids)} icons...")
    
    for icon_id in icon_ids:
        # Extract the icon SVG
        icon_svg = extract_single_icon_svg(svg_content, icon_id)
        
        if icon_svg:
            # Create temporary SVG file
            temp_svg_path = f"/tmp/{icon_id}.svg"
            with open(temp_svg_path, 'w', encoding='utf-8') as f:
                f.write(icon_svg)
            
            # Generate PNG using librsvg or imagemagick (fallback methods)
            png_path = f"{output_dir}/{icon_id}.svg.png"
            
            try:
                # Try rsvg-convert first (usually better quality)
                subprocess.run([
                    'rsvg-convert', '-w', '32', '-h', '32', 
                    temp_svg_path, '-o', png_path
                ], check=True, capture_output=True)
            except (subprocess.CalledProcessError, FileNotFoundError):
                try:
                    # Fallback to ImageMagick
                    subprocess.run([
                        'convert', '-background', 'transparent', '-size', '32x32',
                        temp_svg_path, png_path
                    ], check=True, capture_output=True)
                except (subprocess.CalledProcessError, FileNotFoundError):
                    print(f"Warning: Could not generate PNG for {icon_id}")
                    continue
            
            # Clean up temporary file
            os.remove(temp_svg_path)
            
            if os.path.exists(png_path):
                print(f"Generated: {png_path}")
            else:
                print(f"Failed to generate: {png_path}")


def generate_icon_table_rows(icon_ids: List[str]) -> List[str]:
    """Generate markdown table rows for the icon reference."""
    rows = []
    
    for icon_id in icon_ids:
        # Create the image reference
        img_ref = f"![{icon_id}](img/icons/{icon_id}.svg.png)"
        
        # Create table row
        row = f"| {img_ref} | `{icon_id}` |"
        rows.append(row)
    
    return rows


def update_icon_reference_file(file_path: str, new_rows: List[str]) -> None:
    """Update the icon reference markdown file with new icon table."""
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Find the start of the icon reference table
    table_start_pattern = r'(\| Icon\s+\| Identifier\s+\|\n\|[-\s]+\|[-\s]+\|)\n'
    table_start_match = re.search(table_start_pattern, content)
    
    if not table_start_match:
        print("Could not find icon reference table in the file")
        return
    
    # Find the end of the table (next heading or end of file)
    table_end_pattern = r'\n(?=\n##|\n###|\Z)'
    table_end_match = re.search(table_end_pattern, content[table_start_match.end():])
    
    if table_end_match:
        table_end_pos = table_start_match.end() + table_end_match.start()
    else:
        table_end_pos = len(content)
    
    # Replace the table content
    new_table_content = '\n'.join(new_rows)
    new_content = (
        content[:table_start_match.end()] + 
        new_table_content + 
        '\n' + 
        content[table_end_pos:]
    )
    
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(new_content)


def build_icon_url(version: str) -> str:
    """Build the URL for the icon file based on version."""
    base_url = "https://raw.githubusercontent.com/ibexa/admin-ui-assets/refs/tags"
    return f"{base_url}/v{version}/src/bundle/Resources/public/vendors/ids-assets/dist/img/all-icons.svg"


def download_icon_file(version: str, output_path: str) -> None:
    """Download the icon file from the remote repository."""
    url = build_icon_url(version)
    
    print(f"Downloading icon file from: {url}")
    
    try:
        urllib.request.urlretrieve(url, output_path)
        print(f"Successfully downloaded to: {output_path}")
    except urllib.error.HTTPError as e:
        print(f"Error downloading file: HTTP {e.code} - {e.reason}")
        print(f"URL: {url}")
        sys.exit(1)
    except urllib.error.URLError as e:
        print(f"Error downloading file: {e.reason}")
        sys.exit(1)
    except Exception as e:
        print(f"Error downloading file: {e}")
        sys.exit(1)


def main():
    """Main function to update the icon reference."""
    # Parse command line arguments
    parser = argparse.ArgumentParser(
        description="Update Icon Reference documentation with icons from remote SVG file"
    )
    parser.add_argument(
        "version",
        help="Version tag to download icons from (e.g., 5.0.0-rc1)"
    )
    parser.add_argument(
        "--keep-svg",
        action="store_true",
        help="Keep the downloaded SVG file after processing"
    )
    
    args = parser.parse_args()
    
    # Paths
    svg_path = f"docs/templating/twig_function_reference/img/ibexa-icons-{args.version}.svg"
    md_path = "docs/templating/twig_function_reference/icon_twig_functions.md"
    icons_dir = "docs/templating/twig_function_reference/img/icons"
    
    # Download the icon file
    download_icon_file(args.version, svg_path)
    
    try:
        print(f"Processing SVG file: {svg_path}")
        
        # Extract icon IDs
        icon_ids = extract_icon_ids_from_svg(svg_path)
        print(f"Found {len(icon_ids)} icons")
        
        # Generate PNG images
        generate_png_images(svg_path, icon_ids, icons_dir)
        
        # Generate table rows
        table_rows = generate_icon_table_rows(icon_ids)
        
        # Update the markdown file
        print(f"Updating documentation file: {md_path}")
        update_icon_reference_file(md_path, table_rows)
        
        print("Icon reference documentation updated successfully!")
        print(f"Icons processed: {len(icon_ids)}")
        
    finally:
        # Clean up the downloaded SVG file unless --keep-svg is specified
        if not args.keep_svg and os.path.exists(svg_path):
            os.remove(svg_path)
            print(f"Cleaned up downloaded file: {svg_path}")


if __name__ == "__main__":
    main()
