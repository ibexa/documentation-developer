---
description: CatalogStatus Search Criterion
---

# CatalogStatus Criterion

The `CatalogStatus` Search Criterion searches for catalogs by the value of their status.

## Arguments

- `value` - string representing the catalog's status

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/catalogs/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product-Catalog/operation/ibexa.product_catalog.rest.catalogs.view) request:

=== "XML"

    ```xml
	<CatalogQuery>
		<Query>
			<CatalogStatusCriterion>published</CatalogStatusCriterion>
		</Query>
	</CatalogQuery>
    ```

=== "JSON"

    ```json
    {
        "CatalogQuery": {
            "Query": {
                "CatalogStatusCriterion": "published"
            }
        }
    }
    ```
