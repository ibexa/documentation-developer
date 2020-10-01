# Additional data in the basket line

## Line remark

There is a possibility to add additional data to the basket line. This data will be stored in a basket line and sent to ERP (in the `SesExtension` of the line) automatically.

By default you can enable additional text in the basket line:

``` yaml
#enable/disable additional text line in basket per basket line
ses_basket.default.additional_text_for_basket_line: false
```

In the basket line it looks like:

![](../../img/basket_additional_data_1.png)

You can set a different value for the parameter using one of these two methods: 

- Override the `app/config/parameters.yml` file.
- Within "configuration settings" in eCommerce tab in the backend.

![](../../img/basket_additional_data_2.png)

The input length of this field is controlled by a setting. This is important since the ERP might not accept text longer than a given limit. 

``` yaml
ses_basket.default.additional_text_for_basket_line_input_limit: 30
```

## Additional data

To add some additional information to the basket line, modify the template only. No other changes are necessary.

``` 
<input type="hidden" name="ses_basket[{{ loop.index }}][test]" value="some text"/>
<input type="text" name="ses_basket[{{ loop.index }}][NewText]" value ="Lorem Ipsum... "/>
```
