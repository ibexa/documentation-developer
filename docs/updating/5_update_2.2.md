# Update database to v2.2

!!! caution "Before you proceed"

    When you are updating from a version prior to v2.2, you must implement all the changes [from v1.13](5_update_1.13.md) before you proceed to the steps below.

## Change from UTF8 to UTF8MB4

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

## Migrate Landing Pages

To update to v2.2 with existing Landing Pages, you need to use a dedicated script.
The script is contained in the `ezplatform-page-migration` bundle and **works since version v2.2.2**.
To use it:

1. Run `composer require ezsystems/ezplatform-page-migration`
2. Add the bundle to `app/AppKernel.php`: `new EzSystems\EzPlatformPageMigrationBundle\EzPlatformPageMigrationBundle(),`
3. Run command `bin/console ezplatform:page:migrate`

!!! tip

    This script uses the layout defined in your Landing Page.
    To migrate successfully, you need to copy your zone configuration
    from `ez_systems_landing_page_field_type` under `ezplatform_page_fieldtype` in the new config.
    Otherwise the script will encounter errors.


You can remove the bundle after the migration is complete.

The command migrates Landing Pages created in eZ Platform v1.x, v2.0 and v2.1 to new Pages.
The operation is transactional and rolls back in case of errors.

### Block migration

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

#### Migrate layouts

The `ez_block::renderBlockAction` controller used in layout templates has been replaced by `EzPlatformPageFieldTypeBundle:Block:render`. This controller has two additional parameters, `locationId` and `languageCode`. Only `languageCode` is required.
Also, the HTML class `data-studio-zone` has been replaced with `data-ez-zone-id`
See [documentation](../guide/content_rendering/render_content/render_page.md#render-a-layout) for an example on usage of the new controller.

#### Migrate custom blocks

Landing Page blocks (from v2.1 and earlier) were defined using a class implementing `EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType`. 
In Page Builder (from v2.2 onwards), this interface is no longer present. Instead the logic of your block must be implemented in a [Listener](../extending/extending_page.md#block-rendering-events).
Typically, what you previously would do in `getTemplateParameters()`, you'll now do in the `onBlockPreRender()` event handler.

The definition of block parameters has to be moved from `createBlockDefinition()` to the [YAML configuration](../extending/extending_page.md#creating-page-blocks) for your custom blocks.

For more information about how custom blocks are implemented in Pagebuilder, have a look at [Creating custom Page blocks](../extending/extending_page.md)

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

#### Page migration example

Below is an example how to migrate a Landing Page Layout and Block to new Page Builder. The code is based on the Random block 
defined in the [Enterprise Beginner tutorial](../tutorials/enterprise_beginner/ez_enterprise_beginner_tutorial_-_its_a_dogs_world.md)

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
            # read https://doc.ezplatform.com/en/latest/guide/extending/extending_page/#block-modal-template
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
