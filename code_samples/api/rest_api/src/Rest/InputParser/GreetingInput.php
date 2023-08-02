<?php declare(strict_types=1);

namespace App\Rest\InputParser;

use App\Rest\Values\Greeting;
use EzSystems\EzPlatformRest\Exceptions;
use EzSystems\EzPlatformRest\Input\BaseParser;
use EzSystems\EzPlatformRest\Input\ParsingDispatcher;

class GreetingInput extends BaseParser
{
    public function parse(array $data, ParsingDispatcher $parsingDispatcher)
    {
        if (!isset($data['Salutation'])) {
            throw new Exceptions\Parser("Missing or invalid 'Salutation' element for Greeting.");
        }

        return new Greeting($data['Salutation'], $data['Recipient'] ?? 'World');
    }
}
