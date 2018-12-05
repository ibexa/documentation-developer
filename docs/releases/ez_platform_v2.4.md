# eZ Platform v2.4

**Version number**: v2.4

**Release date**:

**Release type**:

## Notable changes

### Workflow

### Page Builder

### RichText

#### RichText Field Type

RichText Field Type has been extracted to a separate bundle, [ezplatform-richtext](https://github.com/ezsystems/ezplatform-richtext).
See [RichText Field Type Reference](../api/field_type_reference.md#richtext-field-type).

#### Rich Text block

#### Improve styling in Online Editor

Online Editor has been improved with new styling.

![Online Editor menu](img/2.4_oe_menu.png)

#### Images in Rich Text

#### Formatted text in Rich text

You can now use formatted text in Rich Text Fields (provided by means of a `literal` tag).

![Formatted Text in Online Editor](img/2.4_formatted_text.png)

### Translations

#### Language-region translation

#### Content Type translation

### Multi-file management

New multi-file content management functionalities enable you to move and delete multiple files at the same time.

See [Multi-file content management](https://doc.ezplatform.com/projects/userguide/en/latest/multi_file_content_management/) for more information.

### Form block

### Draft list

The list of all drafts can now be found in the **Administrator User** menu under **Drafts**.

![Administrator User list of all Drafts](img/2.4_drafts_admin_user.png "Administrator User list of all Drafts")

See [Reviewing a draft](https://doc.ezplatform.com/projects/userguide/en/latest/publishing/#reviewing-a-draft) for more information.

### Create form on the fly

You can now create Forms on the fly from the Universal Discovery Widget.

![Creating a Form on the Fly](img/2.4_form_on_the_fly.png)

### Subtree search filter

### Policy labels update

The outdated Policy labels are now updated:

|Old|New|
|---|---|
|class|Content Type|
|ParentClass|Content Type of Parent|
|node|Location|
|parentdepth|Parent Depth|
|parentgroup|Content Type Group of Parent|
|parentowner|Owner of Parent|
|subtree|Subtree of Location|

![Updated Policy labels](img/2.4_policy_verbs.png)

### API improvements

#### Simplified use of Content Type objects

This release introduces a few simplifications to API use for Content Types:

- Exposes `content->getContentType()` for easier use, including from Twig as `content.contentType`
- Adds possibility to load several Content Types in bulk using `ContentTypeService->loadContentTypeList()`

## Full list of new features, improvements and bug fixes since v2.3

| eZ Platform   | eZ Enterprise  |
|--------------|------------|
| [List of changes for final of eZ Platform v2.4.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.4.0) | [List of changes for final for eZ Platform Enterprise Edition v2.4.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.4.0) |
| [List of changes for rc2 of eZ Platform v2.4.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.4.0-rc2) | [List of changes for rc2 for eZ Platform Enterprise Edition v2.4.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.4.0-rc2) |
| [List of changes for rc1 of eZ Platform v2.4.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.4.0-rc1) | [List of changes for rc1 for eZ Platform Enterprise Edition v2.4.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.4.0-rc1) |
| [List of changes for beta1 of eZ Platform v2.4.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.4.0-beta1) | [List of changes for beta1 of eZ Platform Enterprise Edition v2.4.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.4.0-beta1) |
