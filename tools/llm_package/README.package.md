# Ibexa DXP developer documentation

This package contains the official [Ibexa DXP developer documentation](https://doc.ibexa.co/en/latest/)
as plain Markdown files, generated from the same sources as the website. Install
it into an Ibexa DXP project so that AI coding assistants (and humans) can read
the documentation offline, right next to the code it describes:

```bash
composer require --dev ibexa/documentation-developer:~5.0
```

## Layout

- `llms.txt` — the table of contents for the whole documentation, with relative
  links into `doc/`. Start here to find the right page.
- `doc/` — one Markdown file per documentation page, mirroring the URL
  structure of the website: `doc/<section>/.../<page>/index.md` corresponds to
  `https://doc.ibexa.co/en/latest/<section>/.../<page>/`.

## Conventions

- Links between documentation pages are relative Markdown links and work
  offline.
- PHP API references are links to the class source in your project's `vendor/`
  directory, with the fully qualified class name as the link text, for example
  ``[`Ibexa\Contracts\Core\Repository\SearchService`](../../../../core/src/contracts/Repository/SearchService.php)``.
  If your project doesn't include the package a class belongs to, the link
  target won't exist — the class name in the link text still tells you what the
  reference is.
- A few links have no local equivalent and stay absolute: images, the
  [PHP API reference](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/)
  itself, and other documentation sites (user documentation, Ibexa Connect).

## Using with AI agents

Point your agent at this package, for example by adding to your project's
`CLAUDE.md` / `AGENTS.md`:

```markdown
Ibexa DXP developer documentation is installed locally in
vendor/ibexa/documentation-developer/. To find a topic, read
vendor/ibexa/documentation-developer/llms.txt (table of contents) or search
vendor/ibexa/documentation-developer/doc/, then follow the relative links.
PHP API links in the docs point at the class sources in vendor/.
```

## Versioning

A new tag is published whenever the generated documentation content changes;
tag names combine the documentation branch and the build date. Use a `~5.0`
constraint to stay on the documentation matching your Ibexa DXP version.

The documentation sources live on the version branches of
[ibexa/documentation-developer](https://github.com/ibexa/documentation-developer)
— contributions are welcome there.
