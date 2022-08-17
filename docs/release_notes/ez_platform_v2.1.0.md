# eZ Platform v2.1.0

**Version number**: v2.1.0

**Release date**: March 27, 2018

**Release type**: Fast Track

## Notable changes

### Custom Tags

You can now add custom tags to RichText Fields.

Custom tags enable you to extend the menu of available elements when editing a RichText Field with the Online Editor.

See [Custom tags](https://doc.ibexa.co/en/2.5/guide/extending/extending_online_editor/#custom-tags) for more information.

### Object states

Object states enable you to create sets of custom states and then assign them to Content.

!["Lock" Object state](2.1_object_state_lock.png)

Object states can be used in conjunction with [permissions](https://doc.ibexa.co/en/2.5/guide/limitation_reference/#state-limitation).

### Content on the fly

Content on the fly enables you to create new Content anywhere in the application from the Universal Discovery widget.

![Content on the fly](cotf.png)

### URL alias management

You can now add custom URL aliases to Content items from the URL tab. Aliases can be set per language of the Content item.

![Custom URL aliases](url_aliases.png)

### REST: GET Location that matches URL alias

You can now translate URL aliases into Locations  with `urlAlias` parameter provided. When user provides parameter in URL, Location with given URL Alias is returned via `GET /content/locations`.

### Password management

You can now change your password, or request a new one if you forgot it.

![Password recovery](forgot_password.png)

!!! caution

    The reaction time when requesting a reset of the password will vary depending on whether an account with the provided email exists in the database or not.
    This could be misused to confirm existing email addresses.
    To avoid this, set Swift Mailer to `spool` mode.

### Simplified filtered search

During search you can now filter the results by Content type, Section, Modified and Created dates.

![Simplified filtered search](filtered_search.png)

### REST: search with FieldCriterion

You can now perform REST search via `POST /views` using custom `FieldCriterion`. This allows you to build custom content logic queries with nested logical operators OR/AND/NOT.

### Other UI improvements

- When accessing the Back Office from a link to a specific Content item, after logging in you will now be redirected to the proper content view.
- In edit mode you can now preview content as it will look in any SiteAccess it is available in.
- When you start editing a Content item that already has an open draft, you will see a draft conflict screen:

![Draft conflict window](draft_conflict.png)

## Full list of new features, improvements and bug fixes since v2.0.0

| eZ Platform   | eZ Enterprise  |
|--------------|------------|
| [List of changes for final of eZ Platform v2.1.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.1.0) | [List of changes for final for eZ Platform Enterprise Edition v2.1.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.1.0) |
| [List of changes for rc1 of eZ Platform v2.1.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.1.0-rc1) | [List of changes for rc1 for eZ Platform Enterprise Edition v2.1.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.1.0-rc1) |
| [List of changes for beta1 of eZ Platform v2.1.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.1.0-beta1) | [List of changes for beta1 of eZ Platform Enterprise Edition v2.1.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.1.0-beta1) |

## Installation

[Installation guide](https://doc.ibexa.co/en/2.5/getting_started/install_ez_platform)

[Technical requirements](https://doc.ibexa.co/en/2.5/getting_started/requirements)
