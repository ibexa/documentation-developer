<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Component\Routing\RouterInterface;
use Twig\Attribute\AsTwigFunction;

class SvgExtension
{
    /**
     * SvgExtension constructor.
     */
    public function __construct(protected RouterInterface $router)
    {
    }

    #[AsTwigFunction(name: 'ibexa_svg_link')]
    public function generateLink(int $contentId, string $fieldIdentifier, string $filename): string
    {
        return $this->router->generate('app.svg_download', [
            'contentId' => $contentId,
            'fieldIdentifier' => $fieldIdentifier,
            'filename' => $filename,
        ]);
    }
}
