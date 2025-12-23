# Agent Instructions for Documentation Developer

## Building Documentation

To build the MkDocs documentation site, use the specific Python interpreter:

```bash
~/python/bin/python3.13 -m mkdocs build --strict
```

## llmstxt Plugin

The llmstxt plugin converts HTML output back to Markdown for LLM consumption.

### Preprocessing

A preprocessing script (`llmstxt_preprocess.py`) is configured to transform the cards macro HTML structure into markdown lists before conversion. This ensures that navigation cards are properly represented in the `llms-full.txt` output.

The cards macro generates HTML like:
```html
<div class="cards col-2">
    <div class="card-wrapper">
        <div>
            <a href="//doc.ibexa.co/en/latest/ai_actions/ai_actions_guide" class="card">
                <div>
                    <p class="title">AI Actions product guide</p>
                    <p class="description">AI Actions help editors by automating repetitive tasks.</p>
                </div>
            </a>
        </div>
    </div>
    <!-- more card-wrappers... -->
</div>
```

The preprocessing script converts these to markdown lists:
```markdown
- [AI Actions product guide](https://doc.ibexa.co/en/latest/ai_actions/ai_actions_guide) - AI Actions help editors by automating repetitive tasks.
- [Configure AI Actions](https://doc.ibexa.co/en/latest/ai_actions/configure_ai_actions) - Configure AI Actions.
```

Key transformations:
1. Groups of cards within a `<div class="cards ...">` wrapper are converted to unordered lists
2. Each card becomes a list item with a link and description
3. Protocol-relative URLs (`//`) are converted to HTTPS (`https://`)

### Configuration

The llmstxt plugin is configured in `plugins.yml`:

```yaml
- llmstxt:
    preprocess: llmstxt_preprocess.py
    markdown_description: |
      Ibexa DXP developer documentation...
    full_output: llms-full.txt
    sections:
      # ... section configuration
```
