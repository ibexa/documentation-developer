<?php

declare(strict_types=1);

namespace EzSystems\Raml2Html\RAML;

use Raml\ParseConfiguration as BaseParseConfiguration;

final class ParserConfiguration extends BaseParseConfiguration
{
    /**
     * Additional non-standard HTTP methods e.g. COPY, MOVE, PUBLISH.
     *
     * @var string[]
     */
    private $nonStandardHttpMethods = [];

    public function getNonStandardHttpMethods(): array
    {
        return $this->nonStandardHttpMethods;
    }

    public function hasNonStandardHttpMethods(): bool
    {
        return !empty($this->nonStandardHttpMethods);
    }

    public function setNonStandardHttpMethods(array $nonStandardHttpMethods): void
    {
        $this->nonStandardHttpMethods = $nonStandardHttpMethods;
    }
}
