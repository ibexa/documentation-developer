# st_tag selector [[% include 'snippets/commerce_badge.md' %]]

Template operator `st_tag` creates a custom HTML attribute that enables you to quickly find an HTML tag with this attribute.

This is especially helpful for Behat testing, because `st_tag` provides consistent naming convention for page selectors.

### Example

Twig template:

``` html+twig
<p {{ st_tag('product', 'price', 'read') }}>1.865,00 €</p>
```

is rendered to HTML:

``` html+twig
<p data-tag-product-price-read>1.865,00 €</p>
```

## Enabling tagging

To enable tagging, define a dynamic SiteAccess-aware parameter `siso_tools.default.tag-prefix`:

``` 
siso_tools.default.tag-prefix: data-tag
```

If you set an empty value to this parameter, then all tags are hidden.
It is important, for example, in `prod` environment to remove Behat tags.

## Implementation

Tagging is implemented with a template operator `st_tag`.

The operator takes the following parameters:

|Parameter|Required|Type| Description|Example|
|--- |--- |--- |--- |---|
|Module/Component|required |string | Identifies module/component/page that you are working on.|`product`, `form`|
|Element (target)|required |string | Identifies specific field that you are searching for.|`price`, `field`, `text`, `label`|
|Action|required |string | Identifies desired action for the selector.|`read` - reads to value of text node</br>`fill`/`write` - fills in form field</br>`click`/`follow`/`submit` - clicking on buttons, following links|
|ID|optional |number, string | Identifies a unique element that occurs more than once on a page. Helpful when searching for specific element in collections, e.g. product list, multiple images, buttons, etc.|`1200`, `button_action`|
|Value|optional |mix | If you don't want to take the value from the wrapper because it contains special characters or format, you can use this parameter to set a standard format. Can be helpful for example for getting prices.|`1600.00` (instead of `1.600,00 €`)|

!!! caution

    Don't use these attributes in CSS (for styling) or JavaScript (for selecting, hooks, etc.).
    These attributes have different and specific purpose.
    In addition, in production mode they can be disabled, which breaks the selectors.

## Examples

### Read price

``` html+twig
<p {{ st_tag('product', 'price', 'read') }}>1.865,00 €</p>
```

Output:

``` html+twig
<p data-tag-product-price-read>1.865,00 €</p>
```

### Read price with custom value

``` html+twig
<p {{ st_tag('product', 'price', 'read', '', '1865.00') }}>1.865,00 €</p>
```

Output:

``` html+twig
<p data-tag-product-price-read="1865.00">1.865,00 €</p>
```

### Follow/click a text link

``` html+twig
<a href="/link-to-product.html" {{ st_tag('product', 'anchor', 'follow', '1200', '') }}>Paprika3</p>
```

Output:

``` html+twig
<a href="/link-to-product.html" data-tag-product-anchor-follow-1200>Paprika3</p>
```

### Fill out form field

``` html+twig
<input name="quantity" id="quantity" value="" {{ st_tag('form', 'input', 'write', 'quantity', '') }}>
```

Output:

``` html+twig
<input name="quantity" id="quantity" value="" data-tag-form-input-write-quantity>
```

### Check if there is a specific message on the page (e.g. after an Ajax response)

``` html+twig
<div class="message notice" {{ st_tag('message', 'notice', 'read', '', '') }}>Message content
```

Output:

``` html+twig
<div class="message notice" data-tag-message-notice-read>Message content
```

### Submit buttons or links

!!! caution

    Always use the same naming for buttons which submit data.
    A Behat test or Google tag manager doesn't recognize whether it is a button, a link or an input field which sends the form.

``` xml
<button name="add_to_basket" type="submit" value="Kaufen" class="button add_to_basket float_right"> {{ st_tag('product', 'order', 'submit', '', '') }} 
```

Output:

``` xml
<input name="quantity" id="quantity" value="" data-tag-product-order-submit>
```
