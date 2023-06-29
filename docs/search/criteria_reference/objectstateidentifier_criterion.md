# ObjectStateIdentifier Criterion

The [`ObjectStateIdentifier` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/ObjectStateId.php)
searches for content based on its Object State identifier.

## Arguments

- `value` - string(s) representing the Object State identifier(s)
- `target` (optional for PHP)  - string representing the Object State group

## Example

### PHP

``` php
$query->query = new Criterion\ObjectStateIdentifier(['ready']);
```

``` php
$query->query = new Criterion\ObjectStateIdentifier(['not_locked'], 'ez_lock');
```

### REST API

=== "XML"

    ```xml
      <Query>
        <Filter>
          <ObjectStateIdentifierCriterion>
            <value>not_locked</value>
            <target>ez_lock</target>
          </ObjectStateIdentifierCriterion>
        </Filter>
      </Query>
    ```

=== "JSON"

    ```json
    "Query": {
      "Filter": {
        "ObjectStateIdentifierCriterion": {
          "value": "not_locked",
          "target": "ez_lock"
        }
      }
    }
    ```