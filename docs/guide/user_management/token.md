---
description: A token is used in the registration process to send out unique emails to activate accounts.
---

# Token

[[= product_name =]] uses the token system in the registration process to create a double opt-in possibility.
The token service can generate a unique token that is valid for a given time.

After user registration, a token is created and stored in the database.
When the user clicks the URL that they receive in an email, the token is validated and fetched from the database.
After the user has been activated, the token is removed from the database.

## Creating a token

A token contains:

- `userId`
- parameters 
- the time for which it is valid
- a service and method that are called if a customer uses the link with the token

``` php
use Ibexa\Bundle\Commerce\ShopTools\Entity\Token;
use Ibexa\Bundle\Commerce\ShopTools\Services\TokenService;

$newsletterTokenData = new NewsletterTokenData();
$newsletterTokenData->setParams($newsletterParams);
$newsletterTokenData->setCustomerProfileData($customerProfileData);
$actionServiceMethod = 'subscribeNewsletter';
$actionService = 'Ibexa\Bundle\Commerce\Newsletter\Service\NoNewsletterService';
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

## Using the token

You can use the token in the built-in token controller when calling a service and method, or in a custom controller or service.

### Checking the token

The token can be checked with the `TokenService`. It returns the parameters that were stored when the token was created: 

``` php
$userToken = "12909dmsd912912"; // e.g. from the Request
/** @var Token $token */
$token = $this->tokenService->loadToken($userToken);

$serviceMethod = $token->getActionServiceMethod();
$tokenParameter = $token->getActionServiceMethodParameter();
```

#### TokenController

You can use the token to deliver unique links to customers.

`TokenController` is available at the `/token/[token]` route, for example: `/token/124f564f6d4df4fd3fd4df34fd34fd`.

`TokenController` is called to process a token, for example, after user registration when the user clicks the activation link.
The controller loads the token from the database, activates the user account and invalidates the token.

Each token has the following attributes that are processed by the token-specific logic:

- `actionServiceId`
- `actionServiceMethod`
- `actionServiceMethodParameter`

``` php
/** @var TokenServiceMethodProcessorService $tokenServiceMethodProcessor */
$tokenServiceMethodProcessor = $this->get('Ibexa\Bundle\Commerce\Eshop\Services\Token\TokenServiceMethodProcessorService');
//trigger the logic for this token with the service
$response = $tokenServiceMethodProcessor->$callableMethod(
       $tokenEntity,
       $callableService,
       $callableMethod
);
```

The `Ibexa\Bundle\Commerce\Eshop\Services\Token\TokenServiceMethodProcessorService` service implements the custom logic for each token and returns a response.

## TokenService

Service ID: `Ibexa\Bundle\Commerce\ShopTools\Services\TokenService`

### Service methods

|Method|Parameters|Returns|Usage|
|--- |--- |--- |--- |
|`createToken`|`userId`, `netData`, `validUntil`, `actionServiceId`, `actionServiceMethod`, `tokenType`, `persist`|`token`|Creates a token with given parameters. If `persist = true`, the token is stored in the database immediately.|
|`loadToken`|`userToken`|`token`|Fetches the token from the database. If the token is not valid, `InvalidTokenException` is thrown.|
|`invalidateToken`|`userToken`|boolean|Calls `loadToken()` and removes the token from the database.|
|`storeToken`|`token`||Stores the token in the database.|
|`removeToken`|`token`||Removes the token from the database.|
|`isTokenValid`|`userToken`|boolean|Returns true if the token is valid.|
