# Importing settings from a bundle

!!! tip

    The following recipe is valid for any type of settings supported by Symfony framework.

If you are keeping some of your code in a bundle, dealing with core bundle semantic configuration can be tedious
if you maintain it in the main `config/packages/ezplatform.yaml` configuration file.

This page shows how to import configuration from a bundle in two ways: [the manual way](#importing-settings-manually) and [the implicit way](#importing-settings-implicitly).

## Importing settings manually

Importing manually is the simpler of the two ways and has the advantage of being explicit.
It relies on using the `imports` statement in your main `config/packages/ezplatform.yaml`:

``` yaml
imports:
    # Import the template selection rules that reside in your custom AcmeExampleBundle.
    - {resource: "@AcmeExampleBundle/Resources/config/templates_rules.yaml"}
 
ezplatform:
    # ...
```

The `templates_rules.yaml` should then be placed in `Resources/config` in AcmeExampleBundle.
The configuration tree from this file will be merged with the main one.

``` yaml
ezplatform:
    system:
        <siteaccess>:
            content_view:
                full:
                    article:
                        template: '@AcmeExample/full/article.html.twig'
                        match:
                            Identifier\ContentType: [article]
                    special:
                        template: '@AcmeExample/full/special.html.twig'
                        match:
                            Id\Content: 142
```

!!! caution

    The imported configuration will override the main configuration files if both cover the same settings.

!!! tip

    If you want to import configuration for development use only, you can do so in `config/packages/dev/ezplatform.yaml` 

## Importing settings implicitly

The following example shows how to implicitly load settings on the example of eZ Platform kernel.
Note that this is also valid for any bundle.

This assumes you have knowledge of [service container extensions](http://symfony.com/doc/4.3/book/service_container.html#importing-configuration-via-container-extensions).

!!! note

    Configuration loaded this way will be overridden by the main `ezplatform.yaml` file.

In `Acme/ExampleBundle/DependencyInjection/AcmeExampleExtension`:

``` php
<?php

namespace Acme\ExampleBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AcmeExampleExtension extends Extension implements PrependExtensionInterface
{
    // ...

    /**
     * Allow an extension to prepend the extension configurations.
     * Here we will load our template selection rules.

     *
     * @param ContainerBuilder $container
     */
    public function prepend( ContainerBuilder $container )
    {
        // Loading your YAML file containing template rules
        $configFile = __DIR__ . '/../Resources/config/template_rules.yaml';
        $config = Yaml::parse( file_get_contents( $configFile ) );
        // Explicitly prepend loaded configuration for "ezplatform" namespace.
        // It will be placed under the "ezplatform" configuration key, like in ezplatform.yaml.
        $container->prependExtensionConfig( 'ezplatform', $config );
        $container->addResource( new FileResource( $configFile ) );
    }
}
```

In `AcmeExampleBundle/Resources/config/template_rules.yaml`:

``` yaml
# You explicitly prepended config for "ezplatform" namespace in the service container extension, 
# so no need to repeat it here
system:
    <siteaccess>:
        content_view:
            full:
                article:
                    template: '@AcmeExample/full/article.html.twig'
                    match:
                        Identifier\ContentType: [article]
                special:
                    template: '@AcmeExample/full/special.html.twig'
                    match:
                        Id\Content: 142
```

!!! note "Performance"

    Service container extensions are called only when the container is being compiled,
    so performance will not be affected.
