# Product images and assets [[% include 'snippets/commerce_badge.md' %]]

Product images and assets can be taken from the content model (if this data provider is used).
External images can also be stored in the file system. 

If images come from the file system, they have to be stored in the following folders:

- Product images in `web/var/assets/product_images`
- Product group images `web/var/assets/product_group_images`

To avoid too many files in one directory, subfolders are used.

For example, images for a product with SKU `D4241` are stored in the following file system folders:

``` 
web/var/assets/product_images/D/4/D4142_picture.jpg
web/var/assets/product_images/D/4/D4142_picture_2.jpg
```

When using a cluster, this folder has to be mounted as an NFS shared or cluster FS file system.

These folders are used as source folders for all assets.

Images are resized automatically when they are used for the first time.
The different image variations are stored in `web/var/ecommerce/storage/<image_class>/<subfolders>`:

``` 
web/var/ecommerce/storage//images/image_zoom/D/4/1/-D4142_picture_2_image_zoom.jpg
web/var/ecommerce/storage//images/image_zoom/D/4/1/-D4142_picture_image_zoom.jpg
web/var/ecommerce/storage//images/thumb_big/D/4/1/-D4142_picture_2_thumb_big.jpg
web/var/ecommerce/storage//images/thumb_big/D/4/1/-D4142_picture_thumb_big.jpg
web/var/ecommerce/storage//images/thumb_medium/D/4/1/-D4142_picture_thumb_medium.jpg
web/var/ecommerce/storage//images/thumb_medium/D/4/1/589768-D4142_thumb_medium.jpg
web/var/ecommerce/storage//images/thumb_smaller/D/4/1/-D4142_picture_2_thumb_smaller.jpg
web/var/ecommerce/storage//images/thumb_smaller/D/4/1/-D4142_picture_thumb_smaller.jpg
```

Image paths are cached in order to avoid accessing the file system in production mode. 
The cache uses stash. 

## Remove stash cache for images and one SKU

``` php
 /** @var $catalogElement \Silversolutions\Bundle\EshopBundle\Catalog\CatalogElement */
        $catalogElement = $catalogService->getDataProvider()->fetchElementBySku(
            $sku,
            array(),
            $ezHelper->getCurrentLanguageCode()
        );
 $assetService = $this->get('silver_catalog.asset_service');
 $assetService->removeAssetCache($catalogElement);
```
