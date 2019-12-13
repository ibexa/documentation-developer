# Creating custom version comparison of Field Types

In the Back Office, you can compare the contents of a Field Type.
Out of the box, you can compare versions of the TextLine Field Type (`ezstring`).
Comparing is possible only between two versions of the same Field Type that are in the same language.

You can add the possibility to compare other Field Types, including the custom ones.
You can base the configuration on the comparison mechanism created for the `ezstring` Field Type.

## Field Type configuration

First, ensure that the Field Type to compare implements the `EzSystems\EzPlatformContentComparison\FieldType\Comparable` interface with the following method:

``` php
use eZ\Publish\SPI\FieldType\Value;
use EzSystems\EzPlatformContentComparison\Comparison\ComparisonData;

interface Comparable
{
    public function getDataToCompare(Value $value): ComparisonData;
}
```

This method fetches the data to compare and determines which [comparison engines](#comparison-engine) should be used.
Therefore, the `ComparisonData` object is specific to the Field Type you want to compare.

In case of `ezstring`, the implementation is:

``` php
public function getDataToCompare(Value $value): ComparisonData;
{
    return new TextLine([
        'textLine' => new StringComparisonValue([
            'value' => $value->text,,
        ]),
    ]);
}
```

Also, the Field Type requires additional configuration (e.g. `comparable_fieldtypes.yaml`).
An exemplary configuration, in this case for `ezstring`, looks the following way:

``` yaml
EzSystems\EzPlatformContentComparison\FieldType\TextLine\Comparable:
  tags:
    - { name: ezplatform.field_type.comparable, alias: ezstring }
```

## Comparison engine

The comparison engine handles the operations required for comparing the contents of Field Types.
Note that each Field Type requires a separate comparison engine.

When creating a custom engine, ensure that it implements the `EzSystems\EzPlatformContentComparison\Engine` interface:

``` php
declare(strict_types=1);

namespace EzSystems\EzPlatformContentComparison\Engine;

use EzSystems\EzPlatformContentComparison\Comparison\ComparisonData;
```

The engine requires also configuration similar to the following one:

``` yaml
EzSystems\EzPlatformContentComparison\Engine\Value\StringValueComparisonEngine: ~

EzSystems\EzPlatformContentComparison\Engine\FieldType\TextLineComparisonEngine:
  tags:
    - { name: ezplatform.field_type.comparable.engine, supported_type: EzSystems\EzPlatformContentComparison\Comparison\Field\TextLine }

EzSystems\EzPlatformContentComparison\Engine\NoComparisonValueEngine:
  tags:
    - { name: ezplatform.field_type.comparable.engine, supported_type: EzSystems\EzPlatformContentComparison\Comparison\Field\NoComparison }

EzSystems\EzPlatformContentComparison\FieldType\NonComparable:
  tags:
    - { name: ezplatform.field_type.comparable, alias: eznoncomparable }
```

Lines 3-5 and 7-9 configure two [comparison engines](#comparison-engine) required for handling the content of the `ezstring` Field Type.
When configuring the engines, ensure that you provided the `supported_type` tag.
Lines 11-13 are for providing the configuration in case the Field Type versions are not comparable.
Finally, in lines 15-17 you configure the Field Type to be comparable by using the `alias` tag.

!!! note

    There is a difference in tagging:

    - Configure the engines with the `ezplatform.field_type.comparable.engine` tag
    - Configure the Field Type with the `ezplatform.field_type.comparable` tag

### VersionDiff

For the comparison purposes, `VersionDiff` is built by `ContentComparisonService::CompareVersions`.
It consists of array of `EzSystems\EzPlatformContentComparison\Values\FieldValueDiff`.
It is an object that holds `EzSystems\EzPlatformContentComparison\Result\ComparisonResult`,
which is specific to a Field Type, as different Field Types have distinct way of showing the difference between their versions. 

The `VersionDiff` is used by the `EzSystems\EzPlatformContentComparison\Service\ContentComparisonService` containing the following method:

``` php
namespace EzSystems\EzPlatformContentComparison\Service;

use eZ\Publish\API\Repository\Values\Content\VersionDiff\VersionDiff;
use eZ\Publish\API\Repository\Values\Content\VersionInfo;

interface ContentComparisonService
{
    public function compareVersions(
        VersionInfo $versionA,
        VersionInfo $versionB,
        ?string $languageCode = null
    ): VersionDiff;
}
```