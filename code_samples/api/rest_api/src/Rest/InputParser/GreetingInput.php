<?php declare(strict_types=1);

namespace App\Rest\InputParser;

use App\Rest\Values\Greeting;
use Ibexa\Contracts\Rest\Exceptions;
use Ibexa\Contracts\Rest\Input\ParsingDispatcher;
use Ibexa\Rest\Input\BaseParser;

class GreetingInput extends BaseParser
{
    public function parse(array $data, ParsingDispatcher $parsingDispatcher): Greeting
    {
        if (!isset($data['Salutation'])) {
            throw new Exceptions\Parser("Missing or invalid 'Salutation' element for Greeting.");
        }

        return new Greeting($data['Salutation'], $data['Recipient'] ?? 'World');
    }
}
