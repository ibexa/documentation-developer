---
description: Client-side Tracking in Ibexa CDP.
edition: experience
---

# Add Client-side Tracking

The final step is setting up a tracking script.
It requires a head tracking script between the `<head></head>` tags on your website, a main script after the head script, and cookie consent.

For more information about setting up a tracking script, see [Raptor documentation](https://content.raptorservices.com/help-center/client-side-tracking).

Now, you need to add a tracker to specific places in your website where you want to track users.
For example, add this tracker to the landing page template to track user entrances.

```js
raptor.trackEvent('visit', ..., ...);
```
or purchases:

```js
  //Parameters for Product 1
raptor.trackEvent('buy', ..., ...);
  //Parameters for Product 2
raptor.trackEvent('buy', ..., ...);
```

For tracking to be effective, you also need to send ID of a logged-in user in the same way.
Add the user ID information by using below script:

```js
raptor.push("setRuid","USER_ID_HERE")
```

For more information on tracking events, see [the documentation](https://content.raptorservices.com/help-center/tracking-events-for-recommendation).