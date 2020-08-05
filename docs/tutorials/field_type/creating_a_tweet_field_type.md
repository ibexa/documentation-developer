# Creating a Tweet Field Type

!!! tip "Getting the code"

    The code created in this tutorial is available on GitHub: (https://github.com/ezsystems/TweetFieldTypeBundle).

# This tutorial is only processable in EZ Platform version < 3.x 

This tutorial covers the creation and development of a custom eZ Platform [Field Type](../../api/field_type_reference/).
Field Types are the smallest building blocks of content. eZ Platform comes with about 30 native types that cover most common needs (Text line, Rich text, Email, Author list, Content relation, Map location, Float, etc.)

Field Types are responsible for:

- Storing data, either using the native storage engine mechanisms or specific means
- Validating input data
- Making the data searchable (if applicable)
- Displaying Fields of this type

Custom Field Types are a very powerful type of extension, since they allow you to hook deep into the content model.

You can find the in-depth [documentation about Field Types](../../api/field_type_api/). It describes how each component of a Field Type interacts with the various layers of the system, and how to implement those.

## Intended audience

This tutorial is aimed at developers who are familiar with eZ Platform and are comfortable with operating in PHP and Symfony.

## Content of the tutorial

This tutorial will demonstrate how to create a Field Type on the example of a *Tweet* Field Type. It will:

- Accept as input the URL of a tweet (`https://twitter.com/{username}/status/{id}`)
- Fetch the tweet using the Twitter oEmbed API (https://developer.twitter.com/en/docs/tweets/post-and-engage/api-reference/get-statuses-oembed)
- Store the tweet’s embed contents and URL
- Display the tweet's embedded version when displaying the field from a template

## Preparation

To start the tutorial, you need to make a clean eZ Platform installation. Follow the guide for your system from [Install eZ Platform](../../getting_started/install_ez_platform/). Remember to install using the `dev` environment.

## Steps

In this tutorial you will go through the following steps:

- [1. Create the bundle](1_create_the_bundle.md)
- [2. Implement the Tweet\Value class](2_implement_the_tweet_value_class.md)
- [3. Implement the Tweet\Type class](3_implement_the_tweet_type_class.md)
- [4. Register the Field Type as a service](4_register_the_field_type_as_a_service.md)
- [5. Implement the Legacy Storage Engine Converter](5_implement_the_legacy_storage_engine_converter.md)
- [6. Introduce a template](6_introduce_a_template.md)
- [7. Allow adding and editing the Field in Back Office](7_allow_adding_and_editing_the_field_in_back_office.md)
- [8. Add a validation](8_add_a_validation.md)

![Final result of the tutorial](img/fieldtype_tutorial_final_result.png)

!!! tip

    For another example, see a [presentation about creating a new Field Type and extending eZ Platform UI](https://mikadamczyk.github.io/presentations/extending-ez-platform-ui/).
