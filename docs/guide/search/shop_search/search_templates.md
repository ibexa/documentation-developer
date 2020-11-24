# Search templates [[% include 'snippets/commerce_badge.md' %]]

## Products

`Catalog/listProductNode.html.twig` is used to display the content for a product.
The template has access to the `catalogElement` containing all the data including price information. 

### Content items

For Content items that are not products, each Content Type has a separate line template for search.
The built-in templates are stored in `Search/result/search_content_list`.

The templates are defined in the following configuration:

``` yaml
search_content_list:
    siso_search_folder_item:
        template: SilversolutionsEshopBundle:Search/result/search_content_list:folder.html.twig
        match:
            Identifier\ContentType: [folder]
    # ...
```

The templates have access to the Content item in the `content` variable.
