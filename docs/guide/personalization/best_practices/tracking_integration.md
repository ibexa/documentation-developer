# Tracking Integration

There are several ways to integrate event reporting into the webpage. The simplest way is to generate code of a tiny image and put it on the webpage (pixel tracking) where the event must be sent.

For example: 

``` html
<img href="https://event.yoochoose.net/ebl/00000/click/johndoe/1/100?categorypath=/a/ab/abc" width="1" height="1">
```

or by javascript Image tracking

``` js
<script type="text/javascript">
var img = new Image(1,1);
img.src = "https://event.yoochoose.net/ebl/00000/click/johndoe/1/100?categorypath=/a/ab/abc";
</script>
```

The drawback of this option is that such a call can be blocked by ad blockers or do-not-track plugins on the client side.

## Server side tracking

Another option is to call the tracker from the server. The most important drawback is the increase in request time by the time of the recommendation request. If the network is overloaded or the Recommendation Engine is not available the number of requests could grow and lead to a stalled and finally crashing httpd service. There are several techniques which help to avoid it.

### Tracking in the bottom

You can place the code at the very end of the generating script and flush the output buffer to the client just before sending events. The connection to the browser will usually still be open during processing, but it will be transparent for the end customer.

### Tracking asynchronously

If the website is implemented in a language which supports multithreading, non-blocking I/O or messaging infrastructure, it is possible to start the recommendation request just after the browser request is received and/or not wait until this process is finished.

## Client side tracking

### JSONP

Another solution is to provide the proxy on the server side, which will forward script requests to the Recommender Engine. In this case the requests will be triggered from the client, when the page is already loaded and rendered. It is not possible to request the recommendation controller server directly from the javascript (over AJAX library or directly over XMLHttpRequest) because of the cross-domain restriction in most browsers. One of the possible technique to work around this limitation is [JSONP](https://en.wikipedia.org/wiki/JSONP).

### Using a server proxy

Another option is to tunnel the JavaScript request through the proxy on the same server. The server must just forward them to the Recommender Engine. It can be a simple implemented apache proxy module, some independent daemon like “netcat” or a PHP script.

## Comparison

An overview of pros and cons for every technique:

| Problem | Image | Server Side | Bottom Reporting | Async. Reporting | JSON | XMLHttpRequest + Proxy |
|----|-----|-----|-----|-----|-----|------|
| Is not blocked by ad blockers or no-track plug-ins. |-| Yes | Yes | Yes |-| Yes |
| Works if JavaScript is disabled. | Yes | Yes | Yes | Yes |-|-|
| Is compatible with frontend caching on the server. |-|-|-|-|Yes | Yes |
| Does not delay page rendering. | Yes |-| Yes | Yes | Yes | Yes |
| Supports authentication for event tracking (not implemented yet) |-| Yes | Yes | Yes |-| depends |

!!! tip "What we recommend"

    We suggest using Image/Pixel tracking for non-complex events and where every page is generated on the server side without caching logic. Some hints how to use preload image URLs with (`var img = new Image(); img.src="uri"`) or without (`&lt;img src="uri"... /&gt;`) javascript elements are given under https://www.mediacollege.com/internet/javascript/image/preload.html.

    If you are planning to implement caching mechanisms and more complex events like consume (depending on viewing time of the page), basket (which is usually an in-page event) or custom in-page events that take place on the client side, we definitely recommend a javascript implementation. We provide an example script and some instructions under [Tracking with yct.js](../developer_guide/tracking_with_yct.md)
