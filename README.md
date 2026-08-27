# Ibexa DXP documentation

Official Ibexa DXP documentation as plain Markdown files.

## Installation

Run the following command:

```bash
composer require --dev ibexa/documentation-developer:~5.0 --no-scripts
```

## Content

This package contains two documentation sets:

- `developer` contains content of the [developer documentation](https://doc.ibexa.co/en/latest/).
- `user` contains content of the [user documentation](https://doc.ibexa.co/projects/userguide).

Each set has its own `llms.txt` at its root (`developer/llms.txt`, `user/llms.txt`) with a table of contents with relative links.

## Use with AI Agents

To use the documentation with AI agents, you can:

- use the `ibexa-documentation` Agent skill provided by this package (recommended)
- instruct the agent manually, by mentioning in the prompt:

``` text
Ibexa DXP documentation is installed locally in vendor/ibexa/documentation-developer/
```
