# Creating custom version comparison of Field Types

!!! enterprise
    
    In the Back Office, you can compare the contents of a Field Type.
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
                'value' => $value->text,
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
    
    When creating a custom engine, ensure that it implements the `\EzSystems\EzPlatformContentComparison\Engine\ComparisonEngine` interface:
    
    ``` php
    namespace EzSystems\EzPlatformContentComparison\Engine;
    
    use EzSystems\EzPlatformContentComparison\Comparison\ComparisonData;
    use EzSystems\EzPlatformContentComparison\Result\ComparisonResult;
    
    interface ComparisonEngine
    {
        public function compareFieldsData(ComparisonData $comparisonDataA, ComparisonData $comparisonDataB): ComparisonResult;
    
        public function areFieldsDataEqual(ComparisonData $comparisonDataA, ComparisonData $comparisonDataB): bool;
    }
    ```
    
    The engine requires also configuration similar to the following one:
    
    ``` yaml
    
    EzSystems\EzPlatformContentComparison\Engine\FieldType\TextLineComparisonEngine:
      tags:
        - { name: ezplatform.field_type.comparable.engine, supported_type: EzSystems\EzPlatformContentComparison\Comparison\Field\TextLine }
    ```
    
    When configuring the engines, ensure that you provided both `ezplatform.field_type.comparable.engine` and `supported_type` tags.
    
    ### VersionDiff
    
    For the comparison purposes, `VersionDiff` is built by `ContentComparisonService::CompareVersions`.
    It consists of an array of `EzSystems\EzPlatformContentComparison\Values\FieldValueDiff`.
    It is an object that holds `EzSystems\EzPlatformContentComparison\Result\ComparisonResult`.
    It is specific to a Field Type because different Field Types have distinct way of showing the difference between their versions. 
    
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