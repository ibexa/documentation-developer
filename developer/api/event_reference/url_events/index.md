# URL events

Events that are triggered when working with URLs, URL aliases and URL wildcards.

## URLs

| Event                  | Dispatched by           | Properties                                              |
| ---------------------- | ----------------------- | ------------------------------------------------------- |
| `BeforeUpdateUrlEvent` | `URLService::updateUrl` | `URL $url` `URLUpdateStruct $struct` `?URL $updatedUrl` |
| `UpdateUrlEvent`       | `URLService::updateUrl` | `URL $url` `URLUpdateStruct $struct` `URL $updatedUrl`  |

## URL aliases

The following events are dispatched when creating and managing [URL aliases](../../../content_management/url_management/url_management/index.md#url-aliases).

| Event                                           | Dispatched by                                         | Properties                                                                                                                          |
| ----------------------------------------------- | ----------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------- |
| `BeforeCreateGlobalUrlAliasEvent`               | `URLAliasService::createGlobalUrlAlias`               | `private $resource` `private $path` `private $languageCode` `private $forwarding` `private $alwaysAvailable` `?URLAlias $urlAlias`  |
| `CreateGlobalUrlAliasEvent`                     | `URLAliasService::createGlobalUrlAlias`               | `private $resource` `private $path` `private $languageCode` `private $forwarding` `private $alwaysAvailable` `URLAlias $urlAlias`   |
| `BeforeCreateUrlAliasEvent`                     | `URLAliasService::createUrlAlias`                     | `Location $location` `private $path` `private $languageCode` `private $forwarding` `private $alwaysAvailable` `?URLAlias $urlAlias` |
| `CreateUrlAliasEvent`                           | `URLAliasService::createUrlAlias`                     | `Location $location` `private $path` `private $languageCode` `private $forwarding` `private $alwaysAvailable` `URLAlias $urlAlias`  |
| `BeforeRefreshSystemUrlAliasesForLocationEvent` | `URLAliasService::refreshSystemUrlAliasesForLocation` | `Location $location`                                                                                                                |
| `RefreshSystemUrlAliasesForLocationEvent`       | `URLAliasService::refreshSystemUrlAliasesForLocation` | `Location $location`                                                                                                                |
| `BeforeRemoveAliasesEvent`                      | `URLAliasService::removeAliases`                      | `array $aliasList`                                                                                                                  |
| `RemoveAliasesEvent`                            | `URLAliasService::removeAliases`                      | `array $aliasList`                                                                                                                  |

## URL wildcards

The following events are dispatched when creating and managing [URL wildcards](../../../content_management/url_management/url_management/index.md#url-wildcards).

| Event                  | Dispatched by                   | Properties                                                                                    |
| ---------------------- | ------------------------------- | --------------------------------------------------------------------------------------------- |
| `BeforeCreateEvent`    | `URLWildcardService::create`    | `private $sourceUrl` `private $destinationUrl` `private $forward` `?URLWildcard $urlWildcard` |
| `CreateEvent`          | `URLWildcardService::create`    | `private $sourceUrl` `private $destinationUrl` `private $forward` `URLWildcard $urlWildcard`  |
| `BeforeUpdateEvent`    | `URLWildcardService::update`    | `URLWildcard $urlWildcard` `URLWildcardUpdateStruct $updateStruct`                            |
| `UpdateEvent`          | `URLWildcardService::update`    | `URLWildcard $urlWildcard` `URLWildcardUpdateStruct $updateStruct`                            |
| `BeforeTranslateEvent` | `URLWildcardService::translate` | `private $url` `?URLWildcardTranslationResult $result`                                        |
| `TranslateEvent`       | `URLWildcardService::translate` | `private $url` `URLWildcardTranslationResult $result`                                         |
| `BeforeRemoveEvent`    | `URLWildcardService::remove`    | `URLWildcard $urlWildcard`                                                                    |
| `RemoveEvent`          | `URLWildcardService::remove`    | `URLWildcard $urlWildcard`                                                                    |
