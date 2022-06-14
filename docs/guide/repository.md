---
description: Ibexa DXP's content Repository stores all content and its related information and exposes a set of services to interact with via API.
---

# Repository

The content Repository is where all your content is stored.

## Services: Public API

The Public API exposes Symfony services for all of its Repository services.

| Service ID                             | Type                                             |
|----------------------------------------|--------------------------------------------------|
| `ibexa.api.service.bookmark`       | `Ibexa\Contracts\Core\Repository\BookmarkService`      |
| `ibexa.api.service.content`        | `Ibexa\Contracts\Core\Repository\ContentService`       |
| `ibexa.api.service.content_type`   | `Ibexa\Contracts\Core\Repository\ContentTypeService`   |
| `ibexa.api.service.field_type`     | `Ibexa\Contracts\Core\Repository\FieldTypeService`     |
| `ibexa.api.service.language`       | `Ibexa\Contracts\Core\Repository\LanguageService`      |
| `ibexa.api.service.location`       | `Ibexa\Contracts\Core\Repository\LocationService`      |
| `ibexa.api.service.notification`   | `Ibexa\Contracts\Core\Repository\NotificationService`  |
| `ibexa.api.service.object_state`   | `Ibexa\Contracts\Core\Repository\ObjectStateService`   |
| `ibexa.api.service.role`           | `Ibexa\Contracts\Core\Repository\RoleService`          |
| `ibexa.api.service.search`         | `Ibexa\Contracts\Core\Repository\SearchService`        |
| `ibexa.api.service.section`        | `Ibexa\Contracts\Core\Repository\SectionService`       |
| `ibexa.api.service.trash`          | `Ibexa\Contracts\Core\Repository\TrashService`         |
| `ibexa.api.service.url`            | `Ibexa\Contracts\Core\Repository\URLService`           |
| `ibexa.api.service.url_alias`      | `Ibexa\Contracts\Core\Repository\URLAliasService`      |
| `ibexa.api.service.url_wildcard`   | `Ibexa\Contracts\Core\Repository\URLWildcardService`   |
| `ibexa.api.service.user`           | `Ibexa\Contracts\Core\Repository\UserService`          |
| `ibexa.api.service.user_preference`| `Ibexa\Contracts\Core\Repository\UserPreferenceService`|

## API

Every Public API Service interface and value object defined in `Ibexa\Contracts\Core\Repository` namespace strictly follows [Semantic Versioning](https://semver.org/) backward compatibility (BC) promise for API consumers.
It means that every usage of API (API call) is guaranteed to work between minor releases.

What can change between minor releases is the API method signature. Because of that, implementation of API interfaces by third party packages (except for the ones implemented with built-in bundles) is not directly supported.
API method signatures should not change between bug-fix releases (e.g. from 2.5.1 to 2.5.2).

You should always check full list of changes for each release in corresponding release notes.

## SPI

[[= product_name =]] SPI is a Service Provider Interface which defines contracts for implementing various parts of the system, including:

 - persistence layer (`SPI\Persistence`)
 - custom Field Types
 - custom Limitations
 - limited portions of IO
 - image variation handling
 - Search Engine layer for custom Search Engine implementations (e.g. Legacy search engine, Solr search engine and Elasticsearch)

!!! caution

    Due to technical limitations, backward compatibility promise to any third party implementations of these interfaces applies only to minor versions.
    It means that interfaces, especially related to `SPI\Persistence` handlers, can change between minor releases.
