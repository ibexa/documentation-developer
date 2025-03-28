---
description: You can enable users to create new content in the repository by using forms available in the front end of the site.
---

# User-generated content

[[= product_name =]] comes with content edition features via the Symfony stack.
They're meant to allow the implementation of user-generated content from the front end, without entering the back office.

## Creating a new draft

The `content/create/draft` route enables you to create a new draft for the selected content item.
Pass the ID of the content item as an argument.

For example, `content/create/draft/59` creates a new draft of the content item with ID 59.

## Creating a content item without using a draft

The `/content/edit/nodraft` route shows a content item creation form for a given content type:

| Argument                | Type      | Description                                                                |
|-------------------------|-----------|----------------------------------------------------------------------------|
| `contentTypeIdentifier` | `string`  | The identifier of the content type to create. Example: `folder`, `article` |
| `languageCode`          | `string`  | Language code the content item must be created in. Example: `eng-GB`       |
| `parentLocationId`      | `integer` | ID of the location the content item must be created in. Example: `2`       |

This means that `/content/create/nodraft/folder/eng-GB/2` enables you to create a Folder in English as a child of location with ID 2.

A limited subset of field types is supported:

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

## Editing a content item

To edit an existing draft, use the `/content/edit/draft/` route, with the following arguments:

| Argument                | Type      | Description                                                              |
|-------------------------|-----------|--------------------------------------------------------------------------|
| `contentId`             | `integer` | ContentId of the item to edit.                                           |
| `versionNo`             | `integer` | Number of the version to edit. The version must be an unpublished draft. |
| `languageCode`          | `string`  | Language code of the version. Example: `eng-GB`                          |

For example, `/content/edit/draft/1/5/eng-GB` enables you to edit draft 5 of content item 1 in English.

## Content editing templates

You can use custom templates for the content editing forms.

Define the templates under the `ibexa.system.<scope>.content_edit.templates` [configuration key](configuration.md#configuration-files):

``` yaml
ibexa:
    system:
        default:
            content_edit:
                templates:
                    edit: content/edit/content_edit.html.twig
                    create_draft: content/edit/content_create_draft.html.twig
```
