# Storing parts of the product in the basket line

The `CatalogElementSerializeService` service is used for the serializing and unserializing of catalog element.
It implements the `SerializeServiceInterface`.

This feature ensures that the basket always contains information about the products that are being ordered. When the customer sends an order, the shop can verify if all relevant product data for the order is present, even if the product was meanwhile removed from the product catalog.

The parameter `refreshCatalogElementAfter` defines how long the catalog element will be used from the basket line until it is refreshed from the catalog.

``` yaml
ses_basket.default.refreshCatalogElementAfter: 1 hours
```

The service is using all attributes of the catalog element, that are set in the configuration:

``` yaml
#defines catalog element attributes that should be stored in a basket line
siso_basket.default.stored_catalog_element_attributes:
    Silversolutions\Bundle\EshopBundle\Product\OrderableProductNode:
        baseAttributes: 
            - customerPrice
            - ean
            - identifier
            # ...
        dataMapAttributes: []
    Silversolutions\Bundle\EshopBundle\Product\OrderableVariantNode:
        baseAttributes: 
            - customerPrice
            - ean
            - identifier
            # ...
        dataMapAttributes: [] 
```

!!! note

    By default, all base attributes are set in the configuration and the dataMap attributes are empty.

    You can override this configuration, but make sure all required base attributes are specified,
    otherwise it is not possible to create a new `CatalogElement` from the serialized version.

!!! tip

    Also make sure that the attributes you specify are either simple datatypes (int, float, boolean, string, array) or instances of [FieldInterface](../../../api/commerce_api/fields_for_ecommerce_data/fields_for_ecommerce_data.md).

    All other objects will be ignored, because it is not possible to assure that the serializing process will work properly.

## CatalogElementSerializationListener

The `CatalogElement` is stored in the basket line using the Doctrine listener. This listener uses the serialize service.

!!! note
    
    Namespace:

    `Silversolutions\Bundle\EshopBundle\EventListener\Basket`

    ID:

    `siso_basket.catalog_element_serialization_listener`

This listener listens to different events to make sure that the catalog element is ALWAYS of type `CatalogElement` in the shop, and of `longtext` (serialized string) type in the database.

``` php
   /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::postLoad,
            Events::prePersist,
            Events::preUpdate,
            Events::postUpdate,
            Events::postPersist,
        );
    }
```

Depending on the event the catalog element from basket line is either serialized to a string or unserialized to a `CatalogElement`.
