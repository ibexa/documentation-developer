<?php declare(strict_types=1);

namespace App\View\Matcher;

use Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo;
use Ibexa\Contracts\Core\Repository\Values\Content\Location;
use Ibexa\Core\MVC\Symfony\Matcher\ContentBased\MultipleValued;
use Ibexa\Core\MVC\Symfony\View\ContentValueView;
use Ibexa\Core\MVC\Symfony\View\LocationValueView;
use Ibexa\Core\MVC\Symfony\View\View;

class Owner extends MultipleValued
{
    public function matchLocation(Location $location)
    {
        return $this->hasOwner($location->getContentInfo());
    }

    public function matchContentInfo(ContentInfo $contentInfo)
    {
        return $this->hasOwner($contentInfo);
    }

    public function match(View $view): ?bool
    {
        $location = null;

        if ($view instanceof LocationValueView) {
            return $this->matchLocation($view->getLocation());
        }

        if ($view instanceof ContentValueView) {
            return $this->matchContentInfo($view->getContent()->contentInfo);
        }

        return false;
    }

    private function hasOwner(ContentInfo $contentInfo): bool
    {
        $owner = $this->getRepository()->getUserService()->loadUser($contentInfo->ownerId);

        if (\array_key_exists($owner->login, $this->values)) {
            return true;
        }

        return false;
    }
}
