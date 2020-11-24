# Advanced configuration [[% include 'snippets/commerce_badge.md' %]]

## Cache configuration

``` yaml
stash:
    caches:
        default:
            drivers:
                - FileSystem
            inMemory: true
            registerDoctrineAdapter: false
            FileSystem:
                keyHashFunction: crc32
```

## Settings for Users

[[= product_name_com =]] uses specific User groups where new Users are placed.
You can configure the Location IDs of these User groups in the following way:

``` yaml
siso_core.default.user_group_location: 106
siso_core.default.user_group_location.business: 106
siso_core.default.user_group_location.private: 106
```

## Supported country list

This configuration controls which countries will be offered in [[= product_name_com =]] (e.g. in registration forms or in the checkout).

``` yaml
siso_tools.default.countries: ['DE','US','NO']
```

## Navigation menu

``` yaml
siso_core.default.breadcrumb_content_label_fields: ['name', 'title']
siso_core.default.navigation.content:
    types: ["st_module", "folder", "article", "landing_page", "ses_productcatalog", "folder_news", "folder_events", "blog", "folder_contacts"]
    sections: [1, 2, 9]
    enable_priority_zero: false
    #additional field keys for translating navigation node label
    label_fields: ['name', 'title']
    additional_fields: ['intro', 'media', 'alternative_title', 'alternative_intro', 'alternative_image']
```

## Search

``` yaml
siso_search.default.groups.search:
    product:
        types:
            - ses_product
            # activate if you want to find product types as well
            #- ses_product_type
        path: '/1/2/'
        section:
            - 1
        visibility: true
        # activate if you want to enable usage of the flag: displayInSearch
        # if false, the flag will be ignored in the search even if set in eZ
        #use_display_in_search_flag: true
    content:
        types:
            - st_module
            - folder
            - article
            - landing_page
            - blog_post
            - event
            # add ez classes like news or folder_news, folder_events, folder_contacts

        path: '/1/2/'
        section:
            - 1
        visibility: true
        # this parameter only make sence if there are some products/product types in the tab, see above
        #use_display_in_search_flag: false
    files:
        types:
            - file

        path: '/1/43/'
        section:
            - 3
        visibility: true
        # this parameter only make sence if there are some products/product types in the tab, see above
        #use_display_in_search_flag: false

siso_search.default.autosuggest_module_definitions:
    product_autosuggest:
        search_limit: 5
        images_field: main_image_url_s
        add_to_basket: true #add to cart
        price_field: ses_product_ses_unit_price_f
        search_fields:
            - ses_product_ses_sku_value_s
            - ses_product_ses_name_value_s
        result_fields:
            - ses_product_ses_sku_value_s
            - ses_product_ses_name_value_s
        result_fields_separator: ' - '
        text_limit: 35
        search_service_id: siso_search.autosuggest_service.product
        redirect_generator_id: siso_search.autosuggest_redirect_generator.product
    category_autosuggest:
        search_limit: 5
        images: true
        search_fields:
            - ses_category_ses_name_value_s
        result_fields:
            - ses_category_ses_name_value_s
        result_fields_separator: ' - '
        text_limit: 60
        search_service_id: siso_search.autosuggest_service.category
        redirect_generator_id: siso_search.autosuggest_redirect_generator.category
    content_autosuggest:
        search_limit: 5
        images: true
        section:
            - 1
        search_fields:
            - article_title_value_s
            - article_intro_value_s
            - article_body_value_s
            - blog_post_title_value_s
            - blog_post_intro_value_s
            - news_title_value_s
            - news_intro_value_s
            - event_title_value_s
            - event_intro_value_s
        result_fields:
            - article_title_value_s
            - article_intro_value_s
            - article_body_value_s
            - news_title_value_s
            - news_intro_value_s
            - event_title_value_s
            - event_intro_value_s
        result_fields_separator: ' - '
        text_limit: 60
        search_service_id: siso_search.autosuggest_service.content
        redirect_generator_id: ~
    download_autosuggest:
        search_limit: 5
        images: true
        search_fields:
            - file_name_value_s
            - file_description_value_s
        result_fields:
            - file_name_value_s
            - file_description_value_s
        mime_types:
            - application/pdf
        result_fields_separator: ' - '
        text_limit: 60
        search_service_id: siso_search.autosuggest_service.download
        redirect_generator_id: siso_search.autosuggest_redirect_generator.download
```
