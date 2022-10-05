---
description: See the methods of event tracking integration using tracking from server or from client-side.
---

# Tracking integration

There are several ways to integrate event reporting into the webpage. 
The simplest way is to generate code of a tiny image and put it on the webpage 
where the event must be sent (so-called pixel tracking).

For example, with HTML: 

``` html
<img href="https://event.perso.ibexa.co/ebl/00000/click/johndoe/1/100?categorypath=/a/ab/abc" width="1" height="1">
```

or with JavaScript:

``` js
<script type="text/javascript">
var img = new Image(1,1);
img.src = "https://event.perso.ibexa.co/ebl/00000/click/johndoe/1/100?categorypath=/a/ab/abc";
</script>
```

The drawback of this option is that such calls can be blocked by ad blockers 
or do-not-track plugins on the client side.

## Server-side tracking

Another option is to call the tracker from the server. 
The most important drawback is that the event request increases the general request time. 
If the network is overloaded or the Personalization server is not available, 
the number of requests could grow and lead to a stalled and finally crashing HTTP service. 
There are several techniques that can help you avoid it.

### Tracking at the bottom

You can place the code at the very end of the generating script 
and flush the output buffer to the client just before sending the events. 
The connection to the browser might remain open for the time of processing, 
but it will be transparent for the end user.

### Tracking asynchronously

If the website is implemented in a language that supports multithreading, non-blocking 
I/O or messaging infrastructure, you can start the event request just after 
the browser request is received instead of waiting for this process to finish.

## Client-side tracking

### Using JSONP

Another solution is to provide a proxy on the server side, which will forward 
script requests to the Personalization server. 
In this model, the requests are triggered from the client, when the page is already 
loaded and rendered. 
It is impossible to request the recommendation controller server directly from JavaScript 
(either through the AJAX library or directly over XMLHttpRequest) because of the 
cross-domain restriction in most browsers. 
One possible work around this limitation is [JSONP](https://en.wikipedia.org/wiki/JSONP).

### Using a server proxy

Another option is to tunnel the JavaScript request through the proxy on the same server. 
The server only forwards requests to the Personalization server. 
It can be a simple implemented Apache proxy module, an independent daemon 
(for example, "netcat"), or a PHP script.

## Comparison

An overview of pros and cons for every technique:

| Problem | Pixel | Server-side | Page bottom | Async. reporting | JSONP | XMLHttpRequest + Proxy |
|----|-----|-----|-----|-----|-----|------|
| Is not blocked by ad blockers or do-not-track plug-ins. |-| Yes | Yes | Yes |-| Yes |
| Works if JavaScript is disabled. | Yes | Yes | Yes | Yes |-|-|
| Is compatible with frontend caching on the server. |-|-|-|-|Yes | Yes |
| Does not delay page rendering. | Yes |-| Yes | Yes | Yes | Yes |
| Supports authentication for event tracking (not implemented yet). |-| Yes | Yes | Yes |-| Yes/No |

!!! tip "The recommended approach"

    An Ibexa-recommended solution is to use pixel tracking for non-complex events,
    or where every page is generated on the server side without any caching logic.
    For hints about preloading image URLs with JavaScript elements 
    (`var img = new Image(); img.src="uri"`)
    or without them (`&lt;img src="uri"... /&gt;`), see [How to Preload Images](https://www.mediacollege.com/internet/javascript/image/preload.html).

    If you plan to implement caching mechanisms and more complex events like 
    consume (depending on the viewing time of the page), basket (which is usually 
    an in-page event) or custom in-page events that take place on the client side, 
    a JavaScript implementation is strongly encouraged.
    For a sample script and instructions, see [Track with yct.js](tracking_with_yct.md).
