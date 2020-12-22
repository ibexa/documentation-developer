# Creating custom version comparison of Field Types

In the Back Office, you can compare the contents of Fields.
Comparing is possible only between two versions of the same Field that are in the same language.

You can add the possibility to compare custom and other unsupported Field Types.
You can base the configuration on the comparison mechanism created for the `ezstring` Field Type.

## Field Type configuration

First, ensure that the Field Type to compare implements the `EzSystems\EzPlatformVersionComparison\FieldType\Comparable` interface with the following method:

``` php
use eZ\Publish\SPI\FieldType\Value;
use EzSystems\EzPlatformVersionComparison\FieldType\FieldTypeComparisonValue;

interface Comparable
{
    public function getDataToCompare(Value $value): FieldTypeComparisonValue;
}
```

This method fetches the data to compare and determines which [comparison engines](#comparison-engine) should be used.
The `ComparisonData` object is specific to the Field Type you want to compare.

In case of `ezstring`, the implementation is:

``` php
public function getDataToCompare(SPIValue $value): FieldTypeComparisonValue
{
    return new Value([
        'textLine' => new StringComparisonValue([
            'value' => $value->text,
        ]),
    ]);
}
```

Also, the Field Type must be registered as a service and tagged as comparable (e.g. `config/comparable_fieldtypes.yaml`).
An example configuration, in this case for `ezstring`, looks the following way:

``` yaml
EzSystems\EzPlatformVersionComparison\FieldType\TextLine\Comparable:
  tags:
    - { name: ezplatform.field_type.comparable, alias: ezstring }
```

## Comparison engine

The comparison engine handles the operations required for comparing the contents of Fields.
Note that each Field Type requires a separate comparison engine.

When creating a custom engine, ensure that it implements the `EzSystems\EzPlatformVersionComparison\Engine\FieldTypeComparisonEngine` interface:

``` php
namespace EzSystems\EzPlatformVersionComparison\Engine;

use EzSystems\EzPlatformVersionComparison\FieldType\FieldTypeComparisonValue;
use EzSystems\EzPlatformVersionComparison\Result\ComparisonResult;

interface FieldTypeComparisonEngine
{
    public function compareFieldsTypeValues(FieldTypeComparisonValue $comparisonDataA, FieldTypeComparisonValue $comparisonDataB): ComparisonResult;

    public function shouldRunComparison(FieldTypeComparisonValue $comparisonDataA, FieldTypeComparisonValue $comparisonDataB): bool;
}
```

The engine must also be registered as a service:

``` yaml

EzSystems\EzPlatformVersionComparison\Engine\FieldType\TextLineComparisonEngine:
    tags:
        - { name: ezplatform.field_type.comparable.engine, supported_type: EzSystems\EzPlatformVersionComparison\FieldType\TextLine\Value }
```

When configuring the engines, ensure to tag them with both the `ezplatform.field_type.comparable.engine` and `supported_type` tags.

### VersionDiff

`VersionDiff` is built by `VersionComparisonService::compare`.
It consists of an array of `EzSystems\EzPlatformVersionComparison\FieldValueDiff`.
It is an object that holds `EzSystems\EzPlatformVersionComparison\Result\ComparisonResult`.
It is specific to a Field Type because different Field Types have distinct way of showing the difference between their versions. 

``` php
namespace EzSystems\EzPlatformVersionComparison\Service;

use eZ\Publish\API\Repository\Values\Content\VersionInfo;
use EzSystems\EzPlatformVersionComparison\VersionDiff;

interface VersionComparisonService
{
    public function compare(
        VersionInfo $versionA,
        VersionInfo $versionB,
        ?string $languageCode = null
    ): VersionDiff;
}
```
