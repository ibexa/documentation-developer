# Attributes search in Elasticsearch database

If you use external data source, it is not possible to display external content in the Universal Discovery Widget as it is deprecated. Attributes search is used in scenario preview and editorials models instead.
This works like an autocomplete feature however, values are dynamically taken from the Elasticsearch database.

## Configure attributes search

In the `config/packages/ibexa.yaml`, add the following configuration key:

```yaml
ibexa:
    system:
       <site_access>:
            personalization:
                output_type_attributes:
                    <item_type_id>:
                        title: <item_name>                        
```


See the example:

```yaml
ibexa:
    system:
        default:
            personalization:
                output_type_attributes:
                    1:
                        title: name
                        description: short_description
                    2:
                        title: category_name
                    3:
                        title: product_name
                    4:
                        title: short_name
                        description: body
                        image: image
                        
```

EventSubscriber `Ibexa\Personalization\Event\Subscriber\UniversalDiscovery\AllowedContentTypes` has been dropped because UDW is no longer used.