# Basket messages

Basket messages are stored in the Basket object, but they are not stored in the database.
It is possible to store several success, error or notice messages for products.

### Methods

|method|meaning|parameters|
|--- |--- |--- |
|setSuccessMessage()|Sets one success message to the basket|$success|
|getSuccessMessages()|Gets all success messages from the basket. If it is not set, an empty string is returned.||
|setErrorMessage()|Sets one error message to the basket|$error|
|getErrorMessages()|Gets all error messages from the basket. If it is not set, an empty string is returned.||
|setNoticeMessage()|Sets one notice message to the basket|$notice|
|getNoticeMessages()|Gets all notice messages from the basket. If it is not set, an empty string is returned.||
|clearAllMessages()|Deletes all messages from the basket||
|removeSuccessMessageForSku()|Deletes all success messages for the given SKU from the success messages|$sku|

## Messages templating

The messages are passed to the template through the `BasketController`, e.g. when displaying the basket:

``` ph
return $this->render(
            'SilversolutionsEshopBundle:Basket:show.html.twig', 
            array(
                'basket' => $basket,
                'error' => $basket->getErrorMessages(),
                'success' => $basket->getSuccessMessages(),
                'notice' => $basket->getNoticeMessages()
            )
); 
```

The messages are shown in the `messages.html.twig` template

`Silversolutions/Bundle/EshopBundle/Resources/views/Basket/messages.html.twig`

``` html+twig
{% if error != '' %}
    {% for e in error %}
        <div class="message error">
            <p><span class="sprite sprite-030f-error">{{ e }}</p>
        
    {% endfor %}
{% endif %}
{% if notice != '' %}
    {% for n in notice %}
        <div class="message notice">
            <p><span class="sprite sprite-030e-notice">{{ n }}</p>
        
    {% endfor %}
{% endif %}
{% if success != '' %}
    {% for s in success %}
        <div class="message success">
            <p><span class="sprite sprite-030g-success">{{ s }}</p>
        
    {% endfor %}
{% endif %}
```
