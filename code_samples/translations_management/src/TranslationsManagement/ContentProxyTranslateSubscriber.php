<?php

declare(strict_types=1);

namespace App\TranslationsManagement\EventSubscriber;

use Ibexa\Contracts\AdminUi\Event\ContentProxyTranslateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class ContentProxyTranslateSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ContentProxyTranslateEvent::class => ['onProxyTranslate', 200],
        ];
    }

    public function onProxyTranslate(ContentProxyTranslateEvent $event): void
    {
        // Read the translation context:
        $event->getContentId();
        $event->getFromLanguageCode(); // ?string — null when no source language is selected
        $event->getToLanguageCode();
        $event->getLocationId();       // ?int — null when the content item isn't published yet

        $url = $this->urlGenerator->generate('your_custom_route', [
            'contentId' => $event->getContentId(),
        ]);

        $event->setResponse(new RedirectResponse($url));
        $event->stopPropagation();
    }
}
