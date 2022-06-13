<?php

namespace App\Rest\Controller;

use App\Rest\Values\Greeting;
use Ibexa\Rest\Message;
use Ibexa\Rest\Server\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function greet(Request $request): Greeting
    {
        if ('POST' === $request->getMethod()) {
            return $this->inputDispatcher->parse(
                new Message(
                    ['Content-Type' => $request->headers->get('Content-Type')],
                    $request->getContent()
                )
            );
        }

        return new Greeting();
    }
}
