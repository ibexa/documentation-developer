<?php

declare(strict_types=1);

namespace EzSystems\Raml2Html\Command;

use EzSystems\Raml2Html\RAML\ParserConfiguration;
use EzSystems\Raml2Html\RAML\ParserFactory;
use Raml\ApiDefinition;
use Raml\Body;
use Raml\Resource;
use Raml\TypeInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class LintTypesCommand extends Command
{
    private const OPTION_NON_STANDARD_HTTP_METHODS = 'non-standard-http-methods';

    /** @var \EzSystems\Raml2Html\RAML\ParserFactory */
    private $ramlParserFactory;

    /** @var string[] */
    private $nonExisting = [];

    public function __construct(ParserFactory $ramlParserFactory)
    {
        parent::__construct();
        $this->ramlParserFactory = $ramlParserFactory;
    }

    protected function configure(): void
    {
        $this->setName('lint:types');
        $this->addArgument('definition');

        $this->addOption(self::OPTION_NON_STANDARD_HTTP_METHODS, null, InputOption::VALUE_OPTIONAL, 'Non standard HTTP methods');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $ramlParser = $this->ramlParserFactory->createParser(
            $this->createParserConfigurationFromInput($input)
        );

        $this->lintTypes($ramlParser->parse($input->getArgument('definition')));

        $nonExisting = array_unique($this->nonExisting);
        foreach ($nonExisting as $typeName) {
            $output->writeln($typeName);
        }
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

    private function lintTypes(ApiDefinition $definition, iterable $resources = null)
    {
        if ($resources === null) {
            $resources = $definition->getResources();
        }

        /** @var resource $resource */
        foreach ($resources as $resource) {
            foreach ($resource->getMethods() as $method) {
                foreach ($method->getBodies() as $body) {
                    if (!$body instanceof Body) {
                        continue;
                    }

                    $this->doCheckType($definition, $body->getType());
                }
            }

            foreach ($method->getResponses() as $response) {
                foreach ($response->getBodies() as $body) {
                    if (!$body instanceof Body) {
                        continue;
                    }

                    $this->doCheckType($definition, $body->getType());
                }
            }

            $this->lintTypes($definition, $resource->getResources());
        }
    }

    private function doCheckType(ApiDefinition $definition, TypeInterface $needle): void
    {
        if (!$this->exists($definition, $needle)) {
            $this->nonExisting[] = $needle->getName();
        }
    }

    private function exists(ApiDefinition $definition, TypeInterface $needle): bool
    {
        foreach ($definition->getTypes() as $type) {
            if ($type->getName() == $needle->getName()) {
                return true;
            }
        }

        return false;
    }
}
