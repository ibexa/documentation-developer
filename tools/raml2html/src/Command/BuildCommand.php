<?php

declare(strict_types=1);

namespace EzSystems\Raml2Html\Command;

use EzSystems\Raml2Html\Generator\Generator;
use EzSystems\Raml2Html\Generator\GeneratorOptions;
use EzSystems\Raml2Html\RAML\ParserFactory;
use EzSystems\Raml2Html\RAML\ParserConfiguration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class BuildCommand extends Command
{
    private const OPTION_THEME = 'theme';
    private const OPTION_OUTPUT_DIR = 'output';
    private const OPTION_NON_STANDARD_HTTP_METHODS = 'non-standard-http-methods';

    /** @var \Raml\Parser */
    private $ramlParserFactory;

    /** @var \EzSystems\Raml2Html\Generator\Generator */
    private $generator;

    /**
     * @param \EzSystems\Raml2Html\Generator\Generator $generator
     * @param \EzSystems\Raml2Html\RAML\ParserFactory $ramlParserFactory
     */
    public function __construct(Generator $generator, ParserFactory $ramlParserFactory)
    {
        parent::__construct();

        $this->generator = $generator;
        $this->ramlParserFactory = $ramlParserFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('build');
        $this->addArgument('definition');
        $this->addOption(self::OPTION_THEME, 't', InputOption::VALUE_REQUIRED, 'Theme', 'default');
        $this->addOption(self::OPTION_OUTPUT_DIR, 'o', InputOption::VALUE_REQUIRED, 'Output directory', getcwd());
        $this->addOption(self::OPTION_NON_STANDARD_HTTP_METHODS, null, InputOption::VALUE_OPTIONAL, 'Non standard HTTP methods');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $ramlParser = $this->ramlParserFactory->createParser(
            $this->createParserConfigurationFromInput($input)
        );

        $this->generator->generate(
            $ramlParser->parse($input->getArgument('definition')),
            $this->createGeneratorOptionsFromInput($input)
        );

        return 0;
    }

    private function createParserConfigurationFromInput(InputInterface $input): ParserConfiguration
    {
        $configuration = new ParserConfiguration();

        $nonStandardHTTPMethods = $input->getOption(self::OPTION_NON_STANDARD_HTTP_METHODS);
        if ($nonStandardHTTPMethods !== null) {
            $configuration->setNonStandardHttpMethods(explode(',', $nonStandardHTTPMethods));
        }

        return $configuration;
    }

    private function createGeneratorOptionsFromInput(InputInterface $input): GeneratorOptions
    {
        $generatorOptions = new GeneratorOptions();
        $generatorOptions->setOutputDir($input->getOption(self::OPTION_OUTPUT_DIR));
        $generatorOptions->setTheme($input->getOption(self::OPTION_THEME));

        return $generatorOptions;
    }
}
