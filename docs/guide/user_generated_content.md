# User-Generated Content

## Creating content

[[= product_name =]] comes with content edition features via the Symfony stack. They are meant to allow the implementation of user-generated content from the front end, without entering the PlatformUI back end.

### Creating a Content item without using a draft

The `/content/create/nodraft` route shows a Content item creation form for a given Content Type:

### Creating a new draft

The `content/create/draft` route allows you to create a new draft for the selected Content item.
Provide it with the content ID as an argument.

For example, `content/create/draft/59` creates a new draft of the Content item with ID 59.

### Creating a content item without using a draft

The `/content/edit/nodraft` route shows a Content item creation form for a given Content Type:

| Argument                | Type      | Description                                                                |
|-------------------------|-----------|----------------------------------------------------------------------------|
| `contentTypeIdentifier` | `string`  | The identifier of the Content Type to create. Example: `folder`, `article` |
| `languageCode`          | `string`  | Language code the Content item must be created in. Example: `eng-GB`       |
| `parentLocationId`      | `integer` | ID of the Location the Content item must be created in. Example: `2`       |

This means that `/content/create/nodraft/folder/eng-GB/2` will enable you to create a Folder in English as a child of Location with ID 2.

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
| `versionNo`             | `integer` | Number of the version to edit. The version must be an unpublished draft. |
| `languageCode`          | `string`  | Language code of the version. Example: `eng-GB`                          |

For example, `/content/edit/draft/1/5/eng-GB` enables you to edit draft 5 of Content item 1 in English.

### Content editing templates

You can use custom templates for the content editing forms.

Define the templates in the following configuration:

``` yaml
ezplatform:
    system:
        default:
            content_edit:
                templates:
                    edit: content/edit/content_edit.html.twig
                    create_draft: content/edit/content_create_draft.html.twig
```
