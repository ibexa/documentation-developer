# Repository

The content Repository is where all your content is stored.

## Services: Public API

The Public API exposes Symfony services for all of its Repository services.

| Service ID                           | Type                                           |
|--------------------------------------|------------------------------------------------|
| `ezpublish.api.service.bookmark`     | `eZ\Publish\API\Repository\BookmarkService`    |
| `ezpublish.api.service.content`      | `eZ\Publish\API\Repository\ContentService`     |
| `ezpublish.api.service.content_type` | `eZ\Publish\API\Repository\ContentTypeService` |
| `ezpublish.api.service.field_type`   | `eZ\Publish\API\Repository\FieldTypeService`   |
| `ezpublish.api.service.language`     | `eZ\Publish\API\Repository\LanguageService`    |
| `ezpublish.api.service.location`     | `eZ\Publish\API\Repository\LocationService`    |
| `ezpublish.api.service.notification` | `eZ\Publish\API\Repository\NotificationService`|
| `ezpublish.api.service.object_state` | `eZ\Publish\API\Repository\ObjectStateService` |
| `ezpublish.api.service.role`         | `eZ\Publish\API\Repository\RoleService`        |
| `ezpublish.api.service.search`       | `eZ\Publish\API\Repository\SearchService`      |
| `ezpublish.api.service.section`      | `eZ\Publish\API\Repository\SectionService`     |
| `ezpublish.api.service.trash`        | `eZ\Publish\API\Repository\TrashService`       |
| `ezpublish.api.service.url`          | `eZ\Publish\API\Repository\URLService`         |
| `ezpublish.api.service.url_alias`    | `eZ\Publish\API\Repository\URLAliasService`    |
| `ezpublish.api.service.url_wildcard` | `eZ\Publish\API\Repository\URLWildcardService` |
| `ezpublish.api.service.user`         | `eZ\Publish\API\Repository\UserService`        |

## SPI and API repositories

The `ezpublish-api` and `ezpublish-spi` repositories are read-only splits of `ezsystems/ezpublish-kernel`
They are available to make dependencies easier and more lightweight.

### API

This package is a split of the eZ Platform Public API. It includes the **services interfaces** and **domain objects** from the `eZ\Publish\API` namespace.

It offers a lightweight way to make your project depend on eZ Platform API and Domain objects, without depending on the whole `ezpublish-kernel`.

The repository is read-only, automatically updated from https://github.com/ezsystems/ezpublish-kernel.

Requiring `ezpublish-api` in your project (on the example of version 6.7):

```
"require": {
    "ezsystems/ezpublish-api": "~6.7"
}
```

### SPI

This package is a split of the eZ Platform SPI (persistence interfaces).

It can be used as a dependency, instead of the whole `ezpublish-kernel`, by packages implementing custom eZ Platform storage engines, or by any package that requires classes from the `eZ\Publish\SPI` namespace.

The repository is read-only, automatically updated from https://github.com/ezsystems/ezpublish-kernel.

Requiring `ezpublish-spi` in your project (on the example of version 6.7):

```
"require": {
    "ezsystems/ezpublish-spi": "~6.7"
}
```
