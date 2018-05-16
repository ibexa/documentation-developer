# Service tags

Service tags in Symfony DIC are a useful way of dedicating services to a specific purpose. They are usually used for extension points.

For instance, if you want to register a [Twig extension](http://twig.sensiolabs.org/doc/advanced.html#creating-extensions) to add custom filters,
you need to create the PHP class and declare it as a service in the DIC configuration with the `twig.extension` tag
(see the [Symfony cookbook entry](http://symfony.com/doc/2.8/templating/twig_extension.html) for a full example).

You will find all service tags exposed by Symfony in [its reference documentation](http://symfony.com/doc/2.8/reference/dic_tags.html).

## List of service tags

|Service tag|Description|
|-----------|-----------|
|[support_tools.system_info.output_format](#support_tools.system_info.output_format )|Registers SystemInfo output format.|
|[support_tools.system_info.collector](#support_tools.system_info.collector)|Registers SystemInfoCollector.|
|[ezplatform.admin_ui.component](#ezplatform.admin_ui.component)|Registers a component in a group specified by group attribute|
|[ezplatform.tab](#ezplatform.tab)|Registers a tab in a group specified by group attribute. |
|[ezplatform.admin_ui.config_provider](#ezplatform.admin_ui.config_provider)|Registers UI configuration Provider.|
|[ezplatform.http_cache.purge_client](#ezplatform.http_cache.purge_client)| Registers a purge client for HTTP cache. |
|[ezplatform.http_cache.tag_handler](#ezplatform.http_cache.tag_handler)|Deprecated|
|[ezplatform.http_cache.fos_tag_handler](#ezplatform.http_cache.fos_tag_handler)|Registers explicitly invalidated cache by tag.|
|[ezplatform.cache_response_tagger](#ezplatform.cache_response_tagger)|Registers ResponseTaggers.|
|[ezpublish.search.solr.query.content.criterion_visitor](#ezpublish.search.solr.query.content.criterion_visitor)|Registers Solr Storage Content criterion visitors.|
|[ezpublish.search.solr.query.location.criterion_visitor](#ezpublish.search.solr.query.location.criterion_visitor)|Registers Solr Storage Location criterion visitors.|
|[ezpublish.search.solr.query.content.facet_builder_visitor](#ezpublish.search.solr.query.content.facet_builder_visitor)||
|[ezpublish.search.solr.query.location.facet_builder_visitor](#ezpublish.search.solr.query.location.facet_builder_visitor)||
|[ezpublish.search.solr.query.content.sort_clause_visitor](#ezpublish.search.solr.query.content.sort_clause_visitor)|Register Solr Storage Content sort clause visitors|
|[ezpublish.search.solr.query.location.sort_clause_visitor](#ezpublish.search.solr.query.location.sort_clause_visitor)|Register Solr Storage Location sort clause visitors|
|[ezpublish.search.solr.endpoint](#ezpublish.search.solr.endpoint)|Registers Solr Endpoints.|
|[ezpublish.config.resolver](#ezpublish.config.resolver)| Adds a specific config resolver to the chain |
|[router](#router)|Adds a specific router to the chain router|
|[ezpublish.fieldType.parameterProvider](#ezpublish.fieldType.parameterProvider)| Registers parameter provider (allows to pass additional parameters to a fieldtype's view template) to specific field type |
|[ezpublish.query_type](#ezpublish.query_type)|Registers QueryType as a service.|
|[ezpublish.searchEngineIndexer](#ezpublish.searchEngineIndexer)||
|[ezpublish.searchEngine](#ezpublish.searchEngine)|Registers search engine identified by its identifier (the "alias" attribute).|
|[ezpublish.api.storage_engine.factory](#ezpublish.api.storage_engine.factory)|Deprecated???|
|[ezpublish.ezrichtext.converter.input.ezxml](#ezpublish.ezrichtext.converter.input.ezxml)||
|[ezpublish.ezrichtext.converter.output.xhtml5](#ezpublish.ezrichtext.converter.output.xhtml5)|Registers renderer in services.yml|
|[ezpublish.api.slot](#ezpublish.api.slot)|Identifies a service as a valid Slot.|
|[ezpublish.storageEngine](#ezpublish.storageEngine)|Registers a storage engine in the Repository factory|
|[ezpublish.url_handler](#ezpublish.url_handler)|Registers a custom protocol for external URLs validation.|
|[ezpublish.view_provider](#ezpublish.view_provider)|Registers view provider into the view_provider registry.|
|[ezpublish_data_collector](#ezpublish_data_collector)| Registers profiler [data collector](https://symfony.com/doc/3.4/profiler/data_collector.html) specific for eZ Platfrom. |
|[ezpublish.core.io.migration.file_lister](#ezpublish.core.io.migration.file_lister)||
|[ezpublish_rest.field_type_processor](#ezpublish_rest.field_type_processor)||
|[ezpublish_rest.input.handler](#ezpublish_rest.input.handler)|Maps input formats (json, xml) to handlers.|
|[ezpublish_rest.input.parser](#ezpublish_rest.input.parser)|Maps Content Type to the input parser.|
|[ezpublish_rest.output.visitor](#ezpublish_rest.output.visitor)|Maps a Request property to an output format (json or xml).|
|[ezpublish_rest.output.value_object_visitor](#ezpublish_rest.output.value_object_visitor)|Maps a ValueObject class name to a Visitor.|
|[ezplatform.installer](#ezplatform.installer)| Allows to define types of installation e.g. `clean`, `demo` |
|[ezpublish.fieldType](#ezpublish.fieldType)|Registers a Field Type|
|[ezpublish.fieldType.nameable](#ezpublish.fieldType.nameable)|Registers service name to be retrieved by it by`\eZ\Publish\SPI\FieldType\Nameable::getFieldName`.|
|[ezpublish.limitationType](#ezpublish.limitationType)|Registers limitations including custom ones as limitation types.|
|[ezpublish.search.common.field_value_mapper](#ezpublish.search.common.field_value_mapper)||
|[ezpublish.fieldType.indexable](#ezpublish.fieldType.indexable)|Registers indexable implementations|
|[ezpublish.search.slot](#ezpublish.search.slot)||
|[ezpublish.search.solr.slot](#ezpublish.search.solr.slot)||
|[ezpublish.search.elasticsearch.slot](#ezpublish.search.elasticsearch.slot)||
|[ezpublish.search.legacy.slot](#ezpublish.search.legacy.slot)||
|[ezpublish.search.elasticsearch.content.facet_builder_visitor](#ezpublish.search.elasticsearch.content.facet_builder_visitor)||
|[ezpublish.search.elasticsearch.content.sort_clause_visitor](#ezpublish.search.elasticsearch.content.sort_clause_visitor)||
|[ezpublish.search.elasticsearch.location.sort_clause_visitor](#ezpublish.search.elasticsearch.location.sort_clause_visitor)||
|[ezpublish.search.elasticsearch.content.criterion_visitor](#ezpublish.search.elasticsearch.content.criterion_visitor)||
|[ezpublish.search.elasticsearch.location.criterion_visitor](#ezpublish.search.elasticsearch.location.criterion_visitor)||
|[ezpublish.search.legacy.gateway.criterion_handler.content](#ezpublish.search.legacy.gateway.criterion_handler.content)|Registers ContentId Criterion handlers|
|[ezpublish.search.legacy.gateway.criterion_handler.location](#ezpublish.search.legacy.gateway.criterion_handler.location)|Registers LocationId Criterion handlers|
|[ezpublish.persistence.legacy.url.criterion_handler](#ezpublish.persistence.legacy.url.criterion_handler)| Allows to define handler for URL query criterion in the legacy storage engine |
|[ezpublish.search.legacy.gateway.criterion_field_value_handler](#ezpublish.search.legacy.gateway.criterion_field_value_handler)| Registers criterion field value handler for legacy storage engine |
|[ezpublish.search.legacy.gateway.sort_clause_handler.content](#ezpublish.search.legacy.gateway.sort_clause_handler.content)|Registers content sort clause handlers|
|[ezpublish.search.legacy.gateway.sort_clause_handler.location](#ezpublish.search.legacy.gateway.sort_clause_handler.location)|Registers location sort clause handlers|
|[ezpublish.fieldType.externalStorageHandler.gateway](#ezpublish.fieldType.externalStorageHandler.gateway)|Registers an external storage gateway for a Field Type in legacy storage engine|
|[ezpublish.fieldType.externalStorageHandler](#ezpublish.fieldType.externalStorageHandler)|Registers an external storage handler for a Field Type|
|[ezpublish.storageEngine.legacy.converter](#ezpublish.storageEngine.legacy.converter)|Registers a converter for a Field Type in legacy storage engine|
|[ezpublish.persistence.legacy.role.limitation.handler](#ezpublish.persistence.legacy.role.limitation.handler)| Register converter of Policy limitation from Legacy value to spi value accepted by API. |
|[ez.fieldFormMapper.value](#ez.fieldFormMapper.value)|Registers FormMapper value providing content editing support.|
|[ez.fieldFormMapper.definition](#ez.fieldFormMapper.definition)|Registers FormMapper definition providing Field Type definition editing support.|
|[ez.limitation.formMapper](#ez.limitation.formMapper)| Registers mapper for limitation form.  |
|[ez.limitation.valueMapper](#ez.limitation.valueMapper)| Registers mapper for limitation values.  |


## EzSupportToolsBundle

### support_tools.system_info.output_format 

Registers SystemInfo output format. \EzSystems\EzSupportToolsBundle\SystemInfo\OutputFormat
   
- format - format of an output e.g. json

Example:

```php
services:
    support_tools.system_info.output_format.json:
        class: "%support_tools.system_info.output_format.json.class%"
        tags:
            - { name: "support_tools.system_info.output_format", format: "json" }
```
    
### support_tools.system_info.collector
 
Registers SystemInfoCollector.
 
- identifier - an identifier string to identify the collector
    
Example:

```php
services:
    support_tools.system_info.collector.database.doctrine:
       class: "%support_tools.system_info.collector.database.doctrine.class%"
        arguments:
            - "@ezpublish.persistence.connection"
        lazy: true
        tags:
            - { name: "support_tools.system_info.collector", identifier: "database" }
```

## EzPlatformAdminUiBundle

### ezplatform.admin_ui.component 

Registers a component in a group specified by group attribute [Extending Platform UI](https://doc.ezplatform.com/en/2.1/guide/extending_ez_platform_ui/#further-extensibility-using-components)
   
- group
    
Example:

```php
services:
    ezplatform.adminui.dashboard.me:
        parent: EzSystems\EzPlatformAdminUi\Component\TwigComponent
        arguments:
            $template: 'EzPlatformAdminUiBundle:dashboard/block:me.html.twig'
        tags:
            - { name: ezplatform.admin_ui.component, group: 'dashboard-blocks' }
```
    
###  ezplatform.tab  

Registers a tab in a group specified by group attribute. \EzSystems\EzPlatformAdminUi\Tab\TabInterface
    
- group
    
Example:
    
```php
    EzSystems\EzPlatformAdminUi\Tab\Dashboard\MyDraftsTab:
            parent: EzSystems\EzPlatformAdminUi\Tab\AbstractTab
            public: false
            tags:
                - { name: ezplatform.tab, group: dashboard-my }
```
    
###  ezplatform.admin_ui.config_provider

Registers UI configuration Provider.
   
- key - TODO
    
Example:

```php
    EzSystems\EzPlatformAdminUi\UI\Config\Provider\Module\UniversalDiscoveryWidget:
           tags:
                - { name: ezplatform.admin_ui.config_provider, key: 'universalDiscoveryWidget' }
```
  
## PlatformHttpCacheBundle

https://doc.ezplatform.com/en/2.0/guide/http_cache/#http-cache-tagging

### ezplatform.http_cache.purge_client 

\EzSystems\PlatformHttpCacheBundle\DependencyInjection\Compiler\DriverPass::process
    
- purge_type

Example:

```php
services:
    ezplatform.http_cache_myhttpcachebundle.purge_client.myhttpcache:
        class: EzSystems\PlatformMyHttpCacheBundle\PurgeClient\MyHttpCachePurgeClient
        arguments: ['@ezplatform.http_cache.cache_manager']
        tags:
            - {name: ezplatform.http_cache.purge_client, purge_type: myhttpcache}
```
    
### ezplatform.http_cache.tag_handler - deprecated

- purge_type
    
### ezplatform.http_cache.fos_tag_handler

Registers explicitly invalidated cache by tag.

- purge_type
    
Example:

```php
services:
    ezplatform.http_cache_myhttpcachebundle.fos_tag_handler.myhttpcache:
        class: EzSystems\PlatformMyHttpCacheBundle\Handler\MyHttpCacheFosTagHandler
        tags:
            - {name: ezplatform.http_cache.fos_tag_handler, purge_type: myhttpcache}
```
  
### ezplatform.cache_response_tagger
 
Registers ResponseTaggers.

Example:
    
```php
services:
    ezplatform.view_cache.response_tagger.location_value_view:
        class: EzSystems\PlatformHttpCacheBundle\ResponseTagger\Delegator\LocationValueViewTagger
        arguments: ['@ezplatform.view_cache.response_tagger.location']
        tags:
            - {name: ezplatform.cache_response_tagger}
```
    
## EzPlatformSolrSearchEngine

### ezpublish.search.solr.query.content.criterion_visitor

Registers Solr Storage Content criterion visitors.

Example:

```php
    ezpublish.search.solr.query.common.criterion_visitor.content_type_group_id_in:
        class: "%ezpublish.search.solr.query.common.criterion_visitor.content_type_group_id_in.class%"
        tags:
            - {name: ezpublish.search.solr.query.content.criterion_visitor}
            - {name: ezpublish.search.solr.query.location.criterion_visitor}
```

### ezpublish.search.solr.query.location.criterion_visitor

Registers Solr Storage Location criterion visitors.

Example:

```php
    ezpublish.search.solr.query.common.criterion_visitor.content_type_group_id_in:
        class: "%ezpublish.search.solr.query.common.criterion_visitor.content_type_group_id_in.class%"
        tags:
            - {name: ezpublish.search.solr.query.content.criterion_visitor}
            - {name: ezpublish.search.solr.query.location.criterion_visitor}
```

### ezpublish.search.solr.query.content.facet_builder_visitor

Example:

```php
services:
    ezpublish.search.solr.query.content.facet_builder_visitor.field:
        class: "%ezpublish.search.solr.query.content.facet_builder_visitor.field.class%"
        tags:
            - {name: ezpublish.search.solr.query.content.facet_builder_visitor}
```

### ezpublish.search.solr.query.location.facet_builder_visitor

Example:

```php
services:
    ezpublish.search.solr.query.common.facet_builder_visitor.content_type:
        class: "%ezpublish.search.solr.query.common.facet_builder_visitor.content_type.class%"
        tags:
            - {name: ezpublish.search.solr.query.content.facet_builder_visitor}
            - {name: ezpublish.search.solr.query.location.facet_builder_visitor}
```

### ezpublish.search.solr.query.content.sort_clause_visitor

Register Solr Storage Content sort clause visitors

Example:

```php
services:
    # Common for Content and Location search
    ezpublish.search.solr.query.common.sort_clause_visitor.content_id:
        class: "%ezpublish.search.solr.query.common.sort_clause_visitor.content_id.class%"
        tags:
            - {name: ezpublish.search.solr.query.content.sort_clause_visitor}
            - {name: ezpublish.search.solr.query.location.sort_clause_visitor}
```

### ezpublish.search.solr.query.location.sort_clause_visitor

Register Solr Storage Location sort clause visitors

Example:

```php
services:
    # Common for Content and Location search
    ezpublish.search.solr.query.common.sort_clause_visitor.content_id:
        class: "%ezpublish.search.solr.query.common.sort_clause_visitor.content_id.class%"
        tags:
            - {name: ezpublish.search.solr.query.content.sort_clause_visitor}
            - {name: ezpublish.search.solr.query.location.sort_clause_visitor}
```

### ezpublish.search.solr.endpoint

Registers Solr Endpoints.

- alias

Example:

```php
    ezpublish.search.solr.endpoint.endpoint0:
        class: "%ezpublish.solr.endpoint.class%"
        arguments:
            -
                scheme: http
                host: localhost
                port: 8983
                path: /solr
                core: core0
        tags:
            - {name: ezpublish.search.solr.endpoint, alias: endpoint0}
```

## EzPublishCoreBundle

### ezpublish.config.resolver

- priority

Example:

```php
services:
    ezpublish.config.resolver.core:
        class: "%ezpublish.config.resolver.dynamic.class%"
        arguments: ["%ezpublish.siteaccess.groups_by_siteaccess%", "%ezpublish.config.default_scope%"]
        calls:
            - [setSiteAccess, ["@ezpublish.siteaccess"]]
            - [setContainer, ["@service_container"]]
        lazy: true
        tags:
            - { name: ezpublish.config.resolver, priority: 200 }
```

### router 

Adds a specific router to the chain router

- priority

Example:

```php
    ezpublish.urlalias_router:
        class: "%ezpublish.urlalias_router.class%"
        arguments:
            - "@ezpublish.api.service.location"
            - "@ezpublish.api.service.url_alias"
            - "@ezpublish.api.service.content"
            - "@ezpublish.urlalias_generator"
            - "@?router.request_context"
            - "@?logger"
        calls:
            - [setConfigResolver, ["@ezpublish.config.resolver"]]
        tags:
            - {name: router, priority: 200}
```
    
### ezpublish.fieldType.parameterProvider

- alias

Example:

```php
services:
    # Parameter providers
    ezpublish.fieldType.parameterProviderRegistry:
        class: "%ezpublish.fieldType.parameterProviderRegistry.class%"

    ezpublish.fieldType.ezdatetime.parameterProvider:
        class: "%ezpublish.fieldType.locale.parameterProvider.class%"
        arguments: ["@ezpublish.locale.converter"]
        calls:
            - [setRequestStack, ["@request_stack"]]
        tags:
            - {name: ezpublish.fieldType.parameterProvider, alias: ezdatetime}
            - {name: ezpublish.fieldType.parameterProvider, alias: ezdate}
            - {name: ezpublish.fieldType.parameterProvider, alias: eztime}
```
    
### ezpublish.query_type 

Registers QueryType as a service. It is required if the class has custom dependencies. You may specify an 'alias' tag attribute that will be used to register the QueryType. It allows you to use the same class, with different arguments, as different QueryTypes: /ezplatform/vendor/ezsystems/ezpublish-kernel/eZ/Bundle/EzPublishCoreBundle/DependencyInjection/Compiler/QueryTypePass.php

<https://doc.ezplatform.com/en/2.1/guide/content_rendering//>

- alias
 
Example: 

```php
services:
    acme.query.latest_articles:
        class: AcmeBundle\Query\LatestContent
        arguments: ['article']
        tags:
            - {name: ezpublish.query_type, alias: latest_articles}
    
    acme.query.latest_links:
        class: AcmeBundle\Query\LatestContent
        arguments: ['link']
        tags:
            - {name: ezpublish.query_type, alias: latest_links}
```
 
### ezpublish.searchEngineIndexer

- alias

Example:
   
```php
services:
       ezpublish.spi.search.legacy.indexer:
           class: "%ezpublish.spi.search.legacy.indexer.class%"
           arguments:
               - "@logger"
               - "@ezpublish.api.storage_engine"
               - "@ezpublish.api.storage_engine.legacy.dbhandler"
               - "@ezpublish.spi.search.legacy"
           tags:
               - {name: ezpublish.searchEngineIndexer, alias: legacy}
           lazy: true
```

### ezpublish.searchEngine

Registers search engine identified by its identifier (the "alias" attribute).

- alias

Example:
    
```php
services:
     ezpublish.spi.search.legacy:
         class: "%ezpublish.spi.search.legacy.class%"
         arguments:
             - "@ezpublish.search.legacy.gateway.content"
             - "@ezpublish.search.legacy.gateway.location"
             - "@ezpublish.search.legacy.gateway.wordIndexer"
             - "@ezpublish.persistence.legacy.content.mapper"
             - "@ezpublish.persistence.legacy.location.mapper"
             - "@ezpublish.spi.persistence.language_handler"
             - "@ezpublish.search.legacy.fulltext_mapper"
         tags:
             - {name: ezpublish.searchEngine, alias: legacy}
         lazy: true
```

### ezpublish.api.storage_engine.factory 

Registers storage engines - deprecated???

- alias

### ezpublish.ezrichtext.converter.input.ezxml

- priority

### ezpublish.ezrichtext.converter.output.xhtml5

Registers renderer in services.yml

- priority

Example:

```php
services:
    ezpublish.fieldType.ezrichtext.converter.template:
        class: "%ezpublish.fieldType.ezrichtext.converter.template.class%"
        arguments:
            - "@ezpublish.fieldType.ezrichtext.renderer"
        tags:
            - {name: ezpublish.ezrichtext.converter.output.xhtml5, priority: 10}
```

### ezpublish.api.slot

Identifies a service as a valid Slot.

- signal

Example:

```php
services:
    app_bundle.handle_submission:
        class: "AppBundle\SignalSlot\HandleSubmission"
        tags:
            - { name: ezpublish.api.slot, signal: '\EzSystems\FormBuilder\Core\SignalSlot\Signal\FormSubmit' }
```

### ezpublish.storageEngine

Registers a storage engine in the Repository factory

- alias - identifies the storage engine

Example:

```php
    ezpublish.spi.persistence.legacy:
        class: "%ezpublish.spi.persistence.legacy.class%"
        arguments:
            - "@ezpublish.spi.persistence.legacy.content.handler"
            - "@ezpublish.spi.persistence.legacy.content_type.handler"
            - "@ezpublish.spi.persistence.legacy.language.handler"
            - "@ezpublish.spi.persistence.legacy.location.handler"
            - "@ezpublish.spi.persistence.legacy.object_state.handler"
            - "@ezpublish.spi.persistence.legacy.section.handler"
            - "@ezpublish.spi.persistence.legacy.transactionhandler"
            - "@ezpublish.spi.persistence.legacy.trash.handler"
            - "@ezpublish.spi.persistence.legacy.url_alias.handler"
            - "@ezpublish.spi.persistence.legacy.url_wildcard.handler"
            - "@ezpublish.spi.persistence.legacy.user.handler"
            - "@ezpublish.spi.persistence.legacy.url.handler"
        tags:
            - {name: ezpublish.storageEngine, alias: legacy}
        lazy: true
```

### ezpublish.url_handler

Registers a custom protocol for external URLs validation. 

- scheme

Example:

```php
services:
    app.url_checker.handler.custom:
        class: 'AppBundle\URLChecker\Handler\CustomHandler'
        ...
        tags:
            - { name: ezpublish.url_handler, scheme: custom }
```

### ezpublish.view_provider

Registers view provider into the view_provider registry.

- type
- priority

Example:

```php
services:
    ezpublish_legacy.content_view_provider:
        class: eZ\Publish\Core\MVC\Legacy\View\Provider\Content
        parent: ezpublish_legacy.view_provider
        public: false
        tags:
            - {name: ezpublish.view_provider, type: 'eZ\Publish\Core\MVC\Symfony\View\ContentView', priority: 4}
```
    
## EzPublishDebugBundle

### ezpublish_data_collector

- panelTemplate
- toolbarTemplate

Example: TODO - check if valid example

```php
services:
    ezpublish_debug.persistence_collector:
        class: %ezpublish_debug.persistence_collector.class%
        arguments: [@ezpublish.spi.persistence.cache.persistenceLogger]
        tags:
            -
                name: ezpublish_data_collector
                id: "ezpublish.debug.persistence"
                panelTemplate: "EzPublishDebugBundle:Profiler/persistence:panel.html.twig"
                toolbarTemplate: "EzPublishDebugBundle:Profiler/persistence:toolbar.html.twig"
```
    
## EzPublishIOBundle

### ezpublish.core.io.migration.file_lister

- identifier

Example:

```php
services:
    ezpublish.core.io.migration.file_lister.media_file_lister:
        class: "%ezpublish.core.io.migration.file_lister.media_file_lister.class%"
        parent: ezpublish.core.io.migration.migration_handler
        arguments:
            - "@ezpublish.core.io.migration.file_lister.file_iterator.media_file_iterator"
            - "%ezsettings.default.binary_dir%"
        tags:
            - { name: "ezpublish.core.io.migration.file_lister", identifier: "media_file" }
        lazy: true
```
    
## EzPublishRestBundle

### ezpublish_rest.field_type_processor
    
- alias

Example:

```php
services:
    ezpublish_rest.field_type_processor.ezimage:
        class: "%ezpublish_rest.field_type_processor.ezimage.class%"
        factory: ["@ezpublish_rest.factory", getImageFieldTypeProcessor]
        arguments:
            - "@router"
        tags:
            - { name: ezpublish_rest.field_type_processor, alias: ezimage }
```
    
### ezpublish_rest.input.handler  

Maps input formats (json, xml) to handlers.

- format

Example:

```php
services:
    ezpublish_rest.input.handler.json:
        class: "%ezpublish_rest.input.handler.json.class%"
        tags:
            - { name: ezpublish_rest.input.handler, format: json }

    ezpublish_rest.input.handler.xml:
        class: "%ezpublish_rest.input.handler.xml.class%"
        tags:
            - { name: ezpublish_rest.input.handler, format: xml }
```
    
### ezpublish_rest.input.parser

Maps Content Type to the input parser.

- mediaType

Example:

```php
services:
    myRestBundle.input_parser.Greetings:
        parent: ezpublish_rest.input.parser
        class: My\Bundle\RestBundle\Rest\InputParser\Greetings
        tags:
            - { name: ezpublish_rest.input.parser, mediaType: application/vnd.my.Greetings }
```
    
### ezpublish_rest.output.visitor

Maps a Request property to an output format (json or xml).

- priority
- regexps

Example:

```php
services:
    ezpublish_rest.output.visitor.json:
        class: "%ezpublish_rest.output.visitor.class%"
        arguments:
            - "@ezpublish_rest.output.generator.json"
            - "@ezpublish_rest.output.value_object_visitor.dispatcher"
        tags:
            - { name: ezpublish_rest.output.visitor, regexps: ezpublish_rest.output.visitor.json.regexps }
```
    
### ezpublish_rest.output.value_object_visitor

Maps a ValueObject class name to a Visitor. 

- type

Example:

```php
services:
    ezpublish_rest.output.value_object_visitor.Exception.InvalidArgumentException:
        class: "%ezpublish_rest.output.value_object_visitor.Exception.InvalidArgumentException.class%"
        tags:
            - { name: ezpublish_rest.output.value_object_visitor, type: \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException }
```
    
## PlatformInstallerBundle

### ezplatform.installer
    
- type

Example:

```php
services:
    acme.platform_installer:
      class: Acme\Installer
      tags: 
        - { name: ezplatform.installer, type: acme }
```
    
## EzPublishCoreBundle

### ezpublish.fieldType

Registers a Field Type

- alias

Example:

```php
services:
    ezpublish.fieldType.ezcomcomments:
        class: %ezpublish.fieldType.eznull.class%
        parent: ezpublish.fieldType
        arguments: [ "ezcomcomments" ]
        tags:
            - {name: ezpublish.fieldType, alias: ezcomcomments}
    ezpublish.fieldType.ezpaex:
        class: %ezpublish.fieldType.eznull.class%
        parent: ezpublish.fieldType
        arguments: [ "ezpaex" ]
        tags:
            - {name: ezpublish.fieldType, alias: ezpaex}
```
    
### ezpublish.fieldType.nameable

Registers service name to be retrieved by it by`\eZ\Publish\SPI\FieldType\Nameable::getFieldName`.

- alias

Example:

```php
services:
    ezpublish.fieldType.ezselection.nameable_field:
        class: "%ezpublish.fieldType.ezselection.nameable_field.class%"
        tags:
            - {name: ezpublish.fieldType.nameable, alias: ezselection}
```

### ezpublish.limitationType

Registers limitations including custom ones as limitation types.

- alias

Example:

```php
services:
    ezpublish.api.role.limitation_type.function_list:
        class: %ezpublish.api.role.limitation_type.blocking.class%
        arguments: ['FunctionList']
        tags:
            - {name: ezpublish.limitationType, alias: FunctionList}
```

### ezpublish.search.common.field_value_mapper

- addMapper

Example:

```php
    ezpublish.search.common.field_value_mapper.integer:
        class: "%ezpublish.search.common.field_value_mapper.integer.class%"
        tags:
            - {name: ezpublish.search.common.field_value_mapper}
```
    
### ezpublish.fieldType.indexable

Registers indexable implementations

- alias

Example:

```php
services:
    ezpublish.fieldType.indexable.ezauthor:
        class: "%ezpublish.fieldType.indexable.ezauthor.class%"
        tags:
            - {name: ezpublish.fieldType.indexable, alias: ezauthor}
```
    
### ezpublish.search.slot

- signal
    
### ezpublish.search.solr.slot - move to solrBundle

- signal

ezpublish.search.%s.slot 

/ezplatform/vendor/ezsystems/ezpublish-kernel/eZ/Publish/Core/Base/Container/Compiler/Search/SearchEngineSignalSlotPass.php

Example:

```php
    ezpublish.search.solr.slot.publish_version:
        parent: ezpublish.search.solr.slot
        class: "%ezpublish.search.solr.slot.publish_version.class%"
        tags:
            - {name: ezpublish.search.solr.slot, signal: ContentService\PublishVersionSignal}
```

### ezpublish.search.elasticsearch.slot

- signal

ezpublish.search.%s.slot 

/ezplatform/vendor/ezsystems/ezpublish-kernel/eZ/Publish/Core/Base/Container/Compiler/Search/SearchEngineSignalSlotPass.php

Example:

```php
services:
        ezpublish.search.elasticsearch.slot.create_location:
            parent: ezpublish.search.elasticsearch.slot
            class: "%ezpublish.search.elasticsearch.slot.create_location.class%"
            tags:
                - {name: ezpublish.search.elasticsearch.slot, signal: LocationService\CreateLocationSignal}
    
        ezpublish.search.elasticsearch.slot.update_location:
            parent: ezpublish.search.elasticsearch.slot
            class: "%ezpublish.search.elasticsearch.slot.update_location.class%"
            tags:
                - {name: ezpublish.search.elasticsearch.slot, signal: LocationService\UpdateLocationSignal}
    
        ezpublish.search.elasticsearch.slot.delete_location:
            parent: ezpublish.search.elasticsearch.slot
            class: "%ezpublish.search.elasticsearch.slot.delete_location.class%"
            tags:
                - {name: ezpublish.search.elasticsearch.slot, signal: LocationService\DeleteLocationSignal}
```

### ezpublish.search.legacy.slot

- signal

ezpublish.search.%s.slot 

/ezplatform/vendor/ezsystems/ezpublish-kernel/eZ/Publish/Core/Base/Container/Compiler/Search/SearchEngineSignalSlotPass.php

Example:

```php
services:
    ezpublish.search.legacy.slot.publish_version:
        parent: ezpublish.search.legacy.slot
        class: "%ezpublish.search.legacy.slot.publish_version.class%"
        tags:
            - {name: ezpublish.search.legacy.slot, signal: ContentService\PublishVersionSignal}

    ezpublish.search.legacy.slot.copy_content:
        parent: ezpublish.search.legacy.slot
        class: "%ezpublish.search.legacy.slot.copy_content.class%"
        tags:
            - {name: ezpublish.search.legacy.slot, signal: ContentService\CopyContentSignal}

    ezpublish.search.legacy.slot.delete_content:
        parent: ezpublish.search.legacy.slot
        class: "%ezpublish.search.legacy.slot.delete_content.class%"
        tags:
            - {name: ezpublish.search.legacy.slot, signal: ContentService\DeleteContentSignal}
```

### ezpublish.search.elasticsearch.content.facet_builder_visitor

Example:

```php
    ezpublish.search.elasticsearch.content.facet_builder_visitor.section:
        class: "%ezpublish.search.elasticsearch.content.facet_builder_visitor.section.class%"
        tags:
            - {name: ezpublish.search.elasticsearch.content.facet_builder_visitor}
```

### ezpublish.search.elasticsearch.content.sort_clause_visitor

Example:

```php
    ezpublish.search.elasticsearch.content.sort_clause_visitor.content_id:
        class: "%ezpublish.search.elasticsearch.content.sort_clause_visitor.content_id.class%"
        tags:
            - {name: ezpublish.search.elasticsearch.content.sort_clause_visitor}
```

### ezpublish.search.elasticsearch.location.sort_clause_visitor

Example:

```php
    ezpublish.search.elasticsearch.location.sort_clause_visitor.content_id:
        class: "%ezpublish.search.elasticsearch.location.sort_clause_visitor.content_id.class%"
        tags:
            - {name: ezpublish.search.elasticsearch.location.sort_clause_visitor}
```

### ezpublish.search.elasticsearch.content.criterion_visitor

Example:

```php
    ezpublish.search.elasticsearch.content.criterion_visitor.content_type_group_id_in:
        class: "%ezpublish.search.elasticsearch.content.criterion_visitor.content_type_group_id_in.class%"
        tags:
            - {name: ezpublish.search.elasticsearch.content.criterion_visitor}
```

### ezpublish.search.elasticsearch.location.criterion_visitor

Example:

```php
    ezpublish.search.elasticsearch.location.criterion_visitor.content_id_in:
        class: "%ezpublish.search.elasticsearch.location.criterion_visitor.content_id_in.class%"
        tags:
            - {name: ezpublish.search.elasticsearch.location.criterion_visitor}
```

### ezpublish.search.legacy.gateway.criterion_handler.content

Registers ContentId Criterion handlers

Example:

```php
services:
    ezpublish.search.legacy.gateway.criterion_handler.common.content_id:
        class: eZ\Publish\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\ContentId
        arguments: [@ezpublish.api.storage_engine.legacy.dbhandler]
        tags:
          - {name: ezpublish.search.legacy.gateway.criterion_handler.content}
          - {name: ezpublish.search.legacy.gateway.criterion_handler.location}
```

### ezpublish.search.legacy.gateway.criterion_handler.location

Registers LocationId Criterion handlers

Example:

```php
services:
    ezpublish.search.legacy.gateway.criterion_handler.common.content_id:
        class: eZ\Publish\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\ContentId
        arguments: [@ezpublish.api.storage_engine.legacy.dbhandler]
        tags:
          - {name: ezpublish.search.legacy.gateway.criterion_handler.content}
          - {name: ezpublish.search.legacy.gateway.criterion_handler.location}
```

### ezpublish.persistence.legacy.url.criterion_handler

Example:

```php
   ezpublish.persistence.legacy.url.criterion_handler.logical_and:
       parent: ezpublish.persistence.legacy.url.criterion_handler.base
       class: '%ezpublish.persistence.legacy.url.criterion_handler.logical_and.class%'
       tags:
           - { name: ezpublish.persistence.legacy.url.criterion_handler }
```

### ezpublish.search.legacy.gateway.criterion_field_value_handler

- alias

Example:

```php
services:
    ezpublish.search.legacy.gateway.criterion_field_value_handler.simple:
        parent: ezpublish.search.legacy.gateway.criterion_field_value_handler.base
        class: "%ezpublish.search.legacy.gateway.criterion_field_value_handler.simple.class%"
        tags:
            - {name: ezpublish.search.legacy.gateway.criterion_field_value_handler, alias: ezboolean}
            - {name: ezpublish.search.legacy.gateway.criterion_field_value_handler, alias: ezdate}
            - {name: ezpublish.search.legacy.gateway.criterion_field_value_handler, alias: ezdatetime}
            - {name: ezpublish.search.legacy.gateway.criterion_field_value_handler, alias: ezemail}
            - {name: ezpublish.search.legacy.gateway.criterion_field_value_handler, alias: ezinteger}
            - {name: ezpublish.search.legacy.gateway.criterion_field_value_handler, alias: ezobjectrelation}
            - {name: ezpublish.search.legacy.gateway.criterion_field_value_handler, alias: eztime}
```
    
### ezpublish.search.legacy.gateway.sort_clause_handler.content

Registers Content Sort Clause handlers

Example:

```php
    ezpublish.search.legacy.gateway.sort_clause_handler.common.date_modified:
        parent: ezpublish.search.legacy.gateway.sort_clause_handler.base
        class: "%ezpublish.search.legacy.gateway.sort_clause_handler.common.date_modified.class%"
        tags:
            - {name: ezpublish.search.legacy.gateway.sort_clause_handler.content}
            - {name: ezpublish.search.legacy.gateway.sort_clause_handler.location}
```

### ezpublish.search.legacy.gateway.sort_clause_handler.location

Registers Content Sort Clause handlers

Example:

```php
services:
    ezpublish.search.legacy.gateway.sort_clause_handler.location.is_main_location:
        parent: ezpublish.search.legacy.gateway.sort_clause_handler.base
        class: "%ezpublish.search.legacy.gateway.sort_clause_handler.location.is_main_location.class%"
        tags:
            - {name: ezpublish.search.legacy.gateway.sort_clause_handler.location}
```

### ezpublish.fieldType.externalStorageHandler.gateway

Registers an external storage gateway for a Field Type in legacy storage engine

- alias
- identifier

Examples:

```php
services:
    ezpublish.fieldType.ezkeyword.storage_gateway:
        class: %ezpublish.fieldType.ezkeyword.storage_gateway.class%
        tags:
            - {name: ezpublish.fieldType.externalStorageHandler.gateway, alias: ezkeyword, identifier: LegacyStorage}
```

### ezpublish.fieldType.externalStorageHandler

Registers an external storage handler for a Field Type - /ezplatform/vendor/ezsystems/ezpublish-kernel/eZ/Publish/Core/Base/Container/Compiler/Storage/ExternalStorageRegistryPass.php

- alias - grubo nie tak

Example:

```php
parameters:
    ezpublish.fieldType.ezurl.externalStorage.class: eZ\Publish\Core\FieldType\Url\UrlStorage
services:
    ezpublish.fieldType.ezurl.externalStorage:
        class: %ezpublish.fieldType.ezurl.externalStorage.class%
        arguments:
            - "@ezpublish.fieldType.ezurl.storage_gateway"
        tags:
            - {name: ezpublish.fieldType.externalStorageHandler, alias: ezurl}
```
    
### ezpublish.storageEngine.legacy.converter

Registers a converter for a Field Type in legacy storage engine

- alias

Example:

```php
services:
    ezsystems.tweetbundle.fieldType.eztweet.converter:
        class: EzSystems\TweetFieldTypeBundle\eZ\Publish\FieldType\Tweet\LegacyConverter
        tags:
            - {name: ezpublish.storageEngine.legacy.converter, alias: eztweet}
```
    
### ezpublish.persistence.legacy.role.limitation.handler

Example:

```php
services:
    ezpublish.persistence.legacy.role.limitation.handler.object_state:
                parent: ezpublish.persistence.legacy.role.limitation.handler
                class: "%ezpublish.persistence.legacy.role.limitation.handler.object_state.class%"
                tags:
                    - {name: ezpublish.persistence.legacy.role.limitation.handler}
```

## RepositoryFormsBundle

### ez.fieldFormMapper.value

Registers FormMapper value providing content editing support.

<https://doc.ezplatform.com/en/2.1/cookbook/adding_new_field_types/#2-service-definition>

Example:

```php
EzSystems\RepositoryForms\FieldType\Mapper\CheckboxFormMapper:
    tags:
        - { name: ez.fieldFormMapper.definition, fieldType: ezboolean }
        - { name: ez.fieldFormMapper.value, fieldType: ezboolean }
```

### ez.fieldFormMapper.definition

Registers FormMapper definition providing Field Type definition editing support.

<https://doc.ezplatform.com/en/2.1/cookbook/adding_new_field_types/#2-service-definition>

Example:

```php
EzSystems\RepositoryForms\FieldType\Mapper\CheckboxFormMapper:
    tags:
        - { name: ez.fieldFormMapper.definition, fieldType: ezboolean }
        - { name: ez.fieldFormMapper.value, fieldType: ezboolean }
```

### ez.limitation.formMapper

See: https://doc.ezplatform.com/en/2.1/guide/custom_policies/#integrating-custom-limitation-types-with-the-ui    

- limitationType
    
Example:

```yml
services:
    acme.security.limitation.custom_limitation.mapper:
        class: 'AppBundle\Security\Limitation\Mapper\CustomLimitationFormMapper'
        arguments:
            # ...
        tags:
            - { name: 'ez.limitation.formMapper', limitationType: 'Custom' }
```   
    
### ez.limitation.valueMapper

See: https://doc.ezplatform.com/en/2.1/guide/custom_policies/#integrating-custom-limitation-types-with-the-ui    

- limitationType
    
Example:

```yml
services:
    acme.security.limitation.custom_limitation.mapper:
        class: 'AppBundle\Security\Limitation\Mapper\CustomLimitationValueMapper'
        arguments:
            # ...
        tags:
            - { name: 'ez.limitation.valueMapper', limitationType: 'Custom' }
```