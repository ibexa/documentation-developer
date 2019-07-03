# Step 3 - Implement the Tweet\Type class

!!! tip

    You can find all files used and modified in this step on [GitHub](https://github.com/ezsystems/TweetFieldTypeBundle/tree/step3_implement_the_tweet_type_class_v2).

### The Type class

The Type contains the logic of the Field Type: validating data, transforming from various formats, describing the validators, etc.
A Type class must implement `eZ\Publish\SPI\FieldType\FieldType` ("Field Type interface").

All native Field Types also extend the `eZ\Publish\SPI\FieldType\FieldType` abstract class that implements this interface and provides implementation facilities through a set of abstract methods of its own. In this case, Type classes implement a mix of methods from the Field Type interface and from the abstract Field Type.

To allow the Field Type to retrieve content name use the `eZ\Publish\SPI\FieldType\FieldType::getName` method.

Let's go over those methods and their implementation.

### Identification method

#### `getFieldTypeIdentifier()`

This method must return the string that **uniquely** identifies the Field Type, in this case "`eztweet`":

``` php
public function getFieldTypeIdentifier()
{
    return 'eztweet';
}
```

### Value handling methods

#### `createValueFromInput()` and `checkValueStructure()`

Both methods are used by the abstract Field Type implementation of `acceptValue()`.
This Field Type interface method checks and transforms various input values into the Type's own Value class: `eZ\FieldType\Tweet\Value`.
This method must:

- either **return the value object** it was able to create out of the input value,
- or **return this value untouched**. The API will detect this and inform that the input value was not accepted.

The only acceptable value for the type is the URL of a tweet:

``` php
protected function createValueFromInput($inputValue)
{
    if (is_string($inputValue)) {
        $inputValue = new Value(['url' => $inputValue]);
    }

    return $inputValue;
}
```

Use this method to provide convenient ways to set an attribute's value using the API. This can be anything from primitives to complex business objects.

Next, implement `checkValueStructure()`. It is called by the abstract Field Type to ensure that the Value fed to the Type is acceptable. In this case, you need to ensure that `Tweet\Value::$url` is a string:

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

The difference between this method and `createValueFromInput()` is that `createValueFromInput()` will, *if given something else than a value of its type*, try to convert it to one. `checkValueStructure()` will always be used, even if the Field Type is directly fed a value object, and not a string.

### Value initialization

#### `getEmptyValue()`

This method provides what is considered an empty value of this type, depending on the business requirements.
No extra initialization is required in this case.

``` php
public function getEmptyValue()
{
    return new Value;
}
```

### Validation

The Type class is also responsible for validating input data (to a `Field`), as well as configuration input data (to a `FieldDefinition`).
In this tutorial, you will validate submitted URLs, ensuring they actually reference a Twitter status.

`validate()` is the method that runs the validation on data, when a Content item is created with a Field of this type:

``` php
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

You validate the URL with a regular expression. If it doesn't match, you add an instance of `ValidationError` to the return array.
Note that the tested value isn't directly embedded in the message but passed as an argument.
This ensures that the variable is properly encoded in order to prevent attacks, and allows for singular/plural phrases using the second parameter.

You will create [more advanced custom validation later in the tutorial](8_add_a_validation.md).

### Metadata handling methods

#### `getFieldName()` and `getSortInfo()`

Field Types require two methods related to Field metadata:

- `getFieldName()` is used to generate a name out of a Field value, either to name a Content item or to generate a part for a URL alias.
- `getSortInfo()` is used by the persistence layer to obtain the value it can use to sort and filter on a Field of this Field Type.

A tweet's full URL isn't suitable as a name. Instead use subset of it: `<username>-<tweetId>` is suitable for both sorting and naming.

You can assume that this method will not be called if the Field is empty, and that the URL is a valid Twitter URL:

``` php
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

In `getFieldName()` you run a regular expression replace operation on the URL to extract the part you're interested in.

This name is a perfect match for `getSortInfo()` as it allows you to sort by the tweet's author and by the tweet's ID.

In the `eZ\Publish\SPI\FieldType\FieldType` interface there is also `getName()` method that is currently deprecated and replaced by `getFieldName()`.
You can throw an exception in its body to make sure it isn't called anywhere:

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

Both methods defined in the Field Type interface are core to the REST API. They are used to export values to serializable hashes:

- `toHash()` builds a hash with every property from `Tweet\Value`;
- `fromHash()` instantiates a `Tweet\Value` with the hash it receives.  

``` php
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

Field Types use their own value objects to expose their contents using their own domain language.
However, to store those objects, the Type needs to map this custom object
to a structure understood by the persistence layer: `PersistenceValue`.
`PersistenceValue` is a simple value object that has three properties:

- `data` - standard data, stored using the storage engine's native features
- `externalData` - external data, stored using a custom storage handler
- `sortKey` - sort value used for sorting

The role of those mapping methods is to convert a `Value` of the Field Type into a `PersistenceValue` and the other way around.

##### About external storage

Whatever is stored in `externalData` requires an external storage handler to be written. Read more about external storage in [Field Type API](../../api/field_type_api.md).

External storage is beyond the scope of this tutorial, but many examples can be found in existing Field Types.

You will follow a simple implementation here: the `Tweet\Value` object will be serialized as an array to the `code` property using `fromHash()` and `toHash()`:

``` php
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

As explained in the tutorial's introduction, you will enrich the tweet's URL with the embed version, fetched using the Twitter API. To do so, you will fill in the value's contents property from the `toPersistenceValue()` when it is called, before creating the `PersistenceValue` object.

First, you need a Twitter client in `Tweet\Type`. For convenience, one is provided in this tutorial's bundle.
Copy the following files to your bundle's directory:

- [`Twitter\TwitterClient.php`](https://github.com/ezsystems/TweetFieldTypeBundle/blob/master/Twitter/TwitterClient.php)
- [`Twitter\TwitterClientInterface.php`](https://github.com/ezsystems/TweetFieldTypeBundle/blob/master/Twitter/TwitterClientInterface.php)

The interface has one method: `getEmbed( $statusUrl )` that returns the embed code as a string when given a tweet's URL.

Next, add the `ezsystems.tweetbundle.twitter.client` service that uses the class above to `Resources/config/services.yaml`:

``` yaml
services:
    ezsystems.tweetbundle.twitter.client:
        class: EzSystems\TweetFieldTypeBundle\Twitter\TwitterClient
```

## Injecting the Twitter client into `Tweet\Type`

The Field Type doesn't have a constructor yet.
You will create one, with an instance of `Twitter\TwitterClientInterface` as the argument, and store it in a new protected property:

``` php
<?php

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

As described above, before creating the `PersistenceValue` object in `toPersistenceValue`,
you will fetch the tweet's embed contents using the client, and assign it to `Tweet\Value::$data`:

``` php
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

When the persistence layer stores content from your type, the value will be completed with what the Twitter API returns.

## Add required `use` statements

In the end the Type class should have the following `use` statements:

``` php
namespace EzSystems\TweetFieldTypeBundle\eZ\Publish\FieldType\Tweet;

use eZ\Publish\Core\FieldType\FieldType;
use eZ\Publish\Core\FieldType\ValidationError;
use eZ\Publish\SPI\Persistence\Content\FieldValue as PersistenceValue;
use eZ\Publish\Core\FieldType\Value as CoreValue;
use eZ\Publish\SPI\FieldType\Value as SPIValue;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentType;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;
use EzSystems\TweetFieldTypeBundle\Twitter\TwitterClientInterface;
```
