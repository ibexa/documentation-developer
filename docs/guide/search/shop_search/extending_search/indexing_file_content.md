# Indexing file content [[% include 'snippets/commerce_badge.md' %]]

Indexing the content of files stored in the content model uses an additional component called Apache Tika.

Apache Tika has two available modes: Server Mode and App Mode. [[= product_name_com =]] uses Apache Tika in App mode.

You can specify which MIME types are indexed in configuration.
If you need additional file types to be indexed, add them to this configuration, for example:

``` yaml
siso_search.default.index_content:
    - application/pdf
    - application/vnd.ms-excel
    - application/msword
```

See [Supported Document Formats](http://tika.apache.org/1.13/formats.html) for a list of formats supported by Apache Tika.

!!! caution

    Make sure [Apache Tika Bundle](https://packagist.org/packages/jolicode/apache-tika-bundle) is installed
    and is enabled in the kernel.

    Apache Tika log file (`/tmp/tika-error.log`) is hardcoded. Make sure the file is writable both by the command-line user who executes the indexer
    and the Apache user, because the indexer is triggered after a file is modified in the backend.

    If this file is not writable, the indexer does not index file contents.

## Extending file content indexer

In order to extend the indexer for files you have to extend the `Ibexa\Platform\Commerce\FieldTypes\FieldType\BinaryFile\SearchField` service.

The `getIndexData(Field $field, FieldDefinition $fieldDefinition)` returns an array of `\eZ\Publish\SPI\Search\Field` objects.

This object is created with the following parameters:

- `name` - a name that is used to build the Solr field name.
- `data` - the data to be indexed.
- Solr field type - you can use any Solr field type. In the PDF example you index the data both as FullTextField and as TextField.

``` php
$parentData = parent::getIndexData($field, $fieldDefinition);

// Return the data that is coming from Apache Tika
$fileContent = $this->getFileContent($field);
 
// Create a Solr FullTextField
$parentData[] = new Search\Field(
    'file_content',
    $fileContent,
    new Search\FieldType\FullTextField()
);
 
// Create a Solr TextField
$parentData[] = new Search\Field(
    'file_content',
    $fileContent,
    new Search\FieldType\TextField()
);

return $parentData;
```

String fields and text fields should be visible as a search result in Solr web administration.
Full text fields are only visible in schema browser.

In this example the Solr text field name for `file_content` is `file_file_file_content_t`.

## Extracting information from a file

The core of this indexer is Apache Tika, a component that can fetch a file and return its contents in plain text, or in HTML.

Apache Tika is injected as a service into the constructor of this class:

``` php
public function __construct($apacheTikaService)
{
    $this->apacheTikaService = $apacheTikaService;
}
```

The main method is `getText`:

``` php
$fileContent = $this->apacheTikaService->getText($fileName);
```

You can also use additional methods to get HTML or metadata of the file:

``` 
getMetadata($fileName)
getHTML($fileName)
```
