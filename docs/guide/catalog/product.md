# Product

The built-in Product Content Type contains the following Fields:

|Name | Identifier | Type | Description |
|---|---|---|---|
|Productname | `ses_name` | `ezstring` | Main name of the product. Used to create the URL |
|Product type | `ses_type` | `ezselection` | |
|SKU | `ses_sku` | `ezstring` | Unique Stock keeping unit |
|Subtitle | `ses_subtitle` | `ezstring` | Additional product name |
|Short description | `ses_short_description` | `ezrichtext` | Short product description |
|Long description | `ses_long_description` | `ezrichtext` | Long product description  |
|Specifications | `ses_specifications` | `sesspecificationstype` | A set of product specification values. They are indexed in the search engine and can be used for faceted search |
|EAN | `ses_ean` | `ezstring` | European Article Number |
|Variants | `ses_variants` | `uivarvarianttype` | [Product variants](#product-variants) |
|Manufacturer SKU | `ses_manufacturer_sku` | `ezstring` | SKU of the product  as assigned by the manufacturer |
|Unit price | `ses_unit_price` | `ezstring` | Product price |
|Product image | `ses_image_main` | ezimage | Main product image |
|Manufacturer | `ses_manufacturer` | ezstring | Manufacturer name |
|Color | `ses_color` | `ezstring` | Product color |
|Technical specification | `ses_specification` | `eztext` | Technical product description |
|Video | `ses_video` | `ezstring` | Link to a product video |
|Add. Product image 1-4 | `ses_image_1` | `ezimage` | Up to four additional images | 
|Currency | `ses_currency` | `ezstring` | Default product currency |
|VAT Code | `ses_vat_code` | `sesselection` | One of predefined VAT rates |
|Product Type | `ses_product_type` | `ezstring` | Product type used for grouping products in comparison |
|Packaging unit | `ses_packaging_unit` | `ezstring` | Product packaging unit |
|Min order quantity | `ses_min_order_quantity` | `ezstring` | Minimum quantity that can be ordered |
|Max order quantity | `ses_max_order_quantity` | `ezstring` | Maximum quantity that can be ordered |
|Unit | `ses_unit` | `ezstring` | Product unit |
|Stock numeric | `ses_stock_numeric` | `ezstring` | |
|Discontinued | `ses_discontinued` | `ezboolean` | Flag to indicate if the product is discontinued |
|Tags | `tags` | `ezkeyword` | Product keywords |

## Custom product Content Type

To create a custom Content Type that acts like a product, add its identifier to the following configuration:

``` yaml
silversolutions_eshop:
    product_content_type_identifiers:
        default:
            - my_custom_product_type
```

The custom Content Type must mirror the structure of the built-in `ses_product` Content Type,
by having Fields with the same identifiers,
but you can add other Fields to it.

!!! tip

    To ensure that all the Fields are set up correctly, you can copy the `ses_product` Content Type
    and add your custom Field to the copy.

Additionally, add the following parameters for your custom Content Type's identifier:

``` yaml
parameters:
    # Enable buying the product in the shop
    silver_eshop.default.catalog_factory.my_custom_product_type: createOrderableProductNode
    # Enable price export in the Back Office
    siso_price.default.price_export.product_type_filter: [ ses_product, my_custom_product_type ]
```

## Product specifications

You can configure the available product specifications and default values by using the following configuration:

``` yaml
siso_core.default.specification_groups:
    -
        code: "technic"
        label: "Technical data"
        default_values:
            -
                id: width
                label: "Width"
                value: ""
                options: ['mm','cm', 'in']
            -
                id: diameter
                label: "Diameter"
                value: ""
                options: ['mm','cm']
```

With the optional `option` attribute you can add a select field that offers, for example, a selection of units.
