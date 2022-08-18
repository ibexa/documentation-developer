# EmailAddress Field Type

The EmailAddress Field Type represents an email address, in the form of a string.

| Name           | Internal name | Expected input type |
|----------------|---------------|---------------------|
| `EmailAddress` | `ezemail`     | `string`            |

## PHP API Field Type 

### Value object

##### Properties

The `Value` class of this Field Type contains the following properties:

| Property | Type     | Description|
|----------|----------|------------|
| `$email` | `string` | This property will be used for the input string provided as email address. |

``` php
// Value object content example

use Ibexa\Core\FieldType\EmailAddress\Type;

// Instantiates an EmailAddress Value object with default value (empty string)
$emailaddressValue = new Type\Value();

// Email definition
$emailaddressValue->email = "someuser@example.com";
```

##### Constructor

The `EmailAddress\Value` constructor will initialize a new Value object with the value provided. It accepts a string as input.

``` php
// Constructor example

use Ibexa\Core\FieldType\EmailAddress\Type;
 
// Instantiates an EmailAddress Value object
$emailaddressValue = new Type\Value( "someuser@example.com" );
```

##### String representation

String representation of the Field Type's Value object is the email address contained in it.

Example: `someuser@example.com`

### Hash format

Hash value for this Field Type's Value is simply the email address as a string.

Example: `someuser@example.com`

### Validation

This Field Type uses the `EmailAddressValidator` validator as a resource which will test the string supplied as input against a pattern, to make sure that a valid email address has been provided.
If the validations fail, a `ValidationError` is thrown, specifying the error message.

### Settings

This Field Type does not support settings.
