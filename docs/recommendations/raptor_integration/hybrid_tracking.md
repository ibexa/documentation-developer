---
description: Enable hybrid tracking to avoid ad blockers and proxy events through your server.
month_change: true
---

# Raptor hybrid tracking

Hybrid tracking mode is an additional tracking mode available alongside [`client` and `server`](tracking_functions.md).
In hybrid mode, the bundle includes a client side shim that captures Raptor tracking events and sends them to a same-origin endpoint instead of communicating directly with Raptor SaaS.
The server enriches each event with identifiers resolved from request cookies (`cookieId`, `sessionId`, and `userId`) and forwards it to Raptor asynchronously through [Messenger](background_tasks.md).
Since the browser never connects to the Raptor domain, ad blockers cannot block the requests.

## Hybrid vs server or client side tracking

Both `server` and `hybrid` tracking modes deliver pageviews and events server side, so tracking requests are not affected by ad blockers.
The difference is that `hybrid` mode also loads the Raptor JavaScript in the browser.

The browser script is used only to manage first-party cookies.
It can create and refresh visitor cookies, which helps them last longer in Safari ITP.
Event tracking still happens on the server, so ad blockers cannot block it.

Server mode should be used when browser side cookie management is not necessary.
While hybrid mode is useful when you want the benefits of server side tracking together with improved cookie persistence.

Check the table below to compare the behavior of different tracking modes:

|Tracking type|Browser script|Event delivery|Works with ad blockers|Cookie refresh|
|-------------|--------------|--------------|----------------------|--------------|
|client       |yes           |Browser       |no                    |yes           |
|server       |no            |Server        |yes                   |no            |
|hybrid       |yes           |Server        |yes                   |yes           |

## Hybrid tracking flow

When hybrid tracking is enabled, `TrackingScriptExtension` renders the proxy bootstrap template and loads the `raptor-proxy.js` shim, which replaces the `window.raptor.push` and drains the initial event queue.
The shim sends batched events to the configured proxy endpoint, by default, `/raptor/track`.
The `TrackingProxyController::track` controller validates the `EventPayloadParser` payload, enriches each event with identifiers resolved from cookies, and dispatches one `TrackProxiedEventMessage` for every event.
Messages are then processed asynchronously through `MessageProvider` and `SendersLocator`, and `TrackProxiedEventMessageHandler` ultimately forwards them to Raptor through `TrackingService::trackRawParameters`.

### Hybrid tracking configuration

To configure the Raptor hybrid tracking, use the `ibexa.system.<scope>.connector_raptor` configuration key in the `config/packages/ibexa_connector_raptor.yaml` file:

``` yaml
ibexa_connector_raptor:
    hybrid_tracking_proxy_path: '/track'

ibexa:
    system:
        default:
            connector_raptor:
                enabled: true
                customer_id: '<id>'
                tracking_type: hybrid
```

### Routing import

Hybrid tracking requires routing import.
It means that the proxy endpoint route must be imported in the project, for example in the `config/routes.yaml` file:

``` yaml
ibexa.connector_raptor:
    resource: '@IbexaConnectorRaptorBundle/Resources/config/routing.yaml'
```

### Proxy path configuration

You can configure the proxy endpoint path globally.
By default, it's set to `/raptor/track`.
The client side shim sends tracking events to this same-origin endpoint, which forwards them to Raptor asynchronously.

``` yaml
ibexa_connector_raptor:
    hybrid_tracking_proxy_path: '/track'
```

!!! note

   The path must start with a `/` symbol.
   The route is generated from this value, so updating it automatically updates the route as well.
   You don't need to modify the routing import.

### Template usage

The Twig API remains identical regardless of the configured tracking mode:

``` html+twig
{{ ibexa_tracking_script() }}
{{ ibexa_tracking_track_event('visit', product) }}
```
