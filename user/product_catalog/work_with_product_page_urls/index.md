# Product page URLs

You can create URL alias name pattern and custom URLs for the Products.

Every [product item](../products/index.md) has a system URL that is automatically generated. It's based on a pattern that combines fields and attributes to build the URL (URL alias name pattern).

When you're creating new [product type](../create_product_types/index.md) you can set up product URL alias name pattern.

To do it, fill in all the necessary information, choose the attributes that you want to use in URL alias name pattern, copy their ID, and paste in the **URL alias name pattern** field using following pattern: --(...), then click **Save and close** button.

Below you can see an example of URL alias name pattern:

![URL attributes](https://doc.ibexa.co/projects/userguide/en/5.0/product_catalog/img/url_attributes.png "URL attributes")

Now, you can see new URL alias name pattern in the product type's view.

![URL alias name pattern](https://doc.ibexa.co/projects/userguide/en/5.0/product_catalog/img/url_alias_name_pattern.png "URL alias name pattern")

## Product Attributes identifiers

Products have their own [attributes](../work_with_product_attributes/index.md) to define product specification.

The following attribute types can be used in URL alias name pattern field:

- Checkbox
- Color
- Integer
- Selection
- Measurement (single)
- Measurement (range)

| Type                 | Returned value                           | Example          |
| -------------------- | ---------------------------------------- | ---------------- |
| Checkbox             | Label of the checkbox is checked         | wireless         |
| Color                | Hex code value                           | 8b0000           |
| Integer              | Integer                                  | 26               |
| Selection            | Selected value with configured separator | children-infants |
| Measurement (single) | Single value and unit                    | 256gb            |
| Measurement (range)  | Value unit and minimum/maximum values    | 20-25cm          |

You can use many attributes identifiers and fields identifiers in the URL alias pattern field.

Having keyword-rich URLs also improves the product's visibility in search engine results and boosts the page's ranking in search results.

## Create custom URL

You can create custom URL for each product. Customized URLs are memorable, help with SEO optimization and reduce bounce rates on the website. It improves the user experience - you can understand what the product is about by reading the link.

To do it, follow the steps:

1. In the left panel, go to **Product catalog** -> **Products**.

2. Choose a product from the list.

3. Click on **URL** tab in the product's view. Here you can see both custom URL aliases and system URL.

![URL tab](https://doc.ibexa.co/projects/userguide/en/5.0/product_catalog/img/url_tab.png "URL tab")

4. Click **Add new** button.

5. Provide custom URL in "URL" field and set up all necessary settings.

![Creating a custom URL](https://doc.ibexa.co/projects/userguide/en/5.0/product_catalog/img/create_custom_url.png "Creating a custom URL")

6. Click **Create**.

Now, in the **URL** tab in the product's view, you can see new custom URL for the product.

![Custom URL](https://doc.ibexa.co/projects/userguide/en/5.0/product_catalog/img/custom_url.png "Custom URL")

You can manage all the product URLs, both system and custom ones: create new and edit or delete existing ones.
