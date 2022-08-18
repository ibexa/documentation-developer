---
target_version: '2.5'
latest_tag: '2.5.30'
---

# Update database to v2.5

## 4. Update the database

Before you start this procedure, make sure you have completed the previous step,
[Updating the app to v2.5](update_app_to_2.5.md).

[[% include 'snippets/update/db/db_backup_warning.md' %]]

!!! note

    If you are starting from version v2.2 or later, skip to the relevant section.

### A. Update to v2.2

#### Change from UTF8 to UTF8MB4

In v2.2 the character set for MySQL/MariaDB database tables changes from `utf8` to `utf8mb4` to support 4-byte characters.

To apply this change, use the following database update script:

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.1.0-to-7.2.0.sql
```

If you use DFS Cluster, also execute the following database update script:

``` bash
mysql -u <username> -p <password> <dfs_database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.1.0-to-7.2.0-dfs.sql
```

Be aware that these upgrade statements may fail due to index collisions.
This is because the indexes have been shortened, so duplicates may occur.
If that happens, you must remove the duplicates manually, and then repeat the statements that failed.

After successfully running those statements, change the character set and collation for each table, as described in [kernel upgrade documentation.](https://github.com/ezsystems/ezpublish-kernel/blob/7.5/doc/upgrade/7.2.md)

You should also change the character set that is specified in the application config:

In `app/config/config.yml`, set the following:

``` yaml
doctrine:
    dbal:
        connections:
            default:
                charset: utf8mb4
```

Also make the corresponding change in `app/config/dfs/dfs.yml`.

#### Migrate Landing Pages

To update to v2.2 with existing Landing Pages, you need to use a dedicated script.
The script is contained in the `ezplatform-page-migration` bundle and **works since version v2.2.2**.
To use the script:

1. Run `composer require ezsystems/ezplatform-page-migration`
2. Add the bundle to `app/AppKernel.php`: `new EzSystems\EzPlatformPageMigrationBundle\EzPlatformPageMigrationBundle(),`
3. Run command `bin/console ezplatform:page:migrate`

!!! tip

    This script uses the layout defined in your Landing Page.
    To migrate successfully, you need to copy your zone configuration
    from `ez_systems_landing_page_field_type` under `ezplatform_page_fieldtype` in the new config.
    Otherwise the script will encounter errors.

You can remove the bundle after the migration is complete.

The `ezplatform:page:migrate` command migrates Landing Pages created in eZ Platform v1.x, v2.0 and v2.1 to new Pages.
The operation is transactional and rolls back in case of errors.

!!! caution "Avoid exception when migrating from eZ Publish"

    If you [migrated to v1.13 from eZ Publish](migrating_from_ez_publish.md), and want to upgrade to v2.5, an exception will occur when you run the `bin/console ezplatform:page:migrate` command and the database contains internal drafts of Landing Pages. 
    
    To avoid this exception, you must first [remove all internal drafts before you migrate](migrating_from_ez_publish.md#migration_exception). 

##### Block migration

In v2.2 Page Builder does not offer all blocks that Landing Page editor did. The removed blocks include Keyword, Schedule, and Form blocks.
The Places block has been removed from the clean installation and will only be available in the demo out of the box.
If you use this block in your site, re-apply its configuration based on the [demo](https://github.com/ezsystems/ezplatform-ee-demo/blob/v2.2.2/app/config/blocks.yml).

Later versions of Page Builder come with a Content Scheduler block and new Form Blocks, but migration of Schedule blocks to Content Scheduler blocks and of Form Blocks is not supported. 

If there are missing block definitions, such as Form Block or Schedule Block,
you have an option to continue, but migrated Landing Pages will come without those blocks.

!!! tip

    If you use different repositories with different SiteAccesses, use the `--siteaccess` switch
    to migrate them separately.

!!! tip

    You can use the `--dry-run` switch to test the migration.

After the migration is finished, you need to clear the cache.

###### Migrate layouts

The `ez_block::renderBlockAction` controller used in layout templates has been replaced by `EzPlatformPageFieldTypeBundle:Block:render`. This controller has two additional parameters, `locationId` and `languageCode`. Only `languageCode` is required.
Also, the HTML class `data-studio-zone` has been replaced with `data-ez-zone-id`
See [documentation](render_page.md#render-a-layout) for an example on usage of the new controller.

###### Migrate custom blocks

Landing Page blocks (from v2.1 and earlier) were defined using a class implementing `EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType`. 
In Page Builder (from v2.2 onwards), this interface is no longer present. Instead the logic of your block must be implemented in a [Listener](page_blocks.md#block-events).
Typically, what you previously would do in `getTemplateParameters()`, you'll now do in the `onBlockPreRender()` event handler.

The definition of block parameters has to be moved from `createBlockDefinition()` to the [YAML configuration](create_custom_page_block.md) for your custom blocks.

For more information about how custom blocks are implemented in Page Builder, have a look at [Creating custom Page blocks](create_custom_page_block.md) for your custom blocks.

For the migration of blocks from Landing Page to Page Builder, you'll need to provide a converter for attributes of custom blocks. For simple blocks you can use `\EzSystems\EzPlatformPageMigration\Converter\AttributeConverter\DefaultConverter`.
Custom converters must implement the `\EzSystems\EzPlatformPageMigration\Converter\AttributeConverter\ConverterInterface` interface.
`convert()` will parse XML `\DOMNode $node` and return an array of `\EzSystems\EzPlatformPageFieldType\FieldType\LandingPage\Model\Attribute` objects.

Below is an example of a simple converter for a custom block:

``` yaml
app.block.foobar.converter:
    class: EzSystems\EzPlatformPageMigration\Converter\AttributeConverter\DefaultConverter
    tags:
        - { name: ezplatform.fieldtype.ezlandingpage.migration.attribute.converter, block_type: foobar }
