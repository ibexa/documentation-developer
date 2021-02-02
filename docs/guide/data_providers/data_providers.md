# Data providers

Data providers define where product information is stored.

You can use one of two data providers: the [Repository data provider](repository_data_provider.md)
or the [eContent data provider](../econtent/econtent.md).

## Repository vs. eContent data provider

| Feature                              | Repository                                | eContent                                     |
| ------------------------------------ | -------------------------------------------- | -------------------------------------------- |
| Flexible data model                   | yes  | yes  |
| Translations                         | yes  | yes  |
| Interface for editing                | yes  | no |
| Versioning                           | yes  | no |
| Simple segmentation          | yes  | yes  |
| Extended segmentation        | no | yes  |
| Fast imports         | no | yes  |
| Support of large catalogs              | no | yes  |
| Staging (live and temporary space) | no | yes  |

## Switching the data provider

You can switch the data provider either [with the command line](#command-line-switching) or [manually](#manual-switching).
Only one data provider can be active at the same time.

### Command-line switching

The `ibexa:commerce:switch-data-provider` command switches between the Repository data provider and eContent.
It is useful especially for testing purposes.

The command takes the following options:

|Option|Notes|
|--- |--- |
|`--new-root-node`|Default value is `56` for Repository data provider, `2` for eContent.|
|`--location-id`|Default value is `56`. This is the default Location ID of the "Product catalog" Content item. If you are using another Location ID, change this parameter.|

To switch to eContent, use the following command:

``` bash
php bin/console ibexa:commerce:switch-data-provider econtent --location-id=56 --new-root-node=2
php bin/console ibexa:commerce:index-econtent --no-debug
php bin/console ibexa:commerce:index-econtent swap --no-debug
```

To switch to the Repository data provider, use the following command:

``` bash
php bin/console ibexa:commerce:switch-data-provider ez
```

After you execute the command, clear the cache.

### Data provider switch process

Switching the data provider introduces the following changes to your project:

#### Changes to `config/packages/ecommerce.yml`

``` yaml
- { resource: '@SilversolutionsEshopBundle/Resources/config/config_data_provider_econtent.yml' }
# or 
- { resource: '@SilversolutionsEshopBundle/Resources/config/config_data_provider_ez.yml' }
```

#### Changes to the "Product catalog" Content item

The Product catalog's root node is set accordingly.

![](../img/product_catalog.png)

### Manual switching

#### 1. Load root element

First, ensure that you are loading the correct root element for your provider.

![](../img/manual_switching.png)

#### 2. Configure search services

Change the alias for search services for every type (product, catalog, content).

``` xml
# set up alias for product search 
# for Repository data provider 
<service id="siso_search.search_service.product" alias="siso_search.ezsolr_search_service">
</service>
 
# for eContent
<service id="siso_search.search_service.product" alias="siso_search.econtentsolr_search_service">
</service>

# set up alias for catalog search 
<service id="siso_search.search_service.catalog" alias="siso_search.econtentsolr_search_service">
</service>

# set up alias for content search 
<service id="siso_search.search_service.content" alias="siso_search.ezsolr_search_service">
</service>
```

#### 3. Set up search groups

Set up search groups and configuration accordingly.

Check the complete configuration from the vendor as well:

- `Siso/Bundle/SearchBundle/Resources/config/econtent_search.yml`
- `Siso/Bundle/SearchBundle/Resources/config/ez_search.yml`

The path for products in eContent e.g. is `/2/` and for Repository `/1/2`

``` yaml
siso_search.default.groups.search:
    product:
        types:
            - ses_product
        path: '/1/2/'
        section: 1
        visibility: true
    content:
        types:
            - st_module
            - folder
            - article
            - landing_page
            - blog_post
            - event
        path: '/1/2/'
        section: 1
        visibility: true
    files:
        types:
            - file
            - video
        path: '/1/43/'
        section: 3
        visibility: true
```
