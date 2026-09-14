---
description: Enable hybrid tracking to avoid ad blockers and proxy events through your server.
month_change: true
delete: true
---

# Hybrid tracking

Hybrid tracking mode is an additional tracking mode available alongside [`client` and `server`](tracking_functions.md).
In hybrid mode, the bundle includes a client-side [shim](https://en.wikipedia.org/wiki/Shim_(computing)) that captures [[= product_name_cdp_base =]] tracking events and sends them to a same-origin endpoint instead of communicating directly with [[= product_name_cdp_base =]] servers.
The server enriches each event with identifiers resolved from request cookies (`cookieId`, `sessionId`, and `userId`) and forwards it to [[= product_name_cdp_base =]] asynchronously through [Ibexa Messenger](background_tasks.md).
Since the browser never connects to the [[= product_name_cdp_base =]] domain, ad blockers cannot block the requests.

## Hybrid vs server or client-side tracking

Both `server` and `hybrid` tracking modes deliver pageviews and events server-side, so tracking requests are not affected by ad blockers.
The main difference is that `hybrid` mode loads a first-party tracking JavaScript (`raptor-proxy.js`) provided by the [[= product_name =]] instance, instead of the [[= product_name_cdp_base =]] SaaS JavaScript.
The [[= product_name_cdp_base =]] script itself (`//deliver.raptorstatic.com/script/raptor-3.0.min.js`) is loaded only in `client` mode.

The browser script only forwards captured tracking events to the same-origin proxy endpoint on your [[= product_name =]] instance. First-party visitor cookies are created and refreshed server-side, which is what helps them survive Safari [Intelligent Tracking Prevention](https://webkit.org/blog/7675/intelligent-tracking-prevention/).
Event tracking still happens on the server, so ad blockers cannot block it.

The main advantage of `hybrid` mode over `server` mode is its ability to capture client-side tracking events.
Visitor cookies are also refreshed more frequently than in `server` mode.

Check the table below to compare the behavior of different tracking modes:

|Tracking type|Browser script|Event delivery|Works with ad blockers|Cookie refresh                       |
|-------------|--------------|--------------|----------------------|-------------------------------------|
|client       |yes           |Browser       |no                    |yes                                  |
|server       |no            |Server        |yes                   |yes (server-side, on full page loads)|
|hybrid       |yes           |Server        |yes                   |yes                                  |

## Hybrid tracking flow

When hybrid tracking is enabled, `TrackingScriptExtension` renders the proxy bootstrap template and loads the `raptor-proxy.js` shim, which replaces the `window.raptor.push` function and sends out the events queued before the tracking consent was given.
The shim sends each captured event to the proxy endpoint as a separate POST request.
The `TrackingProxyController::track` action validates the `EventPayloadParser` payload, enriches each event with identifiers resolved from cookies, and dispatches one `TrackProxiedEventMessage` for every event.
Messages are then processed asynchronously via Ibexa Messenger and `TrackProxiedEventMessageHandler` ultimately forwards them to [[= product_name_cdp_base =]] through `TrackingService::trackRawParameters`.

### Hybrid tracking configuration

To configure the [[= product_name_cdp_base =]] hybrid tracking, use the `ibexa.system.<scope>.connector_raptor` configuration key in the `config/packages/ibexa_connector_raptor.yaml` file:

``` yaml
ibexa_connector_raptor:
    hybrid_tracking_proxy_path: '/raptor/track'

ibexa:
    system:
        default:
            connector_raptor:
                enabled: true
                customer_id: '<id>'
                tracking_type: hybrid
```

!!! note

    The `hybrid_tracking_proxy_path` setting is configured globally, while `enabled`, `customer_id`, and `tracking_type` are configured per SiteAccess.

### Routing import

Hybrid tracking requires routing import.
It means that the proxy endpoint route must be imported in the project, for example in the `config/routes/ibexa_connector_raptor.yaml` file:

``` yaml
ibexa.connector_raptor:
    resource: '@IbexaConnectorRaptorBundle/Resources/config/routing.yaml'
```

This import is required only in `hybrid` mode.
Without it, the proxy endpoint returns 404 responses and tracking events are not processed.

### Proxy path configuration

You can configure the proxy endpoint path globally.
By default, it's set to `/raptor/track`.
The client-side shim sends tracking events to this same-origin endpoint, which forwards them to [[= product_name_cdp_base =]] asynchronously.

``` yaml
ibexa_connector_raptor:
    hybrid_tracking_proxy_path: '/track'
```

!!! note

    The path must start with a `/` symbol and cannot overlap with any existing routes.
    The route is generated from this value, so updating it automatically updates the route as well.
    You don't need to modify the routing import.

After changing the configuration, clear the application cache:

``` bash
php bin/console cache:clear
```

Verify that the route has been registered correctly.
To do it, run the following command:

``` bash
php bin/console debug:router | grep raptor
```

### Template usage

By default, the tracking script waits for user consent before sending tracking events.

The Twig API remains identical regardless of the configured tracking mode:

``` html+twig
{{ ibexa_tracking_script() }}
{{ ibexa_tracking_track_event('visit', product) }}
```
