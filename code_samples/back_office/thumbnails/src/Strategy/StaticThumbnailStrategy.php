<?php

declare(strict_types=1);

namespace App\Strategy;

use Ibexa\Contracts\Core\Repository\Strategy\ContentThumbnail\ThumbnailStrategy;
use Ibexa\Contracts\Core\Repository\Values\Content\Thumbnail;
use Ibexa\Contracts\Core\Repository\Values\Content\VersionInfo;
use Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType;

final readonly class StaticThumbnailStrategy implements ThumbnailStrategy
{
    public function __construct(private string $staticThumbnail)
    {
    }

    public function getThumbnail(ContentType $contentType, array $fields, ?VersionInfo $versionInfo = null): ?Thumbnail
    {
        return new Thumbnail([
            'resource' => $this->staticThumbnail,
        ]);
    }
}
