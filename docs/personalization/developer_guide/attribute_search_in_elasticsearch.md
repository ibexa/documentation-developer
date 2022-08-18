---
description: Attribute search uses Elasticsearch database to display dynamically taken values in scenario and model previews.
---

# Attribute search in Elasticsearch database

If you use external data source for personalization data, it is not possible to display external content in the Universal Discovery Widget as it is deprecated. Attribute search is used in scenario preview and editorials models instead.
Attribute search works like an autocomplete feature, but values are dynamically taken from the Elasticsearch database.

## Configure attribute search

In the `config/packages/ibexa.yaml`, add the following configuration:

```yaml
ibexa:
    system:
       <scope>:
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

![Attributes search](perso_attributes_search.png)
