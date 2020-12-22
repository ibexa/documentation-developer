# Repository

The content Repository is where all your content is stored.

## Services: Public API

The Public API exposes Symfony services for all of its Repository services.

| Service ID                             | Type                                             |
|----------------------------------------|--------------------------------------------------|
| `ezpublish.api.service.bookmark`       | `eZ\Publish\API\Repository\BookmarkService`      |
| `ezpublish.api.service.content`        | `eZ\Publish\API\Repository\ContentService`       |
| `ezpublish.api.service.content_type`   | `eZ\Publish\API\Repository\ContentTypeService`   |
| `ezpublish.api.service.field_type`     | `eZ\Publish\API\Repository\FieldTypeService`     |
| `ezpublish.api.service.language`       | `eZ\Publish\API\Repository\LanguageService`      |
| `ezpublish.api.service.location`       | `eZ\Publish\API\Repository\LocationService`      |
| `ezpublish.api.service.notification`   | `eZ\Publish\API\Repository\NotificationService`  |
| `ezpublish.api.service.object_state`   | `eZ\Publish\API\Repository\ObjectStateService`   |
| `ezpublish.api.service.role`           | `eZ\Publish\API\Repository\RoleService`          |
| `ezpublish.api.service.search`         | `eZ\Publish\API\Repository\SearchService`        |
| `ezpublish.api.service.section`        | `eZ\Publish\API\Repository\SectionService`       |
| `ezpublish.api.service.trash`          | `eZ\Publish\API\Repository\TrashService`         |
| `ezpublish.api.service.url`            | `eZ\Publish\API\Repository\URLService`           |
| `ezpublish.api.service.url_alias`      | `eZ\Publish\API\Repository\URLAliasService`      |
| `ezpublish.api.service.url_wildcard`   | `eZ\Publish\API\Repository\URLWildcardService`   |
| `ezpublish.api.service.user`           | `eZ\Publish\API\Repository\UserService`          |
| `ezpublish.api.service.user_preference`| `eZ\Publish\API\Repository\UserPreferenceService`|

## API

Every Public API Service interface and value object defined in `eZ\Publish\API` namespace strictly follows [Semantic Versioning](https://semver.org/) backward compatibility (BC) promise for API consumers.
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
 - Search Engine layer for custom Search Engine implementations (e.g. Legacy search engine, Solr search engine and in the future Elasticsearch)

!!! caution

    Due to technical limitations, backward compatibility promise to any third party implementations of these interfaces applies only to minor versions.
    It means that interfaces, especially related to `SPI\Persistence` handlers, can change between minor releases.