```

Notice service tag `ezplatform.fieldtype.ezlandingpage.migration.attribute.converter` that must be used for attribute converters.

This converter is only needed when running the `ezplatform:page:migrate` script and can be removed once that has completed.

###### Page migration example

Below is an example how to migrate a Landing Page Layout and Block to new Page Builder. The code is based on the Random block 
defined in the [Enterprise Beginner tutorial](page_and_form_tutorial.md)

??? tip "Landing Page code"

    `app/Resources/views/layouts/sidebar.html.twig`:

    ```php
    <div data-studio-zones-container>
        <main class="landing-page__zone landing-page__zone--{{ zones[0].id }} landing-page__zone--left col-xs-8" data-studio-zone="{{ zones[0].id }}">
            {% if zones[0].blocks %}
                {% for block in zones[0].blocks %}
                    <div class="landing-page__block block_{{ block.type }}">
                        {{ render_esi(controller('ez_block::renderBlockAction', {
                            'contentId': contentInfo.id,
                            'blockId': block.id,
                            'versionNo': versionInfo.versionNo
                        })) }}
                    </div>
                {% endfor %}
            {% endif %}
        </main>
        <aside class="landing-page__zone landing-page__zone--{{ zones[1].id }} landing-page__zone--left col-xs-4" data-studio-zone="{{ zones[1].id }}">
            {% if zones[1].blocks %}
                {% for block in zones[1].blocks %}
                    <div class="landing-page__block block_{{ block.type }}">
                        {{ render_esi(controller('ez_block::renderBlockAction', {
                            'contentId': contentInfo.id,
                            'blockId': block.id,
                            'versionNo': versionInfo.versionNo
                        })) }}
                    </div>
                {% endfor %}
            {% endif %}
        </aside>
    </div>
    ```

    `app/config/layouts.yml`:

    ``` yaml
    ez_systems_landing_page_field_type:
        layouts:
            sidebar:
                identifier: sidebar
                name: Right sidebar
                description: Main section with sidebar on the right
                thumbnail: assets/images/layouts/sidebar.png
                template: layouts/sidebar.html.twig
                zones:
                    first:
                        name: First zone
                    second:
                        name: Second zone
    ```

    `src/AppBundle/Block/RandomBlock.php`:

    ``` php
    <?php

    namespace AppBundle\Block;

    use EzSystems\LandingPageFieldTypeBundle\Exception\InvalidBlockAttributeException;
    use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition;
    use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockAttributeDefinition;
    use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType;
    use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockValue;
    use eZ\Publish\API\Repository\ContentService;
    use eZ\Publish\API\Repository\LocationService;
    use eZ\Publish\API\Repository\SearchService;
    use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
    use eZ\Publish\API\Repository\Values\Content\LocationQuery;

    class RandomBlock extends AbstractBlockType
    {
        /**
         * Content ID regular expression.
         *
         * @example 16
         *
         * @var string
         */
        const PATTERN_CONTENT_ID = '/[0-9]+/';

        /** @var \eZ\Publish\API\Repository\LocationService */
        private $locationService;

        /** @var \eZ\Publish\API\Repository\ContentService */
        private $contentService;

        /** @var \eZ\Publish\API\Repository\SearchService */
        private $searchService;

        /**
         * @param \eZ\Publish\API\Repository\LocationService $locationService
         * @param \eZ\Publish\API\Repository\ContentService $contentService
         * @param \eZ\Publish\API\Repository\SearchService $searchService
         */
        public function __construct(
            LocationService $locationService,
            ContentService $contentService,
            SearchService $searchService
        ) {
            $this->locationService = $locationService;
            $this->contentService = $contentService;
            $this->searchService = $searchService;
        }

        public function getTemplateParameters(BlockValue $blockValue)
        {
            $attributes = $blockValue->getAttributes();
            $contentInfo = $this->contentService->loadContentInfo($attributes['parentContentId']);
            $randomContent = $this->getRandomContent(
                $this->getQuery($contentInfo->mainLocationId)
            );

            return [
                'content' => $randomContent,
            ];
        }

        /**
         * Returns random picked Content.
         *
         * @param \eZ\Publish\API\Repository\Values\Content\LocationQuery $query
         *
         * @return \eZ\Publish\API\Repository\Values\Content\Content
         */
        private function getRandomContent(LocationQuery $query)
        {
            $results = $this->searchService->findLocations($query);
            $searchHits = $results->searchHits;
            if (count($searchHits) > 0) {
                shuffle($searchHits);

                return $this->contentService->loadContentByContentInfo(
                    $searchHits[0]->valueObject->contentInfo
                );
            }

            return null;
        }

        /**
         * Returns LocationQuery object based on given arguments.
         *
         * @param int $parentLocationId
         *
         * @return \eZ\Publish\API\Repository\Values\Content\LocationQuery
         */
        private function getQuery($parentLocationId)
        {
            $query = new LocationQuery();
            $query->query = new Criterion\LogicalAnd([
                new Criterion\Visibility(Criterion\Visibility::VISIBLE),
                new Criterion\ParentLocationId($parentLocationId),
            ]);

            return $query;
        }

        public function createBlockDefinition()
        {
            return new BlockDefinition(
                'random',
                'Random',
                'default',
                'assets/images/blocks/random_block.svg',
                [],
                [
                    new BlockAttributeDefinition(
                        'parentContentId',
                        'Parent',
                        'embed',
                        self::PATTERN_CONTENT_ID,
                        'Choose a valid ContentID',
                        true,
                        false,
                        [],
                        []
                    ),
                ]
            );
        }

        public function checkAttributesStructure(array $attributes)
        {
            if (!isset($attributes['parentContentId']) || preg_match(self::PATTERN_CONTENT_ID, $attributes['parentContentId']) !== 1) {
                throw new InvalidBlockAttributeException('Parent container', 'parentContentId', 'Parent ContentID must be defined.');
            }
        }
    }
    ```

    `src/AppBundle/DependencyInjection/AppExtension.php`:

    ``` php
    <?php

    namespace AppBundle\DependencyInjection;

    use Symfony\Component\HttpKernel\DependencyInjection\Extension;
    use Symfony\Component\DependencyInjection\ContainerBuilder;
    use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
    use Symfony\Component\Config\FileLocator;
    use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
    use Symfony\Component\Yaml\Yaml;
    use Symfony\Component\Config\Resource\FileResource;

    class AppExtension extends Extension implements PrependExtensionInterface
    {
        public function load(array $configs, ContainerBuilder $container)
        {
            $loader = new YamlFileLoader(
                $container,
                new FileLocator(__DIR__ . '/../Resources/config')
            );
            $loader->load('services.yml');
        }

        public function prepend(ContainerBuilder $container)
        {
            $configFile = __DIR__ . '/../Resources/config/blocks.yml';
            $config = Yaml::parse(file_get_contents($configFile));
            $container->prependExtensionConfig('ez_systems_landing_page_field_type', $config);
            $container->addResource(new FileResource($configFile));
        }
    }
    ```

    `src/AppBundle/Resources/config/blocks.yml`:

    ``` yaml
    blocks:
        random:
            views:
                random:
                    template: AppBundle:blocks:random.html.twig
                    name: Random Content Block View
    ```

    `src/AppBundle/Resources/config/services.yml`:

    ``` yaml
    services:
        app.block.random:
            class: AppBundle\Block\RandomBlock
            arguments:
                - '@ezpublish.api.service.location'
                - '@ezpublish.api.service.content'
                - '@ezpublish.api.service.search'
            tags:
                - { name: landing_page_field_type.block_type, alias: random }
    ```

??? tip "Corresponding Page Builder code"

    `app/Resources/views/layouts/sidebar.html.twig`:

    ```php
    <div data-studio-zones-container>
        <main class="landing-page__zone landing-page__zone--{{ zones[0].id }} landing-page__zone--left col-xs-8" data-studio-zone="{{ zones[0].id }} data-ez-zone-id="{{ zones[0].id }}">
            {% if zones[0].blocks %}
                {% set locationId = parameters.location is not null ? parameters.location.id : contentInfo.mainLocationId %}
                {% for block in zones[0].blocks %}
                    <div class="landing-page__block block_{{ block.type }} data-ez-block-id="{{ block.id }}">
                        {{ render_esi(controller('EzPlatformPageFieldTypeBundle:Block:render', {
                            'locationId': locationId,
                            'contentId': contentInfo.id,
                            'blockId': block.id,
                            'versionNo': versionInfo.versionNo,
                            'languageCode': field.languageCode
                        })) }}
                    </div>
                {% endfor %}
            {% endif %}
        </main>
        <aside class="landing-page__zone landing-page__zone--{{ zones[1].id }} landing-page__zone--left col-xs-4" data-studio-zone="{{ zones[1].id }} data-ez-zone-id="{{ zones[1].id }}">
            {% if zones[1].blocks %}
                {% set locationId = parameters.location is not null ? parameters.location.id : contentInfo.mainLocationId %}
                {% for block in zones[1].blocks %}
                    <div class="landing-page__block block_{{ block.type }} data-ez-block-id="{{ block.id }}">
                        {{ render_esi(controller('EzPlatformPageFieldTypeBundle:Block:render', {
                            'locationId': locationId,
                            'contentId': contentInfo.id,
                            'blockId': block.id,
                            'versionNo': versionInfo.versionNo,
                            'languageCode': field.languageCode
                        })) }}
                    </div>
                {% endfor %}
            {% endif %}
        </aside>
    </div>
    ```

    `app/config/layouts.yml`:

    ``` yaml
    ezplatform_page_fieldtype:
        layouts:
            sidebar:
                identifier: sidebar
                name: Right sidebar
                description: Main section with sidebar on the right
                thumbnail: assets/images/layouts/sidebar.png
                template: layouts/sidebar.html.twig
                zones:
                    first:
                        name: First zone
                    second:
                        name: Second zone
    ```

    `src/AppBundle/Block/Event/Listener/RandomBlockListener.php` in place of `src/AppBundle/Block/RandomBlock.php`:

    ``` php
    <?php

    namespace AppBundle\Block\Event\Listener;

    use eZ\Publish\API\Repository\ContentService;
    use eZ\Publish\API\Repository\LocationService;
    use eZ\Publish\API\Repository\SearchService;
    use eZ\Publish\API\Repository\Values\Content\LocationQuery;
    use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\BlockRenderEvents;
    use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\Event\PreRenderEvent;
    use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
    use Symfony\Component\EventDispatcher\EventSubscriberInterface;

    class RandomBlockListener implements EventSubscriberInterface
    {
        /** @var \eZ\Publish\API\Repository\ContentService */
        private $contentService;
        /**
         * @var LocationService
         */
        private $locationService;
        /**
         * @var SearchService
         */
        private $searchService;

        /**
         * BannerBlockListener constructor.
         *
         * @param \eZ\Publish\API\Repository\ContentService $contentService
         */
        public function __construct(
            ContentService $contentService,
            LocationService $locationService,
            SearchService $searchService
        ) {
            $this->contentService = $contentService;
            $this->locationService = $locationService;
            $this->searchService = $searchService;
        }

        /**
         * @return array The event names to listen to
         */
        public static function getSubscribedEvents()
        {
            return [
                BlockRenderEvents::getBlockPreRenderEventName('random') => 'onBlockPreRender',
            ];
        }

        /**
         * @param \EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\Event\PreRenderEvent $event
         *
         * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException
         * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
         */
        public function onBlockPreRender(PreRenderEvent $event)
        {
            //BlockDefinitionFactory
            $blockValue = $event->getBlockValue();
            $renderRequest = $event->getRenderRequest();
            $contentInfo = $this->contentService->loadContentInfo($blockValue->getAttribute('parentContentId')->getValue());

            $randomContent = $this->getRandomContent(
                $this->getQuery($contentInfo->mainLocationId)
            );

            $parameters = $renderRequest->getParameters();
            $parameters['content'] = $randomContent;

            $renderRequest->setParameters($parameters);
        }

        /**
         * Returns random picked Content.
         *
         * @param \eZ\Publish\API\Repository\Values\Content\LocationQuery $query
         *
         * @return \eZ\Publish\API\Repository\Values\Content\Content
         * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
         */
        private function getRandomContent(LocationQuery $query)
        {
            $results = $this->searchService->findLocations($query);
            $searchHits = $results->searchHits;
            if (count($searchHits) > 0) {
                shuffle($searchHits);

                return $this->contentService->loadContentByContentInfo(
                    $searchHits[0]->valueObject->contentInfo
                );
            }

            return null;
        }

        /**
         * Returns LocationQuery object based on given arguments.
         *
         * @param int $parentLocationId
         *
         * @return \eZ\Publish\API\Repository\Values\Content\LocationQuery
         */
        private function getQuery($parentLocationId)
        {
            $query = new LocationQuery();
            $query->query = new Criterion\LogicalAnd([
                new Criterion\Visibility(Criterion\Visibility::VISIBLE),
                new Criterion\ParentLocationId($parentLocationId),
            ]);

            return $query;
        }
    }
    ```

    `src/AppBundle/DependencyInjection/AppExtension.php`:

    ``` php
    <?php

    namespace AppBundle\DependencyInjection;

    use Symfony\Component\HttpKernel\DependencyInjection\Extension;
    use Symfony\Component\DependencyInjection\ContainerBuilder;
    use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
    use Symfony\Component\Config\FileLocator;
    use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
    use Symfony\Component\Yaml\Yaml;
    use Symfony\Component\Config\Resource\FileResource;

    class AppExtension extends Extension implements PrependExtensionInterface
    {
        public function load(array $configs, ContainerBuilder $container)
        {
            $loader = new YamlFileLoader(
                $container,
                new FileLocator(__DIR__ . '/../Resources/config')
            );
            $loader->load('services.yml');
        }

        public function prepend(ContainerBuilder $container)
        {
            $configFile = __DIR__ . '/../Resources/config/blocks.yml';
            $config = Yaml::parse(file_get_contents($configFile));
            $container->prependExtensionConfig('ezplatform_page_fieldtype', $config);
            $container->addResource(new FileResource($configFile));
        }
    }
    ```

    `src/AppBundle/Resources/config/blocks.yml`:

    ``` yaml
    blocks:
        random:
            name: Random
            category: default
            thumbnail: assets/images/layouts/sidebar.png
            #configuration_template: blocks/random_config.html.twig
            views:
                random:
                    template:  AppBundle:blocks:random.html.twig
                    name: Random Content Block View
            attributes:
                parentContentId:
                    type: embed
                    name: Parent Location ID
                    validators:
                        not_blank:
                            message: Please provide parent node
    ```

    `src/AppBundle/Resources/config/services.yml`:

    ``` yaml
    services:
        _defaults:
            autowire: true
            autoconfigure: true
            public: false

        AppBundle\Block\Event\Listener\RandomBlockListener: ~

        app.block.random.converter:
            class: EzSystems\EzPlatformPageMigration\Converter\AttributeConverter\DefaultConverter
            tags:
                - { name: ezplatform.fieldtype.ezlandingpage.migration.attribute.converter, block_type: random }
    ```


### B. Update to v2.3

#### Database update script

Apply the following database update script:

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.2.0-to-7.3.0.sql
```

