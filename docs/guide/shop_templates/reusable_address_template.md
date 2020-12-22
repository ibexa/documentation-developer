# Reusable address template [[% include 'snippets/commerce_badge.md' %]]

The address template is used to display addresses in a more flexible way.

- `EshopBundle\Resources\views\parts\address.html.twig`
- `EshopBundle\Resources\views\parts\address.txt.twig`

To override the template inside a project, create templates inside your project bundle that follow the same structure and have the same name.

## Configuration

|Parameter|Description|
|--- |--- |
|`address`|Address to be displayed. Must be type of Party object (e.g. `buyerAddress`)|
|`class`|Class used for styling (e.g. `styled_list`)|
|`displayEmail`|If set to true, the email address is displayed in template. Default value is `true`.|
|`displayPhone`|If set to true, the phone number is displayed in template. Default value is `true`.|
|`raw`|If set to `true`, the template is displayed without formatting. If set to `false` the template is displayed in an unordered list. Default value is `false`.|

## Example

``` html+twig
{{ include('SilversolutionsEshopBundle:parts:address.html.twig', {'class' : 'styled_list', 'address' : buyerAddress, 'displayEmail' : false, 'displayPhone' : false}) }}

{{ include('SilversolutionsEshopBundle:parts:address.html.twig', {'address' : address, 'displayEmail' : false, 'displayPhone' : false, 'raw' : true}) }}

{{ include('SilversolutionsEshopBundle:parts:address.txt.twig', {'address' : deliveryAddress, 'displayEmail' : false}) }}
```
