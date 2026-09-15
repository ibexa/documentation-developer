# URL field type

This field type makes it possible to store and retrieve a URL.
It's formed by the combination of a link and the respective text.

| Name  | Internal name | Expected input |
|-------|---------------|----------------|
| `Url` | `ezurl`       | `string`       |

## PHP API field type

### Input expectations

|Type|Description|Example|
|------|------|------|
|`string`|Link content provided to the value.|"https://www.ibexa.co"|
|`string`|Text content that represents the stored link.|"Ibexa"|

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property | Type     | Description|
|----------|----------|------------|
| `$link`  | `string` | This property stores the link provided to the value of this field type.                              |
| `$text`  | `string` | This property stores the text to represent the stored link provided to the value of this field type. |

``` php
// Value object content example

$url->link = "https://www.ibexa.co";
$url->text = "Ibexa";
```

##### Constructor

The `Url\Value` constructor initializes a new value object with the provided value.
It expects two comma-separated strings, corresponding to the link and text.

``` php
// Constructor example

// Instantiates an Url Value object
$UrlValue = new Url\Value( "https://www.ibexa.co/", "Ibexa" );
```
### Hash format

| Key    | Type     | Description   | Example                 |
|--------|----------|---------------|-------------------------|
| `link` | `string` | Link content. | "https://www.ibexa.co/" |
| `text` | `string` | Text content. | "Ibexa"                 |

```php
// Example of the hash value in PHP
$hash = [
    "link" => "https://www.ibexa.co/",
    "text" => "Ibexa"
];

```

### Validation

This field type doesn't perform validation.

### Settings

This field type doesn't have settings.

## GraphQL integration

To access the `link` and `text` properties in GraphQL responses, set the `ibexa.graphql.schema.should.extend.ezurl` parameter to `true`.

!!! note

    This behaviour is enabled by default in [[= product_name =]] v5 and the parameter is removed.

Compare the examples below:

<table>
<thead><tr><th scope="col">Parameter value</th><th scope="col">Request</th><th scope="col">Responses</th></tr></thead>
<tbody>
<tr>
<td>Disabled</td>
<td class="compare">
```graphql
{
  content {
    article(contentId: 76) {
      url_field
    }
  }
}
```
</td><td class="compare">
```graphql
{
  "data": {
    "content": {
      "article": {
        "url_field": "https://example.com"
      }
    }
  }
}
```
</td></tr>
<tr>
<td>Enabled</td>
<td class="compare">
```graphql
{
  content {
    article(contentId: 76) {
      url_field {
        text
        link
      }
    }
  }
}

```
</td><td class="compare">
```graphql
{
  "data": {
    "content": {
      "article": {
        "field68dbd09357392": {
          "text": "Example",
          "link": "https://example.com"
        }
      }
    }
  }
}
```
</td></tr>
</tbody></table>
