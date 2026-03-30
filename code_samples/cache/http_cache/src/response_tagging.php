<?php declare(strict_types=1);

/** @var \Ibexa\Contracts\HttpCache\ResponseTagger\ResponseTagger $responseTagger */
/** @var \Ibexa\Core\MVC\Symfony\View\ContentValueView|\Ibexa\Core\MVC\Symfony\View\LocationValueView $view */
$responseTagger->tag($view); // When working with a view

/** @var \Ibexa\Contracts\Core\Repository\Values\Content\Content $content */
$responseTagger->tag($content->getContentInfo()); // When working with a content item

/** @var \Ibexa\Contracts\Core\Repository\Values\Content\Location $location */
$responseTagger->tag($location); // When working with a location
