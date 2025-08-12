<?php declare(strict_types=1);

namespace Acme\ExampleBundle\DependencyInjection;

use Ibexa\Bundle\Core\DependencyInjection\Configuration\SiteAccessAware\ConfigurationProcessor;
use Ibexa\Bundle\Core\DependencyInjection\Configuration\SiteAccessAware\ContextualizerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

final class AcmeExampleExtension extends Extension
{
    public const string ACME_CONFIG_DIR = __DIR__ . '/../../../config/acme';

    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(self::ACME_CONFIG_DIR));
        $loader->load('default_settings.yaml');

        $processor = new ConfigurationProcessor($container, 'acme_example');
        $processor->mapConfig(
            $config,
            // Any kind of callable can be used here.
            // It is called for each declared scope/SiteAccess.
            static function ($scopeSettings, $currentScope, ContextualizerInterface $contextualizer) {
                // Maps the "name" setting to "acme_example.<$currentScope>.name" container parameter
                // It is then possible to retrieve this parameter through ConfigResolver in the application code:
                // $helloSetting = $configResolver->getParameter( 'name', 'acme_example' );
                $contextualizer->setContextualParameter('name', $currentScope, $scopeSettings['name']);
            }
        );

        // Now map "custom_setting" and ensure the key defined for "my_siteaccess" overrides the one for "my_siteaccess_group"
        // It is done outside the closure as it's needed only once.
        $processor->mapConfigArray('custom_setting', $config);

        // Map setting example
        $processor = new ConfigurationProcessor($container, 'acme_example');
        $processor->mapSetting('name', $config);

        // Map config array example
        $processor->mapConfigArray('custom_setting', $config);

        // Merge from second level example
        $contextualizer = $processor->getContextualizer();
        $contextualizer->mapConfigArray('custom_setting', $config, ContextualizerInterface::MERGE_FROM_SECOND_LEVEL);
    }

    /** @param array<mixed> $config */
    #[\Override]
    public function getConfiguration(array $config, ContainerBuilder $container): Configuration
    {
        return new Configuration();
    }
}
