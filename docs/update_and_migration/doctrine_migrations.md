---
description: Update your installation's database schema.
month_change: true
---

# Ibexa Doctrine Migrations

Ibexa Doctrine Migrations is a tool to update your installation's database schema introduced in v6.0.0, v5.0.Y, and v4.6.3X for all editions.
It helps when moving to the latest patch version, it also helps when moving to a upper major version or to an upper edition of the product.

To be able to take advantage of Ibexa Doctrine Migrations, you need to be on a version including it.
Before changing your major version or your edition, move to the latest patch version of your current major version and edition.

TODO: For example:

- Headless v4.6.x [→ Headless v4.6.latest](update_from_4.6.md) [→ Headless v5.0.latest](update_to_5.0.md)
- Headless v5.0.x [→ Headless v5.0.latest](update_from_5.0.md) [→ Commerce v5.0.latest](#)
- Headless v4.6.x → Headless v4.6.latest → Headless v5.0.latest → Commerce v5.0.latest

## Upgrade product edition

TODO: Isn't it the main topic of this page?

Before starting, ensure you have the latest version of your current edition.

TODO:

```bash
composer require ibexa/commerce:[[= latest_tag_5_0 =]]
php bin/console ibexa:doctrine:migrations:migrate
```

TODO: Config?
