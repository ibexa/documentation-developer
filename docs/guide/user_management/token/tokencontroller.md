# TokenController

`TokenController` is available at the `/token/[token]` route,
for example: `/token/124f564f6d4df4fd3fd4df34fd34fd`.

`TokenController` is called to process a token, e.g. after user registration when the user clicks the activation link.
This controller loads the token from the database, activates the user account and invalidates the token.

Each token has the following attributes to process the token-specific logic:

- `$actionServiceId`
- `$actionServiceMethod`
- `$actionServiceMethodParameter`

``` php
/** @var TokenServiceMethodProcessorService $tokenServiceMethodProcessor */
$tokenServiceMethodProcessor = $this->get('silver_eshop.token_service_method_processor');
//trigger the logic for this token with the service
$response = $tokenServiceMethodProcessor->$callableMethod(
       $tokenEntity,
       $callableService,
       $callableMethod
);
```

The `silver_eshop.token_service_method_processor` service implements the custom logic for each token and returns a response.

## TokenServiceMethodProcessorService

Inside the token `TokenServiceMethodProcessorService` controller implements the custom logic for each token.

For example, for the registration token, it calls the method that is stored in the token attribute `$actionServiceMethod`
to the service that is stored in the attribute `$actionServiceId`. In addition, it performs validation and returns a response object.

Both the service in `$actionServiceId` and `TokenServiceMethodProcessorService` must implement a `$actionServiceMethod` method.
This method must return a response of type `Symfony\Component\HttpFoundation\Response`.
