<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SvgExtension extends AbstractExtension
{
    /**
     * SvgExtension constructor.
     */
    public function __construct(protected RouterInterface $router)
    {
    }

    /**
     * @return \Twig\TwigFunction[]
     */
    #[\Override]
    public function getFunctions(): array
    {
        return [
            new TwigFunction('ibexa_svg_link', $this->generateLink(...)),
        ];
    }

    public function generateLink(int $contentId, string $fieldIdentifier, string $filename): string
    {
        return $this->router->generate('app.svg_download', [
            'contentId' => $contentId,
            'fieldIdentifier' => $fieldIdentifier,
            'filename' => $filename,
        ]);
    }
}
