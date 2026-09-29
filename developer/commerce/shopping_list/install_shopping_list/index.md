# Install shopping list

Install the Shopping list LTS update.

Editions: LTS Update, Commerce

## Install framework

Run the following command to install the package:

```bash
composer require ibexa/shopping-list
```

The associated Symfony Flex recipe configures the bundle and its routes.

Check that the following line has been added by the recipe to `config/bundles.php` file's array:

```php
return [
    // ...
    Ibexa\Bundle\ShoppingList\IbexaShoppingListBundle::class => ['all' => true],
];
```

And that you have a `config/routes/ibexa_shopping_list.yaml` file configuring the following routes:

```yaml
ibexa.shopping_list:
    resource: '@IbexaShoppingListBundle/Resources/config/routing.php'

ibexa.rest.shopping_list:
    resource: '@IbexaShoppingListBundle/Resources/config/routing_rest.php'
    prefix: '%ibexa.rest.path_prefix%'
```

## Modify database schema

Add the tables needed by the bundle:

**MySQL**

```sql
CREATE TABLE ibexa_shopping_list (
  id INT AUTO_INCREMENT NOT NULL,
  owner_id INT NOT NULL,
  identifier CHAR(36) NOT NULL COMMENT '(DC2Type:guid)',
  name VARCHAR(190) DEFAULT NULL,
  created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  updated_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  is_default TINYINT(1) DEFAULT 0 NOT NULL,
  UNIQUE INDEX ibexa_shopping_list_identifier_idx (identifier),
  INDEX ibexa_shopping_list_owner_idx (owner_id),
  INDEX ibexa_shopping_list_default_idx (is_default),
  PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;
CREATE TABLE ibexa_shopping_list_entry (
  id INT AUTO_INCREMENT NOT NULL,
  shopping_list_id INT NOT NULL,
  product_code VARCHAR(64) NOT NULL,
  identifier CHAR(36) NOT NULL COMMENT '(DC2Type:guid)',
  added_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  UNIQUE INDEX ibexa_shopping_list_entry_identifier_idx (identifier),
  INDEX ibexa_shopping_list_entry_list_idx (shopping_list_id),
  INDEX ibexa_shopping_list_entry_product_idx (product_code),
  INDEX ibexa_shopping_list_entry_added_at_idx (added_at),
  UNIQUE INDEX ibexa_shopping_list_entry_unique (shopping_list_id, product_code),
  PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;
ALTER TABLE ibexa_shopping_list
  ADD CONSTRAINT ibexa_shopping_list_owner_fk FOREIGN KEY (owner_id) REFERENCES ibexa_user (contentobject_id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE ibexa_shopping_list_entry
  ADD CONSTRAINT ibexa_shopping_list_entry_list_fk FOREIGN KEY (shopping_list_id) REFERENCES ibexa_shopping_list (id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE ibexa_shopping_list_entry
  ADD CONSTRAINT ibexa_shopping_list_entry_product_fk FOREIGN KEY (product_code) REFERENCES ibexa_product (code) ON UPDATE CASCADE ON DELETE CASCADE;
```

**PostgreSQL**

