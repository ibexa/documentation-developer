<?php

declare(strict_types=1);

namespace App\TranslationsManagement;

use Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo;
use Ibexa\Contracts\TranslationsManagement\SideBySide\Service\SideBySideExclusionRuleInterface;

final class MyCustomExclusionRule implements SideBySideExclusionRuleInterface
{
    public function isExcluded(ContentInfo $contentInfo): bool
    {
        return $contentInfo->getContentType()->identifier === 'my_excluded_type';
    }
}
