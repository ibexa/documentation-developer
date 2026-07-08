<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Documentation;

use Ibexa\Bundle\Core\IbexaCoreBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * Builds a Symfony ContainerBuilder populated with all installed bundles so
 * that each bundle's Extension is fully wired — including sub-parsers
 * registered via Bundle::build().
 *
 * This makes it possible to call hasExtension() / createConfiguration() and
 * get a complete config tree, e.g.:
 *   - `ibexa`    — SiteAccess sub-parsers contributed by all installed bundles
 *   - `security` — authenticator factories from SecurityBundle::build()
 *   - every other extension — no-arg constructors resolved automatically
 *
 * No kernel boot or database is required.
 */
final class ConfigurationProvider
{
    private ContainerBuilder $container;

    public function __construct()
    {
        $this->container = $this->buildContainer();
    }

    public function hasExtension(string $alias): bool
    {
        return $this->container->hasExtension($alias);
    }

    public function createConfiguration(string $alias): ConfigurationInterface
    {
        return $this->container->getExtension($alias)->getConfiguration([], $this->container);
    }

    /**
     * Recursively resolves %parameter% placeholders using the container's
     * parameter bag, mirroring what the real Symfony kernel does before
     * passing config to the Config component. Unknown parameters (custom app
     * params not present in the test container) are left as-is.
     *
     * @param array<mixed> $config
     *
     * @return array<mixed>
     */
    public function resolveParameters(array $config): array
    {
        /** @var array<mixed> $result */
        $result = $this->resolveValue($this->container->getParameterBag(), $config);

        return $result;
    }

    private function resolveValue(ParameterBagInterface $bag, mixed $value): mixed
    {
        if (is_array($value)) {
            return array_map(fn (mixed $v): mixed => $this->resolveValue($bag, $v), $value);
        }

        if (!is_string($value)) {
            return $value;
        }

        try {
            return $bag->resolveValue($value);
        } catch (ParameterNotFoundException) {
            return $value;
        }
    }

    private function buildContainer(): ContainerBuilder
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.debug', false);
        $container->setParameter('kernel.bundles', []);
        $container->setParameter('kernel.bundles_metadata', []);
        $container->setParameter('kernel.project_dir', sys_get_temp_dir());
        $container->setParameter('kernel.environment', 'test');

        $bundles = self::discoverBundles();

        // Register all extensions before calling build() on any bundle,
        // because some bundles call $container->getExtension('ibexa') during build().
        foreach ($bundles as $bundle) {
            try {
                $extension = $bundle->getContainerExtension();
                if ($extension !== null) {
                    $container->registerExtension($extension);
                }
            } catch (\Throwable) {
                // Skip bundles whose extension cannot be instantiated.
            }
        }

        // build() registers parsers/factories into the extensions.
        foreach ($bundles as $bundle) {
            try {
                $bundle->build($container);
            } catch (\Throwable) {
                // Skip bundles whose build() fails (e.g. missing sibling extensions).
            }
        }

        return $container;
    }

    /**
     * Returns all installed bundles with SecurityBundle and IbexaCoreBundle
     * guaranteed first (other bundles may call getExtension('ibexa') or
     * getExtension('security') during their build()).
     *
     * @return list<BundleInterface>
     */
    private static function discoverBundles(): array
    {
        // These must be registered before any bundle that calls
        // $container->getExtension('ibexa'/'security') inside build().
        $bundles = [
            new SecurityBundle(),
            new IbexaCoreBundle(),
        ];

        $seen = [SecurityBundle::class, IbexaCoreBundle::class];

        $vendorBase = __DIR__ . '/../vendor';
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($vendorBase));

        foreach ($iterator as $file) {
            if (!$file->isFile() || !preg_match('/\w+Bundle\.php$/', $file->getFilename())) {
                continue;
            }

            $content = file_get_contents($file->getPathname());
            preg_match('/^namespace (.+);/m', $content, $nsMatch);
            preg_match('/^(?:(?:final|abstract)\s+)?class (\w+Bundle)\b/m', $content, $clsMatch);

            if (empty($nsMatch[1]) || empty($clsMatch[1])) {
                continue;
            }

            $fqcn = $nsMatch[1] . '\\' . $clsMatch[1];

            if (!class_exists($fqcn) || in_array($fqcn, $seen, true)) {
                continue;
            }

            $reflection = new \ReflectionClass($fqcn);
            if ($reflection->isAbstract() || !$reflection->implementsInterface(BundleInterface::class)) {
                continue;
            }

            $seen[] = $fqcn;

            try {
                $bundles[] = new $fqcn();
            } catch (\Throwable) {
                // Skip bundles that cannot be instantiated without arguments.
            }
        }

        return $bundles;
    }
}
