---
description: CatalogName Search Criterion
---

# CatalogName Criterion

The `CatalogName` Search Criterion searches for catalogs by the value of their name.

## Arguments

- `value` - string representing the catalog's name

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/catalogs/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product-Catalog/operation/ibexa.product_catalog.rest.catalogs.view) request:

=== "XML"

    ```xml
	<CatalogQuery>
		<Query>
			<CatalogNameCriterion>Furniture</CatalogNameCriterion>
		</Query>
	</CatalogQuery>
    ```

=== "JSON"

    ```json
    {
        "CatalogQuery": {
            "Query": {
                "CatalogNameCriterion": "Furniture"
            }
        }
    }
    ```