#### Form Builder

In an Enterprise installation, to create the *Forms* container under the content tree root use the following command:

``` bash
php bin/console ezplatform:form-builder:create-forms-container
```

You can also specify Content Type, Field values and language code of the container, for example:

``` bash
php bin/console ezplatform:form-builder:create-forms-container --content-type custom --field title --value 'My Forms' --field description --value 'Custom container for the forms' --language-code eng-US
```

You also need to run a script to add database tables for the Form Builder.
You can find it in https://github.com/ezsystems/ezplatform-ee-installer/blob/2.3/Resources/sql/schema.sql#L136

!!! caution "Form (ezform) Field Type"

    After the update, in order to create forms, you have to add a new Content Type (for example, named "Form") that contains `Form` Field (this Content Type can contain other fields
    as well). After that you can use forms inside Landing Pages via Embed block.

### C. Update to v2.4

#### Workflow

When updating an Enterprise installation, you need to [run a script](https://github.com/ezsystems/ezplatform-ee-installer/blob/2.4/Resources/sql/schema.sql#L198)
to add database tables for the Editorial Workflow.

#### Changes to the Forms folder

The built-in Forms folder is located in the Form Section in versions 2.4+.

If you are updating your Enterprise installation, you need to add this Section manually and move the folder to it.

To allow anonymous users to access Forms, you also need to add the `content/read` Policy
with the *Form* Section to the Anonymous User.

#### Changes to Custom tags

v2.4 changed the way of configuring custom tags. They are no longer configured under the `ezpublish` key,
but one level higher in the YAML structure:

``` yaml
ezpublish:
    system:
        <siteaccess>:
            fieldtypes:
                ezrichtext:
                    custom_tags: [exampletag]

ezrichtext:
    custom_tags:
        exampletag:
            # ...
```

The old configuration is deprecated, so if you use custom tags, you need to modify your config accordingly.


### D. Update to v2.5
    
#### Database update script

Apply the following database update script:

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.4.0-to-7.5.0.sql
```

##### v2.5.3

To update to v2.5.3, additionally run the following script:

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.5.2-to-7.5.3.sql
```

##### v2.5.6

To update to v2.5.6, additionally run the following script:

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.5.4-to-7.5.5.sql
```

or for PostgreSQL:

``` bash
psql <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/postgres/dbupdate-7.5.4-to-7.5.5.sql
```

##### v2.5.9

To update to v2.5.9, additionally run the following script:

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.5.6-to-7.5.7.sql
```

or for PostgreSQL:

``` bash
psql <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/postgres/dbupdate-7.5.6-to-7.5.7.sql
```

Additionally, reindex the content:

``` bash
php bin/console ezplatform:reindex
```

#### Changes to database schema

The introduction of [support for PostgreSQL](databases.md#using-postgresql) includes a change in the way database schema is generated.

It is now created based on [YAML configuration](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/config/storage/legacy/schema.yaml), using the new [`DoctrineSchemaBundle`](https://github.com/ezsystems/doctrine-dbal-schema).

If you are updating your application according to the usual procedure, no additional actions are required.
However, if you do not update your meta-repository, you need to take two additional steps:

- enable `EzSystems\DoctrineSchemaBundle\DoctrineSchemaBundle()` in `AppKernel.php`
- add [`ez_doctrine_schema`](https://github.com/ezsystems/ezplatform/blob/2.5/app/config/config.yml#L33) configuration

#### Changes to Matrix Field Type

To migrate your content from legacy XML format to a new `ezmatrix` value use the following command:

```bash
bin/console ezplatform:migrate:legacy_matrix
```

#### Required manual cache clearing if using Redis

If you are using Redis as your persistence cache storage you should always clear it manually after an upgrade.
You can do it in two ways, by using `redis-cli` and executing the following command:

```bash
FLUSHALL
```

or by executing the following command:

```bash
bin/console cache:pool:clear cache.redis
```

#### Updating to 2.5.3

##### Page Builder

This step is only required when updating an Enterprise installation from versions higher than v2.2 and lower than v2.5.3.
In case of versions lower than 2.2, skip this step or ignore the information that indexes from a script below already exist.

When updating to v2.5.3, you need to run the following SQL commands to add missing indexes:

``` bash
CREATE INDEX ezpage_map_zones_pages_zone_id ON ezpage_map_zones_pages(zone_id);
CREATE INDEX ezpage_map_zones_pages_page_id ON ezpage_map_zones_pages(page_id);
CREATE INDEX ezpage_map_blocks_zones_block_id ON ezpage_map_blocks_zones(block_id);
CREATE INDEX ezpage_map_blocks_zones_zone_id ON ezpage_map_blocks_zones(zone_id);
CREATE INDEX ezpage_map_attributes_blocks_attribute_id ON ezpage_map_attributes_blocks(attribute_id);
CREATE INDEX ezpage_map_attributes_blocks_block_id ON ezpage_map_attributes_blocks(block_id);
CREATE INDEX ezpage_blocks_design_block_id ON ezpage_blocks_design(block_id);
CREATE INDEX ezpage_blocks_visibility_block_id ON ezpage_blocks_visibility(block_id);
CREATE INDEX ezpage_pages_content_id_version_no ON ezpage_pages(content_id, version_no);
```

#### Updating to 2.5.16

##### Powered-By header

In order to promote use of eZ Platform, `ezsystems/ez-support-tools` v1.0.10, as of eZ Platform v2.5.16, sets the Powered-By header.
It is enabled by default and generates a header like `Powered-By: eZ Platform Enterprise v2`.

To omit the version number, use the following configuration:
``` yaml
ezplatform_support_tools:
    system_info:
        powered_by:
            release: "none"
```

To opt out of the whole feature, disable it with the following configuration:

``` yaml
ezplatform_support_tools:
    system_info:
        powered_by:
            enabled: false
```

#### Updating to v2.5.18

To update to v2.5.18, if you are using MySQL, additionally run the following update SQL command:

``` sql
ALTER TABLE ezpage_attributes MODIFY value LONGTEXT;
```

##### Update entity managers

Version v2.5.18 introduces new entity managers.
To ensure that they work in multi-repository setups, you must update the GraphQL schema.
You do this manually by following this procedure:

1. Update your project to v2.5.18 and run the `php bin/console cache:clear` command to generate the [service container](php_api.md#service-container).

1. Run the following command to discover the names of the new entity managers. 
    Take note of the names that you discover:

    `php bin/console debug:container --parameter=doctrine.entity_managers --format=json | grep ibexa_`

1. For every entity manager prefixed with `ibexa_`, run the following command:

    `php bin/console doctrine:schema:update --em=<ENTITY_MANAGER_NAME> --dump-sql`
  
1. Review the queries and ensure that there are no harmful changes that could affect your data.

1. For every entity manager prefixed with `ibexa_`, run the following command to run queries on the database:

    `php bin/console doctrine:schema:update --em=<ENTITY_MANAGER_NAME> --force`

###### VCL configuration for Fastly

[[% include 'snippets/update/vcl_configuration_for_fastly.md' %]]

##### Optimize workflow queries

Run the following SQL queries to optimize workflow performance:

``` sql
CREATE INDEX idx_workflow_co_id_ver ON ezeditorialworkflow_workflows(content_id, version_no);
CREATE INDEX idx_workflow_name ON ezeditorialworkflow_workflows(workflow_name);
```


## 5. Finish the update

[[% include 'snippets/update/finish_the_update.md' %]]

[[% include 'snippets/update/notify_support.md' %]]

## Update to v3.3

It is strongly recommended to also [update to the latest LTS, v3.3](update_from_2.5.md).
