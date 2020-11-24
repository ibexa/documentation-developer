# Reusable message template [[% include 'snippets/commerce_badge.md' %]]

The message template renders inline messages within content pages.

`EshopBundle/Resources/views/parts/message.html.twig`

## Parameters

- `content` (required) - Content that is displayed inside a message box. Can be mixed with any type of HTML or text.
- `close` - Flag that indicates if you can close the message. Default: `false`.
- `attrs` - Array of any HTML attributes that is allowed for a `<div>` element as well as some special attributes.

Common attributes:

```
'class': 'alert|success|info|warning|secondary',
'id: 'message-id',
'data-custom-attr': 'data custom value',
'style': 'display: none;'
```

You can pass a CSS class that will style message. Currently the following classes are supported:

- alert (for alerts/errors)
- success
- info
- warning
- secondary

You can pass multiple class names if required, e.g.:`'class': 'alert radius u-margin-top-1x'`

## Examples

### Success message

``` html+twig
{{ include('SilversolutionsEshopBundle:parts:message.html.twig'|st_resolve_template, {
  'content': 'hello world',
  'attrs':  {
    'class': 'success'
  } }) }}
```

### Alert message with a close icon

``` html+twig
{{ include('SilversolutionsEshopBundle:parts:message.html.twig'|st_resolve_template, {
  'content': 'This is an error message',
  'close': true,
  'attrs':  {
    'class': 'alert'
  } }) }}
```

### Notice message with multiline content

``` html+twig
// setting the message content
{% set noticeMsg %}
  {% for n in notice %}
    <p>{{ n }}</p>
  {% endfor %}
{% endset %}

{{ include('SilversolutionsEshopBundle:parts:message.html.twig'|st_resolve_template, {
  'content': noticeMsg, // using the noticeMsg variable
  'attrs':  {
    'class': 'info'
  } }) }}
```

### Warning message with `st_translate()` as content

``` html+twig
{{ include('SilversolutionsEshopBundle:parts:message.html.twig'|st_resolve_template, {
  'content': 'search_result_empty'|st_translate('search'),
  'attrs':  {
    'class': 'warning'
  } }) }}
```

### Alert message with an extra attribute for Behat testing

``` html+twig
{{ include('SilversolutionsEshopBundle:parts:message.html.twig'|st_resolve_template, {
  'content': 'Your Basket is empty'|st_translate ~ '!',
  'attrs':  {
    'class': 'alert',
    'behat': st_tag('message', 'error', 'exists', '', '')
  } }) }}
```

### Alert message with extra CSS classes and inline styling

``` html+twig
{{ include('SilversolutionsEshopBundle:parts:message.html.twig'|st_resolve_template, {
  'content': "Start date must be lower than end date."|st_translate(),
  'attrs':  {
    'class': 'alert js-order-history-dates-invalid',
    'style': 'display: none;'
  } }) }}
```

### Behat extra information

Message elements are rendered with a data tag followed by the Behat `attrs` parameters separated by `-`

The following example checks for a success message with the following configuration:

``` html+twig
// Twig file with success message:
include('SilversolutionsEshopBundle:parts:message.html.twig'|st_resolve_template, {
  'content': s,
  'close': true,
  'attrs':  {
    'class': 'success',
    'behat': st_tag('message', 'success', 'exists', '', '')
```

``` 
// Behat file FeatureContext.php
// This method will check for existing message of a type specified     
// Given $messageType = 'success'
public function iShouldSeeAMessageOfType($messageType)
    {
        $xpath = sprintf("//*[@data-tag-message-%s-exists]", $messageType);
        return $this->iShouldSeeAnElementWithXpath($xpath);
    }
```
