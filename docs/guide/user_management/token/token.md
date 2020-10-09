# Token

The eCommerce uses the token system in the registration process to create a  double opt-in possibility.

The token service can generate a unique token which is valid for a given time.
When a user tries to use the token, a universal controller triggers the service and method assigned to this token. 

After user registration a token is created and stored in the database. The token is valid for a specific time.
After the user clicks the generated URL that they receive via email, the token is validated and fetched from the database.
After the user has been activated, the token is removed from the database.

## Creating a token

First you have to create a token. A token contains

- `userId`
- parameters 
- the time in which it is valid
- a service and method which are called if a customer uses the link with the token

``` php
use \Silversolutions\Bundle\ToolsBundle\Entity\Token;
use \Silversolutions\Bundle\ToolsBundle\Services\TokenService;

$newsletterTokenData = New NewsletterTokenData(); // The object which shall be used later on when the token is used
$newsletterTokenData->setParams($newsletterParams);
$newsletterTokenData->setCustomerProfileData($customerProfileData);
$actionServiceMethod = 'subscribeNewsletter';
$actionService = 'siso_newsletter.newsletter.newsletter_service';
/** @var Token $token */
$token = $this->tokenService->createToken(
    $currentUser->id,
    $newsletterTokenData,
    $validUntil,
    $actionService,
    $actionServiceMethod,
    Token::TOKEN_TYPE_ONE_TIME
);
```

### Using the token

You can use the token in the built-in token controller to call a service and method, or in a custom controller or service.

#### Checking the token custom service

The token can be checked using `TokenService`. It returns the parameters stored when the token was created: 

``` php
$userToken = "12909dmsd912912"; // e.g. from the Request
/** @var Token $token */
$token = $this->tokenService->loadToken($userToken);

$serviceMethod = $token->getActionServiceMethod();
$tokenParameter = $token->getActionServiceMethodParameter();
```

#### TokenController

The token can be used to distribute a link to a customer. The link contains the token as well:
`/token/<tokenid>`

## Token (Entity)

Doctrine is used to stored the token in the database.

|Attribute|Type (PHP)|Required|Usage|
|--- |--- |--- |--- |
|`id`|int|yes|Primary key. Must be unique.|
|`token`|string (32 chars)|yes|Generated token. Must be unique.|
|`userId`|int|yes|ID of the user who created the token. Can be anonymous.|
|`dateCreated`|\DateTime|yes|Timestamp of token creation.|
|`validUntil`|\DateTime|yes|Timestamp until the token is valid.|
|`lastAccess`|\DateTime|yes|Timestamp when the token was last requested.|
|`lockTimeout`|\DateTime|no|Timestamp how long the token is locked. The token cannot be used during this time after last access.|
|`actionServiceId`|string|yes|ID of the service that is invoked|
|`actionServiceMethod`|string|yes|Name of the service method that is invoked.|
|`actionServiceMethodParameter`|eZ\Publish\Core\Repository\Values\User\User|yes|Parameter for the service method.|
|`tokenType`|string|yes|Type of the token. Currently only `one_time_token`. Only defined types are allowed.|

## TokenService

Service ID: `silver_tools.token_service`

If you cannot inject the service, you can use the container:

`$tokenService = $this->container->get('silver_tools.token_service');`

### Service Methods

|Method|Parameters|Return|Usage|
|--- |--- |--- |--- |
|`createToken`|`int $userId,`</br>`\stdClass $netData,`</br>`int $validUntil,`</br>`string $actionServiceId,`</br>`string $actionServiceMethod,`</br>`string $tokenType,`</br>`boolean $persist = true`|Token $token|Creates a token with given parameters. If `persist = true`, the token is stored in the database immediately.|
|`loadToken`|`string $userToken`|Token $token|Fetches token from the database. If the token is not valid, `InvalidTokenException` is thrown.|
|`invalidateToken`|`string $userToken`|boolean|Calls `loadToken` and removes the token from the database.|
|`storeToken`|`Token $token`||Stores token in the database.|
|`removeToken`|`Token $token`||Removes token from the database.|
|`isTokenValid`|`string $userToken`|boolean|Returns true if token is valid.|
