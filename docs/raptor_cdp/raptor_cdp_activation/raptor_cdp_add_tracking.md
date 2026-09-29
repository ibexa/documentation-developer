---
description: Adding tracking in Raptor CDP.
---

# Track with [[= product_name_cdp =]]

To set up Raptor CDP, set up a tracking script that identifies visitors and records their interactions.

## Set up tracking with tracking scripts

The tracking script requires a head tracking script between the `<head></head>` tags on your website, a main script after the head script, and cookie consent.

For more information about setting up a tracking script manually, see [Raptor documentation](https://content.raptorservices.com/help-center/client-side-tracking).

Now, you need to add a tracker to specific places in your website where you want to track users.
For example, add this tracker to the landing page template to track various user activities:

- user entrances

    ```js
    raptor.trackEvent('visit', ..., ...);
    ```

- user purchases

    ```js
    //Parameters for Product 1
    raptor.trackEvent('buy', ..., ...);
    //Parameters for Product 2
    raptor.trackEvent('buy', ..., ...);
    ```

For tracking to be effective, you also need to send ID of a logged-in user in the same way.
Add the user ID information of logged-in users by using below script:

```js
raptor.push("setRuid","USER_ID_HERE")
```

For anonymous visitors, Raptor's tracking script automatically sets an `rsa` cookie that uniquely identifies the visitor, without calling the `setRuid` method.

For more information on tracking events, see [Raptor documentation](https://content.raptorservices.com/help-center/tracking-events-parameters-reference).
