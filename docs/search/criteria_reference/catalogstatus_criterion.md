# CatalogStatus Criterion

The `CatalogStatus` Search Criterion searches for catalogs by the value of their status.

## Arguments

- `value` - string representing the catalog's status

## Example

### REST API

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