# URL Field Type

This Field Type makes it possible to store and retrieve a URL. It is formed by the combination of a link and the respective text.

| Name  | Internal name | Expected input |
|-------|---------------|----------------|
| `Url` | `ezurl`       | `string`       |

## PHP API Field Type

### Input expectations

|Type|Description|Example|
|------|------|------|
|`string`|Link content provided to the value.|"http://www.ibexa.co"|
|`string`|Text content that represents the stored link.|"Ibexa"|

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property | Type     | Description|
|----------|----------|------------|
| `$link`  | `string` | This property stores the link provided to the value of this Field Type.                              |
| `$text`  | `string` | This property stores the text to represent the stored link provided to the value of this Field Type. |

``` php
// Value object content example

$url->link = "http://www.ibexa.co";
$url->text = "Ibexa";
```

##### Constructor

The `Url\Value` constructor initializes a new Value object with the provided value. It expects two comma-separated strings, corresponding to the link and text.

``` php
// Constructor example

// Instantiates an Url Value object
$UrlValue = new Url\Value( "http://www.ibexa.co", "Ibexa" );
```
### Hash format

|Key|Type|Description|Example|
|------|------|------|------|
|`link`|`string`|Link content.|"http://ibexa.co"|
|`text`|`string`|Text content.|"Ibexa"|

```php
// Example of the hash value in PHP
$hash = [
    "link" => "http://ibexa.co",
    "text" => "Ibexa"
];

```

### Validation

This Field Type does not perform validation.

### Settings

This Field Type does not have settings.
