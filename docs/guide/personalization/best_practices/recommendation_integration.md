# Recommendation Integration

There are several ways to integrate the REST calls with the Recommendation engine and to avoid blocking web page rendering, if the communication with the Recommender is distrusted or interrupted.

## Simple Way

The simplest way to load recommendations is to synchronously request the Recommendation Engine for recommendations as they are needed. This way is sufficient in most cases. The most important drawback is that the request time increases by the time of the recommendation request. If the network is overloaded or the Recommendation Engine is not available it can lock the request.

## Loading in the bottom

You can place the code that loads the data from the eZ Recommender at the bottom of the generated document and flush the output buffer to the client just before requesting recommendations. The browser will get a whole page to render and can display it even if the very end of the page is still loading. Then the JavaScript code with the recommendation information loaded at the bottom of the page must fill the gaps on the page with recommendations as soon as it is completely loaded.

## Non-blocking loading in the background

If the website is implemented in a language which supports multithreading or non-blocking I/O, it is possible to start the recommendation request just after the browser request is received. The page generation and the recommendation requests will be accomplished in parallel. By combining this idea with the previous solution and placing the recommendation results at the bottom of the page you can avoid any interruption in the processing.

## Loading from JavaScript using JSONP

It is not possible to request the recommendation controller server directly from the JavaScript (over AJAX library or directly over XMLHttpRequest) because of the cross-domain restriction in most browsers. One of the possible ways to work around this limitation is JSONP.

## Loading over proxy

A better solution than JSONP is to provide the proxy on the server side, which will forward script requests to the Recommender system. It can be implemented as a very simple proxy using the mod\_proxy module of Apache Webserver. It just transfers the data and the JavaScript renders the response into HTML itself.

An alternative approach is creating the HTML code on the server side for every target page in a sense to simplify the script on the client side.

As a possible implementation of such a proxy following tools can be used: the apache proxy module, an independent daemon like “netcat” or a PHP script.

## Comparison

An overview of pros and cons for each of the above techniques:

|Problem|Simple Way|Bottom loading|Background loading|JSONP|XMLHttpRequest + Proxy|
|---|---|---|---|---|---|
|Is not blocked by ad blockers or no-track plug-ins|Yes|Yes|Yes|-|Yes|
|Works if JavaScript is disabled|Yes|depends|-|-|-|	 	 
|Works for server without multithreading functionality|Yes|Yes|-|Yes|Yes|
|Compatible with frontend caching on the server|-|-|-|Yes|Yes|
|Does not delay page rendering|-|depends|depends|Yes|Yes|
|Supports authentication for recommendation fetching|Yes|Yes|Yes|-|depends|
