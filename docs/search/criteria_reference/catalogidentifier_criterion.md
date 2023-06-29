# CatalogIdentifier Criterion

The `CatalogIdentifier` Search Criterion searches for catalogs by the value of their identifier.

## Arguments

- `value` - string representing the catalog's identifier

## Example

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