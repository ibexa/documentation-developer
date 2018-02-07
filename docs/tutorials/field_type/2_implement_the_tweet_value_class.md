# Implement the Tweet\Value class

The Value class of a Field Type is by design very simple. It is meant to be stateless and as lightweight as possible. This class must contain as little logic as possible, because the logic is the responsibility of the Type class. You will create this Type class in the next step.

All the code for the Bundle will be created in: `src/EzSystems/TweetFieldTypeBundle`

The Value class will contain at least:

- public properties: used to store the actual data
- an implementation of the `__toString()` method: required by the Value interface it inherits from

By default, the constructor from `FieldType\Value` will be used. It allows you to pass a hash of property/value pairs. You can override it as well if you want. In this example, we will do that to allow passing only string with the URL as an argument.

The Tweet Field Type is going to store 3 elements:

- The tweet’s URL
- The tweet’s author URL
- The body, as an HTML string  

At this point, it does not matter where they are stored. All you care about is *what you want your Field Type to expose as an API*.

You will end up with the following properties:

``` php
// eZ/Publish/FieldType/Tweet/Value.php

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

The only thing left to honor the `FieldType\Value` interface is to add a `__toString()` method, in addition to the constructor. Let’s say that yours will return the tweet’s URL:

``` php
// eZ/Publish/FieldType/Tweet/Value.php

//Methods of the class Value
public function __toString()
{
    return (string)$this->url;
}
```

As mentioned before, we can also override the constructor to accept passing the URL as a string:

``` php
// eZ/Publish/FieldType/Tweet/Value.php

//Contructor
public function __construct($arg = [])
{
    if (!is_array($arg)) {
        $arg = ['url' => $arg];
    }

    parent::__construct($arg);
}
```

------------------------------------------------------------------------

⬅ Previous: [Structure the bundle](1_create_the_bundle.md)

Next: [Implement the `Tweet\Type` class](3_implement_the_tweet_type_class.md) ➡
