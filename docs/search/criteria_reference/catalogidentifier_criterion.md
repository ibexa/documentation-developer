---
description: CatalogIdentifier Search Criterion
---

# CatalogIdentifier Criterion

The `CatalogIdentifier` Search Criterion searches for a catalog by the value of its identifier.

## Arguments

- `value` - string representing the catalog's identifier

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/catalogs/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product-Catalog/operation/ibexa.product_catalog.rest.catalogs.view) request:

=== "XML"

    ```xml
	<CatalogQuery>
		<Query>
			<CatalogIdentifierCriterion>catalog_1</CatalogIdentifierCriterion>
		</Query>
	</CatalogQuery>
    ```

=== "JSON"

    ```json
    {
        "CatalogQuery": {
            "Query": {
                "CatalogIdentifierCriterion": "catalog_1",
            }
        }
    }
    ```
