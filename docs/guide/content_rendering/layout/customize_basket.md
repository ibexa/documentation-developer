---
description: Customize the template for the shop basket.
---

# Customize basket

To customize the look of the basket, you override the default template.

For example, to add a new column to the basket table that contains the VAT rate,
copy the existing `vendor/ezsystems/ezcommerce-checkout/src/bundle/Resources/views/themes/standard/Basket/page.html.twig` to `templates/themes/<theme_name>/Basket/page.html.twig`.

Next, modify the template to include the following changes:

``` html+twig hl_lines="8 22 23 24 25 26"
<thead>
<tr>
    <th>{{ 'basket.page.table.product'|trans|desc('Product') }}</th>
    <th>{{ 'basket.page.table.stock'|trans|desc('Stock') }}</th>
    <th>{{ 'basket.page.table.quantity'|trans|desc('Quantity') }}</th>
    <th>{{ 'basket.page.table.unit.price'|trans|desc('Unit price') }}</th>
    <th>{{ 'basket.page.table.total.price'|trans|desc('Total price') }}</th>
    <th>{{ 'basket.page.table.total.vat'|trans|desc('VAT') }}</th>
    <th>{{ 'basket.page.table.total.actions'|trans|desc('Actions') }}</th>
</tr>
</thead>

<td>
    {% if line.remoteDataMap.isPriceValid is defined and line.remoteDataMap.isPriceValid %}
        {% if showInclVat %}
            {{ line.linePriceAmountGross|price_format(line.currency) }}
        {% else %}
            {{ line.linePriceAmountNet|price_format(line.currency) }}
        {% endif %}
    {% endif %}
</td>
<td>
    {% if line.vat is defined and line.vat %}
        {{ line.vat }}
    {% endif %}
</td>   
```

Finally, for the template to be applied, you need to [override the existing shop templates](../templates/overriding_shop_templates.md):

``` yaml
[[= include_file('code_samples/front/shop/override_navigation/config/packages/design.yaml') =]]
```
