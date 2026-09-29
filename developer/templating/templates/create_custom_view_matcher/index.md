# Create custom view matcher

You can create custom view matchers to configure template and controller usage for specific custom cases.

In addition to the [built-in view matchers](../view_matcher_reference/index.md), you can also create custom matchers to use in [template configuration](../template_configuration/index.md#view-rules-and-matching).

To do it, create a matcher class that implements `Ibexa\Core\MVC\Symfony\Matcher\ContentBased\MatcherInterface`.

## Matcher class

The matcher class must implement the following methods:

- `matchLocation` - checks if a location object matches.
- `matchContentInfo` - checks if a ContentInfo object matches.
- `match` - checks if the View object matches.
- `setMatchingConfig` - receives the matcher's config from the view rule.

The following example shows how to implement an `Owner` matcher. This matcher identifies content items that have the provided owner or owners.

```php
<?php declare(strict_types=1);

namespace App\View\Matcher;

use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo;
use Ibexa\Contracts\Core\Repository\Values\Content\Location;
use Ibexa\Core\MVC\Symfony\Matcher\ContentBased\MatcherInterface;
use Ibexa\Core\MVC\Symfony\View\ContentValueView;
use Ibexa\Core\MVC\Symfony\View\LocationValueView;
use Ibexa\Core\MVC\Symfony\View\View;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

class Owner implements MatcherInterface
{
    /** @var string[] */
    private array $matchingUserLogins;

    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException
     */
    public function matchLocation(Location $location): bool
    {
        return $this->hasOwner($location->getContentInfo());
    }

    /**
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException
     */
    public function matchContentInfo(ContentInfo $contentInfo): bool
    {
        return $this->hasOwner($contentInfo);
    }

    /**
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException
     */
    public function match(View $view): ?bool
    {
        if ($view instanceof LocationValueView) {
            return $this->matchLocation($view->getLocation());
        }

        if ($view instanceof ContentValueView) {
            return $this->matchContentInfo($view->getContent()->contentInfo);
        }

        return false;
    }

    /**
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException
     */
    private function hasOwner(ContentInfo $contentInfo): bool
    {
        $owner = $this->userService->loadUser($contentInfo->ownerId);

        return in_array($owner->login, $this->matchingUserLogins, true);
    }

    /**
     * @param array<string> $matchingConfig
     */
    public function setMatchingConfig($matchingConfig): void
    {
        if (!is_array($matchingConfig)) {
            throw new InvalidArgumentException('App\Owner view matcher configuration has to be an array');
        }

        $this->matchingUserLogins = $matchingConfig;
    }
}
```

The matcher checks whether the owner of the current content (by its ContentInfo or location) matches any of the values passed in configuration.

## Matcher service

You configure your matcher as a service, tag it `ibexa.view.matcher`, and associate it with the identifier to use in view rules:

```yaml
services:
    App\View\Matcher\Owner:
        autowire: true
        tags:
            - { name: ibexa.view.matcher, identifier: App\Owner }
```

## View configuration

To apply the matcher in view configuration, indicate the matcher by its identifier.

The following configuration uses a special template to render articles owned by the users with provided logins:

```yaml
ibexa_design_engine:
    design_list:
        my_design: [ my_theme ]

ibexa:
    system:
        site_group:
            design: my_design
            content_view:
                full:
                    editor_articles:
                        template: '@ibexadesign/full/featured_article.html.twig'
                        match:
                            Identifier\ContentType: article
                            App\Owner: [johndoe, janedoe]
```

> **Note: Note**
>
> If you use a matcher that is a service instead of a simple class, tag the service with `ibexa.view.matcher`.
