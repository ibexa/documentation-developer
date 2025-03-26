<?php declare(strict_types=1);

namespace App\Rest\Controller;

use ApiPlatform\Metadata\Get;
use ApiPlatform\OpenApi\Factory\OpenApiFactory;
use ApiPlatform\OpenApi\Model;
use App\Rest\Values\Greeting;
use Ibexa\Rest\Server\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Get(
    uriTemplate: '/greet',
    extraProperties: [OpenApiFactory::OVERRIDE_OPENAPI_RESPONSES => false],
    openapi: new Model\Operation(
        summary: 'TODO: Greet',
        description: 'TODO',
        tags: [
            'User',
        ],
        responses: [
            Response::HTTP_OK => [
                'description' => 'TODO',
            ],
        ],
    ),
)]
class DefaultController extends Controller
{
    public function greet(Request $request): Greeting
    {
        return new Greeting();
        //return new Response('TEST');
    }
}
