# FileField

`FileField` is the representative implementation of `AbstractField` for a media file in a defined storage directory.
A file is identified by a `productId`, `storagePath` and several optional parameters.

``` php
const IDENTIFIER = 'sesfile';
// Same as for sesimage: 
public $alternativeText;
public $fileName;
public $fileSize;
public $path;
public $id;
public $mimetype;  // e.g. application/pdf, 
public $description;
```

A new `FileField` can be created using the following data:

``` php
use Silversolutions\Bundle\EshopBundle\Content\Fields\FileField;

$filePath = 'var/storage/4711-001.pdf';
 
$fileField = new FileField(
    array(
        'alternativeText' => 'a nice product',
        'fileName'        => basename($filePath),
        'fileSize'        => filesize($filePath),
        'path'            => $$filePath,
        'mimetype'        => 'application/pdf',
        'description'     => 'Something nice'
    )
);
```
