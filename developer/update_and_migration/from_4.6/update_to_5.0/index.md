# Update from v4.6 to v5.0

Update your installation to v5.0 from the latest v4.6 version.

## Update from v4.6.x to v4.6.latest

Before you update to v5.0, you need to [update to the latest maintenance release of v4.6 (v4.6.32)](../update_from_4.6/index.md).

### Move from old to new Commerce

If you've chosen to use the [deprecated Commerce packages](../../from_4.3/update_from_4.3_old_commerce/index.md) during the update to 4.4, you have to move to [new Commerce ones](../../from_4.3/update_from_4.3_new_commerce/index.md).

## Update from v4.6.latest to v5.0.0

When you have the last version of 4.6, you can update to v5.0.0.

### Requirements

First, match v5.0's [requirements](../../../getting_started/requirements/index.md). It supports only PHP 8.3 and above.

### Update custom code for PHP 8.3+ and DXP 4.6

It's important to stop using deprecated PHP classes as they're removed in 5.0.

The [`ibexa/compatibility-layer`](../../from_3.3/to_4.0/index.md#add-compatibility-layer-package) isn't supported in 5.0. If you use it, remove it (`composer remove ibexa/compatibility-layer`) and make the necessary changes. See [Ibexa DXP v4.0 deprecations and backwards compatibility breaks](../../../release_notes/ibexa_dxp_v4.0_deprecations/index.md) for the list of changes.

[Rector](https://getrector.com/) and the Ibexa rule sets help to upgrade your code.

Install [`ibexa/rector`](https://github.com/ibexa/rector) which contains rules to ensure custom code is up to date with DXP 4.6:

```bash
composer require --dev ibexa/rector
```

Customize the `rector.php` config file by:

- making it match your directory structure (for example, you may not have the `tests` directory)
- adding project-specific rules:
  - specify [PHP rules by using `withPhpSets`](https://getrector.com/documentation/set-lists#content-php-sets)
  - specify [Symfony, Twig, or Doctrine rules by using `withComposerBased`](https://getrector.com/documentation/composer-based-sets).

It's recommended to activate one rule set at a time and preview the output by running Rector with the `--dry-run` option to decide which rulesets should be used and in which order.

Your configuration could look like the following example:

```php
use Ibexa\Contracts\Rector\Sets\IbexaSetList;
use Rector\Config\RectorConfig;

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

Run the following command to preview the changes done by Rector:

```bash
php vendor/bin/rector --dry-run
```

### Move from annotation to attribute

Delete [`config/routes/annotations.yaml`](https://github.com/symfony/recipes/blob/main/doctrine/annotations/1.0/config/routes/annotations.yaml) if you haven't customized it.

If you have customized it, change all occurrences of `type: annotation` to `type: attribute`.

The `config/routes.yaml` file should start with the following declaration from the [Symfony recipe](https://github.com/symfony/recipes/blob/main/symfony/routing/7.0/config/routes.yaml):

```yaml
controllers:
    resource:
        path: ../src/Controller/
        namespace: App\Controller
    type: attribute
```

You can add the new declaration to the top of the file manually, or recreate the file by running `composer sync-recipes symfony/routing --force --reset`.

### Remove GraphQL schema

The GraphQL schema used in 4.6 isn't compatible with version 5.0 and must be deleted. You can do it, for example, with the following command:

```bash
rm -r config/graphql
```

### Update Ibexa DXP application

#### Update package requirements

Ibexa DXP 5.0 is based on Symfony 7.3 and both must be updated. Your development packages must be updated as well. The example below assumes that [`symfony/debug-pack`](https://symfony.com/packages/debug-pack) and `ibexa/rector` are installed. Adjust the list based on your project requirements. Notice the use of the `--no-update` option to only edit the `composer.json` entries and avoid triggering the package update and Composer scripts.

**Ibexa Headless**

```bash
# Update required PHP version
composer require --no-update 'php:>=8.3';
# Update required Symfony version
composer config extra.symfony.require '7.3.*'
# Upgrade Ibexa and Symfony packages: application
composer require --no-update \
    ibexa/headless:5.0.10 \
    symfony/console:^7.3 \
    symfony/dotenv:^7.3 \
    symfony/framework-bundle:^7.3 \
    symfony/runtime:^7.3 \
    symfony/yaml:^7.3 \
;
# Upgrade Ibexa and Symfony packages: development tools
composer require --dev --no-update \
    ibexa/rector:5.0.10 \
    symfony/debug-bundle:^7.3 \
    symfony/stopwatch:^7.3 \
    symfony/web-profiler-bundle:^7.3 \
;
```

**Ibexa Experience**

```bash
# Update required PHP version
composer require --no-update 'php:>=8.3';
# Update required Symfony version
composer config extra.symfony.require '7.3.*'
# Upgrade Ibexa and Symfony packages: application
composer require --no-update \
    ibexa/experience:5.0.10 \
    symfony/console:^7.3 \
    symfony/dotenv:^7.3 \
    symfony/framework-bundle:^7.3 \
    symfony/runtime:^7.3 \
    symfony/yaml:^7.3 \
;
# Upgrade Ibexa and Symfony packages: development tools
composer require --dev --no-update \
    ibexa/rector:5.0.10 \
    symfony/debug-bundle:^7.3 \
    symfony/stopwatch:^7.3 \
    symfony/web-profiler-bundle:^7.3 \
;
```

**Ibexa Commerce**

```bash
# Update required PHP version
composer require --no-update 'php:>=8.3';
# Update required Symfony version
composer config extra.symfony.require '7.3.*'
# Upgrade Ibexa and Symfony packages: application
composer require --no-update \
    ibexa/commerce:5.0.10 \
    symfony/console:^7.3 \
    symfony/dotenv:^7.3 \
    symfony/framework-bundle:^7.3 \
    symfony/runtime:^7.3 \
    symfony/yaml:^7.3 \
;
# Upgrade Ibexa and Symfony packages: development tools
composer require --dev --no-update \
    ibexa/rector:5.0.10 \
    symfony/debug-bundle:^7.3 \
    symfony/stopwatch:^7.3 \
    symfony/web-profiler-bundle:^7.3 \
;
```

#### Remove 4.6 LTS Updates constraints

4.6 LTS Update packages are included by default in 5.0. Remove them from your composer.json to avoid updating their version manually with each update.

For example, the following command removes several released LTS Updates for 4.6 from `composer.json`:

```bash
composer remove --no-update \
    ibexa/connector-ai \
    ibexa/connector-openai \
    ibexa/product-catalog-date-time-attribute \
    ibexa/product-catalog-symbol-attribute \
    ibexa/discounts \
    ibexa/discounts-codes \
    ibexa/collaboration \
    ibexa/share \
;
```

#### Remove separate Elasticsearch 8 package

If you were using the separate `ibexa/elasticsearch8` package in v4.6, you should switch back to the built-in `ibexa/elasticsearch` package, as it now supports both Elasticsearch 7 and Elasticsearch 8.

```bash
composer remove --no-update ibexa/elasticsearch8
```

The `ibexa/elasticsearch` package is automatically installed as part of your Ibexa DXP 5.0 update. Your existing Elasticsearch 8 server and configuration continue to work with the `ibexa/elasticsearch` package.

#### Remove PHP 8.2 error handler

If you were using the [`Php82HideDeprecationsErrorHandler`](../update_from_4.6/index.md#v468) to avoid deprecation messages, you must remove it:

```bash
composer config --unset extra.runtime.error_handler
```

#### Update required packages

It's time to apply the new composer.json and update the dependencies:

```bash
composer update --with-all-dependencies --no-scripts
```

#### Remove Stimulus bootstrap

To help moving from Symfony's Webpack Encore bundle 1.x to 2.x, delete the Stimulus bootstrap file and reset Webpack Encore recipe:

```bash
rm assets/bootstrap.js
composer recipes:install symfony/webpack-encore-bundle --reset --force --yes
```

Compare with your previous version, merge them together and test your customizations if needed.

#### Apply Ibexa DXP recipe

**Ibexa Headless**

```bash
composer recipes:install ibexa/headless --reset --force --yes
```

**Ibexa Experience**

```bash
composer recipes:install ibexa/experience --reset --force --yes
```

**Ibexa Commerce**

```bash
composer recipes:install ibexa/commerce --reset --force --yes
```

#### Sort commands

Executing the recipes appends a new command at the end`composer.json`'s `auto-scripts` section, resulting in incorrect script order. You have to manually sort the commands so the `tsconfig.json` file is created by `yarn ibexa-generate-tsconfig` before being used by `ibexa:encore:compile`. Your `auto-scripts` entry should look like this:

```json
        "auto-scripts": {
            "cache:clear": "symfony-cmd",
            "assets:install %PUBLIC_DIR%": "symfony-cmd",
            "yarn install": "script",
            "yarn ibexa-generate-tsconfig --use-relative-paths": "script",
            "ibexa:encore:compile --config-name app": "symfony-cmd",
            "bazinga:js-translation:dump %PUBLIC_DIR%/assets --merge-domains": "symfony-cmd",
            "ibexa:encore:compile": "symfony-cmd",
            "ibexa:encore:compile --frontend-configs-name ibexa,internals,libs,richtext": "symfony-cmd"
        },
```

#### Remove Ibexa Icons

Remove from your `config/bundles.php` the line about `IbexaIconsBundle`.

#### Post update script

```bash
rm -rf var/cache
composer run-script post-update-cmd
```

### Update database

> **Caution: Caution**
>
> Always back up your data before running any database update scripts.
>
> After updating the database, clear the cache.
>
> Don't use `--force` argument for `mysql` / `psql` commands when performing update queries. If there is any problem during the update, it's best if the query fails immediately, so you can fix the underlying problem before you execute the update again. If you leave this for later you risk ending up with an incompatible database, though the problems might not surface immediately.

The main schema has changed and the provided SQL file `ibexa-4.6.latest-to-5.0.0.sql` updates it:

**MySQL**

```bash
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.6.latest-to-5.0.0.sql
```

**PostgreSQL**

```bash
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.6.latest-to-5.0.0.sql
```

Ibexa Open Source

If you don't have access to Ibexa DXP's `ibexa/installer` package, apply the following database update:

**MySQL**

```sql
-- Rename core related schema
ALTER TABLE ezbinaryfile RENAME TO ibexa_binary_file;

ALTER TABLE ezcobj_state RENAME TO ibexa_object_state;
ALTER TABLE ibexa_object_state RENAME INDEX ezcobj_state_priority TO ibexa_object_state_priority;
ALTER TABLE ibexa_object_state RENAME INDEX ezcobj_state_lmask TO ibexa_object_state_lmask;
ALTER TABLE ibexa_object_state RENAME INDEX ezcobj_state_identifier TO ibexa_object_state_identifier;

ALTER TABLE ezcobj_state_group RENAME TO ibexa_object_state_group;
ALTER TABLE ibexa_object_state_group RENAME INDEX ezcobj_state_group_lmask TO ibexa_object_state_group_lmask;
ALTER TABLE ibexa_object_state_group RENAME INDEX ezcobj_state_group_identifier TO ibexa_object_state_group_identifier;

ALTER TABLE ezcobj_state_group_language RENAME TO ibexa_object_state_group_language;

ALTER TABLE ezcobj_state_language RENAME TO ibexa_object_state_language;

ALTER TABLE ezcobj_state_link RENAME TO ibexa_object_state_link;

ALTER TABLE ezcontent_language RENAME TO ibexa_content_language;
ALTER TABLE ibexa_content_language RENAME INDEX ezcontent_language_name TO ibexa_content_language_name;

ALTER TABLE ezcontentbrowsebookmark RENAME TO ibexa_content_bookmark;
ALTER TABLE ibexa_content_bookmark RENAME INDEX ezcontentbrowsebookmark_location TO ibexa_content_bookmark_location;
ALTER TABLE ibexa_content_bookmark RENAME INDEX ezcontentbrowsebookmark_user TO ibexa_content_bookmark_user;
ALTER TABLE ibexa_content_bookmark RENAME INDEX ezcontentbrowsebookmark_user_location TO ibexa_content_bookmark_user_location;

ALTER TABLE ezcontentclass RENAME TO ibexa_content_type;
ALTER TABLE ibexa_content_type RENAME INDEX ezcontentclass_version TO ibexa_content_type_version;
ALTER TABLE ibexa_content_type RENAME INDEX ezcontentclass_identifier TO ibexa_content_type_identifier;

ALTER TABLE ezcontentclass_attribute RENAME TO ibexa_content_type_field_definition;
ALTER TABLE ibexa_content_type_field_definition RENAME INDEX ezcontentclass_attr_ccid TO ibexa_content_type_field_definition_ct_id;
ALTER TABLE ibexa_content_type_field_definition RENAME INDEX ezcontentclass_attr_dts TO ibexa_content_type_field_definition_dts;

ALTER TABLE ezcontentclass_attribute_ml RENAME TO ibexa_content_type_field_definition_ml;
ALTER TABLE ibexa_content_type_field_definition_ml DROP FOREIGN KEY ezcontentclass_attribute_ml_lang_fk;
ALTER TABLE ibexa_content_type_field_definition_ml ADD CONSTRAINT ibexa_content_type_field_definition_ml_lang_fk FOREIGN KEY (language_id) REFERENCES ibexa_content_language(id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE ezcontentclass_classgroup RENAME TO ibexa_content_type_group_assignment;

ALTER TABLE ezcontentclass_name RENAME TO ibexa_content_type_name;

ALTER TABLE ezcontentclassgroup RENAME TO ibexa_content_type_group;

ALTER TABLE ezcontentobject_tree RENAME TO ibexa_content_tree;
ALTER TABLE ibexa_content_tree RENAME INDEX ezcontentobject_tree_p_node_id TO ibexa_content_tree_p_node_id;
ALTER TABLE ibexa_content_tree RENAME INDEX ezcontentobject_tree_path_ident TO ibexa_content_tree_path_ident;
ALTER TABLE ibexa_content_tree RENAME INDEX ezcontentobject_tree_contentobject_id_path_string TO ibexa_content_tree_contentobject_id_path_string;
ALTER TABLE ibexa_content_tree RENAME INDEX ezcontentobject_tree_co_id TO ibexa_content_tree_co_id;
ALTER TABLE ibexa_content_tree RENAME INDEX ezcontentobject_tree_depth TO ibexa_content_tree_depth;
ALTER TABLE ibexa_content_tree RENAME INDEX ezcontentobject_tree_path TO ibexa_content_tree_path;
ALTER TABLE ibexa_content_tree RENAME INDEX modified_subnode TO ibexa_content_modified_subnode;
ALTER TABLE ibexa_content_tree RENAME INDEX ezcontentobject_tree_remote_id TO ibexa_content_tree_remote_id;

ALTER TABLE ibexa_content_bookmark DROP FOREIGN KEY ezcontentbrowsebookmark_location_fk;
ALTER TABLE ibexa_content_bookmark ADD CONSTRAINT ibexa_content_bookmark_location_fk FOREIGN KEY (node_id) REFERENCES ibexa_content_tree(node_id) ON DELETE CASCADE;

ALTER TABLE ezcontentobject RENAME TO ibexa_content;
ALTER TABLE ibexa_content RENAME INDEX ezcontentobject_classid TO ibexa_content_type_id;
ALTER TABLE ibexa_content RENAME INDEX ezcontentobject_lmask TO ibexa_content_lmask;
ALTER TABLE ibexa_content RENAME INDEX ezcontentobject_pub TO ibexa_content_pub;
ALTER TABLE ibexa_content RENAME INDEX ezcontentobject_section TO ibexa_content_section;
ALTER TABLE ibexa_content RENAME INDEX ezcontentobject_currentversion TO ibexa_content_currentversion;
ALTER TABLE ibexa_content RENAME INDEX ezcontentobject_owner TO ibexa_content_owner;
ALTER TABLE ibexa_content RENAME INDEX ezcontentobject_status TO ibexa_content_status;
ALTER TABLE ibexa_content RENAME INDEX ezcontentobject_remote_id TO ibexa_content_remote_id;

ALTER TABLE ezcontentobject_attribute RENAME TO ibexa_content_field;
ALTER TABLE ibexa_content_field RENAME INDEX ezcontentobject_attribute_co_id_ver_lang_code TO ibexa_content_field_co_id_ver_lang_code;
ALTER TABLE ibexa_content_field RENAME INDEX ezcontentobject_classattr_id TO ibexa_content_field_classattr_id;
ALTER TABLE ibexa_content_field RENAME INDEX ezcontentobject_attribute_language_code TO ibexa_content_field_language_code;
ALTER TABLE ibexa_content_field RENAME INDEX ezcontentobject_attribute_co_id_ver TO ibexa_content_field_co_id_ver;

ALTER TABLE ezcontentobject_link RENAME TO ibexa_content_relation;
ALTER TABLE ibexa_content_relation RENAME INDEX ezco_link_to_co_id TO ibexa_content_relation_to_co_id;
ALTER TABLE ibexa_content_relation RENAME INDEX ezco_link_from TO ibexa_content_relation_from;
ALTER TABLE ibexa_content_relation RENAME INDEX ezco_link_cca_id TO ibexa_content_relation_cca_id;

ALTER TABLE ezcontentobject_name RENAME TO ibexa_content_name;
ALTER TABLE ibexa_content_name RENAME INDEX ezcontentobject_name_lang_id TO ibexa_content_name_lang_id;
ALTER TABLE ibexa_content_name RENAME INDEX ezcontentobject_name_cov_id TO ibexa_content_name_cov_id;
ALTER TABLE ibexa_content_name RENAME INDEX ezcontentobject_name_name TO ibexa_content_name_name;

ALTER TABLE ezcontentobject_trash RENAME TO ibexa_content_trash;
ALTER TABLE ibexa_content_trash RENAME INDEX ezcobj_trash_depth TO ibexa_content_trash_depth;
ALTER TABLE ibexa_content_trash RENAME INDEX ezcobj_trash_p_node_id TO ibexa_content_trash_p_node_id;
ALTER TABLE ibexa_content_trash RENAME INDEX ezcobj_trash_path_ident TO ibexa_content_trash_path_ident;
ALTER TABLE ibexa_content_trash RENAME INDEX ezcobj_trash_co_id TO ibexa_content_trash_co_id;
ALTER TABLE ibexa_content_trash RENAME INDEX ezcobj_trash_modified_subnode TO ibexa_content_trash_modified_subnode;
ALTER TABLE ibexa_content_trash RENAME INDEX ezcobj_trash_path TO ibexa_content_trash_path;

ALTER TABLE ezcontentobject_version RENAME TO ibexa_content_version;
ALTER TABLE ibexa_content_version RENAME INDEX ezcobj_version_status TO ibexa_content_version_status;
ALTER TABLE ibexa_content_version RENAME INDEX idx_object_version_objver TO ibexa_content_version_idx_ver;
ALTER TABLE ibexa_content_version RENAME INDEX ezcontobj_version_obj_status TO ibexa_content_version_idx_status;
ALTER TABLE ibexa_content_version RENAME INDEX ezcobj_version_creator_id TO ibexa_content_version_creator_id;

ALTER TABLE ezdfsfile RENAME TO ibexa_dfs_file;
ALTER TABLE ibexa_dfs_file RENAME INDEX ezdfsfile_name_trunk TO ibexa_dfs_file_name_trunk;
ALTER TABLE ibexa_dfs_file RENAME INDEX ezdfsfile_expired_name TO ibexa_dfs_file_expired_name;
ALTER TABLE ibexa_dfs_file RENAME INDEX ezdfsfile_name TO ibexa_dfs_file_name;
ALTER TABLE ibexa_dfs_file RENAME INDEX ezdfsfile_mtime TO ibexa_dfs_file_mtime;

ALTER TABLE ezgmaplocation RENAME TO ibexa_map_location;
ALTER TABLE ibexa_map_location RENAME INDEX latitude_longitude_key TO ibexa_map_location_latitude_longitude_key;

ALTER TABLE ezimagefile RENAME TO ibexa_image_file;
ALTER TABLE ibexa_image_file RENAME INDEX ezimagefile_file TO ibexa_image_file_file;
ALTER TABLE ibexa_image_file RENAME INDEX ezimagefile_coid TO ibexa_image_file_coid;

ALTER TABLE ezkeyword RENAME TO ibexa_keyword;
ALTER TABLE ibexa_keyword RENAME INDEX ezkeyword_keyword TO ibexa_keyword_keyword;

ALTER TABLE ezkeyword_attribute_link RENAME TO ibexa_keyword_field_link;
ALTER TABLE ibexa_keyword_field_link RENAME INDEX ezkeyword_attr_link_oaid TO ibexa_keyword_field_link_oaid;
ALTER TABLE ibexa_keyword_field_link RENAME INDEX ezkeyword_attr_link_kid_oaid TO ibexa_keyword_field_link_kid_oaid;
ALTER TABLE ibexa_keyword_field_link RENAME INDEX ezkeyword_attr_link_oaid_ver TO ibexa_keyword_field_link_oaid_ver;

ALTER TABLE ezmedia RENAME TO ibexa_media;

ALTER TABLE eznode_assignment RENAME TO ibexa_node_assignment;
ALTER TABLE ibexa_node_assignment RENAME INDEX eznode_assignment_is_main TO ibexa_node_assignment_is_main;
ALTER TABLE ibexa_node_assignment RENAME INDEX eznode_assignment_coid_cov TO ibexa_node_assignment_coid_cov;
ALTER TABLE ibexa_node_assignment RENAME INDEX eznode_assignment_parent_node TO ibexa_node_assignment_parent_node;
ALTER TABLE ibexa_node_assignment RENAME INDEX eznode_assignment_co_version TO ibexa_node_assignment_co_version;

ALTER TABLE eznotification RENAME TO ibexa_notification;
ALTER TABLE ibexa_notification RENAME INDEX eznotification_owner_is_pending TO ibexa_notification_owner_is_pending;
ALTER TABLE ibexa_notification RENAME INDEX eznotification_owner TO ibexa_notification_owner;

ALTER TABLE ezpackage RENAME TO ibexa_package;

ALTER TABLE ezpolicy RENAME TO ibexa_policy;
ALTER TABLE ibexa_policy RENAME INDEX ezpolicy_role_id TO ibexa_policy_role_id;
ALTER TABLE ibexa_policy RENAME INDEX ezpolicy_original_id TO ibexa_policy_original_id;

ALTER TABLE ezpolicy_limitation RENAME TO ibexa_policy_limitation;
ALTER TABLE ibexa_policy_limitation RENAME INDEX policy_id TO ibexa_policy_id;

ALTER TABLE ezpolicy_limitation_value RENAME TO ibexa_policy_limitation_value;
ALTER TABLE ibexa_policy_limitation_value RENAME INDEX ezpolicy_limit_value_limit_id TO ibexa_policy_limit_value_limit_id;
ALTER TABLE ibexa_policy_limitation_value RENAME INDEX ezpolicy_limitation_value_val TO ibexa_policy_limitation_value_val;

ALTER TABLE ezpreferences RENAME TO ibexa_user_preference;
ALTER TABLE ibexa_user_preference RENAME INDEX ezpreferences_user_id_idx TO ibexa_user_preference_user_id_idx;
ALTER TABLE ibexa_user_preference RENAME INDEX ezpreferences_name TO ibexa_user_preference_name;

ALTER TABLE ezrole RENAME TO ibexa_role;

ALTER TABLE ezsearch_object_word_link RENAME TO ibexa_search_object_word_link;
ALTER TABLE ibexa_search_object_word_link RENAME INDEX ezsearch_object_word_link_object TO ibexa_search_object_word_link_object;
ALTER TABLE ibexa_search_object_word_link RENAME INDEX ezsearch_object_word_link_identifier TO ibexa_search_object_word_link_identifier;
ALTER TABLE ibexa_search_object_word_link RENAME INDEX ezsearch_object_word_link_integer_value TO ibexa_search_object_word_link_integer_value;
ALTER TABLE ibexa_search_object_word_link RENAME INDEX ezsearch_object_word_link_word TO ibexa_search_object_word_link_word;
ALTER TABLE ibexa_search_object_word_link RENAME INDEX ezsearch_object_word_link_frequency TO ibexa_search_object_word_link_frequency;

ALTER TABLE ezsearch_word RENAME TO ibexa_search_word;
ALTER TABLE ibexa_search_word RENAME INDEX ezsearch_word_word_i TO ibexa_search_word_word_i;
ALTER TABLE ibexa_search_word RENAME INDEX ezsearch_word_obj_count TO ibexa_search_word_obj_count;

ALTER TABLE ezsection RENAME TO ibexa_section;

ALTER TABLE ezsite_data RENAME TO ibexa_site_data;

ALTER TABLE ezurl RENAME TO ibexa_url;
ALTER TABLE ibexa_url RENAME INDEX ezurl_url TO ibexa_url_url;

ALTER TABLE ezurl_object_link RENAME TO ibexa_url_content_link;
ALTER TABLE ibexa_url_content_link RENAME INDEX ezurl_ol_coa_id TO ibexa_url_ol_coa_id;
ALTER TABLE ibexa_url_content_link RENAME INDEX ezurl_ol_url_id TO ibexa_url_ol_url_id;
ALTER TABLE ibexa_url_content_link RENAME INDEX ezurl_ol_coa_version TO ibexa_url_ol_coa_version;
ALTER TABLE ibexa_url_content_link RENAME INDEX ezurl_ol_coa_id_cav TO ibexa_url_ol_coa_id_cav;

ALTER TABLE ezurlalias RENAME TO ibexa_url_alias;
ALTER TABLE ibexa_url_alias RENAME INDEX ezurlalias_source_md5 TO ibexa_url_alias_source_md5;
ALTER TABLE ibexa_url_alias RENAME INDEX ezurlalias_wcard_fwd TO ibexa_url_alias_wcard_fwd;
ALTER TABLE ibexa_url_alias RENAME INDEX ezurlalias_forward_to_id TO ibexa_url_alias_forward_to_id;
ALTER TABLE ibexa_url_alias RENAME INDEX ezurlalias_imp_wcard_fwd TO ibexa_url_alias_imp_wcard_fwd;
ALTER TABLE ibexa_url_alias RENAME INDEX ezurlalias_source_url TO ibexa_url_alias_source_url;
ALTER TABLE ibexa_url_alias RENAME INDEX ezurlalias_desturl TO ibexa_url_alias_desturl;

ALTER TABLE ezurlalias_ml RENAME TO ibexa_url_alias_ml;
ALTER TABLE ibexa_url_alias_ml RENAME INDEX ezurlalias_ml_actt_org_al TO ibexa_url_alias_ml_actt_org_al;
ALTER TABLE ibexa_url_alias_ml RENAME INDEX ezurlalias_ml_text_lang TO ibexa_url_alias_ml_text_lang;
ALTER TABLE ibexa_url_alias_ml RENAME INDEX ezurlalias_ml_par_act_id_lnk TO ibexa_url_alias_ml_par_act_id_lnk;
ALTER TABLE ibexa_url_alias_ml RENAME INDEX ezurlalias_ml_par_lnk_txt TO ibexa_url_alias_ml_par_lnk_txt;
ALTER TABLE ibexa_url_alias_ml RENAME INDEX ezurlalias_ml_act_org TO ibexa_url_alias_ml_act_org;
ALTER TABLE ibexa_url_alias_ml RENAME INDEX ezurlalias_ml_text TO ibexa_url_alias_ml_text;
ALTER TABLE ibexa_url_alias_ml RENAME INDEX ezurlalias_ml_link TO ibexa_url_alias_ml_link;
ALTER TABLE ibexa_url_alias_ml RENAME INDEX ezurlalias_ml_id TO ibexa_url_alias_ml_id;

ALTER TABLE ezurlalias_ml_incr RENAME TO ibexa_url_alias_ml_incr;

ALTER TABLE ezurlwildcard RENAME TO ibexa_url_wildcard;

ALTER TABLE ezuser RENAME TO ibexa_user;
ALTER TABLE ibexa_user RENAME INDEX ezuser_login TO ibexa_user_login;

ALTER TABLE ezuser_accountkey RENAME TO ibexa_user_accountkey;

ALTER TABLE ezuser_role RENAME TO ibexa_user_role;
ALTER TABLE ibexa_user_role RENAME INDEX ezuser_role_role_id TO ibexa_user_role_role_id;
ALTER TABLE ibexa_user_role RENAME INDEX ezuser_role_contentobject_id TO ibexa_user_role_contentobject_id;

ALTER TABLE ezuser_setting RENAME TO ibexa_user_setting;

ALTER TABLE ibexa_content_bookmark DROP FOREIGN KEY ezcontentbrowsebookmark_user_fk;
ALTER TABLE ibexa_content_bookmark ADD CONSTRAINT ibexa_content_bookmark_user_fk FOREIGN KEY (user_id) REFERENCES ibexa_user(contentobject_id) ON DELETE CASCADE;

-- Rename contentclass_id column
ALTER TABLE ibexa_content_type_field_definition RENAME COLUMN contentclass_id TO content_type_id;
ALTER TABLE ibexa_content_type_group_assignment RENAME COLUMN contentclass_id TO content_type_id;
ALTER TABLE ibexa_content_type_name RENAME COLUMN contentclass_id TO content_type_id;
ALTER TABLE ibexa_content RENAME COLUMN contentclass_id TO content_type_id;
ALTER TABLE ibexa_search_object_word_link RENAME COLUMN contentclass_id TO content_type_id;

-- Update content type version to status
ALTER TABLE ibexa_content_type RENAME INDEX ibexa_content_type_version TO ibexa_content_type_status;
ALTER TABLE ibexa_content_type RENAME COLUMN version TO status;

ALTER TABLE ibexa_content_type_field_definition RENAME COLUMN version TO status;

ALTER TABLE ibexa_content_type_field_definition_ml RENAME COLUMN version TO status;

ALTER TABLE ibexa_content_type_group_assignment RENAME COLUMN contentclass_version TO content_type_status;
ALTER TABLE ibexa_content_type_name RENAME COLUMN contentclass_version TO content_type_status;

-- Rename user invitations tables
ALTER TABLE ibexa_user_invitations RENAME TO ibexa_user_invitation;
ALTER TABLE ibexa_user_invitation RENAME INDEX ibexa_user_invitations_email_idx TO ibexa_user_invitation_email_idx;
ALTER TABLE ibexa_user_invitation RENAME INDEX ibexa_user_invitations_hash_idx TO ibexa_user_invitation_hash_idx;
ALTER TABLE ibexa_user_invitation RENAME INDEX ibexa_user_invitations_email_uindex TO ibexa_user_invitation_email_uindex;
ALTER TABLE ibexa_user_invitation RENAME INDEX ibexa_user_invitations_hash_uindex TO ibexa_user_invitation_hash_uindex;

ALTER TABLE ibexa_user_invitations_assignments RENAME TO ibexa_user_invitation_assignment;
ALTER TABLE ibexa_user_invitation_assignment DROP FOREIGN KEY ibexa_user_invitations_assignments_ibexa_user_invitations_id_fk;
ALTER TABLE ibexa_user_invitation_assignment ADD CONSTRAINT ibexa_user_invitation_assignment_ibexa_user_invitation_id_fk
    FOREIGN KEY (invitation_id) REFERENCES ibexa_user_invitation(id) ON DELETE CASCADE ON UPDATE CASCADE;

-- Rename content type field definition ML columns
ALTER TABLE ibexa_content_type_field_definition_ml RENAME COLUMN contentclass_attribute_id TO content_type_field_definition_id;

-- Rename content field columns and indexes
ALTER TABLE ibexa_content_field RENAME COLUMN contentclassattribute_id TO content_type_field_definition_id;
ALTER TABLE ibexa_content_field RENAME INDEX ibexa_content_field_classattr_id TO ibexa_content_field_field_definition_id;

-- Update content relation columns and indexes
ALTER TABLE ibexa_content_relation RENAME COLUMN contentclassattribute_id TO content_type_field_definition_id;
ALTER TABLE ibexa_content_relation RENAME INDEX ibexa_content_relation_cca_id TO ibexa_content_relation_ccfd_id;

-- Update search object word link columns
ALTER TABLE ibexa_search_object_word_link RENAME COLUMN contentclass_attribute_id TO content_type_field_definition_id;
```

**PostgreSQL**

```sql
-- Rename core related schema
ALTER TABLE ezbinaryfile RENAME TO ibexa_binary_file;

ALTER TABLE ezcobj_state RENAME TO ibexa_object_state;
ALTER INDEX ezcobj_state_priority RENAME TO ibexa_object_state_priority;
ALTER INDEX ezcobj_state_lmask RENAME TO ibexa_object_state_lmask;
ALTER INDEX ezcobj_state_identifier RENAME TO ibexa_object_state_identifier;

ALTER TABLE ezcobj_state_group RENAME TO ibexa_object_state_group;
ALTER INDEX ezcobj_state_group_lmask RENAME TO ibexa_object_state_group_lmask;
ALTER INDEX ezcobj_state_group_identifier RENAME TO ibexa_object_state_group_identifier;

ALTER TABLE ezcobj_state_group_language RENAME TO ibexa_object_state_group_language;

ALTER TABLE ezcobj_state_language RENAME TO ibexa_object_state_language;

ALTER TABLE ezcobj_state_link RENAME TO ibexa_object_state_link;

ALTER TABLE ezcontent_language RENAME TO ibexa_content_language;
ALTER INDEX ezcontent_language_name RENAME TO ibexa_content_language_name;

ALTER TABLE ezcontentbrowsebookmark RENAME TO ibexa_content_bookmark;
ALTER INDEX ezcontentbrowsebookmark_location RENAME TO ibexa_content_bookmark_location;
ALTER INDEX ezcontentbrowsebookmark_user RENAME TO ibexa_content_bookmark_user;
ALTER INDEX ezcontentbrowsebookmark_user_location RENAME TO ibexa_content_bookmark_user_location;

ALTER TABLE ezcontentclass RENAME TO ibexa_content_type;
ALTER INDEX ezcontentclass_version RENAME TO ibexa_content_type_version;
ALTER INDEX ezcontentclass_identifier RENAME TO ibexa_content_type_identifier;

ALTER TABLE ezcontentclass_attribute RENAME TO ibexa_content_type_field_definition;
ALTER INDEX ezcontentclass_attr_ccid RENAME TO ibexa_content_type_field_definition_ct_id;
ALTER INDEX ezcontentclass_attr_dts RENAME TO ibexa_content_type_field_definition_dts;

ALTER TABLE ezcontentclass_attribute_ml RENAME TO ibexa_content_type_field_definition_ml;
ALTER TABLE ibexa_content_type_field_definition_ml DROP CONSTRAINT ezcontentclass_attribute_ml_lang_fk;
ALTER TABLE ibexa_content_type_field_definition_ml ADD CONSTRAINT ibexa_content_type_field_definition_ml_lang_fk FOREIGN KEY (language_id) REFERENCES ibexa_content_language(id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE ezcontentclass_classgroup RENAME TO ibexa_content_type_group_assignment;

ALTER TABLE ezcontentclass_name RENAME TO ibexa_content_type_name;

ALTER TABLE ezcontentclassgroup RENAME TO ibexa_content_type_group;

ALTER TABLE ezcontentobject_tree RENAME TO ibexa_content_tree;
ALTER INDEX ezcontentobject_tree_p_node_id RENAME TO ibexa_content_tree_p_node_id;
ALTER INDEX ezcontentobject_tree_path_ident RENAME TO ibexa_content_tree_path_ident;
ALTER INDEX ezcontentobject_tree_contentobject_id_path_string RENAME TO ibexa_content_tree_contentobject_id_path_string;
ALTER INDEX ezcontentobject_tree_co_id RENAME TO ibexa_content_tree_co_id;
ALTER INDEX ezcontentobject_tree_depth RENAME TO ibexa_content_tree_depth;
ALTER INDEX ezcontentobject_tree_path RENAME TO ibexa_content_tree_path;
ALTER INDEX modified_subnode RENAME TO ibexa_content_modified_subnode;
ALTER INDEX ezcontentobject_tree_remote_id RENAME TO ibexa_content_tree_remote_id;

ALTER TABLE ibexa_content_bookmark DROP CONSTRAINT ezcontentbrowsebookmark_location_fk;
ALTER TABLE ibexa_content_bookmark ADD CONSTRAINT ibexa_content_bookmark_location_fk FOREIGN KEY (node_id) REFERENCES ibexa_content_tree(node_id) ON DELETE CASCADE;

ALTER TABLE ezcontentobject RENAME TO ibexa_content;
ALTER INDEX ezcontentobject_classid RENAME TO ibexa_content_type_id;
ALTER INDEX ezcontentobject_lmask RENAME TO ibexa_content_lmask;
ALTER INDEX ezcontentobject_pub RENAME TO ibexa_content_pub;
ALTER INDEX ezcontentobject_section RENAME TO ibexa_content_section;
ALTER INDEX ezcontentobject_currentversion RENAME TO ibexa_content_currentversion;
ALTER INDEX ezcontentobject_owner RENAME TO ibexa_content_owner;
ALTER INDEX ezcontentobject_status RENAME TO ibexa_content_status;
ALTER INDEX ezcontentobject_remote_id RENAME TO ibexa_content_remote_id;

ALTER TABLE ezcontentobject_attribute RENAME TO ibexa_content_field;
ALTER INDEX ezcontentobject_attribute_co_id_ver_lang_code RENAME TO ibexa_content_field_co_id_ver_lang_code;
ALTER INDEX ezcontentobject_classattr_id RENAME TO ibexa_content_field_classattr_id;
ALTER INDEX ezcontentobject_attribute_language_code RENAME TO ibexa_content_field_language_code;
ALTER INDEX ezcontentobject_attribute_co_id_ver RENAME TO ibexa_content_field_co_id_ver;

ALTER TABLE ezcontentobject_link RENAME TO ibexa_content_relation;
ALTER INDEX ezco_link_to_co_id RENAME TO ibexa_content_relation_to_co_id;
ALTER INDEX ezco_link_from RENAME TO ibexa_content_relation_from;
ALTER INDEX ezco_link_cca_id RENAME TO ibexa_content_relation_cca_id;

ALTER TABLE ezcontentobject_name RENAME TO ibexa_content_name;
ALTER INDEX ezcontentobject_name_lang_id RENAME TO ibexa_content_name_lang_id;
ALTER INDEX ezcontentobject_name_cov_id RENAME TO ibexa_content_name_cov_id;
ALTER INDEX ezcontentobject_name_name RENAME TO ibexa_content_name_name;

ALTER TABLE ezcontentobject_trash RENAME TO ibexa_content_trash;
ALTER INDEX ezcobj_trash_depth RENAME TO ibexa_content_trash_depth;
ALTER INDEX ezcobj_trash_p_node_id RENAME TO ibexa_content_trash_p_node_id;
ALTER INDEX ezcobj_trash_path_ident RENAME TO ibexa_content_trash_path_ident;
ALTER INDEX ezcobj_trash_co_id RENAME TO ibexa_content_trash_co_id;
ALTER INDEX ezcobj_trash_modified_subnode RENAME TO ibexa_content_trash_modified_subnode;
ALTER INDEX ezcobj_trash_path RENAME TO ibexa_content_trash_path;

ALTER TABLE ezcontentobject_version RENAME TO ibexa_content_version;
ALTER INDEX ezcobj_version_status RENAME TO ibexa_content_version_status;
ALTER INDEX idx_object_version_objver RENAME TO ibexa_content_version_idx_ver;
ALTER INDEX ezcontobj_version_obj_status RENAME TO ibexa_content_version_idx_status;
ALTER INDEX ezcobj_version_creator_id RENAME TO ibexa_content_version_creator_id;

ALTER TABLE ezdfsfile RENAME TO ibexa_dfs_file;
ALTER INDEX ezdfsfile_name_trunk RENAME TO ibexa_dfs_file_name_trunk;
ALTER INDEX ezdfsfile_expired_name RENAME TO ibexa_dfs_file_expired_name;
ALTER INDEX ezdfsfile_name RENAME TO ibexa_dfs_file_name;
ALTER INDEX ezdfsfile_mtime RENAME TO ibexa_dfs_file_mtime;

ALTER TABLE ezgmaplocation RENAME TO ibexa_map_location;
ALTER INDEX latitude_longitude_key RENAME TO ibexa_map_location_latitude_longitude_key;

ALTER TABLE ezimagefile RENAME TO ibexa_image_file;
ALTER INDEX ezimagefile_file RENAME TO ibexa_image_file_file;
ALTER INDEX ezimagefile_coid RENAME TO ibexa_image_file_coid;

ALTER TABLE ezkeyword RENAME TO ibexa_keyword;
ALTER INDEX ezkeyword_keyword RENAME TO ibexa_keyword_keyword;

ALTER TABLE ezkeyword_attribute_link RENAME TO ibexa_keyword_field_link;
ALTER INDEX ezkeyword_attr_link_oaid RENAME TO ibexa_keyword_field_link_oaid;
ALTER INDEX ezkeyword_attr_link_kid_oaid RENAME TO ibexa_keyword_field_link_kid_oaid;
ALTER INDEX ezkeyword_attr_link_oaid_ver RENAME TO ibexa_keyword_field_link_oaid_ver;

ALTER TABLE ezmedia RENAME TO ibexa_media;

ALTER TABLE eznode_assignment RENAME TO ibexa_node_assignment;
ALTER INDEX eznode_assignment_is_main RENAME TO ibexa_node_assignment_is_main;
ALTER INDEX eznode_assignment_coid_cov RENAME TO ibexa_node_assignment_coid_cov;
ALTER INDEX eznode_assignment_parent_node RENAME TO ibexa_node_assignment_parent_node;
ALTER INDEX eznode_assignment_co_version RENAME TO ibexa_node_assignment_co_version;

ALTER TABLE eznotification RENAME TO ibexa_notification;
ALTER INDEX eznotification_owner_is_pending RENAME TO ibexa_notification_owner_is_pending;
ALTER INDEX eznotification_owner RENAME TO ibexa_notification_owner;

ALTER TABLE ezpackage RENAME TO ibexa_package;

ALTER TABLE ezpolicy RENAME TO ibexa_policy;
ALTER INDEX ezpolicy_role_id RENAME TO ibexa_policy_role_id;
ALTER INDEX ezpolicy_original_id RENAME TO ibexa_policy_original_id;

ALTER TABLE ezpolicy_limitation RENAME TO ibexa_policy_limitation;
ALTER INDEX policy_id RENAME TO ibexa_policy_id;

ALTER TABLE ezpolicy_limitation_value RENAME TO ibexa_policy_limitation_value;
ALTER INDEX ezpolicy_limit_value_limit_id RENAME TO ibexa_policy_limit_value_limit_id;
ALTER INDEX ezpolicy_limitation_value_val RENAME TO ibexa_policy_limitation_value_val;

ALTER TABLE ezpreferences RENAME TO ibexa_user_preference;
ALTER INDEX ezpreferences_user_id_idx RENAME TO ibexa_user_preference_user_id_idx;
ALTER INDEX ezpreferences_name RENAME TO ibexa_user_preference_name;

ALTER TABLE ezrole RENAME TO ibexa_role;

ALTER TABLE ezsearch_object_word_link RENAME TO ibexa_search_object_word_link;
ALTER INDEX ezsearch_object_word_link_object RENAME TO ibexa_search_object_word_link_object;
ALTER INDEX ezsearch_object_word_link_identifier RENAME TO ibexa_search_object_word_link_identifier;
ALTER INDEX ezsearch_object_word_link_integer_value RENAME TO ibexa_search_object_word_link_integer_value;
ALTER INDEX ezsearch_object_word_link_word RENAME TO ibexa_search_object_word_link_word;
ALTER INDEX ezsearch_object_word_link_frequency RENAME TO ibexa_search_object_word_link_frequency;

ALTER TABLE ezsearch_word RENAME TO ibexa_search_word;
ALTER INDEX ezsearch_word_word_i RENAME TO ibexa_search_word_word_i;
ALTER INDEX ezsearch_word_obj_count RENAME TO ibexa_search_word_obj_count;

ALTER TABLE ezsection RENAME TO ibexa_section;

ALTER TABLE ezsite_data RENAME TO ibexa_site_data;

ALTER TABLE ezurl RENAME TO ibexa_url;
ALTER INDEX ezurl_url RENAME TO ibexa_url_url;

ALTER TABLE ezurl_object_link RENAME TO ibexa_url_content_link;
ALTER INDEX ezurl_ol_coa_id RENAME TO ibexa_url_ol_coa_id;
ALTER INDEX ezurl_ol_url_id RENAME TO ibexa_url_ol_url_id;
ALTER INDEX ezurl_ol_coa_version RENAME TO ibexa_url_ol_coa_version;
ALTER INDEX ezurl_ol_coa_id_cav RENAME TO ibexa_url_ol_coa_id_cav;

ALTER TABLE ezurlalias RENAME TO ibexa_url_alias;
ALTER INDEX ezurlalias_source_md5 RENAME TO ibexa_url_alias_source_md5;
ALTER INDEX ezurlalias_wcard_fwd RENAME TO ibexa_url_alias_wcard_fwd;
ALTER INDEX ezurlalias_forward_to_id RENAME TO ibexa_url_alias_forward_to_id;
ALTER INDEX ezurlalias_imp_wcard_fwd RENAME TO ibexa_url_alias_imp_wcard_fwd;
ALTER INDEX ezurlalias_source_url RENAME TO ibexa_url_alias_source_url;
ALTER INDEX ezurlalias_desturl RENAME TO ibexa_url_alias_desturl;

ALTER TABLE ezurlalias_ml RENAME TO ibexa_url_alias_ml;
ALTER INDEX ezurlalias_ml_actt_org_al RENAME TO ibexa_url_alias_ml_actt_org_al;
ALTER INDEX ezurlalias_ml_text_lang RENAME TO ibexa_url_alias_ml_text_lang;
ALTER INDEX ezurlalias_ml_par_act_id_lnk RENAME TO ibexa_url_alias_ml_par_act_id_lnk;
ALTER INDEX ezurlalias_ml_par_lnk_txt RENAME TO ibexa_url_alias_ml_par_lnk_txt;
ALTER INDEX ezurlalias_ml_act_org RENAME TO ibexa_url_alias_ml_act_org;
ALTER INDEX ezurlalias_ml_text RENAME TO ibexa_url_alias_ml_text;
ALTER INDEX ezurlalias_ml_link RENAME TO ibexa_url_alias_ml_link;
ALTER INDEX ezurlalias_ml_id RENAME TO ibexa_url_alias_ml_id;

ALTER TABLE ezurlalias_ml_incr RENAME TO ibexa_url_alias_ml_incr;

ALTER TABLE ezurlwildcard RENAME TO ibexa_url_wildcard;

ALTER TABLE ezuser RENAME TO ibexa_user;
ALTER INDEX ezuser_login RENAME TO ibexa_user_login;

ALTER TABLE ezuser_accountkey RENAME TO ibexa_user_accountkey;

ALTER TABLE ezuser_role RENAME TO ibexa_user_role;
ALTER INDEX ezuser_role_role_id RENAME TO ibexa_user_role_role_id;
ALTER INDEX ezuser_role_contentobject_id RENAME TO ibexa_user_role_contentobject_id;

ALTER TABLE ezuser_setting RENAME TO ibexa_user_setting;

ALTER TABLE ibexa_content_bookmark DROP CONSTRAINT ezcontentbrowsebookmark_user_fk;
ALTER TABLE ibexa_content_bookmark ADD CONSTRAINT ibexa_content_bookmark_user_fk FOREIGN KEY (user_id) REFERENCES ibexa_user(contentobject_id) ON DELETE CASCADE;

-- Rename contentclass_id column
ALTER TABLE ibexa_content_type_field_definition RENAME COLUMN contentclass_id TO content_type_id;
ALTER TABLE ibexa_content_type_group_assignment RENAME COLUMN contentclass_id TO content_type_id;
ALTER TABLE ibexa_content_type_name RENAME COLUMN contentclass_id TO content_type_id;
ALTER TABLE ibexa_content RENAME COLUMN contentclass_id TO content_type_id;
ALTER TABLE ibexa_search_object_word_link RENAME COLUMN contentclass_id TO content_type_id;

-- Update content type version to status
ALTER INDEX ibexa_content_type_version RENAME TO ibexa_content_type_status;
ALTER TABLE ibexa_content_type RENAME COLUMN version TO status;

ALTER TABLE ibexa_content_type_field_definition RENAME COLUMN version TO status;

ALTER TABLE ibexa_content_type_field_definition_ml RENAME COLUMN version TO status;

ALTER TABLE ibexa_content_type_group_assignment RENAME COLUMN contentclass_version TO content_type_status;
ALTER TABLE ibexa_content_type_name RENAME COLUMN contentclass_version TO content_type_status;

-- Rename user invitations tables
ALTER TABLE ibexa_user_invitations RENAME TO ibexa_user_invitation;
ALTER INDEX ibexa_user_invitations_email_idx RENAME TO ibexa_user_invitation_email_idx;
ALTER INDEX ibexa_user_invitations_hash_idx RENAME TO ibexa_user_invitation_hash_idx;
ALTER INDEX ibexa_user_invitations_email_uindex RENAME TO ibexa_user_invitation_email_uindex;
ALTER INDEX ibexa_user_invitations_hash_uindex RENAME TO ibexa_user_invitation_hash_uindex;

ALTER TABLE ibexa_user_invitations_assignments RENAME TO ibexa_user_invitation_assignment;
ALTER TABLE ibexa_user_invitation_assignment DROP CONSTRAINT ibexa_user_invitations_assignments_ibexa_user_invitations_id_fk;
ALTER TABLE ibexa_user_invitation_assignment ADD CONSTRAINT ibexa_user_invitation_assignment_ibexa_user_invitation_id_fk
    FOREIGN KEY (invitation_id) REFERENCES ibexa_user_invitation(id) ON DELETE CASCADE ON UPDATE CASCADE;

-- Rename content type field definition ML columns
ALTER TABLE ibexa_content_type_field_definition_ml RENAME COLUMN contentclass_attribute_id TO content_type_field_definition_id;

-- Rename content field columns and indexes
ALTER TABLE ibexa_content_field RENAME COLUMN contentclassattribute_id TO content_type_field_definition_id;
ALTER INDEX ibexa_content_field_classattr_id RENAME TO ibexa_content_field_field_definition_id;

-- Update content relation columns and indexes
ALTER TABLE ibexa_content_relation RENAME COLUMN contentclassattribute_id TO content_type_field_definition_id;
ALTER INDEX ibexa_content_relation_cca_id RENAME TO ibexa_content_relation_ccfd_id;

-- Update search object word link columns
ALTER TABLE ibexa_search_object_word_link RENAME COLUMN contentclass_attribute_id TO content_type_field_definition_id;

-- Rename core sequence names to match new table names
ALTER SEQUENCE ezcobj_state_group_id_seq RENAME TO ibexa_object_state_group_id_seq;
ALTER SEQUENCE ezcobj_state_id_seq RENAME TO ibexa_object_state_id_seq;
ALTER SEQUENCE ezcontentbrowsebookmark_id_seq RENAME TO ibexa_content_bookmark_id_seq;
ALTER SEQUENCE ezcontentclass_attribute_id_seq RENAME TO ibexa_content_type_field_definition_id_seq;
ALTER SEQUENCE ezcontentclass_id_seq RENAME TO ibexa_content_type_id_seq;
ALTER SEQUENCE ezcontentclassgroup_id_seq RENAME TO ibexa_content_type_group_id_seq;
ALTER SEQUENCE ezcontentobject_attribute_id_seq RENAME TO ibexa_content_field_id_seq;
ALTER SEQUENCE ezcontentobject_id_seq RENAME TO ibexa_content_id_seq;
ALTER SEQUENCE ezcontentobject_link_id_seq RENAME TO ibexa_content_relation_id_seq;
ALTER SEQUENCE ezcontentobject_tree_node_id_seq RENAME TO ibexa_content_tree_node_id_seq;
ALTER SEQUENCE ezcontentobject_version_id_seq RENAME TO ibexa_content_version_id_seq;
ALTER SEQUENCE ezimagefile_id_seq RENAME TO ibexa_image_file_id_seq;
ALTER SEQUENCE ezkeyword_attribute_link_id_seq RENAME TO ibexa_keyword_field_link_id_seq;
ALTER SEQUENCE ezkeyword_id_seq RENAME TO ibexa_keyword_id_seq;
ALTER SEQUENCE eznode_assignment_id_seq RENAME TO ibexa_node_assignment_id_seq;
ALTER SEQUENCE eznotification_id_seq RENAME TO ibexa_notification_id_seq;
ALTER SEQUENCE ezpackage_id_seq RENAME TO ibexa_package_id_seq;
ALTER SEQUENCE ezpolicy_id_seq RENAME TO ibexa_policy_id_seq;
ALTER SEQUENCE ezpolicy_limitation_id_seq RENAME TO ibexa_policy_limitation_id_seq;
ALTER SEQUENCE ezpolicy_limitation_value_id_seq RENAME TO ibexa_policy_limitation_value_id_seq;
ALTER SEQUENCE ezpreferences_id_seq RENAME TO ibexa_user_preference_id_seq;
ALTER SEQUENCE ezrole_id_seq RENAME TO ibexa_role_id_seq;
ALTER SEQUENCE ezsearch_object_word_link_id_seq RENAME TO ibexa_search_object_word_link_id_seq;
ALTER SEQUENCE ezsearch_word_id_seq RENAME TO ibexa_search_word_id_seq;
ALTER SEQUENCE ezsection_id_seq RENAME TO ibexa_section_id_seq;
ALTER SEQUENCE ezurl_id_seq RENAME TO ibexa_url_id_seq;
ALTER SEQUENCE ezurlalias_id_seq RENAME TO ibexa_url_alias_id_seq;
ALTER SEQUENCE ezurlalias_ml_incr_id_seq RENAME TO ibexa_url_alias_ml_incr_id_seq;
ALTER SEQUENCE ezurlwildcard_id_seq RENAME TO ibexa_url_wildcard_id_seq;
ALTER SEQUENCE ezuser_accountkey_id_seq RENAME TO ibexa_user_accountkey_id_seq;
ALTER SEQUENCE ezuser_role_id_seq RENAME TO ibexa_user_role_id_seq;
```

As this script targets all editions, on editions lower than Commerce you may encounter errors about missing tables which can safely be ignored.

Many tables and columns are renamed. If you have custom code directly querying those, you will need to update them.

You can track the renaming in the `ibexa-4.6.latest-to-5.0.0.sql` file or below.

Tables and columns renaming map

| Old name                                              | New name                                                                |
| ----------------------------------------------------- | ----------------------------------------------------------------------- |
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

DFS (Distributed File System)

If [DFS IO handler](../../../infrastructure_and_maintenance/clustering/clustering/index.md#dfs-io-handler) is used and, as recommended, its table is on its own database, you'll have to rename table and columns there. Here are the DFS renaming queries (extracted from `ibexa-4.6.latest-to-5.0.0.sql`):

```sql
ALTER TABLE ezdfsfile RENAME TO ibexa_dfs_file;
ALTER TABLE ibexa_dfs_file RENAME INDEX ezdfsfile_name_trunk TO ibexa_dfs_file_name_trunk;
ALTER TABLE ibexa_dfs_file RENAME INDEX ezdfsfile_expired_name TO ibexa_dfs_file_expired_name;
ALTER TABLE ibexa_dfs_file RENAME INDEX ezdfsfile_name TO ibexa_dfs_file_name;
ALTER TABLE ibexa_dfs_file RENAME INDEX ezdfsfile_mtime TO ibexa_dfs_file_mtime;
```

### Update custom code for Ibexa DXP 5.0

See [Ibexa DXP v5.0 deprecations and backwards compatibility breaks](../../../release_notes/ibexa_dxp_v5.0_deprecations/index.md) for the list of changes. The following sections presents some of those changes and how to apply them.

#### Update PHP framework standards

Among other things, previously deprecated classes have been removed, and the type hinting strictness has been increased.

Update the `rector.php` file to use [`IbexaSetList::IBEXA_50`](../../../../../../ibexa/rector/src/contracts/Sets/IbexaSetList.php) rule set. If you didn't edit it the first time, you can run its recipe:

```bash
composer recipe:install ibexa/rector --force --reset --yes
```

You can adjust the other rule sets (for example, the Symfony ones) to match higher versions.

Again, it's recommended to activate one rule set at a time and preview the output by running Rector with the `--dry-run` option to decide which rulesets should be used and in which order.

As this update spans across a broad range of versions, multiple rules can be considered as in the example below.

```php
//…
use Ibexa\Contracts\Rector\Sets\IbexaSetList;
use Rector\Config\RectorConfig;
use Rector\Symfony\Set\SymfonySetList;

return RectorConfig::configure()
    // ...
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
           SymfonySetList::SYMFONY_73, // https://getrector.com/find-rule?activeRectorSetGroup=symfony&rectorSet=symfony-symfonysymfony-73
           SymfonySetList::ANNOTATIONS_TO_ATTRIBUTES,
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
       privatization: true, // https://getrector.com/find-rule?activeRectorSetGroup=core&rectorSet=core-privatization
       naming: true, // https://getrector.com/find-rule?activeRectorSetGroup=core&rectorSet=core-naming
       instanceOf: true, // https://getrector.com/find-rule?activeRectorSetGroup=core&rectorSet=core-instanceof
       earlyReturn: true, // https://getrector.com/find-rule?activeRectorSetGroup=core&rectorSet=core-early-return
       rectorPreset: true,
       symfonyCodeQuality: true, // https://getrector.com/find-rule?activeRectorSetGroup=symfony&rectorSet=symfony-code-quality
       symfonyConfigs: true, // https://getrector.com/find-rule?activeRectorSetGroup=symfony&rectorSet=symfony-configs
   );
```

In the following example, you can see optimization thanks to the following features:

- [Constructor parameter promoted as properties](https://www.php.net/manual/en/language.oop5.decon.php#language.oop5.decon.constructor.promotion) (available since PHP 8.0)
- [`AsCommand` attribute to register a command](https://symfony.com/doc/7.4/console.html#creating-a-command) (available since Symfony 6.2)

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

#### Update JavaScript

If you haven't renamed your Webpack file since 3.3, do it now as v5.0 no longer supports the old names.

| Old name                    | New name                       |
| --------------------------- | ------------------------------ |
| ez.config.js                | ibexa.config.js                |
| ez.config.manager.js        | ibexa.config.manager.js        |
| ez.webpack.custom.config.js | ibexa.webpack.custom.config.js |

`ibexa/rector` 5.0 also comes with the [JavaScript Transform module](https://github.com/ibexa/rector/blob/v5.0.0/js/README.md) to help you maintain your JavaScript code.

Customize the `rector.config.js` config file by:

- making it match your directory structure
- modifying the list of enabled plugins and their configuration

The example below is made to fix in place the JS files from `asset/js/` directory, and is ready to enable plugin rule sets one at a time (plugin path is relative to `vendor/ibexa/rector/` directory).

```js
module.exports = {
    config: {
        paths: [
            {
                input: 'assets/js',
                output: 'assets/js',
            },
        ],
    },
    plugins: (plugins) => {
        return [
            './js/ibexa-rename-ez-global.js',
            //'./js/ibexa-rename-variables.js',
            //'./js/ibexa-rename-string-values.js',
            //'./js/ibexa-rename-trans-id.js',
            //'./js/ibexa-rename-in-translations.js',
            //'./js/ibexa-rename-icons.js',
        ];
    },
    pluginsConfig: (config) => {
        return config;
    },
};
```

Install the tool dependencies once with the following command:

```bash
yarn --cwd ./vendor/ibexa/rector/js install
```

Run it using the following command:

```bash
yarn --cwd ./vendor/ibexa/rector/js transform
```

#### Update field type identifiers

Several field type identifiers have changed. The old identifiers are still supported, but it's recommended to migrate as soon as possible.

You can list existing field type services with the command `php bin/console debug:container --tag=ibexa.field_type`. The output as an `alias` column with new identifiers and a `legacy_alias` column with the old identifiers.

Field type identifiers renaming map

| old identifier (`legacy_alias`) | new identifier (`alias`)        |
| ------------------------------- | ------------------------------- |
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

You may have to update them in several places, for example:

- Update the field identifiers in templates to display or edit fields or their definition. For example, in a `@IbexaCore/content_fields.html.twig` extension, `{% block ezstring_field %)` must be changed for `{% block ibexa_string_field %}`
- Update the field identifiers in migration files

#### Update icons

The provided built-it icon set has been changed.

The `ibexa/rector` JavaScript Transform module's plugin `ibexa-rename-icons.js` refactors the icon usage in JavaScript files. You may have to update them in other contexts, for example, in configuration files associating icons to content types or Page Builder blocks.

The icon library file's path changed from `/bundles/ibexaicons/img/all-icons.svg` to `/bundles/ibexaadminuiassets/vendors/ids-assets/dist/img/all-icons.svg`.

Some icons have been renamed. You can find an [`ibexa-rename-icons` map in `vendor/ibexa/rector/js/rules.config.json` (`"old-name": "new-name"`)](https://github.com/ibexa/rector/blob/v5.0.0/js/rules.config.json#L63).

Icons renaming map

| Old name                | New name                     |
| ----------------------- | ---------------------------- |
| about-info              | help                         |
| about                   | info-square                  |
| airtime                 | signal-radio                 |
| align-center            | align-text-center            |
| align-justify           | align-text-justified         |
| align-left              | align-text-left              |
| align-right             | align-text-right             |
| approved                | check-circle                 |
| article                 | file-text                    |
| assign-section          | assign                       |
| author                  | user-editor                  |
| autosave-error          | cloud-error                  |
| autosave-off            | cloud-discard                |
| autosave-on             | cloud                        |
| autosave-saved          | cloud-check                  |
| autosave-saving         | cloud-synch                  |
| b2b                     | handshake                    |
| back                    | arrow-left                   |
| back-current-date       | calendar-back                |
| bestseller              | badge-star                   |
| block-invisible         | block-hidden                 |
| block-visible-recurring | block-lock                   |
| blog                    | app-blog                     |
| blog_post               | note-blog                    |
| bold                    | text-bold                    |
| bookmark                | favourite-outline            |
| bookmark-active         | favourite-filled             |
| bookmark-manager        | book                         |
| box-collapse            | arrow-move-right             |
| browse                  | folder-browse                |
| bubbles                 | message-bubble               |
| business-deal-cash      | user-money                   |
| button                  | cursor-clicked               |
| campaign                | speaker                      |
| captcha                 | form-captcha                 |
| caret-back              | arrow-chevron-left           |
| caret-double-back       | arrow-double-left            |
| caret-double-next       | arrow-double-right           |
| caret-down              | arrow-chevron-down           |
| caret-expanded          | arrow-double-left            |
| caret-next              | arrow-chevron-right          |
| caret-up                | arrow-chevron-up             |
| cart                    | shopping-cart                |
| cart-full               | shopping-cart                |
| cart-upload             | shopping-cart-arrow-up       |
| cart-wishlist           | shopping-cart-heart          |
| category                | tag                          |
| checkbox                | form-checkbox                |
| checkbox-multiple       | form-check-list              |
| checkmark               | form-check                   |
| circle-caret-down       | chevron-down-circle          |
| circle-caret-left       | chevron-left-circle          |
| circle-caret-right      | chevron-right-circle         |
| circle-caret-up         | chevron-up-circle            |
| circle-close            | discard-circle               |
| circle-create           | add-circle                   |
| circle-minus            | minus-circle                 |
| circle-pause            | minus-circle                 |
| clicked-recommendations | cursor-clicked-hand          |
| clipboard               | clipboard-check              |
| collapse                | arrow-collapse-right         |
| content-write           | file-text-write              |
| column-settings         | table-settings-column        |
| comment                 | message                      |
| components              | box-component                |
| connect                 | connection                   |
| content-draft           | draft                        |
| contentlist             | list-content                 |
| content-list            | list-content                 |
| content-type            | tools                        |
| content-type-content    | file-type                    |
| content-type-group      | tool-group                   |
| copy-subtree            | content-tree-copy            |
| create                  | add                          |
| create-content          | file-add                     |
| create-location         | content-tree-create-location |
| customer                | user-customer                |
| customer-portal         | device-monitor-user          |
| customer-portal-page    | app-user                     |
| customer-type           | device-monitor-type          |
| custom_tags             | prompt                       |
| date                    | calendar                     |
| date-updated            | calendar-reload              |
| discount-coupon         | discount-ticket              |
| drafts                  | edit-draft                   |
| dropdown                | form-dropdown                |
| earth-access            | world-cursor                 |
| embed                   | text-embedded                |
| embed-inline            | text-embedded-inline         |
| erp                     | connection-erp               |
| error                   | exclamation-mark             |
| error-icon              | file-warning                 |
| expand-left             | arrow-expand-left            |
| expand-right            | arrow-expand-right           |
| explore                 | ai                           |
| fields                  | form-input                   |
| file-video              | video                        |
| flash                   | lightning                    |
| focus                   | arrows-outside               |
| focus-image             | focus-target                 |
| folder-empty            | folder-open                  |
| form                    | form-check-square            |
| full-view               | arrows-full-view             |
| future-publication      | calendar-clock               |
| gallery                 | image-gallery                |
| go-right                | arrow-to-right               |
| go-to-root              | content-tree-arrow-up        |
| go-up                   | arrow-to-up                  |
| h1                      | header-1                     |
| h2                      | header-2                     |
| h3                      | header-3                     |
| h4                      | header-4                     |
| h5                      | header-5                     |
| h6                      | header-6                     |
| hide                    | visibility-hidden            |
| hierarchy               | hierarchy-site-map           |
| history-file            | file-history                 |
| 'home-page'             | home                         |
| image-center            | align-block-center           |
| image-editor            | image-edit                   |
| image-left              | align-block-left             |
| image-right             | align-block-right            |
| image-variations        | image-focus                  |
| imported-items          | database-synch               |
| information             | info-square                  |
| input-hidden            | form-input-hidden            |
| input-line              | form-input-single-line       |
| input-line-multiple     | form-input-multi-line        |
| input-number            | form-input-number            |
| interface-block         | forbidden                    |
| italic                  | text-italic                  |
| keyword                 | hash                         |
| landing_page            | layout-navbar                |
| landingpage-add         | layout-navbar-add            |
| landingpage-preview     | layout-navbar-visible        |
| languages               | world                        |
| languages-add           | world-add                    |
| last-purchased          | cursor-clicked-hand          |
| last-viewed             | app-recent                   |
| layout-manager          | layout                       |
| link-content            | file-link                    |
| link-remove             | unlink                       |
| list                    | list-bullet                  |
| list-numbered           | list-number                  |
| localize                | target-location              |
| location-add-new        | content-tree-create-location |
| lock-unlock             | unlock                       |
| logout                  | log-out                      |
| maform                  | chart-histogram              |
| mail                    | message-email                |
| mail-open               | message-email-read           |
| markup                  | file-code                    |
| menu                    | menu-hamburger               |
| move                    | folder-open-move             |
| newsletter              | news                         |
| notice                  | alert-error                  |
| open-newtab             | open-new-window              |
| open-sametab            | open-same-window             |
| options                 | more                         |
| order-history           | file-history                 |
| order-management        | receipt-settings             |
| order-status            | product-search               |
| panels                  | view-panels                  |
| paragraph               | text-paragraph               |
| paragraph-add           | text-paragraph-add           |
| pdf-file                | file-pdf                     |
| personalize             | user-target                  |
| personalize-block       | file-settings                |
| personalize-content     | tag-settings                 |
| pin-unpin               | unpin                        |
| place                   | pin-location                 |
| places                  | pins-locations               |
| portfolio               | suitcase                     |
| previewed               | overdue                      |
| product-category        | product-tag                  |
| product-list            | clipboard-list               |
| product_list            | clipboard-list               |
| product-low             | product-arrow-down           |
| product type            | product-collection           |
| product-type            | product-collection           |
| profile                 | user-profile                 |
| publish                 | rocket                       |
| publish-later           | calendar-number              |
| publish-later-cancel    | calendar-discard             |
| publish-later-create    | calendar-add                 |
| qa-content              | qa-file                      |
| qa-form                 | qa-form-check                |
| radio-button            | form-radio                   |
| radio-button-multiple   | form-radio-list              |
| rate                    | stars                        |
| rate-review             | star-circle                  |
| recent-activity         | activity-clock               |
| recently-added          | history                      |
| recommendation-calls    | arrows-circle                |
| redo                    | action-redo                  |
| refresh                 | arrows-reload                |
| rejected                | arrow-to-down-circle         |
| relations               | hierarchy-square             |
| restore                 | arrow-restore                |
| restore-parent          | content-tree-restore-parent  |
| review                  | message-edit                 |
| roles                   | user-id                      |
| rss                     | signal-rss                   |
| schedule                | calendar-schedule            |
| sections                | database                     |
| send-email              | send                         |
| settings-block          | settings                     |
| settings-config         | settings-configure           |
| sites-all               | sites                        |
| spinner                 | arrow-rotate                 |
| stats                   | chart-dots                   |
| strikethrough           | text-strikethrough           |
| subscriber              | user-mail                    |
| subscript               | text-subscript               |
| superscript             | text-superscript             |
| swap                    | arrows-synchronize           |
| system-information      | info-circle                  |
| trash-empty             | trash-discard                |
| trash-notrashed         | trash-open                   |
| underscore              | text-underline               |
| undo                    | action-undo                  |
| un-focus                | arrows-inside                |
| un-full-view            | arrows-full-view-out         |
| upload-image            | image-upload                 |
| user-blocked            | user-block                   |
| user_group              | user-group                   |
| users-personalization   | user-focus                   |
| user-recycle            | arrows-reload-user           |
| users-select            | users-add                    |
| user-tick               | user-check                   |
| version-compare         | action-compare-versions      |
| version-compare-action  | action-compare               |
| versions                | archived-version             |
| vertical-left-right     | arrow-collapse-expand        |
| view                    | visibility                   |
| view-desktop            | device-monitor               |
| view-hide               | visibility-hidden            |
| view-mobile             | device-mobile                |
| view-tablet             | device-tablet                |
| warning                 | alert-warning                |
| warning-triangle        | alert-warning                |

The following example illustrates the update of a custom page block's icon:

```diff
  ibexa_fieldtype_page:
      blocks:
          event:
              name: About Block
              category: Custom
-             thumbnail: /bundles/ibexaicons/img/all-icons.svg#about
+             thumbnail: /bundles/ibexaadminuiassets/vendors/ids-assets/dist/img/all-icons.svg#info-square
```

### Install new features' schemas

Features which were optional 4.6 LTS Updates are now part of 5.0.0.

- If you have already installed the feature, its schema has been updated by the previous step.
- If you haven't installed the feature, you need to add its schema to your database. Store the SQL of the schema into a file, **review it carefully**, then run it.
- If you mistakenly reinstall a schema, you might encounter "Table already exists" errors which can be ignored.

#### Install AI actions schema

**MySQL**

```bash
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/connector-ai/src/bundle/Resources/config/schema.yaml > schema_connector-ai.sql
# Pause to review schema_connector-ai.sql
mysql -u <username> -p <password> <database_name> < schema_connector-ai.sql
```

**PostgreSQL**

```bash
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/connector-ai/src/bundle/Resources/config/schema.yaml > schema_connector-ai.sql
# Pause to review schema_connector-ai.sql
psql <database_name> < schema_connector-ai.sql
```

#### Install date and time attribute type

**MySQL**

```bash
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/product-catalog-date-time-attribute/src/bundle/Resources/config/schema.yaml > schema_date-time-attribute.sql
# Pause to review schema_date-time-attribute.sql
mysql -u <username> -p <password> <database_name> < schema_date-time-attribute.sql
```

**PostgreSQL**

```bash
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/product-catalog-date-time-attribute/src/bundle/Resources/config/schema.yaml > schema_date-time-attribute.sql
# Pause to review schema_date-time-attribute.sql
psql <database_name> < schema_date-time-attribute.sql
```

#### Install symbol attribute type

**MySQL**

```bash
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/product-catalog-symbol-attribute/src/bundle/Resources/config/schema.yaml > schema_symbol-attribute.sql
# Pause to review schema_symbol-attribute.sql
mysql -u <username> -p <password> <database_name> < schema_symbol-attribute.sql
```

**PostgreSQL**

```bash
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/product-catalog-symbol-attribute/src/bundle/Resources/config/schema.yaml > schema_symbol-attribute.sql
# Pause to review schema_symbol-attribute.sql
psql <database_name> < schema_symbol-attribute.sql
```

#### Install collaboration

**MySQL**

```bash
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/collaboration/src/bundle/Resources/config/schema.yaml > schema_collaboration.sql
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/share/src/bundle/Resources/config/schema.yaml > schema_share.sql
# Pause to review schema_collaboration.sql and schema_share.sql
mysql -u <username> -p <password> <database_name> < schema_collaboration.sql
mysql -u <username> -p <password> <database_name> < schema_share.sql
```

**PostgreSQL**

```bash
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/collaboration/src/bundle/Resources/config/schema.yaml > schema_collaboration.sql
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/share/src/bundle/Resources/config/schema.yaml > schema_share.sql
# Pause to review schema_collaboration.sql and schema_share.sql
psql <database_name> < schema_collaboration.sql
psql <database_name> < schema_share.sql
```

#### Install discounts (Commerce)

**MySQL**

```bash
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/discounts/src/bundle/Resources/config/schema.yaml > schema_discounts.sql
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/discounts-codes/src/bundle/Resources/config/schema.yaml > schema_discounts-codes.sql
# Pause to review schema_discounts.sql and schema_discounts-codes.sql
mysql -u <username> -p <password> <database_name> < schema_discounts.sql
mysql -u <username> -p <password> <database_name> < schema_discounts-codes.sql
```

**PostgreSQL**

```bash
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/discounts/src/bundle/Resources/config/schema.yaml > schema_discounts.sql
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/discounts-codes/src/bundle/Resources/config/schema.yaml > schema_discounts-codes.sql
# Pause to review schema_discounts.sql and schema_discounts-codes.sql
psql <database_name> < schema_discounts.sql
psql <database_name> < schema_discounts-codes.sql
```

### Clear cache pool

The persistence cache pool needs to be cleared to be able to use the repository again.

```bash
php bin/console cache:pool:clear --all
```

### Migrations

#### Taxonomy

```bash
php bin/console ibexa:migrations:import vendor/ibexa/taxonomy/src/bundle/Resources/install/migrations/2025_08_09_14_47_mark_tag_as_container.yaml
php bin/console ibexa:migrations:migrate --file=2025_08_09_14_47_mark_tag_as_container.yaml --siteaccess=admin
```

#### Product catalog

```bash
php bin/console ibexa:migrations:import vendor/ibexa/product-catalog/src/bundle/Resources/migrations/2025_07_09_13_52_mark_product_category_container.yaml
php bin/console ibexa:migrations:migrate --file=2025_07_09_13_52_mark_product_category_container.yaml --siteaccess=admin
```

#### Corporate accounts (Experience, Commerce)

```bash
php bin/console ibexa:migrations:import vendor/ibexa/corporate-account/src/bundle/Resources/migrations/2025_07_08_09_27_set_container_to_company.yaml
php bin/console ibexa:migrations:migrate --file=2025_07_08_09_27_set_container_to_company.yaml --siteaccess=admin
```

### Generate GraphQL schema

GraphQL usage is no longer required for the Ibexa DXP back office. If you are using GraphQL in your project, you can generate its schema by running:

```bash
php bin/console ibexa:graphql:generate-schema
```

### Upgrade GraphQL usage

- In 4.6, pagination for [RelationList field type](../../../content_management/field_types/field_type_reference/relationlistfield/index.md) is disabled by default, and can be enabled using the `ibexa.graphql.schema.ibexa_object_relation_list.enable_pagination` parameter
- In 5.0, pagination for RelationList field type is always activated and can't be disabled. The previous parameter doesn't exist anymore and is ignored if set

If you have code based on `relations` request returning the entire list, you have to update it. For more information, see [Pagination in GraphQL](../../../api/graphql/graphql_queries/index.md#pagination).

### Update search indexes

Ensure your search index is up to date with the following command:

```bash
php bin/console ibexa:reindex
```

### Finalizing

#### Clear cache and rebuild

Finish the update process:

```bash
composer run-script post-update-cmd
```

#### HTTP Cache

Use the newer VCL files. Depending on your reverse proxy, you'll find them in the following directories:

- Varnish: `vendor/ibexa/http-cache/docs/varnish/vcl/`
- Fastly: `vendor/ibexa/fastly/fastly/`

#### Ibexa Cloud

Generate the Ibexa Cloud Platform.sh configuration files, review the changes with your own version, and merge your customizations.

```bash
composer ibexa:setup --platformsh
```

#### Conclusion

Your project is now running the latest major version of Ibexa DXP. To reach the last patch version, see [Update from v5.0.x to v5.0.latest](../../from_5.0/update_from_5.0/index.md)
