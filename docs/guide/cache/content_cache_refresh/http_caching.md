# HTTP caching [[% include 'snippets/commerce_badge.md' %]]

The central point of HTTP caching is a service called `HttpCachingStrategyService`.
It enables configuring each controller's response separately.

Another important solution is `Identity\IdentityDefiner`
which has separate caches for different Users or User Groups. This service is optional.

## Configuration

First, enable HTTP caching and ESI support and configure services in Symfony.

Be sure that HTTP caching is enabled in web server virtual host configuration:

```
SetEnv USE_HTTP_CACHE 1
```

Next, enable ESI support in Symfony:

``` yaml
framework:
    esi: { enabled: true }
    fragments: { path: /_fragment }
```

The service configuration is handled in `services.xml`:

``` xml
<service id="siso_core.http_caching.strategy" class="%siso_core.http_caching.strategy.class%">
    <argument type="service" id="ezpublish.config.resolver" />
</service>
```

Optionally, configure identity definer service:

``` xml
<service id="siso_core.http_caching.identity_definer" class="%siso_core.http_caching.identity_definer.class%">
    <argument type="service" id="ezpublish.api.repository" />
    <tag name="ezpublish.identity_definer" />
</service>
```

### Cache blocks configuration

You need to configure sets of caching parameters (cache blocks) and use the name of cache blocks in controller actions:

``` php
$response = new Response();
// Get an instance of HTTP caching strategy
$cachingStrategy = $this->get('siso_core.http_caching.strategy');

// Cache response using preconfigured cache block name "product"
$cachingStrategy->defineResponse($response, 'product', $catalogElement->cacheIdentifier);
```

All cache blocks are described in the `silver_eshop.default.http_cache` parameter in `parameters.yml`:

``` yaml
silver_eshop.default.http_cache:
    # cache block name
    any_cache_block_name:
        # Response max age in seconds. Zero means that this response will not be cached.
        max_age: 3600
        # Vary is a criteria that allows to have different caches for different users or user groups.
        # Possible values:
        #     ~          : don't vary cache. Let's have one page representation for everybody.
        #     cookie     : each user will have his own cache block for this response
        #     user-hash  : each user group will have its own cache based on IdentityDefiner.
        vary: ~
```

The following example configures four different blocks:

``` yaml
silver_eshop.default.http_cache:
    product:
        max_age: 3600
        vary: ~
    product_list:
        max_age: 3600
        vary: ~
    price_block:
        max_age: 0
    header_login:
        max_age: 36000
        vary: cookie
    basket_preview:
        max_age: 36000
        vary: cookie
```

## Usage

To cache responses you need to inject an instance of `HttpCachingStrategyService`
or get this instance from a container.

Symfony HTTP cache or Varnish use response headers to store the response. 

`defineResponse()` reads parameters from cache block configuration and defines a unique cache
that gives a possibility to purge particular cache blocks matched by this ID. 

Parameters:

- `Response $response` - response object which is modified
- `string $blockName` - cache block name
- `$id = null` - cache identifier (e.g, basket ID or catalog element ID)

Example:

``` php
$cachingStrategy->defineResponse($response, 'product', $catalogElement->cacheIdentifier);
```

## Purging caches

### Console command

Parameters:

- IDs - List of space-separated cache identifiers, e.g. "111 222 333". By default the command clears all HTTP caches.

Example:

``` bash
php bin/console silversolutions:http-cache:purge 1056 222 --env="prod"
```

### Purging using [[= product_name =]] service

If you programmatically updated product data, basket or some other cached content,
you need to update caches to show users current information.

To do this you need to inject or get the purger service:

Example:

``` 
<call method="setHttpCachePurger">
    <argument type="service" id="ezplatform.http_cache.purge_client" />
</call>
```

Next, call the purger service:

Example:

``` php
/**
 * @param GatewayCachePurger $cachePurger
 */
public function (EzSystems\PlatformHttpCacheBundle\PurgeClient\PurgeClientInterface $cachePurger)
{
    $this->cachePurger = $cachePurger;
}
/**
 * @param $basketId
 */
protected function purgeBasketHttpCache($basketId)
{
    if($this->cachePurger){
        $this->cachePurger->purge(['siso_basket' . $basketId]);
    }
}
```

## Caching in `CatalogController`

Caching for different kinds of catalog elements is implemented in the `CatalogController`:

``` php
if ($catalogElement instanceof ProductNode) {
    $cachingStrategy->defineResponse($response, 'product', $catalogElement->cacheIdentifier);
} elseif ($catalogElement instanceof ProductType) {
    $cachingStrategy->defineResponse($response, 'product_type', $catalogElement->cacheIdentifier);
} elseif ($catalogElement instanceof CatalogElement
    && $this->getCustomerProfileDataService()->isUserAnonymous()
) {
    $cachingStrategy->defineResponse($response, 'product_list', $catalogElement->cacheIdentifier);
}
```
