---
description: View matchers are used in template configuration to decide when to use which template and controller.
---

# View matcher reference

You can use the following matchers to [match content views](template_configuration.md#view-rules-and-matching):

| Identifier | Matches |
|------|------|
| [`Id\Content`](#idcontent) | ID number of the Content item. |
| [`Id\ContentType`](#idcontenttype) | ID number of the Content Type that the Content item belongs to. |
| [`Identifier\ContentType`](#identifiercontenttype) | Identifier of the Content Type that the Content item belongs to. |
| [`Id\ContentTypeGroup`](#idcontenttypegroup) | ID number of the group containing the Content Type that the Content item belongs to. |
| [`Id\Location`](#idlocation) | ID number of a Location. |
| [`Id\LocationRemote`](#idlocationremote) | Remote ID number of a Location. |
| [`Id\ParentContentType`](#idparentcontenttype) | ID number of the parent Content Type. |
| [`Identifier\ParentContentType`](#identifierparentcontenttype) | Identifier of the parent Content Type. |
| [`Id\ParentLocation`](#idparentlocation) | ID number of the parent Location. |
| [`Id\Remote`](#idremote) | Remote ID of a Content item. |
| [`Id\Section`](#idsection) | ID number of the Section that the Content item belongs to. |
| [`Identifier\Section`](#identifiersection) | Identifier of the Section that the Content item belongs to. |
| [`Depth`](#depth) | Depth of the Location. The depth of a top level Location is 1. |
| [`UrlAlias`](#urlalias) | Virtual URL of the Location. |

!!! tip

    You can also create [custom view matchers](custom_view_matcher.md).

## Id\Content

Matches the ID number of a Content item.

``` yaml
match:
    Id\Content: 145
```

## Id\ContentType

Matches the ID number of a Content Type that the Content item belongs to.

``` yaml
match:
    Id\ContentType: 2
```

## Identifier\ContentType

Matches the identifier of the Content Type that the Content item belongs to.

``` yaml
match:
    Identifier\ContentType: [blog_post]
```

## Id\ContentTypeGroup

Matches the ID number of the Content Type Group that the Content item belongs to.

``` yaml
match:
    Id\ContentTypeGroup: 1
```

## Id\Location

Matches the ID number of a Location. In the case of a Content item, matched against the main Location.

``` yaml
match:
    Id\Location: 144
```

## Id\LocationRemote

Matches the Remote ID number of a Location. In the case of a Content item, matched against the main Location.

``` yaml
match:
    Id\LocationRemote: 5b1e33529082b68ad3a41b9089136a0a
```

## Id\ParentContentType

Matches the ID number of the parent Content Type. In the case of a Content item, matched against the main Location.

``` yaml
match:
    Id\ParentContentType: 42
```

## Identifier\ParentContentType

Matches the identifier of the parent Content Type. In the case of a Content item, matched against the main Location.

``` yaml
match:
    Identifier\ParentContentType: blog
```

## Id\ParentLocation

Matches the ID number of the parent Location. In the case of a Content item, matched against the main Location.

``` yaml
match:
    Id\ParentLocation: 2
```

## Id\Remote

Matches the remote ID number of a Content item.

``` yaml
match:
    Id\Remote: 145
```

## Id\Section

Matches the ID number of the Section that the Content item belongs to.

``` yaml
match:
    Id\Section: 1
```

## Identifier\Section

Matches the identifier of the Section that the Content item belongs to.

``` yaml
match:
    Identifier\Section: standard
```

## Depth

Matches the depth of the Location. The depth of a top level Location is 1.

``` yaml
match:
    Depth: 2
```

## UrlAlias

Matches the virtual URL of the Location.
Matches when the URL alias of the Location starts with the value passed.

``` yaml
match:
    UrlAlias: 'terms-and-conditions'
```
