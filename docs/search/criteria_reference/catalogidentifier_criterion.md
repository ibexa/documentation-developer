# CatalogIdentifier Criterion

The `CatalogIdentifier` Search Criterion searches for a catalog by the value of its identifier.

## Arguments

- `value` - string representing the catalog's identifier

## Example

### REST API

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