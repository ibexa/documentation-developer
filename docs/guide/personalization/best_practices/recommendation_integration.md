---
description: Methods for REST call with Personalization server.
---

# Recommendation integration

There are several ways to integrate the REST calls with the Personalization server 
and to avoid blocking web page rendering, if the communication with the Recommender 
is distrusted or interrupted.

## Simple way

The simplest way to load recommendations is to synchronously request the Personalization 
server for recommendations as they are needed. This way is sufficient in most cases. 
The most important drawback is that the request time increases by the time 
of the recommendation request. 
If the network is overloaded or the Personalization server is not available, 
it can lock the request.

## Load in the bottom

You can place the code that loads the data from the eZ Recommender at the bottom 
of the generated document and flush the output buffer to the client 
just before requesting recommendations. 
The browser will get a whole page to render and can display it even if the very end 
of the page is still loading. 
Then the JavaScript code with the recommendation information loaded at the bottom 
of the page must fill the gaps on the page with recommendations as soon as 
it is completely loaded.

## Non-blocking loading in the background

If the website is implemented in a language that supports multithreading or 
non-blocking I/O, the recommendation request can start just after the browser 
request is received. 
The page generation and the recommendation requests are accomplished in parallel. 
By combining this idea with the previous solution and placing the recommendation 
results at the bottom of the page you can avoid any interruption in the processing.

## Loading from JavaScript using JSONP

You cannot request the recommendation controller server directly from the JavaScript 
(over AJAX library or directly over XMLHttpRequest) because of the cross-domain 
restriction in most browsers. 
One of the possible ways to work around this limitation is JSONP.

## Loading over proxy

A better solution than JSONP is to provide the proxy on the server side, which 
forwards script requests to the Personalization service. 
It can be implemented as a very simple proxy using the mod\_proxy module of 
the Apache Webserver. 
It just transfers the data and the JavaScript renders the response into HTML itself.

An alternative approach is to create the HTML code on the server side for every 
target page, to simplify the script on the client side.

You can use the following tools as an implementation of such a proxy: 
the Apache proxy module, an independent daemon like “netcat” or a PHP script.

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
