---
description: Update your installation to v5.0 from the latest v4.6 version.
month_change: true
---

# Update from v4.6 to v5.0

## Update from v4.6.x to v4.6.latest

Before you update to v5.0, you need to [update to the latest maintenance release of v4.6 (v[[= latest_tag_4_6 =]])](update_from_4.6.md).

## Update from v4.6.latest to v5.0.TODO

When you have the last version of 4.6, you can update to v5.0.

### Requirements

First, match v5.0's [requirements](requirements.md).
It supports only PHP 8.3 and above.

### Update custom code for PHP 8.3+ and DXP 4.6

If your DXP 4.6 is running on a PHP below 8.3, start migrating it to PHP 8.3.

Use Ibexa Rector to help yourself to upgrade PHP code for 8.3,
see [`ibexa/rector`'s README](https://github.com/ibexa/rector?tab=readme-ov-file#ibexa-dxp-rector) for more information about installation and usage.

Rector might also find out code deprecated in 4.6 which are likely removed in 5.0.
Update according to its report to reduce this debt and have less code not compatible with 5.0.

TODO: Example with our own code samples?
TODO: list of features deprecated in 4.6 removed in 5.0?

### TODO: Other updates like moving from any deprecated stuff?

### TODO: Install all 4.6 LTS Updates? It could help with the DB schemas or configs…

### Move from annotation to attribute

Delete [`config/routes/annotations.yaml`](https://github.com/symfony/recipes/blob/main/doctrine/annotations/1.0/config/routes/annotations.yaml) if you haven't customised it.

If you have customized it, you have to move from `type: annotation` to `type: attribute`.
TODO: Any help or recommendation to provide to the reader?

The `config/routes.yaml` file should start with the following declaration from [its recipe](https://github.com/symfony/recipes/blob/main/symfony/routing/7.0/config/routes.yaml):

```yaml
controllers:
    resource:
        path: ../src/Controller/
        namespace: App\Controller
    type: attribute
```

- You can delete the file and let the recipe recreate it. Then, if you have customized it, merge with your previous version from your version system.
- Or edit the file and copy-paste the new declaration at top of it.


```bash
rm config/routes/annotations.yaml
rm config/routes.yaml
```

### Remove Stimulus bootstrap

Edit `assets/app.js` and remove the following lines:

```
// start the Stimulus application
import './bootstrap';
```

Delete the bootstrap file:

```
rm assets/bootstrap.js
```

### Remove GraphQL schema

4.6 GraphQL isn't compatible with 5.0 so delete it.

TODO: Is `@=resolver` to `@=query` change need to be detailed?

```bash
rm -r config/graphql
```

### Update [[= product_name =]] application

#### Update package requirements

[[= product_name =]] 5.0 is based on Symfony 7.2 and both must be updated.
Your development package must be updated as well.
The process example below considers [`symfony/debug-pack`](https://symfony.com/packages/Debug%20Pack) and `ibexa/rector` as installed.

=== "[[= product_name_headless =]]"

    ```bash
    TODO
    ```
=== "[[= product_name_exp =]]"

    ```bash
    TODO
    ```
=== "[[= product_name_com =]]"

    ```bash
    # Update required PHP version
    composer require --no-update 'php:>=8.3';
    # Update required Symfony version
    composer config extra.symfony.require '7.2.*'
    # Upgrade Ibexa and Symfony packages: application
    composer require --no-update \
        ibexa/commerce:[[= latest_tag_5_0 =]] \
        symfony/console:^7.2 \
        symfony/dotenv:^7.2 \
        symfony/framework-bundle:^7.2 \
        symfony/runtime:^7.2 \
        symfony/yaml:^7.2 \
    ;
    # Upgrade Ibexa and Symfony packages: development tools
    ddev composer require --dev --no-update \
        ibexa/rector:[[= latest_tag_5_0 =]] \
        symfony/debug-bundle:^7.2 \
        symfony/stopwatch:^7.2 \
        symfony/web-profiler-bundle:^7.2 \
    ;
    # Update packages / Install new dependencies
    ddev composer update --with-all-dependencies --no-scripts --verbose
    ```

#### Remove 4.6 LTS Updates constraints

4.6 LTS Update packages are included by default in 5.0.
You can now remove them from your composer.json
so you don't have to maintain which of their versions your composer.json is referring to. 

TODO: Test the following command 

```bash
composer remove --no-update \
    ibexa/connector-ai \
    ibexa/collaboration \
    ibexa/share \
;
```

#### Update required packages

It's time to apply the new composer.json and update the dependencies:

TODO: 🤞

```bash
composer update --with-all-dependencies --no-scripts
```

#### Remove PHP 8.2 error handler

TODO: Do it earlier?

If you were using the [`Php82HideDeprecationsErrorHandler`](update_from_4.6.md#v468) to avoid deprecation messages,
you can remove it:

```bash
# Remove Php82HideDeprecationsErrorHandler
ddev composer config --unset extra.runtime.error_handler
```

#### Recipes

```bash
# Force recipes reset
rm symfony.lock
# Run recipes
composer recipes:install ibexa/commerce --force --yes -v
```

#### Sort commands

Recipe appends a command to `composer.json`'s `auto-scripts`.
You have to manually resort the commands so the `tsconfig.json` file
is created by `yarn ibexa-generate-tsconfig`
before being used by `ibexa:encore:compile`.
Your `auto-scripts` entry should look like this:

```json
        "auto-scripts": {
            "cache:clear": "symfony-cmd",
            "assets:install %PUBLIC_DIR%": "symfony-cmd",
            "yarn install": "script",
            "ibexa:encore:compile --config-name app": "symfony-cmd",
            "bazinga:js-translation:dump %PUBLIC_DIR%/assets --merge-domains": "symfony-cmd",
            "yarn ibexa-generate-tsconfig": "script",
            "ibexa:encore:compile": "symfony-cmd"
        },
```

#### Post update script

```bash
# Manually clear cache to ensure scripts won't use a piece of it
rm -rf var/cache
# A.k.a "auto-scripts"
composer run-script post-update-cmd
```

### Update database

Apply the following database update script:

### [[= product_name =]]

TODO: Rework 4.6 LTS Update schemas injection

=== "MySQL"

    ```bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.6.latest-to-5.0.0.sql
    # LTS Update related schemas to inject only if the add-on was never installed
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/collaboration/src/bundle/Resources/config/schema.yaml | mysql -u <username> -p <password> <database_name>
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/share/src/bundle/Resources/config/schema.yaml | mysql -u <username> -p <password> <database_name>
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/connector-ai/src/bundle/Resources/config/schema.yaml | mysql -u <username> -p <password> <database_name>
    ```

=== "PostgreSQL"

    ```bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.6.latest-to-5.0.0.sql
    # LTS Update related schemas to inject only if the add-on was never installed
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/collaboration/src/bundle/Resources/config/schema.yaml | psql <database_name>
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/share/src/bundle/Resources/config/schema.yaml | psql <database_name>
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/connector-ai/src/bundle/Resources/config/schema.yaml | psql <database_name>
    ```

TODO: Migration files? Content type updates?

Many tables are renamed. Some columns are also renamed.
If you have custom code directly querying those, you will need to update them.

You can track the renamming in the `ibexa-4.6.latest-to-5.0.0.sql` files or in the folded map below.

??? note "Renaming map"

    TODO: Keep up-to-date
    
    | old name                                  | new name                                            |
    |:------------------------------------------|:----------------------------------------------------|
    | ezbinaryfile                              | ibexa_binary_file                                   |
    | ezcobj_state                              | ibexa_object_state                                  |
    | ezcobj_state_group                        | ibexa_object_state_group                            |
    | ezcobj_state_group_language               | ibexa_object_state_group_language                   |
    | ezcobj_state_language                     | ibexa_object_state_language                         |
    | ezcobj_state_link                         | ibexa_object_state_link                             |
    | ezcontent_language                        | ibexa_content_language                              |
    | ezcontentbrowsebookmark                   | ibexa_content_bookmark                              |
    | ezcontentclass                            | ibexa_content_type                                  |
    | ezcontentclass_attribute                  | ibexa_content_type_field_definition                 |
    | ezcontentclass_attribute.contentclass_id  | ibexa_content_type_field_definition.content_type_id |
    | ezcontentclass_attribute_ml               | ibexa_content_type_field_definition_ml              |
    | ezcontentclass_classgroup                 | ibexa_content_type_group_assignment                 |
    | ezcontentclass_classgroup.contentclass_id | ibexa_content_type_group_assignment.content_type_id |
    | ezcontentclass_name                       | ibexa_content_type_name                             |
    | ezcontentclass_name.contentclass_id       | ibexa_content_type_name.content_type_id             |
    | ezcontentclassgroup                       | ibexa_content_type_group                            |
    | ezcontentobject                           | ibexa_content                                       |
    | ezcontentobject.contentclass_id           | ibexa_content.content_type_id                       |
    | ezcontentobject_attribute                 | ibexa_content_field                                 |
    | ezcontentobject_link                      | ibexa_content_relation                              |
    | ezcontentobject_name                      | ibexa_content_name                                  |
    | ezcontentobject_trash                     | ibexa_content_trash                                 |
    | ezcontentobject_tree                      | ibexa_content_tree                                  |
    | ezcontentobject_version                   | ibexa_content_version                               |
    | ezdatebasedpublisher_scheduled_entries    | ibexa_scheduler_scheduled_entries                   |
    | ezdfsfile                                 | ibexa_dfs_file                                      |
    | ezeditorialworkflow_markings              | ibexa_workflow_markings                             |
    | ezeditorialworkflow_transitions           | ibexa_workflow_transitions                          |
    | ezeditorialworkflow_workflows             | ibexa_workflow_workflows                            |
    | ezform_field_attributes                   | ibexa_form_field_attributes                         |
    | ezform_field_validators                   | ibexa_form_field_validators                         |
    | ezform_fields                             | ibexa_form_fields                                   |
    | ezform_form_submission_data               | ibexa_form_form_submission_data                     |
    | ezform_form_submissions                   | ibexa_form_form_submissions                         |
    | ezform_forms                              | ibexa_form_forms                                    |
    | ezgmaplocation                            | ibexa_map_location                                  |
    | ezimagefile                               | ibexa_image_file                                    |
    | ezkeyword                                 | ibexa_keyword                                       |
    | ezkeyword_attribute_link                  | ibexa_keyword_field_link                            |
    | ezmedia                                   | ibexa_media                                         |
    | eznode_assignment                         | ibexa_node_assignment                               |
    | eznotification                            | ibexa_notification                                  |
    | ezpackage                                 | ibexa_package                                       |
    | ezpage_attributes                         | ibexa_page_attributes                               |
    | ezpage_blocks                             | ibexa_page_blocks                                   |
    | ezpage_blocks_design                      | ibexa_page_blocks_design                            |
    | ezpage_blocks_visibility                  | ibexa_page_blocks_visibility                        |
    | ezpage_map_attributes_blocks              | ibexa_page_map_attributes_blocks                    |
    | ezpage_map_blocks_zones                   | ibexa_page_map_blocks_zones                         |
    | ezpage_map_zones_pages                    | ibexa_page_map_zones_pages                          |
    | ezpage_pages                              | ibexa_page_pages                                    |
    | ezpage_zones                              | ibexa_page_zones                                    |
    | ezpolicy                                  | ibexa_policy                                        |
    | ezpolicy_limitation                       | ibexa_policy_limitation                             |
    | ezpolicy_limitation_value                 | ibexa_policy_limitation_value                       |
    | ezpreferences                             | ibexa_preferences                                   |
    | ezrole                                    | ibexa_role                                          |
    | ezsearch_object_word_link                 | ibexa_search_object_word_link                       |
    | ezsearch_object_word_link.contentclass_id | ibexa_search_object_word_link.content_type_id       |
    | ezsearch_word                             | ibexa_search_word                                   |
    | ezsection                                 | ibexa_section                                       |
    | ezsite                                    | ibexa_site                                          |
    | ezsite_data                               | ibexa_site_data                                     |
    | ezsite_public_access                      | ibexa_site_public_access                            |
    | ezurl                                     | ibexa_url                                           |
    | ezurl_object_link                         | ibexa_url_content_link                              |
    | ezurlalias                                | ibexa_url_alias                                     |
    | ezurlalias_ml                             | ibexa_url_alias_ml                                  |
    | ezurlalias_ml_incr                        | ibexa_url_alias_ml_incr                             |
    | ezurlwildcard                             | ibexa_url_wildcard                                  |
    | ezuser                                    | ibexa_user                                          |
    | ezuser_accountkey                         | ibexa_user_accountkey                               |
    | ezuser_role                               | ibexa_user_role                                     |
    | ezuser_setting                            | ibexa_user_setting                                  |
    
    TODO: Something about renamed indexes?

TODO: Compatibility "views" layers? Even if there is this layer to save time, it is recommended to update your code to use the new tables.

#### Generate GraphQL schema

GraphQL is used by 4.6's Back Office
but isn't used by 5.0's one.

Optionally, if you are using GraphQL in your project, generate its schema:

```bash
php bin/console ibexa:graphql:generate-schema
```

### Update custom code for [[= product_name =]] 5.0

Update the `rector.php` file to use `IbexaSetList::IBEXA_50` rule set
by running the recipe:

```bash
composer recipe:install ibexa/rector --force --reset --yes
```

### Update Back Office extensions

TODO: Update JS, templates, CSS…
TODO: Some old deprecated Webpack file names were supported in 4.6 for backward compatibility; They aren't in 5.0
TODO: Conversion tables
