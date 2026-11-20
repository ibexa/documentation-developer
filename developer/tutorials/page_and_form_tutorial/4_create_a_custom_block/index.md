# Step 4 — Create a custom block

Try creating a custom page block with specific logic.

Editions: Experience

This step guides you through creating a custom block. The custom block displays a randomly chosen content item from a selected folder.

To create a custom block from scratch you need four elements:

- block configuration
- a template
- a listener
- the listener registered as a service

## Block configuration

In `config/packages/ibexa_fieldtype_page.yaml` add the following block under the `blocks` key:

```yaml
        random:
            name: Random block
            thumbnail: /assets/images/blocks/random_block.svg#random
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
                            message: Choose a content item
```

This configuration defines one attribute, `parent`. Use it to select the folder containing tips.

## Block template

You also need to create the block template, `templates/blocks/random/default.html.twig`:

```html+twig
<div class="row random-block">
    <h4 class="text-right">{{ 'Tip of the Day'|trans }}</h4>
    <h5>{{ ibexa_content_name(randomContent) }}</h5>
    <div class="random-block-text">
        {{ ibexa_render_field(randomContent, 'body') }}
    </div>
</div>
```

## Block listener

Block listener provides the logic for the block. It's contained in `src/Event/RandomBlockListener.php`:

```php
<?php

declare(strict_types=1);

namespace App\Event;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\Location;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\BlockRenderEvents;
use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\Event\PreRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RandomBlockListener implements EventSubscriberInterface
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly LocationService $locationService,
        private readonly SearchService $searchService
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BlockRenderEvents::getBlockPreRenderEventName('random') => 'onBlockPreRender',
        ];
    }

    public function onBlockPreRender(PreRenderEvent $event): void
    {
        $blockValue = $event->getBlockValue();
        /** @var \Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\Twig\TwigRenderRequest $renderRequest */
        $renderRequest = $event->getRenderRequest();

        $parameters = $renderRequest->getParameters();

        $contentIdAttribute = $blockValue->getAttribute('parent');
        $location = $this->loadLocationByContentId((int) $contentIdAttribute->getValue());
        $contents = $this->findContentItems($location);
        shuffle($contents);

        $parameters['randomContent'] = reset($contents);

        $renderRequest->setParameters($parameters);
    }

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

    private function loadLocationByContentId(int $contentId): Location
    {
        $contentInfo = $this->contentService->loadContentInfo($contentId);

        return $this->locationService->loadLocation($contentInfo->mainLocationId);
    }
}
```

At this point the new custom block is ready to be used.

You're left with the last cosmetic changes. First, the new Block has a broken icon in the **Page blocks** toolbox in page mode. This is because you haven't provided this icon yet. If you look back to the YAML configuration, you can see the icon file defined as `random_block.svg` (line 4). Download [the provided file](https://github.com/ibexa/documentation-developer/blob/5.0/code_samples/tutorials/page_tutorial_starting_point/public/assets/images/blocks/random_block.svg) and place it in `public/assets/images/blocks`.

Finally, add some styling for the new block. Add the following to the end of the `assets/css/style.css` file:

```css
/* Random block */
.random-block {
    border: 1px solid #83705a;
    border-radius: 5px;
    padding: 0 25px 25px 25px;
    margin-top: 15px;
}

.random-block h4 {
    font-variant: small-caps;
    font-size: 1.2em;
}

.random-block h5 {
    font-size: 1.2em;
}

.random-block-text {
    font-size: .85em;
}
```

Run `yarn encore <dev|prod>` to regenerate assets.

Go back to editing the front page. Drag a Random Block from the **Page blocks** toolbox on the right to the page's side column. Access the block's settings and choose the "All Tips" folder from the menu. Save and publish all the changes.

Refresh the home page. The Tip of the Day block displays a random Tip from the "Tips" folder. Refresh the page a few more times and you can see the tip change randomly.

![Random Block with a Tip](https://doc.ibexa.co/en/5.0/tutorials/page_and_form_tutorial/img/enterprise_tut_random_block.png "Random Block with a Tip")

To learn more about custom Page Builder blocks, see [Create custom page block](../../../content_management/pages/create_custom_page_block/index.md).
