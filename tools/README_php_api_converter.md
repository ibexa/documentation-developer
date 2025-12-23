# PHP API Converter

This tool extracts method signatures from the generated PHP API HTML documentation and creates a compact Markdown file suitable for LLM consumption.

## Usage

1. **Build the documentation** (generates HTML files):
   ```bash
   ~/python/bin/python3.13 -m mkdocs build --strict
   ```

2. **Run the converter**:
   ```bash
   ~/python/bin/python3.13 tools/php_api_converter.py
   ```

## What it does

- **Input**: HTML files in `site/api/php_api/php_api_reference/classes/`
- **Output**: `docs/api/php_api/php_api_signatures.md`
- **Filtering**: Only includes `Ibexa\Contracts\*` classes (public API)
- **Extracts**: Public method signatures with parameter and return types

## Output Format

```markdown
## Ibexa\Contracts\Core\Repository\ContentService

- `loadContent(int $contentId[, array $languages = null[, int $versionNo = null]]) : Content`
- `createContent(ContentCreateStruct $contentCreateStruct, array $locationCreateStructs) : Content`
...
```

## Statistics

From the Ibexa DXP v5.0 documentation:
- **2,377 contract classes**
- **14,627 public methods**
- **~1.4 MB** output file
- **~19,000 lines**

## Integration

The generated file is included in the llmstxt output via `plugins.yml`:

```yaml
PHP API Reference (Signatures):
- api/php_api/php_api_reference.md   # Proxy/overview file
- api/php_api/php_api_signatures.md   # Full signatures
```

## Dependencies

- Python 3.13+
- No external dependencies (uses only stdlib `re` and `pathlib`)

## Regeneration

Re-run the converter after:
- Ibexa DXP version upgrades
- PHP API changes
- Documentation rebuilds

The tool processes all 2,486 HTML files in ~90 seconds.
