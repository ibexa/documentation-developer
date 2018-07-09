# Step 2 - Implement the Tweet\Value class

### The Value class

The Value is used to represent an instance of the Field Type within a Content item. Each Field will present its data using an instance of the Type's Value class.
A Value class must implement the `eZ\Publish\SPI\FieldType\Value` interface. It may also extend the `eZ\Publish\Core\FieldType\Value` abstract class.

The Value class of a Field Type is by design very simple. It is meant to be stateless and as lightweight as possible. This class must contain as little logic as possible, because the logic is handled by the Type class.

The Value class will contain at least:

- public properties: used to store the actual data
- an implementation of the `__toString()` method: required by the Value interface it inherits from

By default, the constructor from `FieldType\Value` will be used. It allows you to pass a hash of property/value pairs. You can override it as well if you want. In this example, you will do that to allow passing only string with the URL as an argument.

The Tweet Field Type is going to store three elements:

- The tweet's URL
- The tweet's author URL
- The body, as an HTML string

At this point, it does not matter where they are stored. You want to focus on *what the Field Type exposes as an API*.

`eZ/Publish/FieldType/Tweet/Value.php` should have the following properties:

``` php
<?php
//Properties of the class Value
/**
 * Tweet URL on twitter.com.
 *
 * @var string
 */
public $url;

/**
 * Author's Twitter URL (https://twitter.com/UserName)
 *
 * @var string
 */
public $authorUrl;

/**
 * The tweet's embed HTML
 *
 * @var string
 */
public $contents;
```

To match the `FieldType\Value` interface you also need to add a `__toString()` method, in addition to the constructor.
Here it will return the tweet's URL:

``` php
<?php
// eZ/Publish/FieldType/Tweet/Value.php

//Methods of the class Value
public function __toString()
{
    return (string)$this->url;
}
```

As mentioned before, you can also override the constructor to accept passing the URL as a string:

``` php
// eZ/Publish/FieldType/Tweet/Value.php

//Constructor
public function __construct($arg = [])
{
    if (!is_array($arg)) {
        $arg = ['url' => $arg];
    }

    parent::__construct($arg);
}
```
