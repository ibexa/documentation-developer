# ProductSelection

This Field Type offers a relation feature for products. It can be used with products stored in the content model or in eContent.

Add a new Field (Product relationlist) to a Content Type:

![](../img/additional_ez_fieldtypes_1.png)

In edit mode an editor can search for a product or SKU and add the product to the relation list:

The optional attribute `note` can be used for example to display a hint on the frontend (e.g. "Offer").

![](../img/additional_ez_fieldtypes_2.png)

You can access the relation list data in Twig with:

- `sku`
- `name`
- `note`
- `image`

For example:

``` html+twig
<table class="table table-striped">
    {% for product in field.value.product_list %}
        <tr>
            <td>
                {% if product.image|default('') != '' %}
                   <img src="{{ product.image }}" height="40px" />
                {% endif %}
            </td>
            <td>{{ product.name }}</td>
        </tr>
    {% endfor %}
</table>
```
