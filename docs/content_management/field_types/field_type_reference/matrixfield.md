# Matrix Field Type

This Field represents and handles a table of rows and columns of data.

| Name     | Internal name | Expected input |
|----------|---------------|----------------|
| `Matrix` | `ezmatrix`    | `array`        |

The Matrix Field Type is available via the Matrix Bundle
provided by the [ibexa/matrix-fieldtype](https://github.com/ibexa/matrix-fieldtype) package.

## PHP API Field Type

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

The minimum number of rows is set on Content Type level for each Field.

Validation checks for empty rows. A row is considered empty if it contains only empty cells (or cells containing only spaces). Empty rows are removed.

If, after removing empty rows, the number of rows does not fulfill the configured `Minimum number of rows`, the Field will not validate.

For example, the following input will not validate if `Minimum number of rows` is set to 3, because the second row is empty:

```php
new FieldType\Value([
    new FieldType\Value\Row(['col1' => 'Row 1, Col 1', 'col2' => 'Row 1, Col 2']),
    new FieldType\Value\Row(['col1' => '', 'col2' => '']),
    new FieldType\Value\Row(['col1' => 'Row 3, Col 1', 'col2' => 'Row 3, Col 2']),
]);
```

## GraphQL Field Type operations

To get a Field of the Matrix Field Type with GraphQL, you will need to specify a Content ID, a Content Type, and a Field Type.

The types that are returned are named after the Type and the Field:

- `{TypeIdentifier}{FieldIdentifier}Row`

The example below shows a GraphQL query for a Recipe Content item (belonging to a Content Type with a Matrix Field added), that has two Fields:

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

The Type returned for the Matrix Field exposes columns defined in the Field definition:

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

### Query for the Field Type and Field definition's details

With this query you can inspect details of specific Content Type. In case of a Matrix Field, you can ask for the list of columns, their names and identifiers.

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

The response will list the exposed Field Type settings:

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

To create a Matrix Field Type you need to define Field Type and Field definition identifiers.
The types that are used for input are named after the Type and the Field:

- `{TypeIdentifier}{FieldIdentifier}RowInput` e.g. `dish.nutritionFacts`, `event.agenda`: `DishNutritionFactsRowInput`, `EventAgendaRowInput`

The example below shows how to create a Recipe Content item (belonging to a Content Type with a Matrix Field Type added) that has two Fields:

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

The response will confirm creation of the new Recipe Field:

```
{
  "data": {
    "createRecipe": {
      "name": "Cake Ingredient List"
    }
  }
}

```
