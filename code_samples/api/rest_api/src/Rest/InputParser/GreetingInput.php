<?php

namespace App\Rest\InputParser;

use App\Rest\Values\Greeting;
use Ibexa\Contracts\Rest\Input\ParsingDispatcher;
use Ibexa\Rest\Input\BaseParser;
use Ibexa\Rest\Server\Exceptions;

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
