---
description: Customize the login form for new users in your site front end.
---

# Add login form

You can create a login form for your users. 
Follow the instruction below to create a template with login form. If you want to configure more options for example, password expiration, see [other user management templates](user_management.md#other-user-management-templates).

First, make sure you have configured [login methods](user_management.md#login-methods).

If you only want to change a template, in the `config/packages/views.yaml` add the following configuration:

```yaml
ibexa:
    system:
        my_siteaccess:
            user:
                login_template: '@ibexadesign/Security/login.html.twig'
```

To add a link redirecting to the login form, in the page layout template, provide the following code:

```html+twig
<a href="{{ path('login') }}">Log in</a>
```

Next, add the template defined in the event.

In `templates/themes/<theme_name>/login`, create an `expired_credentials.html.twig` file:

```html+twig
{% extends '@ibexadesign/Security/base.html.twig' %}

{%- block content -%}
    <h2 class="ibexa-login__header">
        {{ 'authentication.credentials_expired'|trans|desc('Your password has expired') }}
    </h2>
    <p>
        {{ 'authentication.credentials_expired.message'|trans|desc(
            'For security reasons, your password has expired and needs to be changed. An email has been sent to you with instructions.'
        ) }}
    </p>
    <p>
        <a href="{{ path('ibexa.user.forgot_password') }}" class="btn btn-primary ibexa-btn ibexa-btn--login">
            {{ 'authentication.credentials_expired.reset_password'|trans|desc('Reset password') }}
        </a>
    </p>
{%- endblock -%}
```

## Customize login form

You can use a custom template for example to display information about password expiration
or to customize [other user management templates](user_management.md#other-user-management-templates).

In case of more advanced template customization, you can use a subscriber,
for example in `src/EventSubscriber/LoginFormViewSubscriber.php`:

``` php hl_lines="23 35 40 42"
<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Core\MVC\Symfony\Event\PreContentViewEvent;
use Ibexa\Core\MVC\Symfony\MVCEvents;
use Ibexa\Core\MVC\Symfony\View\LoginFormView;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\CredentialsExpiredException;

final class LoginFormViewSubscriber implements EventSubscriberInterface
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            MVCEvents::PRE_CONTENT_VIEW => 'onPreContentView',
        ];
    }
    
    public function onPreContentView(PreContentViewEvent $event): void
    {
        $view = $event->getContentView();
        
        if (!($view instanceof LoginFormView)) {
            return ;
        }
        
        $view->addParameters([
            'foo' => 'foo',
            'bar' => 'bar'
        ]);
        
        if ($view->getLastAuthenticationException() instanceof CredentialsExpiredException) {
            // View with instruction to unlock account
            $view->setTemplateIdentifier('login/expired_credentials.html.twig');
        }
    }
}
```

In the provided example, in line 23, the `PRE_CONTENT_VIEW` event is used.
You can also pass additional parameters to the view (line 35).
In this case, at the instance of exception (line 40), the subscriber displays the `expired_credentials.html.twig` template (line 42).

Remember to provide a template and point to it in the subscriber
(in this case, in `templates/login/expired_credentials.html.twig`):

```html+twig
{% extends '@ibexadesign/Security/base.html.twig' %}

{%- block content -%}
    <h2 class="ibexa-login__header">
        {{ 'authentication.credentials_expired'|trans|desc('Your password has expired') }}
    </h2>
    <p>
        {{ 'authentication.credentials_expired.message'|trans|desc(
            'For security reasons, your password has expired and needs to be changed. An email has been sent to you with instructions.'
        ) }}
    </p>
    <p>
        <a href="{{ path('ibexa.user.forgot_password') }}" class="btn btn-primary ibexa-btn ibexa-btn--login">
            {{ 'authentication.credentials_expired.reset_password'|trans|desc('Reset password') }}
        </a>
    </p>
{%- endblock -%}
```

For more information, see [Templates documentation](templates.md).
