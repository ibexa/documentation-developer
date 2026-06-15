<?php declare(strict_types=1);

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class MyFeatureEvent extends Event
{
    public function __construct(
        private readonly object $object,
        private readonly string $action
    ) {
    }

    public function getObject(): object
    {
        return $this->object;
    }

    public function getAction(): string
    {
        return $this->action;
    }
}
