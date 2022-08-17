# 4.2. Update configuration

## `ezpublish` configuration key

The main YAML configuration key is now [`ezplatform` instead of `ezpublish`](ez_platform_v3.0_deprecations.md#configuration-through-ezplatform).
You need to change your configuration files to make use of the new key. For example:

**Use:**

``` yaml
ezplatform:
    system:
        default:
            # ...
```

**instead of:**

``` yaml
ezpublish:
    system:
        default:
            # ...
```

## Resolving settings

If you used dynamic settings (through `$setting$`),
or got settings from the [ConfigResolver](dynamic_configuration.md#configresolver) in a class constructor,
you now need to rewrite your code to inject the ConfigResolver and get the relevant setting:

**Use:**

``` php
use eZ\Publish\Core\MVC\ConfigResolverInterface;

class MyService
{
    /** @var \eZ\Publish\Core\MVC\ConfigResolverInterface */
    private $configResolver;

    public function __construct(ConfigResolverInterface $configResolver)
    {
        $this->configResolver = $configResolver;
    }

    public function myMethodWhichUsesSetting(): void
    {
        $setting = $this->configResolver->getParameter('setting');
    }
}
```

**instead of:**

``` php
use eZ\Publish\Core\MVC\ConfigResolverInterface;

class MyService
{
    public function __construct(ConfigResolverInterface $configResolver)
    {
        $this->setting = $configResolver->getParameter('setting');
    }
}
```
