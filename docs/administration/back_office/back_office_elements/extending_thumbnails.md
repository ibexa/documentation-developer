---
description: Customize thumbnails use for content items in the back office.
---

# Extending thumbnails

The thumbnails API enable you to choose an image for a specific content.
If you don't want to use custom thumbnails, `ContentType` is used instead.

## Thumbnail mechanism

The thumbnail mechanism has two layers, and each layer can have many implementations.
The mechanism checks if any of the implementations returns a field, for example, `ezimage`, that has function "Can be a thumbnail" turned on.

![Can be a thumbnail setting](extending_thumbnail_can_be.png)

If found, the image is used as a content type thumbnail.

### First layer

First layer of the mechanism contains strategy pattern that focuses on finding a thumbnail source.
The thumbnail can be found inside or outside the content type.
For example for users thumbnails can be downloaded from an avatar-generating service.

For this layer there are following default implementations:

- The mechanism looks for fields that can be thumbnail, if found, the mechanism moves to the second layer.
- If there are no fields that can be a thumbnail, the content type icon is used as a thumbnail.

### Second layer

Second layer of mechanism enables selection of thumbnail from a field that the first layer has found.
It searches the content type for all the fields, for example, images, with function "Can be a thumbnail" turned on.

If there is more than one field in the content type that can be used as a thumbnail, this layer returns the first nonempty field as a thumbnail.

This mechanism can be modified to fit your site needs, so you can decide from where and how the thumbnails is downloaded.

### Create a thumbnail mechanism

First, create base strategy for returning custom thumbnails from a static file.
Create `StaticStrategy.php` in `src/Strategy`.

```php
[[= include_file('code_samples/back_office/thumbnails/src/Strategy/StaticThumbnailStrategy.php') =]]
```

Next, add the strategy with the `ibexa.repository.thumbnail.strategy.content` tag and `priority: 100` to `config/services.yaml`:

```yaml
[[= include_file('code_samples/back_office/thumbnails/config/custom_services.yaml') =]]
```

Priority `100` allows this strategy to be used first on a clean installation or before any other strategy with lower priority.

At this point you can go to the back office and check the results.

!!! note "Thumbnail mechanism "

    This strategy overrides all generated thumbnails. You can specify a specific content type.
    See the example [here](https://github.com/ibexa/user/blob/4.6/src/lib/Strategy/DefaultThumbnailStrategy.php)


## Other fields as thumbnails

Any field type can generate a thumbnail, for example:

- DateAndTime (`ezdatetime`) - you can add a mini calendar thumbnail for Appointment content type and on the day of the appointment a clock thumbnail with a specific time when it takes place
- TextBlock (`eztext`) -  you can add a first letter of the text block that is inside

### Add eztext field as thumbnail

First, create a strategy that adds support for `eztext` as the thumbnail.
It enables you to add a thumbnail URL in the text field.

Add `FieldValueUrl.php` in `src/Thumbnails`.

```php
<?php

declare(strict_types=1);

namespace App\Thumbnails;

use Ibexa\Contracts\Core\Repository\Values\Content\Field;
use Ibexa\Contracts\Core\Repository\Values\Content\Thumbnail;
use Ibexa\Contracts\Core\Repository\Strategy\ContentThumbnail\Field\FieldTypeBasedThumbnailStrategy;
use Ibexa\Contracts\Core\Repository\Values\Content\VersionInfo;

class FieldValueUrl implements FieldTypeBasedThumbnailStrategy
{
    public function getFieldTypeIdentifier(): string
    {
        return 'eztext';
    }

    public function getThumbnail(Field $field, ?VersionInfo $versionInfo = null): ?Thumbnail
    {
        return new Thumbnail([
            'resource' => $field->value,
        ]);
    }
}
```

Next, add the strategy with the `ibexa.repository.thumbnail.strategy.field` tag to `config/services.yaml`:

```yaml
    App\Thumbnails\FieldValueUrl:
        tags:
            - { name: ibexa.repository.thumbnail.strategy.field, priority: 100 }
```

At this point you can go to the back office and check the results.
