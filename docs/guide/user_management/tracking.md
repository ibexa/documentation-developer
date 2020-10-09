# Tracking

eZ Commerce comes with a simple extensible system for tracking tools. Any tracking tool can be plugged in.

The tracking tools can output the tracking code in the template where they are included (product detail, basket, etc.)
in the selected position on the page (top/bottom).
The tracking tools are included directly in the template using [Twig helper methods](#twig).

The tracking services are executed in sequence depending on the priority.

!!! note

    Every tracking tool service must implement `TrackerInterface`, be tagged as `tracker` and have a defined priority.

## TrackerInterface

`TrackerInterface` returns rendered tracking code snippets and a selected position where the snippets should be placed (top/bottom).

## Twig

`EshopBundle/Resources/views/Components/tracker_macros.html.twig` contains two Twig macros which loop over all tracker contents for a specific position.
Both take `tracking_codes` (array) as parameter.

### top

``` html+twig
{% macro top(tracking_codes) %}
    {% for tracking_html in tracking_codes[constant('Silversolutions\\Bundle\\EshopBundle\\Api\\TrackerInterface::POSITION_TOP')] %}
        {{ tracking_html|raw }}
    {% endfor %}
{% endmacro %}
```

### bottom

``` html+twig
{% macro bottom(tracking_codes) %}
    {% for tracking_html in tracking_codes[constant('Silversolutions\\Bundle\\EshopBundle\\Api\\TrackerInterface::POSITION_BOTTOM')] %}
        {{ tracking_html|raw }}
    {% endfor %}
{% endmacro %}
```

## Twig functions

To get the tracking code that should be passed to the macros you can use the following Twig template functions.

### `ses_track_basket`

Parameters:

- `$basket`
- `$mode`
- `$params`

This method executes all tagged services and returns a list of rendered basket tracking contents depending on given parameters.

For example:

``` html+twig
{% import "SilversolutionsEshopBundle:Components:tracker_macros.html.twig"|st_resolve_template as tracker %}
{% set tracking_codes = ses_track_basket(basket, 'view') %}
{% block tracker_top %}
    {{ tracker.top(tracking_codes) }}
{% endblock %}
...
{% block tracker_bottom %}
    {{ tracker.bottom(tracking_codes) }}
{% endblock %}
```

### `ses_track_product`

Parameters:

- `$catalogElement`
- `$mode`
- `$params`

This method executes all tagged services and returns a list of rendered product tracking contents depending on given parameters.

For example:

``` html+twig
{% import "SilversolutionsEshopBundle:Components:tracker_macros.html.twig"|st_resolve_template as tracker %}
{% set tracking_codes = ses_track_product(catalogElement, 'view') %}
{% block tracker_top %}
    {{ tracker.top(tracking_codes) }}
{% endblock %}
...
{% block tracker_bottom %}
    {{ tracker.bottom(tracking_codes) }}
{% endblock %}
```

### `ses_track_base`

Parameters:

- `$params`

This method executes all tagged services and returns a list of rendered base tracking contents depending on given parameters.

For example:

``` html+twig
{% import "SilversolutionsEshopBundle:Components:tracker_macros.html.twig"|st_resolve_template as tracker %}
{% set tracking_codes_base = ses_track_base() %}
{% block tracker_top_base %}
    {{ tracker.top(tracking_codes_base) }}
{% endblock %}
...
{% block tracker_bottom_base %}
    {{ tracker.bottom(tracking_codes_base) }}
{% endblock %} 
```

## Implementing a custom tracker

The following example shows how to implement a recommendation tracker service.
The service must implement the [TrackerInterface](#tracker-interface).

``` php
namespace Company\ProjectBundle\Service;

use Silversolutions\Bundle\EshopBundle\Api\TrackerInterface;

class RecommendationTrackerService implements TrackerInterface
{

    /**
    * get the dependencies
    */
    public function __construct(...)
    {
        ...
    }

    /**
    * returns an array with rendered template snippet and the required position
    * depending on given parameters in following format
    *  array(
    *      'position' => self::POSITION_TOP
    *      'template' => '<script...'
    * )
    *   
    * @param Basket $basket
    * @param string $mode
    * @param array $params
    * @return array
    *
    */
    public function getBasketTrackingHtmlResult(Basket $basket, $mode, $params = array())
    {
        // TODO: Implement getBasketTrackingHtmlResult() method.
    }

    /**
    * returns an array with rendered template snippet and the required position
    * depending on given parameters in following format
    *  array(
    *      'position' => self::POSITION_TOP
    *      'template' => '<script...'
    * )
    *
    * @param ProductNode $catalogElement
    * @param string $mode
    * @param array $params
    * @return array
    *
    */
    public function getProductTrackingHtmlResult(ProductNode $catalogElement, $mode, $params = array())
    {
        // TODO: Implement getProductTrackingHtmlResult() method.
    }

    /**
    * returns an array with rendered template snippet and the required position
    * depending on given parameters in following format
    *  array(
    *      'position' => self::POSITION_TOP
    *      'template' => '<script...'
    * )
    *
    * @param array $params
    * @return array
    *
    */
    public function getBaseTrackingHtmlResult($params = array())
    {
        // TODO: Implement getBaseTrackingHtmlResult() method.
    }
}
```

You must register the implementation as a service and tag it with `tracker` with a `priority` attribute.
With the priority you can customize the order of invocation for all tracking services (lower number means earlier invocation).

``` xml
    <parameters>
        <parameter key="company_tracking.recommendation_tracker.class">Company\ProjectBundle\Service\RecommendationTrackerService</parameter>
    </parameters>

    <services>
        <service id="company_tracking.recommendation_tracker" class="%company_tracking.recommendation_tracker.class%">
            <argument type="service" id="templating" />
            <argument type="service" id="siso_tools.template_resolver" />
            <argument>%recommendation_customer_id%</argument>            
            <tag name="tracker" priority="1" />
        </service>
    </services>
```
