# CatalogName Criterion

The `CatalogName` Search Criterion searches for catalogs by the value of their name.

## Arguments

- `value` - string representing the catalog's name

## Example

### REST API

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