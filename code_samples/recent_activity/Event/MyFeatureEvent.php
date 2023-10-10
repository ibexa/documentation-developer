<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class MyFeatureEvent extends Event
{
    private object $object;

    private string $action;

    public function __construct(object $object, string $action)
    {
        $this->object = $object;
        $this->action = $action;
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
