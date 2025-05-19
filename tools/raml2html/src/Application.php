<?php

declare(strict_types=1);

namespace EzSystems\Raml2Html;

use EzSystems\Raml2Html\Command\BuildCommand;
use EzSystems\Raml2Html\Command\ClearCacheCommand;
use EzSystems\Raml2Html\Command\LintTypesCommand;
use EzSystems\Raml2Html\Command\TestCompareCommand;
use EzSystems\Raml2Html\Command\TestLogicCommand;
use EzSystems\Raml2Html\Command\TestTypeUsageCommand;
use EzSystems\Raml2Html\Generator\Generator;
use EzSystems\Raml2Html\RAML\ParserFactory;
use EzSystems\Raml2Html\Twig\Extension\HashExtension;
use EzSystems\Raml2Html\Twig\Extension\RenderExtension;
use EzSystems\Raml2Html\Twig\Extra\Markdown\GithubFlavoredMarkdown;
use Symfony\Component\Console\Application as BaseApplication;
use Twig as Twig;
use Twig\Extra\Markdown\DefaultMarkdown;
use Twig\Extra\Markdown\MarkdownExtension;
use Twig\Extra\Markdown\MarkdownRuntime;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

final class Application extends BaseApplication
{
    private const CACHE_DIR = __DIR__ . '/../var/cache/';

    /** @var Twig\Environment|null */
    private $twig = null;

    /**
     * {@inheritdoc}
     */
    protected function getDefaultCommands(): array
    {
        return array_merge(parent::getDefaultCommands(), [
            new BuildCommand(
                $this->getGenerator(),
                $this->getRamlParserFactory()
            ),
            new LintTypesCommand(
                $this->getRamlParserFactory()
            ),
            new ClearCacheCommand(self::CACHE_DIR),
            new TestCompareCommand(),
            new TestTypeUsageCommand(),
            new TestLogicCommand(),
        ]);
    }

    public function getTwig(): Twig\Environment
    {
        if ($this->twig === null) {
            $loader = new Twig\Loader\FilesystemLoader(__DIR__ . '/../themes');
            $options = [
                'debug' => true,
                'cache' => self::CACHE_DIR,
                'strict_variables' => true,
            ];

            $this->twig = new Twig\Environment($loader, $options);
            $this->twig->addExtension(new RenderExtension());
            $this->twig->addExtension(new MarkdownExtension());
            $this->twig->addRuntimeLoader(new class implements RuntimeLoaderInterface {
                public function load($class): ?MarkdownRuntime {
                    if (MarkdownRuntime::class === $class) {
                        return new MarkdownRuntime(new GithubFlavoredMarkdown());
                    }

                    return null;
                }
            });
            $this->twig->addExtension(new HashExtension());
        }

        return $this->twig;
    }

    private function getGenerator(): Generator
    {
        return new Generator($this->getTwig());
    }

    private function getRamlParserFactory(): ParserFactory
    {
        return new ParserFactory();
    }
}
