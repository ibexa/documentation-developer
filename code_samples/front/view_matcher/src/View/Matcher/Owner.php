<?php

namespace App\View\Matcher;

use eZ\Publish\API\Repository\Repository;
use eZ\Publish\API\Repository\Values\Content\ContentInfo;
use eZ\Publish\API\Repository\Values\Content\Location;
use eZ\Publish\Core\MVC\Symfony\View\ContentValueView;
use eZ\Publish\Core\MVC\Symfony\View\LocationValueView;
use eZ\Publish\Core\MVC\Symfony\View\View;
use eZ\Publish\Core\MVC\Symfony\Matcher\ContentBased\MultipleValued;

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
