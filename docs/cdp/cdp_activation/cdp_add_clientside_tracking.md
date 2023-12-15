---
description: Client-side Tracking in Ibexa CDP.
---

# Add Client-side Tracking

The final step is setting up a tracking script.
It requires a head tracking script between the `<head></head>` tags on your website,
a main script after the head script, and cookie consent.
For more information about setting up a tracking script, see [a tutorial in Raptor documentation](https://support.raptorsmartadvisor.com/hc/en-us/articles/9563346335004-Client-Side-Tracking).

Now, you need to add a tracker to specific places in your website where you want to track users.
For example, add this tracker to the Landing Page template to track user entrances.

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

For more information on tracking events, see [the documentation](https://support.raptorsmartadvisor.com/hc/en-us/articles/201912411-Tracking-Events).