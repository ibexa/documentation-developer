# Step 4 - Creating a custom block

!!! tip

    You can find all files used and modified in this step on [GitHub](https://github.com/ezsystems/ezstudio-beginner-tutorial/tree/v2-master).

The last of the planned Page elements is to create a custom block.
The custom block will display a randomly chosen Content item from a selected folder.

To create a custom block from scratch you need four elements:

- block configuration
- a template
- a listener
- the listener registered as a service

### Block configuration

In `app/config/layouts.yml` add the following block under the `blocks` key:

``` yaml hl_lines="10"
blocks:
    random:
        name: Random block
        thumbnail: assets/images/blocks/random_block.svg
        views:
            random:
                template: blocks/random/default.html.twig
                name: Random Content Block View
        attributes:
            parent:
                type: embed
                name: Parent
                validators:
                    not_blank:
                        message: You must provide value
                    regexp:
                        options:
                            pattern: '/[0-9]+/'
                        message: Choose a Content item
```

This configuration defines one attribute, `parent`. You will use it to select the folder containing tips.

### Block template

You also need to create the block template, `app/Resources/views/blocks/random/default.html.twig`:

``` html+twig
<div class="row random-block">
    <h4 class="text-right">{{ 'Tip of the Day'|trans }}</h4>
    <h5>{{ ez_content_name(randomContent) }}</h5>
    <div class="random-block-text">
        {{ ez_render_field(randomContent, 'body') }}
    </div>
</div>
```

### Block listener

Block listener provides the logic for the block. It is contained in `src/AppBundle/Event/RandomBlockListener.php`:

``` php
<?php

declare(strict_types=1);

namespace AppBundle\Event;

use eZ\Publish\API\Repository\Values\Content\Location;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\BlockRenderEvents;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\Event\PreRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\SearchService;

class RandomBlockListener implements EventSubscriberInterface
{
/** @var \eZ\Publish\API\Repository\ContentService */
private $contentService;

/** @var \eZ\Publish\API\Repository\LocationService */
private $locationService;

/** @var \eZ\Publish\API\Repository\SearchService */
private $searchService;

/**
 * @param \eZ\Publish\API\Repository\ContentService $contentService
 * @param \eZ\Publish\API\Repository\LocationService $locationService
 * @param \eZ\Publish\API\Repository\SearchService $searchService
 */
public function __construct(
    ContentService $contentService,
    LocationService $locationService,
    SearchService $searchService
) {
    $this->contentService = $contentService;
    $this->locationService = $locationService;
    $this->searchService = $searchService;
}

/**
 * @return array The event names to listen to
 */
public static function getSubscribedEvents()
{
    return [
        BlockRenderEvents::getBlockPreRenderEventName('random') => 'onBlockPreRender',
    ];
}

/**
 * @param \EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\Event\PreRenderEvent $event
 *
 * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
 * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException
 * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
 */
public function onBlockPreRender(PreRenderEvent $event): void
{
    $blockValue = $event->getBlockValue();
    $renderRequest = $event->getRenderRequest();

    $parameters = $renderRequest->getParameters();

    $contentIdAttribute = $blockValue->getAttribute('parent');
    $location = $this->loadLocationByContentId((int) $contentIdAttribute->getValue());
    $contents = $this->findContentItems($location);
    shuffle($contents);

    $parameters['randomContent'] = reset($contents);

    $renderRequest->setParameters($parameters);
}

/**
 * @param Location $location
 *
 * @return \eZ\Publish\API\Repository\Values\Content\Content[]
 *
 * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
 */
private function findContentItems(Location $location): array
{
    $query = new Query();
    $query->query = new Criterion\LogicalAnd(
        [
            new Criterion\ParentLocationId($location->id),
            new Criterion\Visibility(Criterion\Visibility::VISIBLE),
        ]
    );

    $searchHits = $this->searchService->findContent($query)->searchHits;

    $contentArray = [];
    foreach ($searchHits as $searchHit) {
        $contentArray[] = $searchHit->valueObject;
    }

    return $contentArray;
}

    /**
     * @param int $contentId
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Location
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
     */
    private function loadLocationByContentId(int $contentId): Location
    {
        $contentInfo = $this->contentService->loadContentInfo($contentId);

        return $this->locationService->loadLocation($contentInfo->mainLocationId);
    }
}
```

### Add the listener to services

Finally, you need to add the listener as a service. Add the following configuration to `app/config/services.yml` under the `services` key:

``` yaml
services:
    AppBundle\Event\RandomBlockListener:
        tags:
            - { name: kernel.event_subscriber }
```

At this point the new custom block is ready to be used.

You're left with the last cosmetic changes. First, the new Block has a broken icon in the Elements menu in Page mode.
This is because you haven't provided this icon yet. If you look back to the YAML configuration, you can see the icon file defined as `random_block.svg` (line 4). Download [the provided file](img/enterprise_tut_random_block.svg) and place it in `web/assets/images/blocks`.

Finally, add some styling for the new block. Add the following to the end of the `web/assets/css/style.css` file:

``` css
/* Random block */
.random-block {
    border: 1px solid #83705a;
    border-radius: 5px;
    padding: 0 25px 25px 25px;
    margin-top: 15px;
}

.random-block h4 {
    font-variant: small-caps;
    font-size: .8em;
}

.random-block h5 {
    font-size: 1.2em;
}

.random-block-text {
    font-size: .85em;
}
```

Go back to editing the Front Page. Drag a Random Block from the Elements menu on the right to the Page's side column.
Access the block's settings and choose the "All Tips" folder from the menu. Save and publish all the changes.

Refresh the home page. The Tip of the Day block will display a random Tip from the "Tips" folder.
Refresh the page a few more times and you will see the tip change randomly.

![Random Block with a Tip](img/enterprise_tut_random_block.png "Random Block with a Tip")

### Congratulations!

You have finished the tutorial and created your first customized Page.

You have learned how to:

- Create and customize a Page
- Make use of existing blocks and adapt them to your needs
- Plan content airtimes using the Content Scheduler block
- Create custom blocks

![Final result of the tutorial](img/enterprise_tut_main_screen.png "Final result of the tutorial")
