# Add user login form

You can add a login form for your users. The template defines lots of config options for example, information about password expiration or [other user management templates](#other-user-management-templates).

**Prerequisite**

Make sure you have configured [login methods](../guide/user_management/user_management.md##login-methods).

If you only want to change a template, in the `config/packages/views.yaml` add the following code:

```yaml
ezpublish:
    system:
        my_siteaccess:
            user:
                login_template: '@ezdesign/Security/login.html.twig'
```

For more advanced customization, you can use a subscriber.
 Create `src/EventSubscriber/LoginFormViewSubscriber.php`:
 
 ``` php hl_lines="23 35 40 42"
 <?php

 declare(strict_types=1);

 namespace App\EventSubscriber;

 use eZ\Publish\Core\MVC\Symfony\Event\PreContentViewEvent;
 use eZ\Publish\Core\MVC\Symfony\MVCEvents;
 use eZ\Publish\Core\MVC\Symfony\View\LoginFormView;
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
 
In the provided example, in line 23, the `PRE_CONTENT_VIEW` event is used. You can also pass additional parameters to the view (line 35). In this case, at the instance of exception (line 40), the subscriber displays the `expired_credentials.html.twig` template (line 42).

Next, provide the template defined in the event. In the `templates/login`, create the `expired_credentials/html.twig` file:

```html+twig
{% extends '@ezdesign/Security/base.html.twig' %}

{%- block content -%}
    <h2 class="ez-login__header">
        {{ 'authentication.credentials_expired'|trans|desc('Your password has expired') }}
    </h2>
    <p>
        {{ 'authentication.credentials_expired.message'|trans|desc(
            'For security reasons, your password has expired and needs to be changed. An email has been sent to you with instructions.'
        ) }}
    </p>
    <p>
        <a href="{{ path('ezplatform.user.forgot_password') }}" class="btn btn-primary ez-btn ez-btn--login">
            {{ 'authentication.credentials_expired.reset_password'|trans|desc('Reset password') }}
        </a>
    </p>
{%- endblock -%}
```
