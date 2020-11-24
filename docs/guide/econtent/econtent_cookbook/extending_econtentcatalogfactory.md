# Extending EcontentCatalogFactory [[% include 'snippets/commerce_badge.md' %]]

Catalog objects are created with `EcontentCatalogFactory`.
This involves both product and product groups, or any other type of elements that are part of the catalog.

Sometimes projects need to extend this class to provide additional functionality or logic to the catalog elements.

Catalog objects have default properties and a data map with additional fields.
This data map is flexible and enables adding new custom properties to objects,
such as file objects, arrays of files, images, custom values based on standard values, flags, etc.

The following example shows how to extend `EcontentCatalogFactory` to enable adding a video to the product data map.

## Step 1: Create a class

Create a new class `MyProjectEcontentCatalogFactory` that extends `EcontentCatalogFactory`.

``` php
<?php

namespace MyProject\Bundle\ProjectBundle\Services\Factory;
 
class MyProjectEcontentCatalogFactory extends EcontentCatalogFactory
{}
```

## Step 2: Register the class a service

In `services.yml`, add the new class that you just created.

If you are not overriding the constructor, it is enough to add only the parameter with the original key and the new class:

``` xml
<parameter key="silver_catalog.econtent_catalog_factory.class">MyProject\Bundle\ProjectBundle\Services\Factory\CornelsenEcontentCatalogFactory</parameter>
```

## Step 3: Create an extraction method

Create a new extraction method for the video. For this example, assume that the object has one video and its name is the SKU with the mp4 extension.

Every new element that is added to the catalog element must be placed in its data map.
The catalog element data map supports different Field objects as its elements.
You can find the available Field elements in `EshopBundle/Content/Fields`

This example uses the File Field object and the [Symfony finder object](http://symfony.com/doc/current/components/finder.html) to support file system access.

``` php
/**
 * This method will extract all videos of specified extensions.
 *
 * @param $fieldIdentifier
 * @param $dataMap
 * @return FileField
 */
protected function extractVideo($fieldIdentifier, $dataMap)
{
    $attributes = $this->getFieldFromDataMap($fieldIdentifier, $dataMap);
    $fileName = $attributes['data_text'].'mp4';
    $finder = new Finder();
    try {
        $finder->files()->in('videos/')->name($fileName);
        /** @var \Symfony\Component\Finder\SplFileInfo $file */
        foreach ($finder as $file) {
            $fileName = $file->getRelativePathname();
            $fileSize = $file->getSize();
            $fileRecord = array(
                'fileName' => $fileName,
                'fileSize' => $fileSize,
                'path' => 'videos/'.$fileName,
            );
        }
    } catch (\InvalidArgumentException $e) { }
  
    return new FileField($fileRecord);
}
```

## Step 4. Call your method from the data map

Add the call to `extractVideo()` in `fillCatalogElementDataMap()`.

The `fillCatalogElementDataMap()` method is responsible for generating the data map of the catalog element.

``` php
/**
 * Fills the data map of a catalog element
 *
 * @param CatalogElement $catalogElement
 * @param array $dataMap
 * @return CatalogElement
 */
protected function fillCatalogElementDataMap(CatalogElement $catalogElement, array $dataMap = array())
{
    /* Before returning the catalog element you can add the video to the data map: */
  
    // Videos are added to products only:
    if ($catalogElement instanceof ProductNode) {
        $videoField = $this->extractVideo('ses_sku', $dataMap);
        $catalogElement->addFieldToDataMap('video', $videoField);
    }
 
    return $catalogElement;
}
```

Your catalog element now should have a video file in its data map.

You can also add arrays of fields to the data map. In such a case the object will be an `ArrayField`, and its contents will be Field objects.
You can have an Array Field with different file fields, text fields or any other kind of defined field.
