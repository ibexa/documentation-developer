<?php declare(strict_types=1);

namespace App\Rest\Values;

class Greeting
{
    public function __construct(
        public string $salutation = 'Hello',
        public string $recipient = 'World'
    ) {
    }
}
