# Implement the Tweet\Type class

As said in the introduction, the Type class of a Field Type must implement `eZ\Publish\SPI\FieldType\FieldType` (later referred to as "Field Type interface").

All native Field Types also extend the `eZ\Publish\Core\FieldType\FieldType` abstract class that implements this interface and provides implementation facilities through a set of abstract methods of its own. In this case, Type classes implement a mix of methods from the Field Type interface and from the abstract Field Type.

The recommended way to allow the Field Type to be able to generate content name is through implementing the `eZ\Publish\SPI\FieldType\Nameable` interface. It was also used in this tutorial.

Let’s go over those methods and their implementation.

### Identification method

#### `getFieldTypeIdentifier()`

This method must return the string that **uniquely** identifies this Field Type (DataTypeString in legacy), in this case "`eztweet`":

``` php
// eZ/Publish/FieldType/Tweet/Type.php

public function getFieldTypeIdentifier()
{
    return 'eztweet';
}
```

### Value handling methods

#### `createValueFromInput()` and `checkValueStructure()`

Both methods are used by the abstract Field Type implementation of `acceptValue()`. This Field Type interface method checks and transforms various input values into the type's own Value class: `eZ\FieldType\Tweet\Value`. This method must:

- either **return the Value object** it was able to create out of the input value,
- or **return this value untouched**. The API will detect this and inform that the input value was not accepted.

The only acceptable value for your type is the URL of a tweet (you could of course imagine more possibilities). This should do:

``` php
protected function createValueFromInput($inputValue)
{
    if (is_string($inputValue)) {
        $inputValue = new Value(['url' => $inputValue]);
    }

    return $inputValue;
}
```

Use this method to provide convenient ways to set an attribute’s value using the API. This can be anything from primitives to complex business objects.

Next, implement `checkValueStructure()`. It is called by the abstract Field Type to ensure that the Value fed to the Type is acceptable. In this case, you want to be sure that `Tweet` `     \Value::$url` is a string:

``` php
protected function checkValueStructure(CoreValue $value)
{
    if (!is_string($value->url)) {
        throw new InvalidArgumentType(
            '$value->url',
            'string',
            $value->url
        );
    }
}
```

You see that this executes the same check as in `createValueFromInput()`, but both methods aren't responsible for the same thing. The first will, *if given something else than a Value of its type*, try to convert it to one. `checkValueStructure()` will always be used, even if the Field Type is directly fed a `Value` object, and not a string.

### Value initialization

#### `getEmptyValue()`

This method provides what is considered an empty value of this type, depending on your business requirements. No extra initialization is required in this case.

``` php
// eZ/Publish/FieldType/Tweet/Type.php

public function getEmptyValue()
{
    return new Value;
}
```

If you ran the unit tests at this point, you would get about five failures, all of them on the `fromHash()` or `toHash()` methods. You'll handle them later.

### Validation

The Type class is also responsible for validating input data (to a `Field`), as well as configuration input data (to a `FieldDefinition`). In this tutorial, we will validate submitted urls, ensuring they actually reference a Twitter status.

`validate()` is the method that runs the validation on data, when a Content item is created with a Field of this type:

``` php
// eZ/Publish/FieldType/Tweet/Type.php

public function validate(FieldDefinition $fieldDefinition, SPIValue $fieldValue)
{
    $errors = [];

    if ($this->isEmptyValue($fieldValue)) {
        return $errors;
    }

    // Tweet URL validation
    if (!preg_match('#^https?://twitter.com/([^/]+)/status/[0-9]+$#', $fieldValue->url, $m)) {
        $errors[] = new ValidationError(
            'Invalid Twitter status URL %url%',
            null,
            ['%url%' => $fieldValue->url]
        );
    }

    return $errors;
}
```

You validate the URL with a regular expression. If it doesn’t match, you add an instance of `ValidationError` to the return array. Note that the tested value isn’t directly embedded in the message but passed as an argument. This ensures that the variable is properly encoded in order to prevent attacks, and allows for singular/plural phrases using the second parameter.

We will create more advanced custom validation later in the tutorial.

### Metadata handling methods

#### `getFieldName()` and `getSortInfo()`

Field Types require two methods related to Field metadata:

- ` getFieldName()` is used to generate a name out of a Field value, either to name a Content item (naming pattern in legacy) or to generate a part for a URL alias.

- ` getSortInfo()` is used by the persistence layer to obtain the value it can use to sort and filter on a Field of this type

Obviously, a tweet’s full URL isn’t really suitable as a name. Let’s use a subset of it: `<username>-<tweetId>` should be reasonable enough, and suitable for both sorting and naming.

You can assume that this method will not be called if the Field is empty, and that the URL is a valid twitter URL:

``` php
// eZ/Publish/FieldType/Tweet/Type.php

public function getFieldName( SPIValue $value , FieldDefinition $fieldDefinition, $languageCode)
{
    return preg_replace(
        '#^https?://twitter\.com/([^/]+)/status/([0-9]+)$#',
        '$1-$2',
        (string)$value->url
    );
}

protected function getSortInfo(CoreValue $value)
{
    return (string)$value->url;
}
```

In `getFieldName()` you run a regular expression replace on the URL to extract the part you’re interested in.

This name is a perfect match for `getSortInfo()` as it allows you to sort by the tweet’s author and by the tweet’s ID.

