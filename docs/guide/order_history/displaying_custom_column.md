# Displaying custom column [[% include 'snippets/commerce_badge.md' %]]

## 1. Check if there is an existing block for your field

By default you can configure columns per document type in the [configuration](orderhistory_configuration.md).
You can display any field that has a block in `OrderHistoryBundle/Resources/views/OrderHistory/Components/fields.html.twig`.

!!! note

    When using the block name as column identifier in the configuration, remove the suffix `_field`.

If there is no block for your custom field, you need to create one.

The block name usually reflects the name of the document line field, for example:

``` xml
<CreditNoteList ses_unbounded="CreditNoteLine">   
    <CreditNoteLine ses_tree="SesExtension">
            ...
            <PaymentMeans>   
                ...         
                <PaymentDueDate>2007-01-01</PaymentDueDate>
            </PaymentMeans>   
    </CreditNoteLine>
</CreditNoteList>
```

Block name:

``` html+twig
{#obj is passed automatically and it is the document line#}

{% block PaymentMeans_PaymentDueDate_field %}
    {% spaceless %}
        {% set field_value = obj.PaymentMeans.PaymentDueDate.value %}
        {{ block( 'date_field' ) }}
    {% endspaceless %}
{% endblock %}
```

## 2\. Create missing block

If you did not find the corresponding block, you need to create your own. First you need to know the document structure.
Custom fields are passed to `SesExtension` if there is no standard for them.

``` xml
<DeliveryNoteList ses_unbounded="CreditNoteLine">   
    <DeliveryNoteListLine ses_tree="SesExtension">
            ...
            <SesExtension>   
                ...         
                <TrackingCode>20057487546987</TrackingCode>
            </SesExtension>   
    </DeliveryNoteListLine>
</DeliveryNoteList>
```

Override the corresponding template in `OrderHistoryBundle/Resources/views/OrderHistory/Components/fields.html.twig`.

Create a new block:

``` html+twig
{#obj will be passed automatically and it is the document line#}

{% block SesExtension_TrackingCode_field %}
    {% spaceless %}
        {% if obj.SesExtension.value.TrackingCode is defined %}
            {% set field_value = obj.SesExtension.value.TrackingCode %}
            <a href="#">{{ field_value }}</a> 
        {% endif %}        
    {% endspaceless %}
{% endblock %}
```

## 3\. Add new column to the configuration

``` yaml 
siso_order_history:
    #block name is specified in Components/fields.html.twig
    default_list_fields:    
        delivery_note:
            - ID_list
            - IssueDate
            - SesExtension_TrackingCode
```
