<?php

declare(strict_types=1);

namespace EzSystems\Raml2Html\RAML;

use Raml\Method;
use Raml\Parser;

final class ParserFactory
{
    public function createParser(ParserConfiguration $configuration = null): Parser
    {
        if ($configuration === null) {
            $configuration = $this->getDefaultConfiguration();
        }

        if ($configuration->hasNonStandardHttpMethods()) {
            Method::$validMethods = array_merge(Method::$validMethods, $configuration->getNonStandardHttpMethods());
        }

        $parser = new Parser();
        $parser->setConfiguration($configuration);

        return $parser;
    }

    private function getDefaultConfiguration(): ParserConfiguration
    {
        $configuration = new ParserConfiguration();
        $configuration->enableDirectoryTraversal();

        return $configuration;
    }
}
