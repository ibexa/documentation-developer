<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\AdminUi\Menu\Event\ConfigureMenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class HelpMenuSubscriber implements EventSubscriberInterface
{
    private bool $kernelDebug;

    public function __construct(
        bool $kernelDebug
    ) {
        $this->kernelDebug = $kernelDebug;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'ibexa_integrated_help.menu_configure.help_menu' => 'onHelpMenuConfigure',
        ];
    }

    public function onHelpMenuConfigure(ConfigureMenuEvent $event): void
    {
        $menu = $event->getMenu();

        // Remove roadmap menu item
        if ($menu->getChild('help__general')) {
            $generalSection = $menu->getChild('help__general');
            if ($generalSection->getChild('help__product_roadmap')) {
                $generalSection->removeChild('help__product_roadmap');
            }
        }

        // Add videos tab, shown only in production
        if ($this->kernelDebug === false) {
            $resourcesSection = $menu->addChild('help__videos', [
                'label' => 'Product videos',
            ]);

            $resourcesSection->addChild('help__webinar_v5', [
                'label' => 'Webinar: Introducing Ibexa DXP v5',
                'uri' => 'https://www.youtube.com/watch?v=qWaBHG2LRm8',
                'extras' => [
                    'isHighlighted' => false,
                    'icon' => 'https://doc.ibexa.co/en/5.0/templating/twig_function_reference/img/icons/video.svg.png',
                    'description' => 'Discover new features and improvements brought by Ibexa DXP v5.',
                ],
            ]);
        }
    }
}
