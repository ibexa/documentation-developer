# Ibexa DXP documentation

This package contains the official Ibexa DXP documentation as plain Markdown
files, generated from the same sources as the website. Install it into an Ibexa
DXP project so that AI coding assistants (and humans) can read the
documentation offline, right next to the code it describes:

```bash
composer require --dev ibexa/documentation-developer:~5.0
```

## Layout

- `developer/` — the [developer documentation](https://doc.ibexa.co/en/latest/):
  APIs, extension points, configuration, tutorials.
- `user/` — the [user documentation](https://doc.ibexa.co/projects/userguide/en/latest/):
  working with the back office, content management, commerce.
- Each set has its own `llms.txt` at its root (`developer/llms.txt`,
  `user/llms.txt`) — a table of contents with relative links. Start there to
  find the right page.
- One Markdown file per page, mirroring the URL structure of the website:
  `developer/<section>/.../<page>/index.md` corresponds to
  `https://doc.ibexa.co/en/latest/<section>/.../<page>/`, and
  `user/<section>/.../<page>/index.md` to
  `https://doc.ibexa.co/projects/userguide/en/latest/<section>/.../<page>/`.
- `.agents/skills/external/` — agent skills for working with Ibexa DXP. When
  the package is installed with Symfony Flex, its recipe copies them into your
  project's `.agents/skills/ibexa/` directory.

## Conventions

- Links between documentation pages are relative Markdown links and work
  offline — including cross-links between the developer and user documentation.
- PHP API references are links to the class source in your project's `vendor/`
  directory, with the fully qualified class name as the link text, for example
  ``[`Ibexa\Contracts\Core\Repository\SearchService`](../../../../core/src/contracts/Repository/SearchService.php)``.
  If your project doesn't include the package a class belongs to, the link
  target won't exist — the class name in the link text still tells you what the
  reference is.
- A few links have no local equivalent and stay absolute: images, the
  [PHP API reference](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/)
  itself, and other documentation sites (e.g. Ibexa Connect).

## Using with AI agents

Point your agent at this package, for example by adding to your project's
`CLAUDE.md` / `AGENTS.md`:

```markdown
Ibexa DXP documentation is installed locally in
vendor/ibexa/documentation-developer/: developer documentation in developer/,
user documentation in user/. To find a topic, read the set's table of contents
(developer/llms.txt or user/llms.txt) or search the Markdown files, then follow
the relative links. PHP API links in the docs point at the class sources in
vendor/.
```

## Versioning

A new tag is published whenever the generated documentation content changes;
tag names combine the documentation branch and the build date. Use a `~5.0`
constraint to stay on the documentation matching your Ibexa DXP version.

The documentation sources live on the version branches of
[ibexa/documentation-developer](https://github.com/ibexa/documentation-developer)
and [ibexa/documentation-user](https://github.com/ibexa/documentation-user)
— contributions are welcome there.
