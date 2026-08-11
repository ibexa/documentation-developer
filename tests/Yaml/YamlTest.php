<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Documentation\Yaml;

use Ibexa\Tests\Documentation\ConfigurationProvider;
use Ibexa\Tests\Documentation\ValidationBaseline;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * @group yaml
 */
final class YamlTest extends TestCase
{
    private const string REPO_ROOT = __DIR__ . '/../../';
    private const string BASELINE_FILE = __DIR__ . '/../yaml-validation-baseline.yaml';

    /**
     * @dataProvider provideYamlSources
     */
    public function testYamlIsSyntacticallyValid(string $filePath, int $line, string $body, string $bodyHash): void
    {
        $filePath = self::relativePath($filePath);

        try {
            Yaml::parse($body, Yaml::PARSE_CUSTOM_TAGS | Yaml::PARSE_CONSTANT);
        } catch (ParseException $e) {
            if (self::baseline()->isInBaseline($filePath, $bodyHash, $e->getMessage())) {
                self::markTestSkipped(sprintf(
                    'Known baseline issue in %s at line %d: %s',
                    $filePath,
                    $line,
                    $e->getMessage(),
                ));
            }

            self::fail(sprintf(
                'YAML parse error at %s:%d [hash:%s]: %s',
                $filePath,
                $line,
                $bodyHash,
                $e->getMessage(),
            ));
        }

        $this->addToAssertionCount(1);
    }

    /**
     * @param int $line Starting line of the config block (0 for standalone YAML files).
     *
     * @dataProvider provideBundleConfigs
     */
    public function testBundleConfigurationIsValid(
        string $extensionName,
        mixed $config,
        string $filePath,
        int $line,
        string $bodyHash
    ): void {
        $configuration = self::configurationProvider()->createConfiguration($extensionName);
        $processor = new Processor();

        $config = self::configurationProvider()->resolveParameters(is_array($config) ? $config : []);

        try {
            $processor->processConfiguration($configuration, [$config]);
        } catch (\Exception $e) {
            if (self::baseline()->isInBaseline($filePath, $bodyHash, $e->getMessage())) {
                self::markTestSkipped(sprintf(
                    'Known baseline issue for "%s" in %s:%d: %s',
                    $extensionName,
                    $filePath,
                    $line,
                    $e->getMessage(),
                ));
            }

            self::fail(sprintf(
                'Invalid configuration for "%s" in %s:%d [hash:%s] — %s',
                $extensionName,
                $filePath,
                $line,
                $bodyHash,
                $e->getMessage(),
            ));
        }

        $this->addToAssertionCount(1);
    }

    /**
     * Yields all standalone YAML files from code_samples/ plus every fenced
     * YAML block extracted from docs Markdown files.
     *
     * @return iterable<string, array{string, int, string, string}>
     */
    public static function provideYamlSources(): iterable
    {
        foreach (self::samplesProvider()->getCodeSampleYaml() as $item) {
            yield self::makeLabel($item->path, $item->line) => [$item->path, $item->line, $item->body, $item->bodyHash];
        }
    }

    /**
     * Yields one entry per (extension, config) pair found in YAML files and
     * in fenced YAML blocks from docs Markdown files.
     *
     * @return iterable<string, array{string, mixed, string, int, string}>
     */
    public static function provideBundleConfigs(): iterable
    {
        foreach (self::provideYamlSources() as [$filePath, $line, $body, $bodyHash]) {
            $path = self::relativePath($filePath);
            try {
                $parsed = Yaml::parse($body, Yaml::PARSE_CUSTOM_TAGS);
            } catch (\Throwable) {
                continue;
            }

            if (!is_array($parsed)) {
                continue;
            }

            foreach ($parsed as $extensionName => $config) {
                if (!is_string($extensionName) || !self::configurationProvider()->hasExtension($extensionName)) {
                    continue;
                }

                yield sprintf('%s (%s)', $extensionName, self::makeLabel($path, $line)) => [$extensionName, $config, $path, $line, $bodyHash];
            }
        }
    }

    private static function configurationProvider(): ConfigurationProvider
    {
        static $provider = null;

        return $provider ??= new ConfigurationProvider();
    }

    private static function samplesProvider(): YamlSamplesProvider
    {
        static $provider = null;

        return $provider ??= new YamlSamplesProvider();
    }

    private static function baseline(): ValidationBaseline
    {
        static $baseline = null;

        return $baseline ??= new ValidationBaseline(self::BASELINE_FILE, realpath(self::REPO_ROOT));
    }

    private static function makeLabel(string $absolutePath, int $lineNumber): string
    {
        return ltrim(str_replace(realpath(self::REPO_ROOT), '', $absolutePath), '/') . ':' . $lineNumber;
    }

    private static function relativePath(string $absolutePath): string
    {
        return ltrim(str_replace(realpath(self::REPO_ROOT), '', $absolutePath), '/');
    }
}