```sql
CREATE TABLE ibexa_shopping_list (
  id SERIAL NOT NULL,
  owner_id INT NOT NULL,
  identifier UUID NOT NULL,
  name VARCHAR(190) DEFAULT NULL,
  created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
  updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
  is_default BOOLEAN DEFAULT false NOT NULL,
  PRIMARY KEY (id)
);
CREATE UNIQUE INDEX ibexa_shopping_list_identifier_idx ON ibexa_shopping_list (identifier);
CREATE INDEX ibexa_shopping_list_owner_idx ON ibexa_shopping_list (owner_id);
CREATE INDEX ibexa_shopping_list_default_idx ON ibexa_shopping_list (is_default);
COMMENT ON COLUMN ibexa_shopping_list.created_at IS '(DC2Type:datetime_immutable)';
COMMENT ON COLUMN ibexa_shopping_list.updated_at IS '(DC2Type:datetime_immutable)';
CREATE TABLE ibexa_shopping_list_entry (
  id SERIAL NOT NULL,
  shopping_list_id INT NOT NULL,
  product_code VARCHAR(64) NOT NULL,
  identifier UUID NOT NULL,
  added_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
  PRIMARY KEY (id)
);
CREATE UNIQUE INDEX ibexa_shopping_list_entry_identifier_idx ON ibexa_shopping_list_entry (identifier);
CREATE INDEX ibexa_shopping_list_entry_list_idx ON ibexa_shopping_list_entry (shopping_list_id);
CREATE INDEX ibexa_shopping_list_entry_product_idx ON ibexa_shopping_list_entry (product_code);
CREATE INDEX ibexa_shopping_list_entry_added_at_idx ON ibexa_shopping_list_entry (added_at);
CREATE UNIQUE INDEX ibexa_shopping_list_entry_unique ON ibexa_shopping_list_entry (shopping_list_id, product_code);
COMMENT ON COLUMN ibexa_shopping_list_entry.added_at IS '(DC2Type:datetime_immutable)';
ALTER TABLE ibexa_shopping_list
  ADD CONSTRAINT ibexa_shopping_list_owner_fk FOREIGN KEY (owner_id) REFERENCES ibexa_user (contentobject_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE ibexa_shopping_list_entry
  ADD CONSTRAINT ibexa_shopping_list_entry_list_fk FOREIGN KEY (shopping_list_id) REFERENCES ibexa_shopping_list (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE ibexa_shopping_list_entry
  ADD CONSTRAINT ibexa_shopping_list_entry_product_fk FOREIGN KEY (product_code) REFERENCES ibexa_product (code) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
```

The script creates the required data structures, but doesn't add any data to the database.

The users don't have any shopping lists, not even the default “My Wishlist” list. The default shopping list is created automatically when the user triggers the "Add to wishlist" action for the first time.

## Configure

By default, the maximum shopping list count per user is 10 and the maximum entries per list is 100. When listing their shopping lists, the user see 25 lists per page (and as it's over the shopping list count, there is always one page of shopping lists in this default scenario).

You can override the following parameters to change their values:

```yaml
parameters:
    ibexa.site_access.config.default.shopping_list.limits.max_lists_per_user: 10
    ibexa.site_access.config.default.shopping_list.limits.max_entries_per_list: 100
    ibexa.site_access.config.default.shopping_list.pagination.list_per_page_limit: 25
```

> **Caution: Max lists per user and default shopping list**
>
> The customer can always create the default shopping list if it doesn't exist yet, even if they have already reached the limit defined by `max_lists_per_user`. So, for 10 as the default limit, the user may have 11 lists if the user created 10 custom lists before creating the default one. If you want to restrict users to only the default shopping list, you can set `max_lists_per_user` to 0.

### Shopping list user role

To allow customers to use the shopping list feature, create a new role and assign it to registered customer groups. To restrict authenticated users access to only their own lists, you must grant the four functions from the Shopping List module with the limitation 'Shopping List Owner: Self'. Otherwise, they will be able to interact with all shopping lists existing in the system. Anonymous users can't have shopping lists as they're internally sharing the same account.

To create such role, you can use a [migration file](../../../content_management/data_migration/importing_data/index.md#roles), for example, with the following content:

```yaml
-   type: role
    mode: create
    metadata:
        identifier: Shopping List User
    policies:
        -   module: shopping_list
            function: create
            limitations:
                -   identifier: ShoppingListOwner
                    values: [self]
        -   module: shopping_list
            function: view
            limitations:
                -   identifier: ShoppingListOwner
                    values: [self]
        -   module: shopping_list
            function: edit
            limitations:
                -   identifier: ShoppingListOwner
                    values: [self]
        -   module: shopping_list
            function: delete
            limitations:
                -   identifier: ShoppingListOwner
                    values: [self]
```

On a clean install, you can, for example, assign this "Shopping List User" role to the "Customers" user group.

After placing the migration content in `src/Migrations/Ibexa/migrations/shopping_list_user.yaml`, you can import and execute it with:

```bash
php bin/console ibexa:migrations:migrate --file=shopping_list_user.yaml --siteaccess=admin
```
