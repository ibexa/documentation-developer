# Adding elements to autosuggestion module [[% include 'snippets/commerce_badge.md' %]]

Any Solr field can be displayed in autosuggest results.

1\. Identify the Solr field you want to show.

You can find the required field using Solr HTTP interface.

The following example displays a preview of PDF content in the download module.

Content of indexed files is stored in the `file_file_file_content_t` Solr field.

2\. Add Solr field to configuration:

``` yaml hl_lines="11"
siso_search.default.autosuggest_module_definitions:
download_autosuggest:
    search_limit: 5
    images: true
    search_fields:
        - file_name_value_s
        - file_description_value_s
    result_fields:
        - file_name_value_s
        - file_description_value_s
        - file_file_file_content_t
    mime_types:
        - application/pdf
    result_fields_separator: ' - '
    text_limit: 60
```

3\. PDF content is displayed in each result line.

You can also customize the result line.
Each template has the full result line to allow template customization without service modification.
For example, the template for download module is `Resources/views/Search/autosuggest/search_autosuggest_download_line.html.twig`.

The `resultLine` array has all information received from Solr, so you can use it to change field rendering.

## Adding a label to products

You can also show in autosuggestion information which is not available directly in Solr and requires processing.
To do this, create an indexer plugin and have your information processed. 

In this example you display a flag for new products.

First, define what is a "new" product.
The example assumes a new product is a product that was published within the last month.

You can use the Solr field `"published_dt": "2016-01-19T09:59:24Z"` to calculate whether the product is new or not.

[Create an indexer plugin](indexer_plugin_for_custom_field_types.md) to add a new boolean field which is set to true if the current date - product published date <= 30 days.

If the new field is `ext_product_new_s`, add it to the result fields of Solr in product configuration:

``` yaml hl_lines="15"
product_autosuggest:
    search_limit: 10
    images_field: main_image_url_s
    display_cart_info: true #add to cart
    types:
        - 2
    path: '/2/'
    section: 1
    search_fields:
        - ses_product_ses_sku_value_s
        - ses_product_ses_name_value_s
    result_fields:
        - ses_product_ses_sku_value_s
        - ses_product_ses_name_value_s
        - ext_product_new_s
    result_fields_separator: ' - '
    text_limit: 35
```

Now modify the `/Resources/views/Search/autosuggest/search_autosuggest_product_line.html.twig` template to read that value.

Even it is not used, in every template you have the `resultLine` array with all Solr information.

``` php
array (size=5)
  'id' => string 'content9982gerde' (length=16)
  'ses_product_ses_name_value_s' => string 'DMX Followspot HMI-1200' (length=23)
  'ses_product_ses_sku_value_s' => string '40180' (length=5)
  'main_image_url_s' => string '/var/ezdemo_site/storage/images/4/4/1/1/531144-2-ger-DE/40180.jpg' (length=65)
  'meta_indexed_language_code_s' => string 'ger-DE' (length=6)
```

Additionally, if you change the configuration to support your new indexed field, that new field should be part of this array:

``` php hl_lines="7"
array (size=5)
  'id' => string 'content9982gerde' (length=16)
  'ses_product_ses_name_value_s' => string 'DMX Followspot HMI-1200' (length=23)
  'ses_product_ses_sku_value_s' => string '40180' (length=5)
  'main_image_url_s' => string '/var/ezdemo_site/storage/images/4/4/1/1/531144-2-ger-DE/40180.jpg' (length=65)
  'meta_indexed_language_code_s' => string 'ger-DE' (length=6)
  'ext_product_new_s' => bool true
```

The template modification might look like this:

``` html+twig hl_lines="8 9 10 11"
<div class="row">
    <div class="small-8 large-8 columns">
        <a href="{{ ('/redirect_switcher?sku=' ~ sku ~ '&type=' ~ type)|st_siteaccess_path }}">
            {% if imageSrc is defined %}
                <img src="{{ imageSrc }}" width="50px"/>
            {% endif %}
            {{ set_bold_text(searchQueryString, productText) }}
            {% if resultLine.ext_product_new_s is defined and resultLine.ext_product_new_s %}
                <!-- DISPLAY FANCY ANIMATED GIF WITH NEW LABEL -->
                <img border="0" alt="animated gif" src="new3__e0.gif">
            {% endif %}    
        </a>
    </div>
        {% if addToBasket %}
<div class="small-4 large-4 columns">
<form action="/basket/add" method="post">
    <section class="js-add-to-basket-parent">
        <input type="hidden" name="ses_basket[{{ number }}][quantity]" value="1">
        <input type="hidden" name="ses_basket[{{ number }}][sku]" value="{{ sku }}">
        <input type="hidden" name="autosuggest" value="autosuggest">
        <button class="button tiny js-add-to-basket" style="float:right;" data-sku="{{ sku }}" type="submit" name="add_to_basket">
            <i class="fa fa-cart-plus fa-lg fa-fw"></i>
        </button>
    </section>
</form>
</div>
```
