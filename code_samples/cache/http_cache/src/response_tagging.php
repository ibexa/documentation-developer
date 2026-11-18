<?php declare(strict_types=1);
use Ibexa\Contracts\Core\Repository\Values\Content\Content;
use Ibexa\Contracts\Core\Repository\Values\Content\Location;
use Ibexa\Contracts\HttpCache\ResponseTagger\ResponseTagger;
use Ibexa\Core\MVC\Symfony\View\ContentValueView;
use Ibexa\Core\MVC\Symfony\View\LocationValueView;

/** @var ResponseTagger $responseTagger */
/** @var ContentValueView|LocationValueView $view */
$responseTagger->tag($view); // When working with a view

/** @var Content $content */
$responseTagger->tag($content->getContentInfo()); // When working with a content item

/** @var Location $location */
$responseTagger->tag($location); // When working with a location
