<?php

declare(strict_types=1);

namespace EzSystems\Raml2Html\Generator;

use Raml\ApiDefinition;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;

final class Generator
{
    /** @var \Twig\Environment */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function generate(ApiDefinition $apiDefinition, GeneratorOptions $options): void
    {
        $theme = $options->getTheme();

        $output = $this->twig->render("$theme/index.html.twig", [
            'api' => $apiDefinition,
            'theme' => $theme,
        ]);

        $filename = $this->getOutputFilePath($apiDefinition, $options);

        $fs = new Filesystem();
        $fs->dumpFile($filename, $output);
    }

    private function getOutputFilePath(ApiDefinition $apiDefinition, GeneratorOptions $options): string
    {
        return $options->getOutputDir() . \DIRECTORY_SEPARATOR . 'rest_api_reference.html';
    }
}
