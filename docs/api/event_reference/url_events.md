---
description: Events that are triggered when working with URLs, URL aliases and URL wildcards.
---

# URL events

## URLs

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeUpdateUrlEvent`|`URLService::updateUrl`|`URL $url`</br>`URLUpdateStruct $struct`</br>`URL|null $updatedUrl`|
|`UpdateUrlEvent`|`URLService::updateUrl`|`URL $url`</br>`URLUpdateStruct $struct`</br>`URL $updatedUrl`|

## URL aliases

The following events are dispatched when creating and managing [URL aliases](url_management.md#url-aliases).

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateGlobalUrlAliasEvent`|`URLAliasService::createGlobalUrlAlias`|`private $resource`</br>`private $path`</br>`private $languageCode`</br>`private $forwarding`</br>`private $alwaysAvailable`</br>`URLAlias|null $urlAlias`|
|`CreateGlobalUrlAliasEvent`|`URLAliasService::createGlobalUrlAlias`|`private $resource`</br>`private $path`</br>`private $languageCode`</br>`private $forwarding`</br>`private $alwaysAvailable`</br>`URLAlias $urlAlias`|
|`BeforeCreateUrlAliasEvent`|`URLAliasService::createUrlAlias`|`Location $location`</br>`private $path`</br>`private $languageCode`</br>`private $forwarding`</br>`private $alwaysAvailable`</br>`URLAlias|null $urlAlias`|
|`CreateUrlAliasEvent`|`URLAliasService::createUrlAlias`|`Location $location`</br>`private $path`</br>`private $languageCode`</br>`private $forwarding`</br>`private $alwaysAvailable`</br>`URLAlias $urlAlias`|
|`BeforeRefreshSystemUrlAliasesForLocationEvent`|`URLAliasService::refreshSystemUrlAliasesForLocation`|`Location $location`|
|`RefreshSystemUrlAliasesForLocationEvent`|`URLAliasService::refreshSystemUrlAliasesForLocation`|`Location $location`|
|`BeforeRemoveAliasesEvent`|`URLAliasService::removeAliases`|`array $aliasList`|
|`RemoveAliasesEvent`|`URLAliasService::removeAliases`|`array $aliasList`|

## URL wildcards

The following events are dispatched when creating and managing [URL wildcards](url_management.md#url-wildcards).

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateEvent`|`URLWildcardService::create`|`private $sourceUrl`</br>`private $destinationUrl`</br>`private $forward`</br>`URLWildcard|null $urlWildcard`|
|`CreateEvent`|`URLWildcardService::create`|`private $sourceUrl`</br>`private $destinationUrl`</br>`private $forward`</br>`URLWildcard $urlWildcard`|
|`BeforeUpdateEvent`|`URLWildcardService::update`|`URLWildcard $urlWildcard`</br>`URLWildcardUpdateStruct $updateStruct`|
|`UpdateEvent`|`URLWildcardService::update`|`URLWildcard $urlWildcard`</br>`URLWildcardUpdateStruct $updateStruct`|
|`BeforeTranslateEvent`|`URLWildcardService::translate`|`private $url`</br>`URLWildcardTranslationResult|null $result`|
|`TranslateEvent`|`URLWildcardService::translate`|`private $url`</br>`URLWildcardTranslationResult $result`|
|`BeforeRemoveEvent`|`URLWildcardService::remove`|`URLWildcard $urlWildcard`|
|`RemoveEvent`|`URLWildcardService::remove`|`URLWildcard $urlWildcard`|
