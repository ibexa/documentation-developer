# Indexing email data [[% include 'snippets/commerce_badge.md' %]]

Indexing email data requires creating the `SearchField` class for the User Content item.
The User Field Type doesn't have an implementation of `SearchField`, so this `SearchField` class must implement the `Indexable` interface.

Service definition:

``` xml
<service id="ezpublish.fieldType.indexable.user" class="%ezpublish.fieldType.indexable.user.class%">
    <tag name="ezpublish.fieldType.indexable" alias="ezuser" />
</service>
```

Tag the service with `ezpublish.fieldType.indexable`. This enables the indexer to execute this service in the indexer process.

The alias indicates which element is to be extended. In the example above it is `ezuser`.

### Indexing email

User email is taken from an SPI Field which has an `externalData` array with several fields.
The following example gets the email Field and indexes it in two Solr fields:

``` php
/**
 * Get index data for field for backend search
 *
 * @param Field $field
 * @param FieldDefinition $fieldDefinition
 *
 * @return Search\Field[]
 */
public function getIndexData(Field $field, FieldDefinition $fieldDefinition)
{
    return array(
        new Search\Field(
            'email_value',
            $field->value->externalData['email'],
            new Search\FieldType\StringField()
        ),
        new Search\Field(
            'email_value',
            $field->value->externalData['email'],
            new Search\FieldType\FullTextField()
        ),
    );
}
```

### Indexing additional user data

The `externalData` array has the following data:

- `hasStoredLogin`
- `contentId`
- `login`
- `email`
- `passwordHash`
- `passwordHashType`
- `enabled`
- `maxLogin`

To index additional data related to the user, you can add new `Search\Field` to the return array of method `getIndexData`.

``` php
return array(
    new Search\Field(
        'email_value',
        $field->value->externalData['email'],
        new Search\FieldType\StringField()
    ),
    new Search\Field(
        'email_value',
        $field->value->externalData['email'],
        new Search\FieldType\FullTextField()
    ),

    // New data to be indexed:
    new Search\Field(
        'login_value',
        $field->value->externalData['login'],
        new Search\FieldType\StringField()
    ),
);
```

If you add a new search field, you also need to add the field definition to the `getIndexDefinition()` method:

``` php
/**
 * Get index field types for backend search
 *
 * @return \eZ\Publish\SPI\Search\FieldType[]
 */
public function getIndexDefinition()
{
    return array(
        'email_value' => new Search\FieldType\StringField(),
 
        // New field definition for login name:
        'login_value' => new Search\FieldType\StringField(),
    );
}
```

This example uses Solr string field and full text field.

String fields and text fields should be visible as a search result in Solr web administration.
Full text fields are only visible in schema browser.

In this example the Solr text field name for email is `user_user_account_email_value_s`.
