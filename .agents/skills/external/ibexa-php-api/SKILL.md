---
name: ibexa-php-api
description: Work with the Ibexa DXP PHP API - resolve interfaces, services, and value objects from vendor sources before writing code. Use when writing or reviewing PHP code that uses Ibexa DXP APIs.
---

# Ibexa DXP PHP API

<!-- Placeholder skill: shipped with ibexa/documentation-developer, content to be expanded. -->

Before writing code against an Ibexa DXP API, check the real contracts in this
project's `vendor/` directory instead of guessing signatures.

## Resolving a class

- Namespaces map to packages via PSR-4, e.g. `Ibexa\Contracts\ProductCatalog\…`
  → `vendor/ibexa/product-catalog/src/contracts/…`.
- Public, stable APIs live under `Ibexa\Contracts\…` (`src/contracts/` in each
  package); classes outside `Contracts` are internal implementation.
- Find service methods: `grep -n "public function" vendor/ibexa/<package>/src/contracts/<…>Interface.php`.

## Guidelines

- Inject the `…ServiceInterface` contracts rather than concrete classes.
- Distinguish create/update structs (`…CreateStruct`, `…UpdateStruct`) from
  read-only value objects.
- Usage documentation and examples for each API are available locally — see the
  `ibexa-documentation` skill.
