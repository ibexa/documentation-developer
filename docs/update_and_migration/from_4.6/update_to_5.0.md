---
description: Update your installation to v5.0 from the latest v4.6 version.
month_change: true
---

# Update from v4.6 to v5.0

## Update from v4.6.x to v4.6.latest

Before you update to v5.0, you need to [update to the latest maintenance release of v4.6 (v[[= latest_tag_4_6 =]])](update_from_4.6.md).

### Move from old to new Commerce

If circa v4.3 you kept [deprecated old Commerce packages](update_from_4.3_old_commerce.md),
you have to move to [new Commerce ones](update_from_4.3_new_commerce.md).

## Update from v4.6.latest to v5.0.0

When you have the last version of 4.6, you can update to v5.0.0.

### Requirements

First, match v5.0's [requirements](requirements.md).
It supports only PHP 8.3 and above.

### Update custom code for PHP 8.3+ and DXP 4.6

Rector helps to upgrade your code.

Install [`ibexa/rector`](https://github.com/ibexa/rector) which contains rules to ensure custom code is up to date with DXP 4.6:

```bash
composer require --dev ibexa/rector
```

Customize the `rector.php` config file.
Make is match your directory structure (for example, you may have to remove the `tests` directory).
You can add rules [for PHP with `withPhpSets`](https://getrector.com/documentation/set-lists#content-php-sets)
or [for Symfony with `withComposerBased`](https://getrector.com/blog/introducing-composer-version-based-sets).
It's recommended to activate one rule set at a time, run a first time with the `--dry-run` option,
check the output, and decide if kept right now, or discarded for another time.
TODO: Can it be kept for another time or will it break?
Your configuration could look like the following:

```php
return RectorConfig::configure()
    ->withPaths(
       [
           __DIR__ . '/src',
       ]
    )
    ->withSets(
       [
           IbexaSetList::IBEXA_46->value,
       ]
    )
    ->withPhpSets(php83: true)
    ->withComposerBased(symfony: true)
;
```

```bash
php vendor/bin/rector --dry-run
```

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
    ibexa/discounts \
    ibexa/discounts-codes \
;
```

#### Remove PHP 8.2 error handler

If you were using the [`Php82HideDeprecationsErrorHandler`](update_from_4.6.md#v468) to avoid deprecation messages,
you can remove it:

```bash
composer config --unset extra.runtime.error_handler
```

#### Update required packages

It's time to apply the new composer.json and update the dependencies:

TODO: 🤞

```bash
composer update --with-all-dependencies --no-scripts
```

#### Remove Stimulus bootstrap

To help moving from Symfony's Webpack Encore bundle 1.x to 2.x,
delete the Stimulus bootstrap file
and reset Webpack Encore recipe:

```
rm assets/bootstrap.js
composer recipes:install symfony/webpack-encore-bundle --reset --force --yes
```

#### Apply [[= product_name =]] recipe

=== "[[= product_name_headless =]]"

    ```bash
    composer recipes:install ibexa/headless --reset --force --yes
    ```

=== "[[= product_name_exp =]]"

    ```bash
    composer recipes:install ibexa/experience --reset --force --yes
    ```

=== "[[= product_name_com =]]"

    ```bash
    composer recipes:install ibexa/commerce --reset --force --yes
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
rm -rf var/cache
composer run-script post-update-cmd
```

### Update database

Apply the following database update script:

=== "MySQL"

    ```bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.6.latest-to-5.0.0.sql
    # LTS Update related schemas to inject only if the add-on was never installed
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/collaboration/src/bundle/Resources/config/schema.yaml | mysql -u <username> -p <password> <database_name>
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/share/src/bundle/Resources/config/schema.yaml | mysql -u <username> -p <password> <database_name>
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/connector-ai/src/bundle/Resources/config/schema.yaml | mysql -u <username> -p <password> <database_name>
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/discounts/src/bundle/Resources/config/schema.yaml | ddev mysql -u <username> -p <password> <database_name>
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/discounts-codes/src/bundle/Resources/config/schema.yaml | ddev mysql -u <username> -p <password> <database_name>
    ```

=== "PostgreSQL"

    ```bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.6.latest-to-5.0.0.sql
    # LTS Update related schemas to inject only if the add-on was never installed
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/collaboration/src/bundle/Resources/config/schema.yaml | psql <database_name>
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/share/src/bundle/Resources/config/schema.yaml | psql <database_name>
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/connector-ai/src/bundle/Resources/config/schema.yaml | psql <database_name>
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/discounts/src/bundle/Resources/config/schema.yaml | psql <database_name>
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/discounts-codes/src/bundle/Resources/config/schema.yaml | psql <database_name>
    ```

TODO: Migration files? Content type updates? Seems not.

Many tables are renamed. Some columns are also renamed.
If you have custom code directly querying those, you will need to update them.

You can track the renaming in the `ibexa-4.6.latest-to-5.0.0.sql` files or below.

??? note "Tables and columns renaming map"

    TODO: Keep up-to-date
    
    | old name                                              | new name                                                                |
    |:------------------------------------------------------|:------------------------------------------------------------------------|
    | ezbinaryfile                                          | ibexa_binary_file                                                       |
    | ezcobj_state                                          | ibexa_object_state                                                      |
    | ezcobj_state_group                                    | ibexa_object_state_group                                                |
    | ezcobj_state_group_language                           | ibexa_object_state_group_language                                       |
    | ezcobj_state_language                                 | ibexa_object_state_language                                             |
    | ezcobj_state_link                                     | ibexa_object_state_link                                                 |
    | ezcontent_language                                    | ibexa_content_language                                                  |
    | ezcontentbrowsebookmark                               | ibexa_content_bookmark                                                  |
    | ezcontentclass                                        | ibexa_content_type                                                      |
    | ezcontentclass_attribute                              | ibexa_content_type_field_definition                                     |
    | ezcontentclass_attribute.contentclass_id              | ibexa_content_type_field_definition.content_type_id                     |
    | ezcontentclass_attribute_ml                           | ibexa_content_type_field_definition_ml                                  |
    | ezcontentclass_attribute_ml.contentclass_attribute_id | ibexa_content_type_field_definition_ml.content_type_field_definition_id |
    | ezcontentclass_classgroup                             | ibexa_content_type_group_assignment                                     |
    | ezcontentclass_classgroup.contentclass_id             | ibexa_content_type_group_assignment.content_type_id                     |
    | ezcontentclass_name                                   | ibexa_content_type_name                                                 |
    | ezcontentclass_name.contentclass_id                   | ibexa_content_type_name.content_type_id                                 |
    | ezcontentclassgroup                                   | ibexa_content_type_group                                                |
    | ezcontentobject                                       | ibexa_content                                                           |
    | ezcontentobject.contentclass_id                       | ibexa_content.content_type_id                                           |
    | ezcontentobject_attribute                             | ibexa_content_field                                                     |
    | ezcontentobject_attribute.contentclassattribute_id    | ibexa_content_field.content_type_field_definition_id                    |
    | ezcontentobject_link                                  | ibexa_content_relation                                                  |
    | ezcontentobject_link.contentclassattribute_id         | ibexa_content_relation.content_type_field_definition_id                 |
    | ezcontentobject_name                                  | ibexa_content_name                                                      |
    | ezcontentobject_trash                                 | ibexa_content_trash                                                     |
    | ezcontentobject_tree                                  | ibexa_content_tree                                                      |
    | ezcontentobject_version                               | ibexa_content_version                                                   |
    | ezdatebasedpublisher_scheduled_entries                | ibexa_scheduler_scheduled_entries                                       |
    | ezdfsfile                                             | ibexa_dfs_file                                                          |
    | ezeditorialworkflow_markings                          | ibexa_workflow_markings                                                 |
    | ezeditorialworkflow_transitions                       | ibexa_workflow_transitions                                              |
    | ezeditorialworkflow_workflows                         | ibexa_workflow_workflows                                                |
    | ezform_field_attributes                               | ibexa_form_field_attributes                                             |
    | ezform_field_validators                               | ibexa_form_field_validators                                             |
    | ezform_fields                                         | ibexa_form_fields                                                       |
    | ezform_form_submission_data                           | ibexa_form_form_submission_data                                         |
    | ezform_form_submissions                               | ibexa_form_form_submissions                                             |
    | ezform_forms                                          | ibexa_form_forms                                                        |
    | ezgmaplocation                                        | ibexa_map_location                                                      |
    | ezimagefile                                           | ibexa_image_file                                                        |
    | ezkeyword                                             | ibexa_keyword                                                           |
    | ezkeyword_attribute_link                              | ibexa_keyword_field_link                                                |
    | ezmedia                                               | ibexa_media                                                             |
    | eznode_assignment                                     | ibexa_node_assignment                                                   |
    | eznotification                                        | ibexa_notification                                                      |
    | ezpackage                                             | ibexa_package                                                           |
    | ezpage_attributes                                     | ibexa_page_attributes                                                   |
    | ezpage_blocks                                         | ibexa_page_blocks                                                       |
    | ezpage_blocks_design                                  | ibexa_page_blocks_design                                                |
    | ezpage_blocks_visibility                              | ibexa_page_blocks_visibility                                            |
    | ezpage_map_attributes_blocks                          | ibexa_page_map_attributes_blocks                                        |
    | ezpage_map_blocks_zones                               | ibexa_page_map_blocks_zones                                             |
    | ezpage_map_zones_pages                                | ibexa_page_map_zones_pages                                              |
    | ezpage_pages                                          | ibexa_page_pages                                                        |
    | ezpage_zones                                          | ibexa_page_zones                                                        |
    | ezpolicy                                              | ibexa_policy                                                            |
    | ezpolicy_limitation                                   | ibexa_policy_limitation                                                 |
    | ezpolicy_limitation_value                             | ibexa_policy_limitation_value                                           |
    | ezpreferences                                         | ibexa_preferences                                                       |
    | ezrole                                                | ibexa_role                                                              |
    | ezsearch_object_word_link                             | ibexa_search_object_word_link                                           |
    | ezsearch_object_word_link.contentclass_id             | ibexa_search_object_word_link.content_type_id                           |
    | ezsearch_object_word_link.contentclass_attribute_id   | ibexa_search_object_word_link.content_type_field_definition_id          |
    | ezsearch_word                                         | ibexa_search_word                                                       |
    | ezsection                                             | ibexa_section                                                           |
    | ezsite                                                | ibexa_site                                                              |
    | ezsite_data                                           | ibexa_site_data                                                         |
    | ezsite_public_access                                  | ibexa_site_public_access                                                |
    | ezurl                                                 | ibexa_url                                                               |
    | ezurl_object_link                                     | ibexa_url_content_link                                                  |
    | ezurlalias                                            | ibexa_url_alias                                                         |
    | ezurlalias_ml                                         | ibexa_url_alias_ml                                                      |
    | ezurlalias_ml_incr                                    | ibexa_url_alias_ml_incr                                                 |
    | ezurlwildcard                                         | ibexa_url_wildcard                                                      |
    | ezuser                                                | ibexa_user                                                              |
    | ezuser_accountkey                                     | ibexa_user_accountkey                                                   |
    | ezuser_role                                           | ibexa_user_role                                                         |
    | ezuser_setting                                        | ibexa_user_setting                                                      |

    TODO: Something about renamed indexes?

TODO: Compatibility "views" layers? Even if there is this layer to save time, it is recommended to update your code to use the new tables.

### Generate GraphQL schema

4.6's Back Office uses GraphQL while 5.0's one doesn't.
But, optionally, if you are using GraphQL in your project, generate its schema:

```bash
php bin/console ibexa:graphql:generate-schema
```

### Update custom code for [[= product_name =]] 5.0

#### Update PHP framework standards

TODO: Merge up / deduplicate with DXP 4.6 / Symfony 5.4 usage of Rector above…

Update the `rector.php` file to use `IbexaSetList::IBEXA_50` rule set.
If you didn't edit it the first time, you can run its recipe:

```bash
composer recipe:install ibexa/rector --force --reset --yes
```

You can add some other rule sets (like, for example, the Symfony ones) to match newer standards.

Again, it's recommended to activate one set at a time, run a first time with the `--dry-run` option,
check the output, and decide if kept right now, or discarded for another time.

```php
//…
use Rector\Symfony\Set\SymfonySetList;
use Rector\Symfony\Set\SensiolabsSetList;
//…
   ->withSets(
       [
           IbexaSetList::IBEXA_50->value,
           SymfonySetList::SYMFONY_54, // https://getrector.com/find-rule?activeRectorSetGroup=symfony&rectorSet=symfony-symfonysymfony-54
           SymfonySetList::SYMFONY_60, // https://getrector.com/find-rule?activeRectorSetGroup=symfony&rectorSet=symfony-symfonysymfony-60
           SymfonySetList::SYMFONY_61, // https://getrector.com/find-rule?activeRectorSetGroup=symfony&rectorSet=symfony-symfonysymfony-61
           SymfonySetList::SYMFONY_62, // https://getrector.com/find-rule?activeRectorSetGroup=symfony&rectorSet=symfony-symfonysymfony-62
           SymfonySetList::SYMFONY_63, // https://getrector.com/find-rule?activeRectorSetGroup=symfony&rectorSet=symfony-symfonysymfony-63
           SymfonySetList::SYMFONY_64, // https://getrector.com/find-rule?activeRectorSetGroup=symfony&rectorSet=symfony-symfonysymfony-64
           SymfonySetList::SYMFONY_70, // https://getrector.com/find-rule?activeRectorSetGroup=symfony&rectorSet=symfony-symfonysymfony-70
           SymfonySetList::SYMFONY_71, // https://getrector.com/find-rule?activeRectorSetGroup=symfony&rectorSet=symfony-symfonysymfony-71
           SymfonySetList::SYMFONY_72, // https://getrector.com/find-rule?activeRectorSetGroup=symfony&rectorSet=symfony-symfonysymfony-72
           SymfonySetList::ANNOTATIONS_TO_ATTRIBUTES,
           SensiolabsSetList::ANNOTATIONS_TO_ATTRIBUTES,
       ]
   )
   ->withPhpSets()
   ->withComposerBased(twig: true, symfony: true)
   ->withAttributesSets(symfony: true, sensiolabs: true)
   ->withPreparedSets(
       deadCode: true, // https://getrector.com/find-rule?activeRectorSetGroup=core&rectorSet=core-dead-code
       codeQuality: true, // https://getrector.com/find-rule?activeRectorSetGroup=core&rectorSet=core-code-quality
       codingStyle: true, // https://getrector.com/find-rule?activeRectorSetGroup=core&rectorSet=core-coding-style
       typeDeclarations: true, // https://getrector.com/find-rule?activeRectorSetGroup=core&rectorSet=core-type-declarations
       // privatization: true, // https://getrector.com/find-rule?activeRectorSetGroup=core&rectorSet=core-privatization
       naming: true, // https://getrector.com/find-rule?activeRectorSetGroup=core&rectorSet=core-naming
       instanceOf: true, // https://getrector.com/find-rule?activeRectorSetGroup=core&rectorSet=core-instanceof
       earlyReturn: true, // https://getrector.com/find-rule?activeRectorSetGroup=core&rectorSet=core-early-return
       // strictBooleans: true, // https://getrector.com/find-rule?activeRectorSetGroup=core&rectorSet=core-strict-booleans
       rectorPreset: true,
       symfonyCodeQuality: true, // https://getrector.com/find-rule?activeRectorSetGroup=symfony&rectorSet=symfony-code-quality
       symfonyConfigs: true, // https://getrector.com/find-rule?activeRectorSetGroup=symfony&rectorSet=symfony-configs 
   );
```

TODO: Among other things, the type hinting strictness has been increased.

TODO: `AsCommand` attribute; Rector doesn't move `parent::__construct('app:test');` into `AsCommand`?

In the following example, you can see optimization thanks to the following features:

- [Constructor parameter promoted as properties](https://www.php.net/manual/en/language.oop5.decon.php#language.oop5.decon.constructor.promotion) (available since PHP 8.0)
- [`AsCommand` attribute to register a command](https://symfony.com/doc/7.2/console.html#console_registering-the-command) (available since Symfony 6.2)

```diff
+#[AsCommand(name: 'app:test', description: 'Command to test something.')]
 class TestCommand extends Command
 {
-    private Repository $repository;
-
-    public function __construct(Repository $repository)
+    public function __construct(private readonly Repository $repository)
     {
-        $this->repository = $repository;
-        parent::__construct('app:test');
     }
-
-     protected function configure()
-     {
-        $this->setDescription('Command to test something.');
-     }

      protected function execute(InputInterface $input, OutputInterface $output): int
```

#### Update field type identifiers

Several field type identifiers have changed.
Old identifiers are still supported, but it's recommended to migrate as soon as possible
and to include this action to the current version update task list.

You can list existing field type services with the command `php bin/console debug:container --tag=ibexa.field_type`.
The output as an `alias` column with new identifiers and a `legacy_alias` column with the old identifiers.

??? note "Field type identifiers renaming map"

    | old identifier (`legacy_alias`) | new identifier (`alias`)        |
    |:--------------------------------|:--------------------------------|
    | ibexa_address                   | ibexa_address                   |
    | ezauthor                        | ibexa_author                    |
    | ezbinaryfile                    | ibexa_binaryfile                |
    | ezboolean                       | ibexa_boolean                   |
    | ezcontentquery                  | ibexa_content_query             |
    | ezcountry                       | ibexa_country                   |
    | ibexa_customer_group            | ibexa_customer_group            |
    | ezdate                          | ibexa_date                      |
    | ezdatetime                      | ibexa_datetime                  |
    | ezemail                         | ibexa_email                     |
    | ezfloat                         | ibexa_float                     |
    | ezform                          | ibexa_form                      |
    | ezgmaplocation                  | ibexa_gmap_location             |
    | ezimage                         | ibexa_image                     |
    | ezimageasset                    | ibexa_image_asset               |
    | ezinteger                       | ibexa_integer                   |
    | ezisbn                          | ibexa_isbn                      |
    | ezkeyword                       | ibexa_keyword                   |
    | ezlandingpage                   | ibexa_landing_page              |
    | ezmatrix                        | ibexa_matrix                    |
    | ibexa_measurement               | ibexa_measurement               |
    | ezmedia                         | ibexa_media                     |
    | ezobjectrelation                | ibexa_object_relation           |
    | ezobjectrelationlist            | ibexa_object_relation_list      |
    | ibexa_product_specification     | ibexa_product_specification     |
    | ezrichtext                      | ibexa_richtext                  |
    | ezselection                     | ibexa_selection                 |
    | ibexa_seo                       | ibexa_seo                       |
    | ezstring                        | ibexa_string                    |
    | ibexa_taxonomy_entry            | ibexa_taxonomy_entry            |
    | ibexa_taxonomy_entry_assignment | ibexa_taxonomy_entry_assignment |
    | eztext                          | ibexa_text                      |
    | eztime                          | ibexa_time                      |
    | ezurl                           | ibexa_url                       |
    | ezuser                          | ibexa_user                      |


- Update in template
  - TODO: `{% block ezstring_field %)` → `{% block ibexa_string_field %}` (content_fields.html.twig) and others (field edit, field def, field def edit,…)
  - TODO: Configs, template paths, template rules, whatever needed…
- Update in migration files
- TODO: Update in DB?

### Update search indexes

TODO: Earlier?

TODO: For Solr and Elasticsearch, it seems that the schema/config/template haven't changed.
TODO: Is a re-index needed? Maybe not either. 

```
php bin/console ibexa:reindex
```

#### Update Back Office extensions

TODO: Update JS, templates, CSS…
TODO: Some old deprecated Webpack file names were supported in 4.6 for backward compatibility; They aren't in 5.0
TODO: Conversion tables
TODO: Icons
TODO: Shared with front?
