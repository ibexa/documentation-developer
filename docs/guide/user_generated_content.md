# User-Generated Content

## Creating content

eZ Platform comes with content edition features via the Symfony stack. They are meant to allow the implementation of user-generated content from the front end, without entering the PlatformUI back end.

### Creating a Content item without using a draft

The `/content/create/nodraft` route shows a Content item creation form for a given Content Type:

### Creating a new draft

The `content/create/draft` route allows you to create a new draft for the selected content item.
Provide it with the Content ID as an argument.

For example, `content/create/draft/59` creates a new draft of the Content item with ID 59.

### Creating a content item without using a draft

The `/content/edit/nodraft` route shows a Content item creation form for a given Content Type:

| Argument                | Type      | Description                                                                |
|-------------------------|-----------|----------------------------------------------------------------------------|
| `contentTypeIdentifier` | `string`  | The identifier of the Content Type to create. Example: `folder`, `article` |
| `languageCode`          | `string`  | Language code the Content item must be created in. Example: `eng-GB`       |
| `parentLocationId`      | `integer` | ID of the Location the Content item must be created in. Example: `2`       |

This means that `/content/create/nodraft/folder/eng-GB/2` will enable you to create a Folder in English as a child of LocationId 2.

For now a limited subset of Field Types is supported:

- `TextLine`
- `TextBlock`
- `Selection`
- `Checkbox`
- `User`
- `Date`
- `DateAndTime`
- `Time`
- `Integer`
- `Float`
- `URL`

### Editing a Content item

To edit an existing draft, use the `/content/edit/draft/`

| Argument                | Type      | Description                                                              |
|-------------------------|-----------|--------------------------------------------------------------------------|
| `contentId`             | `integer` | ContentId of the item to edit.                                           |
| `versionNo`             | `integer` | Number of the Version to edit. The version must be an unpublished draft. |
| `languageCode`          | `string`  | Language code of the version. Example: `eng-GB`                          |

For example, `/content/edit/draft/1/5/eng-GB` enables you to edit draft 5 of Content item 1 in English.

### Content editing templates

You can use custom templates for the content editing forms.

Define the templates in the following configuration:

``` yaml
ezpublish:
    system:
        default:
            content_edit:
                templates:
                    edit: 'content_edit/content_edit.html.twig'
                    create_draft: 'content_edit/content_create_draft.html.twig'
```

## Registering new users

You can allow your users to create accounts by employing the `/register` route. This route leads to a registration form that, when filled in, creates a new User Content item in the repository.

### User Groups

By default, new Users generated in this way are placed in the Guest accounts group. You can select a different default group in the following section of configuration:

``` yaml
ezpublish:
    system:
        default:
            user_registration:
                group_id: <userGroupContentId>
```

### Registration form templates

You can use custom templates for the registration form and registration confirmation page.

The templates are defined with the following configuration:

``` yaml
ezpublish:
    system:
        default:
            user_registration:
                templates:
                    form: 'user/registration_form.html.twig'
                    confirmation: 'user/registration_confirmation.html.twig'
```

With this configuration you place the templates in `app/Resources/views/user/registration_form.html.twig` and `app/Resources/views/user/registration_confirmation.html.twig`.

Here are default templates that you can reuse and/or modify:

**Registration form:**

``` html
{% extends noLayout is defined and noLayout == true ? viewbaseLayout : pagelayout %}
{% block content %}
     {% import "EzSystemsRepositoryFormsBundle:Content:content_form.html.twig" as contentForms %}

     <section class="ez-content-edit">
         {{ contentForms.display_form(form) }}
     </section>
{% endblock %}
```

**Registration confirmation:**

``` html
{% extends noLayout is defined and noLayout == true ? viewbaseLayout : pagelayout %}
{% block content %}
    <h1>Your account has been created</h1>
    <p class="user-register-confirmation-message">
        Thank you for registering an account. You can now <a href="{{ path('login') }}">login</a>.
    </p>
{% endblock %}
```
