# Keyword Field Type

This Field Type stores one or several comma-separated keywords as a string or array of strings.

| Name      | Internal name | Expected input|
|-----------|---------------|---------------|
| `Keyword` | `ezkeyword`   | `string[]|string` |

## PHP API Field Type 

### Input expectations

|Type|Example|
|------|------|
|`string`|`"documentation"`|
|`string`|`"php, Ibexa Platform, html5"`|
|`string[]`|`[ "Ibexa", "Enterprise", "User Experience Management" ]`|

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property | Type       | Description|
|----------|------------|------------|
| `$value` | `string[]` | Holds an array of keywords as strings.|

``` php
// Value object content example
use Ibexa\Core\FieldType\Keyword\Value;
 
// Instantiates a Value object
$keywordValue = new Value();
 
// Sets an array of keywords as a value
$keyword->value = [ "php", "css3", "html5", "Ibexa Platform" ];
```

#### Constructor

The `Keyword\Value` constructor will initialize a new Value object with the value provided.

It expects a list of keywords, either comma-separated in a string or as an array of strings.

``` php
// Constructor example
use Ibexa\Core\FieldType\Keyword\Value;
 
// Instantiates a Value object with an array of keywords
$keywordValue = new Value( [ "php5", "css3", "html5" ] );
 
// Instantiates a Value object with a list of keywords in a string
// This is equivalent to the example above
$keywordValue = new Value( "php5,css3,html5" );
```
