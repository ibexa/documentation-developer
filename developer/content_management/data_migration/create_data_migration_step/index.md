# Create data migration step

Create a custom step for data migrations.

Besides the [built-in migrations steps](../importing_data/index.md#available-migrations), you can also create custom ones.

To create a custom migration step, you need:

- A step class, to store any additional data that you might require.
- A step normalizer, to convert YAML definition into your step class.
- A step executor, to handle the step.

The following example shows how to create a step that replaces all `ibexa_string` fields that have an old company name with "New Company Name".

## Create step class

First, create a step class, in `src/Migrations/Step/ReplaceNameStep.php`:

```php
<?php

declare(strict_types=1);

namespace App\Migrations\Step;

use Ibexa\Migration\ValueObject\Step\StepInterface;

final readonly class ReplaceNameStep implements StepInterface
{
    private string $replacement;

    public function __construct(?string $replacement = null)
    {
        $this->replacement = $replacement ?? 'New Company Name';
    }

    public function getReplacement(): string
    {
        return $this->replacement;
    }
}
```

## Create normalizer

Then you need a normalizer to convert data that comes from YAML into a step object, in `src/Migrations/Step/ReplaceNameStepNormalizer.php`:

```php
<?php

declare(strict_types=1);

namespace App\Migrations\Step;

use Ibexa\Contracts\Migration\Serializer\AbstractStepNormalizer;
use Ibexa\Migration\ValueObject\Step\StepInterface;

/**
 * @extends \Ibexa\Contracts\Migration\Serializer\AbstractStepNormalizer<\App\Migrations\Step\ReplaceNameStep>
 */
final class ReplaceNameStepNormalizer extends AbstractStepNormalizer
{
    protected function normalizeStep(
        StepInterface $object,
        ?string $format = null,
        array $context = []
    ): array {
        assert($object instanceof ReplaceNameStep);

        return [
            'replacement' => $object->getReplacement(),
        ];
    }

    protected function denormalizeStep(
        $data,
        string $type,
        string $format,
        array $context = []
    ): ReplaceNameStep {
        return new ReplaceNameStep($data['replacement'] ?? null);
    }

    public function getHandledClassType(): string
    {
        return ReplaceNameStep::class;
    }

    public function getType(): string
    {
        return 'company_name';
    }

    public function getMode(): string
    {
        return 'replace';
    }
}
```

Then, tag the step normalizer, so it's recognized by the serializer used for migrations.

```yaml
    App\Migrations\Step\ReplaceNameStepNormalizer:
        tags:
            - 'ibexa.migrations.serializer.step_normalizer'
            - 'ibexa.migrations.serializer.normalizer'
```

## Create executor

And finally, create an executor to perform the step, in `src/Migrations/Step/ReplaceNameExecutor.php`:

```php
<?php

declare(strict_types=1);

namespace App\Migrations\Step;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\Values\Filter\Filter;
use Ibexa\Contracts\Migration\StepExecutor\AbstractStepExecutor;
use Ibexa\Core\FieldType\TextLine\Value;
use Ibexa\Migration\ValueObject\Step\StepInterface;

final class ReplaceNameStepExecutor extends AbstractStepExecutor
{
    public function __construct(private readonly ContentService $contentService)
    {
    }

    protected function doHandle(StepInterface $step)
    {
        assert($step instanceof ReplaceNameStep);

        $contentItems = $this->contentService->find(new Filter());

        foreach ($contentItems as $contentItem) {
            $struct = $this->contentService->newContentUpdateStruct();

            foreach ($contentItem->getFields() as $field) {
                if ($field->fieldTypeIdentifier !== 'ibexa_string') {
                    continue;
                }

                if ($field->fieldDefIdentifier === 'identifier') {
                    continue;
                }

                if (str_contains((string) $field->value, 'Company Name')) {
                    $newValue = str_replace('Company Name', $step->getReplacement(), $field->value);
                    $struct->setField($field->fieldDefIdentifier, new Value($newValue));
                }
            }

            try {
                $content = $this->contentService->createContentDraft($contentItem->contentInfo);
                $content = $this->contentService->updateContent($content->getVersionInfo(), $struct);
                $this->contentService->publishVersion($content->getVersionInfo());
            } catch (\Throwable) {
                // Ignore
            }
        }

        return null;
    }

    public function canHandle(StepInterface $step): bool
    {
        return $step instanceof ReplaceNameStep;
    }
}
```

Tag the executor with `ibexa.migrations.step_executor` tag.

```yaml
    App\Migrations\Step\ReplaceNameStepExecutor:
        tags:
            - 'ibexa.migrations.step_executor'
```

Then you can create a migration file that represents this step in your application:

```yaml
-   type: company_name
    mode: replace
    replacement: 'New Company Name' # as declared in normalizer, this is optional
```
