# Matrix field type

This field represents and handles a table of rows and columns of data.

| Name     | Internal name | Expected input |
|----------|---------------|----------------|
| `Matrix` | `ezmatrix`    | `array`        |

The Matrix field type is available via the Matrix Bundle provided by the [ibexa/fieldtype-matrix](https://github.com/ibexa/fieldtype-matrix) package.

## PHP API field type

### Input expectations

|Type|Description|Example|
|------|------|------|
|`array`|array of `Ibexa\FieldTypeMatrix\FieldType\Value\Row` objects which contain column data|see below|

Example of input:

```php
new FieldType\Value([
    new FieldType\Value\Row(['col1' => 'Row 1, Col 1', 'col2' => 'Row 1, Col 2']),
    new FieldType\Value\Row(['col1' => 'Row 2, Col 1', 'col2' => 'Row 2, Col 2']),
    new FieldType\Value\Row(['col1' => 'Row 3, Col 1', 'col2' => 'Row 3, Col 2']),
]);
```

### Value Object

`Ibexa\FieldTypeMatrix\FieldType\Value` offers the following properties:

|Property|Type|Description|
|------|------|------|
|`rows`|`RowsCollection`|Array of `Row` objects containing an array of cells (`Row::getCells()` returns array `['col1' => 'Value 1', /* ... */]`).|

### Validation

The minimum number of rows is set on content type level for each field.

Validation checks for empty rows.
A row is considered empty if it contains only empty cells (or cells containing only spaces).
Empty rows are removed.

If, after removing empty rows, the number of rows doesn't fulfill the configured `Minimum number of rows`, the field doesn't validate.

For example, the following input doesn't validate if `Minimum number of rows` is set to 3, because the second row is empty:

```php
new FieldType\Value([
    new FieldType\Value\Row(['col1' => 'Row 1, Col 1', 'col2' => 'Row 1, Col 2']),
    new FieldType\Value\Row(['col1' => '', 'col2' => '']),
    new FieldType\Value\Row(['col1' => 'Row 3, Col 1', 'col2' => 'Row 3, Col 2']),
]);
```

## GraphQL field type operations

To get a field of the Matrix field type with GraphQL, you need to specify a content ID, a content type, and a field type.

The types that are returned are named after the Type and the field:

- `{TypeIdentifier}{FieldIdentifier}Row`

The example below shows a GraphQL query for a Recipe content item (belonging to a content type with a Matrix field added), that has two fields:

- `name`: `ezstring`
- `ingredients`: `ezmatrix` with two columns: `ingredient` and `quantity`

```
{
  content {
    recipe(id: 123) {
      name
      ingredients {
        ingredient
        quantity
      }
    }
  }
}
```

The Type returned for the Matrix field exposes columns defined in the field definition:

```
{
  "data": {
    "content": {
      "recipe": {
        "name": "Cake ingredients",
        "ingredients": [
          {
            "ingredient": "Butter",
            "quantity": "200 grams"
          },
          {
            "ingredient": "Sugar",
            "quantity": "100 grams"
          }
        ]
      }
    }
  }
}
```

### Query for the field type and field definition's details

With this query you can inspect details of specific content type.
In case of a Matrix field, you can ask for the list of columns, their names, and identifiers.

```
{
  content {
    _types {
      recipe {
        ingredients {
          settings {
            minimumRows
            columns {
              name
              identifier
            }
          }
        }
      }
    }
  }
}
```

The response lists the exposed field type settings:

- minimumRows
- columns
    - name
    - identifier

Example response:

```
{
  "data": {
    "content": {
      "_types": {
        "recipe": {
          "ingredients": {
            "settings": {
              "minimumRows": 1,
              "columns": [
                {
                  "name": "ingredient",
                  "identifier": "ingredient"
                },
                {
                  "name": "quantity",
                  "identifier": "quantity"
                }
              ]
            }
          }
        }
      }
    }
  }
}
```

### Mutation

To create a Matrix field type you need to define field type and field definition identifiers.
The types that are used for input are named after the Type and the field:

- `{TypeIdentifier}{FieldIdentifier}RowInput`, for example, `dish.nutritionFacts`, `event.agenda`: `DishNutritionFactsRowInput`, `EventAgendaRowInput`

The example below shows how to create a Recipe content item (belonging to a content type with a Matrix field type added) that has two fields:

- `name`: `"Cake Ingredient List"`
- `ingredients`: `ezmatrix` with two columns: `ingredient` and `quantity`

```
 mutation AddRecipe {
  createRecipe(
    language: eng_GB
    parentLocationId: 2,
    input: {
      name: "Cake Ingredient List",
      ingredients: [
        {ingredient: "sugar", quantity: "100 grams"}
        {ingredient: "butter", quantity: "200 grams"}
      ]
    }
  ) {
    name
  }
}
```

The response confirms creation of the new Recipe field:

```
{
  "data": {
    "createRecipe": {
      "name": "Cake Ingredient List"
    }
  }
}

```
