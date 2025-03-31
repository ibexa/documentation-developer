<?php declare(strict_types=1);

namespace App\Rest\Controller;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Factory\OpenApiFactory;
use ApiPlatform\OpenApi\Model;
use App\Rest\Values\Greeting;
use Ibexa\Rest\Server\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[Post(
    uriTemplate: '/greet',
    extraProperties: [OpenApiFactory::OVERRIDE_OPENAPI_RESPONSES => false],
    openapi: new Model\Operation(
        summary: 'Greet',
        description: 'Greets a recipient with a salutation',
        tags: [
            'App',
        ],
        parameters: [
            new Model\Parameter(
                name: 'Content-Type',
                in: 'header',
                required: false,
                description: 'The greeting input schema encoded in XML or JSON.',
                schema: [
                    'type' => 'string',
                ],
            ),
            new Model\Parameter(
                name: 'Accept',
                in: 'header',
                required: true,
                description: 'If set, the greeting is returned in XML or JSON format.',
                schema: [
                    'type' => 'string',
                ],
            ),
        ],
        requestBody: new Model\RequestBody(
            required: false,
            content: new \ArrayObject([
                'application/vnd.ibexa.api.GreetingInput+xml' => [
                    'schema' => [
                        'type' => 'object',
                        'xml' => [
                            'name' => 'GreetingInput',
                            'wrapped' => false,
                        ],
                        'properties' => [
                            'salutation' => [
                                'type' => 'string',
                                'required' => false,
                            ],
                            'recipient' => [
                                'type' => 'string',
                                'required' => false,
                            ],
                        ],
                    ],
                    'example' => [
                        'salutation' => 'Good morning',
                    ],
                ],
                'application/vnd.ibexa.api.GreetingInput+json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'GreetingInput' => [
                                'type' => 'object',
                                'properties' => [
                                    'salutation' => [
                                        'type' => 'string',
                                        'required' => false,
                                    ],
                                    'recipient' => [
                                        'type' => 'string',
                                        'required' => false,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'example' => [
                        'GreetingInput' => [
                            'salutation' => 'Good day',
                            'recipient' => 'Earth',
                        ],
                    ],
                ],
            ]),
        ),
        responses: [
            Response::HTTP_OK => [
                'description' => 'OK - Return a greeting',
                'content' => [
                    'application/vnd.ibexa.api.Greeting+xml' => [
                        'schema' => [
                            'xml' => [
                                'name' => 'Greeting',
                                'wrapped' => false,
                            ],
                            'properties' => [
                                'salutation' => [
                                    'type' => 'string',
                                ],
                                'recipient' => [
                                    'type' => 'string',
                                ],
                                'sentence' => [
                                    'type' => 'string',
                                    'description' => 'Composed sentence using salutation and recipient.'
                                ]
                            ],
                        ],
                        'example' => [
                            'salutation' => 'Good morning',
                            'recipient' => 'World',
                            'sentence' => 'Good Morning World',
                        ],
                    ],
                    'application/vnd.ibexa.api.Greeting+json' => [
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'Greeting' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'salutation' => [
                                            'type' => 'string',
                                        ],
                                        'recipient' => [
                                            'type' => 'string',
                                        ],
                                        'sentence' => [
                                            'type' => 'string',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'example' => [
                            'Greeting' => [
                                'salutation' => 'Good day',
                                'recipient' => 'Earth',
                                'sentence' => 'Good day Earth',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ),
)]
class DefaultController extends Controller
{
    public const DEFAULT_FORMAT = 'xml';

    public const AVAILABLE_FORMATS = ['json', 'xml'];

    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function greet(Request $request): Response//Greeting
    {
        $contentType = $request->headers->get('Content-Type');
        if ($contentType) {
            preg_match('@.*[/+](?P<format>[^/+]+)@', $contentType, $matches);
            $format = empty($matches['format']) ? self::DEFAULT_FORMAT : $matches['format'];
            $input = $request->getContent();
            $greeting = $this->serializer->deserialize($input, Greeting::class, $format);
        } else {
            $greeting = new Greeting();
        }

        $accept = $request->headers->get('Accept', 'application/' . self::DEFAULT_FORMAT);
        preg_match('@.*[/+](?P<format>[^/+]+)@', $accept, $matches);
        $format = empty($matches['format']) ? self::DEFAULT_FORMAT : $matches['format'];
        if (!in_array($format, self::AVAILABLE_FORMATS)) {
            $format = self::DEFAULT_FORMAT;
        }

        //return $greeting;

        $serialized = $this->serializer->serialize($greeting, $format, [
            XmlEncoder::ROOT_NODE_NAME => substr(strrchr(get_class($greeting), '\\'), 1),
        ]);

        return new Response($serialized, Response::HTTP_OK, ['Content-Type' => "application/vnd.ibexa.api.Greeting+$format"]);
    }
}
