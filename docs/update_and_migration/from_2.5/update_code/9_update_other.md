# 4.9 Other code updates

## HTTP cache

HTTP cache bundle now uses FOS Cache Bundle v2.
If your code makes use of HTTP cache bundle, see [the list of changes and deprecations](ez_platform_v3.0_deprecations.md#ezplatform-http-cache).

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

## Commands

The `ContainerAwareCommand` class is not available in Symfony 5. Therefore, if your custom commands use `Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand`
as a base class, you must rewrite them to use `Symfony\Component\Console\Command\Command` instead. 

## Permissions

Some [permission choice loaders](ez_platform_v3.0_deprecations.md#code-cleanup-in-ez-platform-kernel) have been removed.
If your code uses them, you must rewrite it to use the permission resolver.

## Service container parameters

A number of Symfony [service container](php_api.md#service-container) parameters [have been dropped](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/doc/bc/1.0/dropped-container-parameters.md).

Check if your code uses such invalid parameters: search for them by using the `ezpublish\..*\.class` regular expression pattern. 
When found, replace all the occurrences with fully-qualified class names.

## QueryTypes

If your code relies on automatically registering QueryTypes through the naming convention `<Bundle>\QueryType\*QueryType`,
you need to register your QueryTypes as services and tag them with `ezpublish.query`, or enable their automatic configuration (`autoconfigure: true`).

## Symfony namespaces

A number of Symfony namespaces have changed, and you must update your code if it uses them. 
For example, the following namespaces are now different:

|Use|Instead of|
|---|---|
|Symfony\Contracts\Translation\TranslatorInterface|Symfony\Component\Translation\TranslatorInterface|
|Symfony\Contracts\EventDispatcher\Event|Symfony\Component\EventDispatcher\Event|

For more information, search for removed classes in Symfony [version 4.0](https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.0.md) and [version 5.0](https://github.com/symfony/symfony/blob/5.0/UPGRADE-5.0.md) documentation.

## Apache/Nginx configuration

Make sure that your Apache/Nginx configuration is up to date with Symfony 5.
Refer to [the provided `vhost.template`](https://github.com/ezsystems/ezplatform/blob/master/doc/apache2/vhost.template)
for an example.

## Deprecations

Due to a number of compatibility breaks and deprecations introduced in eZ Platform v3.0, the changes that result from the above considerations might not be sufficient. 
Make sure that you review your code and account for all changes listed in [Deprecations and backwards compatibility breaks](ez_platform_v3.0_deprecations.md).

## Next steps

Now, proceed to the next step, [updating to v3.3](../to_3.3.md).
