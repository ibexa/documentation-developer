# Login and registration cookbook

[[= product_name_com =]] is able to check credentials not only specified by username and password,
but also using customer number (which could be taken from ERP system). 

## Services

### AuthenticationListener

The first part in the authentication process is `AuthenticationListener`.
This listener is able to read the posted values from the login form and create a `UserToken`.

The default Symfony listener is extended to collect more information (`customer_number`).
In the standard Symfony login form, only username and password are allowed.

The extended listener implements the same `AbstractAuthenticationListener` interface.

`services.xml`:

``` xml
<parameter key="security.authentication.listener.form.class">Silversolutions\Bundle\EshopBundle\Service\Security\CustomFormAuthenticationListener</parameter>
```

A different `UsernamePasswordToken` (using `TokenInterface`) is needed here.
You must add a new attribute to the `customer_no` token. This `UsernamePasswordToken` is passed to the next service in the authentication process.

``` php
$token = new UsernamePasswordToken($username, $password, $this->providerKey);
$token->setAttribute('customer_no', $customerNo);
```

### UserProvider

`UserProvider` gets the created `UsernamePasswordToken` and fetches the correct User from the content model.

The default fetching functionality is extended because, in the Customer Center, the User can be placed in different User Groups (or outside a group).

The provider uses `locationId` in the backend to determine private/b2b customers.

It provides a `checkEzUser()` method which checks the Location and customer number of the given User.

``` xml
<parameter key="ezpublish.security.user_provider.class">Silversolutions\Bundle\EshopBundle\Service\Security\UserProvider</parameter>
```

### AuthenticationProvider

`AuthenticationProvider` retrieves and authenticates the User (with the `UsernamePasswordToken`).
The methods `retrieveUser()` and `checkAuthentication()` try to load a User by username or email and take credentials into account.
Afterwards, also the Location and possibly the customer number are checked by the `checkEzUser()` method from `UserProvider`.

``` xml
<parameter key="security.authentication.provider.dao.class">Silversolutions\Bundle\EshopBundle\Service\Security\AuthenticationProvider</parameter>
Security Controller
```

## Security Controller

The goal of the Security Controller's `loginAction()` is to display the login mask and authentication errors, if there are any.

``` php
/**
 * renders the login form
 *
 * @param \Symfony\Component\HttpFoundation\Request $request
 * @return Response
 */
public function loginAction(Request $request)
{
    $session = $request->getSession();
    if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
        $error = $request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
    } else  {
        $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
        $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
    }
    return $this->render(
        'SilversolutionsEshopBundle:Security:login.html.twig',
        array(
            'error' => $error,
        )
    );
}
```

## Login form

Login form is adjusted to use the additional parameter `_customer_no`.

#### Template Example

`views/Security/login.html.twig`:

```html+twig
<form class="" action="{{ path( 'login_check' ) }}" method="post" role="form">
     {% block login_fields %}
           <fieldset>
                 {% if ses_config_parameter('enable_customer_number_login','siso_eshop') %}
                    <label for="customer_no">{{ 'Customer Number'|st_translate }}</label>
                    <input type="text" id="customer_no" class="form-control" name="_customer_no" placeholder="{{ 'Customer Number'|st_translate }}" />
                 {% endif %}
                 <div class="form-group">
                            <label for="username">{{ 'Username / Email'|st_translate }}</label>
                            <input type="text" id="username" class="form-control" name="_username" value="" required="required" autofocus="autofocus" autocomplete="on" placeholder="{{ 'Username'|st_translate }}" />
                 
                 <div class="form-group{% if error %} has-error{% endif %}">
                            <label for="password">{{ 'Password'|st_translate }}</label>
                            <input type="password" id="password" class="form-control" name="_password" required="required" placeholder="{{ 'Password'|st_translate }}" />
                 
                 <button type="submit" class="button">{{ 'Login'|trans }}</button>
           </fieldset>
     {% endblock %}
  </form>
```

!!! note

    The login forms in the template must post to the `{{ path( 'login_check' ) }}`

    This URL is not the URL of the security controller.
    The posted data is handled automatically by Symfony and passed to the Security context, where the authentication is done.

## Logging in a User from a controller

Sometimes a User must be logged in directly, without providing the username/password combination.
An example use case is logging in with SSO:

``` php
public function loginEzUserAction()
{
        $roles = array('ROLE_USER');
        $repository = $this->get('ezpublish.api.repository');
        $ezUser = $this->repository->getCurrentUser();
        $user = new CoreUser($ezUser, $roles);

         /**
             * the provider key can be found usually in the security.yml file
             * it is the name of the firewall
             * e.g.
             * firewalls:
             *      ezpublish_front:
             *          pattern: ^/
             *          anonymous: ~
             *          form_login:
             *          require_previous_session: false
             *          logout: ~
        */
        $providerKey = 'ezpublish_front';

        //create new token
        $token = new UsernamePasswordToken($user, null, $providerKey, $roles);
        $this->securityContext->setToken($token);
        $this->repository->setCurrentUser($ezUser);
}
```
