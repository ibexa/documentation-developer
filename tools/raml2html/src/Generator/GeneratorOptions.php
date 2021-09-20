<?php

declare(strict_types=1);

namespace EzSystems\Raml2Html\Generator;

final class GeneratorOptions
{
    /**
     * Documentation theme.
     *
     * @var string
     */
    private $theme;

    /**
     * Output directory.
     *
     * @var string
     */
    private $outputDir;

    public function getTheme(): string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): void
    {
        $this->theme = $theme;
    }

    public function getOutputDir(): string
    {
        return $this->outputDir;
    }

    public function setOutputDir(string $outputDir): void
    {
        $this->outputDir = $outputDir;
    }
}
