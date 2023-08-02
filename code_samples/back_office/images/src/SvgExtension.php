<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SvgExtension extends AbstractExtension
{
    /** @var \Symfony\Component\Routing\RouterInterface */
    protected $router;

    /**
     * SvgExtension constructor.
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('ibexa_svg_link', [
                $this,
                'generateLink',
            ]),
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
