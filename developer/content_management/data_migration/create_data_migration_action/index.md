# Create data migration action

Create a custom action to use while performing data migration.

To create an [action](../data_migration_actions/index.md) that is performed after a migration step, you need:

- An action class, to store any additional data that you might require.
- An action denormalizer, to convert YAML definition into your action class.
- An action executor, to handle the action.

The following example shows how to create an action that assigns a content item to a Section.

First, create an action class, in `src/Migrations/Action/AssignSection.php`:

```php
<?php

declare(strict_types=1);

namespace App\Migrations\Action;

use Ibexa\Migration\ValueObject\Step\Action;

final readonly class AssignSection implements Action
{
    public const string TYPE = 'assign_section';

    public function __construct(private string $sectionIdentifier)
    {
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->sectionIdentifier;
    }

    public function getSupportedType(): string
    {
        return self::TYPE;
    }
}
```

Then you need a denormalizer to convert data that comes from YAML into an action object, in `src/Migrations/Action/AssignSectionDenormalizer.php`:

```php
<?php

declare(strict_types=1);

namespace App\Migrations\Action;

use Ibexa\Contracts\Migration\Serializer\Denormalizer\AbstractActionDenormalizer;
use Webmozart\Assert\Assert;

final class AssignSectionDenormalizer extends AbstractActionDenormalizer
{
    protected function supportsActionName(string $actionName, ?string $format = null): bool
    {
        return $actionName === AssignSection::TYPE;
    }

    /**
     * @param array<mixed> $data
     * @param string $type
     * @param string|null $format
     * @param array<mixed> $context
     *
     * @return \App\Migrations\Action\AssignSection
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = []): AssignSection
    {
        Assert::keyExists($data, 'value');

        return new AssignSection($data['value']);
    }
}
```

Then, tag the action denormalizer so it's recognized by the serializer used for migrations.

```yaml
services:
    App\Migrations\Action\AssignSectionDenormalizer:
        autoconfigure: false
        tags:
            - { name: 'ibexa.migrations.serializer.normalizer' }
```

And finally, add an executor to perform the action, in `src/Migrations/Action/AssignSectionExecutor.php`:

```php
<?php declare(strict_types=1);

namespace App\Migrations\Action;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\SectionService;
use Ibexa\Contracts\Core\Repository\Values\ValueObject as APIValueObject;
use Ibexa\Migration\StepExecutor\ActionExecutor\ExecutorInterface;
use Ibexa\Migration\ValueObject;

final readonly class AssignSectionExecutor implements ExecutorInterface
{
    public function __construct(
        private ContentService $contentService,
        private SectionService $sectionService
    ) {
    }

    /**
     * @param \App\Migrations\Action\AssignSection $action
     * @param \Ibexa\Contracts\Core\Repository\Values\Content\Content $content
     */
    public function handle(ValueObject\Step\Action $action, APIValueObject $content): void
    {
        $contentInfo = $this->contentService->loadContentInfo($content->id);
        $section = $this->sectionService->loadSectionByIdentifier($action->getValue());
        $this->sectionService->assignSection($contentInfo, $section);
    }
}
```

Tag the executor with `ibexa.migrations.executor.action.<type>` tag, where `<type>` is the "type" of the step that executor works with (for example, `content`, `content_type`, or `location`). The tag has to have a `key` property with the action type.

```yaml
    App\Migrations\Action\AssignSectionExecutor:
        tags:
            - { name: 'ibexa.migrations.executor.action.content', key: !php/const App\Migrations\Action\AssignSection::TYPE }
```
