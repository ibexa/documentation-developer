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
    private UserService $userService;

    /** @var string[] */
    private array $matchingUserLogins;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
