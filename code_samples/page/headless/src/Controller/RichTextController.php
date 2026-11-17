<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\Contracts\FieldTypeRichText\RichText\Converter as RichTextConverterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RichTextController extends AbstractController
{
    public function __construct(private readonly RichTextConverterInterface $richTextOutputConverter)
    {
    }

    /**
     * Convert RichText DocBook XML into HTML 5.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/richtext-to-html5')]
    public function richTextToHtml5(Request $request): Response
    {
        $xml = new \DOMDocument();
        $xml->loadXML($request->getContent());

        return new Response($this->richTextOutputConverter->convert($xml)->saveHTML());
    }
}
