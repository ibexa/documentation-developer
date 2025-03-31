<?php declare(strict_types=1);

namespace App\Rest\Controller;

use ApiPlatform\Metadata\Get;
use ApiPlatform\OpenApi\Factory\OpenApiFactory;
use ApiPlatform\OpenApi\Model;
use App\Rest\Values\Greeting;
use Ibexa\Rest\Server\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\SerializerInterface;

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
    public const DEFAULT_FORMAT = 'xml';

    public const AVAILABLE_FORMATS = ['json', 'xml'];

    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function greet(Request $request): Response//Greeting
    {
        //$this->serializer->deserialize($request->getContent())
        $salutation = 'Salut';
        $recipient = 'Monde';

        $accept = $request->headers->get('Accept', 'application/' . self::DEFAULT_FORMAT);
        preg_match('@.*[/+](?P<format>[^/+]+)@', $accept, $matches);
        $format = empty($matches['format']) ? self::DEFAULT_FORMAT : $matches['format'];
        if (!in_array($format, self::AVAILABLE_FORMATS)) {
            $format = self::DEFAULT_FORMAT;
        }

        $greeting = new Greeting($salutation, $recipient);

        //return $greeting;

        $serialized = $this->serializer->serialize($greeting, $format, [
            XmlEncoder::ROOT_NODE_NAME => substr(strrchr(get_class($greeting), '\\'), 1),
        ]);

        return new Response($serialized, Response::HTTP_OK);
    }
}
