# EzHelperService

`Silversolutions\Bundle\ToolsBundle\Services\EzHelperService` provides helper methods for e.g. User Components or Translation Components.

Service ID: `silver_tools.ez_helper`

## Methods

### General

|Method|Parameters|Returns|Description|
|--- |--- |--- |--- |
|`clearVersions`|`ContentInfo $contentInfo`|`void`|Clears the (archived) versions of the given `$contentInfo` up to the required count of versions (set in configuration)|

### User Components

|Method|Parameters|Returns|Description|
|--- |--- |--- |--- |
|`getCurrentUser`|-|`\eZ\Publish\API\Repository\Values\User\User`|Returns the current user from the default context|
|`updateUser`|`User $ezUser`</br>`array $fields = array()`|`\eZ\Publish\API\Repository\Values\Content\Content`|Updates User Content item|
|`updateUserCustomAttributes`|`User $ezUser`</br>`array $fields = array()`|`\eZ\Publish\API\Repository\Values\Content\Content`|Updates custom User Content item information (such as `customer_number`, `customer_profile_data`, etc.)|
|`getUserByUserId`|`$userId`|`\eZ\Publish\API\Repository\Values\User\User`|Returns a User Content item by user ID|
|`createUser`|`array $userData = array()`</br>`$defaultLanguage = 'eng-US'`|`\eZ\Publish\API\Repository\Values\User\User`|Creates a User Content item|
|`loginEzUser`|`\eZ\Publish\API\Repository\Values\User\User $user`</br>`\Symfony\Component\HttpFoundation\Session\Session $session`</br>`\Symfony\Component\HttpFoundation\Response $response`|-|Login as a User|
|`isEzUserLoggedIn`|`Request $request`|boolean|Returns true if the user is logged in|
|`getAnonymousUser`|-|`\eZ\Publish\API\Repository\Values\User\User`|Returns the anonymous user for the current context|
|`isEzUserAnonymous`|`\eZ\Publish\API\Repository\Values\User\User $user`|boolean|Returns true if the given user is anonymous|
|`findUser`|`$value`</br>`$searchAttribute = 'login'`</br>`$locationId = null`|`\eZ\Publish\API\Repository\Values\User\User or null`|Returns a User Content item by an attribute. Default attribute is `login`, but other, such as `email` are possible|

### SiteAccess translation components

|Method|Parameters|Returns|Description|
|--- |--- |--- |--- |
|`getCurrentLanguageCode()`|-|null\|string</br>e.g. ger-DE|Returns the current SiteAccess language if set in the configuration, otherwise null|
|`getTranslatedNameForEzContent()`|`\eZ\Publish\API\Repository\Values\Content\Content $ezContent`|string|Returns the translated name of the Content item|
|`getTranslatedFieldForEzContent()`|`\eZ\Publish\API\Repository\Values\Content\Content $ezContent`</br>`string $fieldIdentifier`|`\eZ\Publish\API\Repository\Values\Content\Field`\|null|Returns the translated Field of the Content item|
|`getUrlForSiteAccess()`|`string $urlPath`|string</br>e.g. `home` -> `/de/home`|Changes the given URL to the URL for the current SiteAccess|
|`getUserConf()`|`$key`|string|Returns the parameter value from the configuration for given `$key` and namespace `self::ST_EZ_HELPER_CREATE_USER`|
|`getEzContentByLocationId()`|`$ezLocationId`|`Content`|Returns content by Location ID|
|`getEzLocationByLocationId()`|`$ezLocationId`|`Content`|Returns Location by Location ID|
|`getEzContentByLocation()`|`Location $ezLocation`|`Content`|Returns content by Location|
|`getEzContentByContentId()`|`$ezContentId`|`Content`|Returns content by content ID|
|`getEzTypeIdentifierByEzContent()`|`Content $ezContent`|string|Returns the Content Type identifier for the given Content item|
|`getEzContentFieldValue()`|`Content $ezContent`</br>`$fieldIdentifier`</br>`$languageCode`</br>`$fieldType`|null\|mixed|Returns a Field value for the given Content item by identifier|
|`getUrlAliasByUrl()`|`$url`</br>`$languageCode`|`\eZ\Publish\API\Repository\Values\Content\URLAlias`</br>`@throws \eZ\Publish\API\Repository\Exceptions\NotFoundException`|Looks up the URL alias for the given URL.|
|`getUrlAliasByLocation()`|`Location $ezLocation`</br>`$languageCode`|null\|`\eZ\Publish\API\Repository\Values\Content\URLAlias`|Returns the URL alias for the given Location|