In the `eZ\Publish\SPI\FieldType\FieldType` interface there is also `getName()` method that is currently deprecated and replaced by `getFieldName()`. You can throw an exception in its body to make sure it isn't called anywhere:
```php
public function getName(SPIValue $value)
{
    throw new \RuntimeException(
        'Name generation provided via NameableField set via "ezpublish.fieldType.nameable" service tag'
    );
}
```

### Field Type serialization methods

#### `fromHash()` and `toHash()`

Both methods defined in the Field Type interface are core to the REST API. They are used to export values to serializable hashes.

In this case it is quite easy:

- `toHash()` will build a hash with every property from `Tweet\Value`;

- `fromHash()` will instantiate a `Tweet\Value` with the hash it receives.  

``` php
// eZ/Publish/FieldType/Tweet/Type.php

public function fromHash($hash)
{
    if ($hash === null) {
        return $this->getEmptyValue();
    }

    return new Value($hash);
}

public function toHash(SPIValue $value)
{
    if ($this->isEmptyValue($value)) {
        return null;
    }

    return [
        'url' => $value->url,
        'authorUrl' => $value->authorUrl,
        'contents' => $value->contents
    ];
}
```

### Persistence methods

#### `fromPersistenceValue()` and `toPersistenceValue()`

Storage of Field Type data is done through the persistence layer (SPI).

Field Types use their own Value objects to expose their contents using their own domain language. However, to store those objects, the Type needs to map this custom object to a structure understood by the persistence layer: `PersistenceValue`. This simple value object has three properties:

- `data` – standard data, stored using the storage engine's native features
- `externalData` – external data, stored using a custom storage handler
- `sortKey` – sort value used for sorting

The role of those mapping methods is to convert a `Value` of the Field Type into a `PersistenceValue` and the other way around.

##### About external storage

Whatever is stored in `externalData` requires an external storage handler to be written. Read more about external storage in [Field Type API and best practices](../../api/field_type_api_and_best_practices/).

External storage is beyond the scope of this tutorial, but many examples can be found in existing Field Types.

You will follow a simple implementation here: the `Tweet\Value` object will be serialized as an array to the `code` property using `fromHash()` and `toHash()`:

``` php
// eZ/Publish/FieldType/Tweet/Type.php

public function toPersistenceValue(SPIValue $value)
{
    if ($value === null) {
        return new PersistenceValue(
            [
                'data' => null,
                'externalData' => null,
                'sortKey' => null,
            ]
        );
    }

    return new PersistenceValue(
        [
            'data' => $this->toHash($value),
            'sortKey' => $this->getSortInfo($value),
        ]
    );
}

public function fromPersistenceValue(PersistenceValue $fieldValue)
{
    if ($fieldValue->data === null) {
        return $this->getEmptyValue();
    }

    return new Value($fieldValue->data);
}
```

## Fetching data from the Twitter API

As explained in the tutorial's introduction, you will enrich our tweet's URL with the embed version, fetched using the Twitter API. To do so, you will, when `toPersistenceValue()` is called, fill in the value's contents property from this method, before creating the `PersistenceValue` object.

First, we need a Twitter client in `Tweet\Type`. For convenience, one is provided in this tutorial's bundle:

- the `Twitter\TwitterClient` class
- the `Twitter\TwitterClientInterface` interface
- an `ezsystems.tweetbundle.twitter.client` service that uses the class above.

The interface has one method: `getEmbed( $statusUrl )` that, given a tweet's URL, returns the embed code as a string. The implementation is very simple, for the sake of simplicity, but gets the job done. Ideally, it should at the very least handle errors, but it is not necessary here.

## Injecting the Twitter client into `Tweet\Type`

Your Field Type doesn't have a constructor yet. You will create one, with an instance of `Twitter\TwitterClientInterface` as the argument, and store it in a new protected property:

``` php
<?php
// eZ/Publish/FieldType/Tweet/Type.php:

use EzSystems\TweetFieldTypeBundle\Twitter\TwitterClientInterface;

class Type extends FieldType
{
    protected $twitterClient;

    public function __construct(TwitterClientInterface $twitterClient)
    {
        $this->twitterClient = $twitterClient;
    }
}
```

## Completing the value using the Twitter client

As described above, before creating the `PersistenceValue` object in `toPersistenceValue`, you will fetch the tweet's embed contents using the client, and assign it to `Tweet\Value::$data`:

``` php
// eZ/Publish/FieldType/Tweet/Type.php

public function toPersistenceValue(SPIValue $value)
{
    if ($value === null) {
        return new PersistenceValue(
            [
                'data' => null,
                'externalData' => null,
                'sortKey' => null,
            ]
        );
    }

    if ($value->contents === null) {
        $value->contents = $this->twitterClient->getEmbed($value->url);
    }

    return new PersistenceValue(
        [
            'data' => $this->toHash($value),
            'sortKey' => $this->getSortInfo($value),
        ]
    );
}
```

And that's it! When the persistence layer stores content from our type, the value will be completed with what the twitter API returns.

------------------------------------------------------------------------

⬅ Previous: [Implement the `Tweet\Value` class](2_implement_the_tweet_value_class.md)

Next: [Register the Field Type as a service](4_register_the_field_type_as_a_service.md) ➡
