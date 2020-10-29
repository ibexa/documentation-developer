# 4.10 Other code upgrades

## HTTP cache

HTTP cache bundle now uses FOS Cache Bundle v2.
If your code makes use of HTTP cache bundle, see [the list of changes and deprecations](../releases/ez_platform_v3.0_deprecations.md#http-cache-bundle).

## User checker

Add the user checker to firewall by adding the following line to `config/packages/security.yaml`:

``` yaml hl_lines="5"
security:
    firewalls:
        ezpublish_front:
            # ...
            user_checker: eZ\Publish\Core\MVC\Symfony\Security\UserChecker
            # ...
```

## Command

If your custom commands use `Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand`
you need to rewrite them to use `Symfony\Component\Console\Command\Command` instead,
because `ContainerAwareCommand` is deprecated.

## Permission-related methods

Some deprecated [permission-related methods](../releases/ez_platform_v3.0_deprecations.md#permission-related-methods) have been removed.
If your code uses them, you need to rewrite it to use the permission resolver.

## Container parameters

A numer of Symfony Dependency Injection Container parameters [have been dropped](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/doc/bc/1.0/dropped-container-parameters.md).

To check if your code uses them, search for all occurrences of `ezpublish\..*\.class` (regular expression pattern)
and [decorate Symfony services](https://symfony.com/doc/5.0/service_container/service_decoration.html) instead.

## QueryTypes

If your code relies on automatically registering QueryTypes through the naming convention `<Bundle>\QueryType\*QueryType`,
you need to register your QueryTypes as services and tag them with `ezpublish.query`, or enable their automatic configuration (`autoconfigure: true`).

## Symfony namespaces

The following Symfony namespaces have changed. You need to update your code if it uses any of them:

|Use|Instead of|
|---|---|
|Symfony\Contracts\Translation\TranslatorInterface|Symfony\Component\Translation\TranslatorInterface|
|Symfony\Contracts\EventDispatcher\Event|Symfony\Component\EventDispatcher\Event|

## Apache/Nginx configuration

Make sure that you Apache/Nginx configuration is up to date with Symfony 5.
Refer to [the provided `vhost.template`](https://github.com/ezsystems/ezplatform/blob/master/doc/apache2/vhost.template)
for an example.

## Deprecations

For a full list of changes, see [Deprecations and backwards compatibility breaks](../releases/ez_platform_v3.0_deprecations.md).

