<?php declare(strict_types=1);

namespace App\Rest\Values;

class Greeting
{
    public string $salutation;

    public string $recipient;

    public function __construct(string $salutation = 'Hello', string $recipient = 'World')
    {
        $this->salutation = $salutation;
        $this->recipient = $recipient;
    }
}
