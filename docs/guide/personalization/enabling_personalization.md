---
description: Configure your project files to enable Personalization and set up items you want to track.
---

# Enabling personalization

The personalization service is based on a client-server architecture.
To enable it, you must set up authentication parameters that you receive from [[= product_name_base =]].

## Getting authentication parameters

First, either you or another [[= product_name_base =]] user responsible for managing the website 
must [request access to the service]([[= user_doc =]]/personalization/enabling_personalization/#requesting-access-to-the-server).

## Setting up customer credentials

When you receive the confirmation email, add the credentials to your configuration.
In the root folder of your project, edit either the `.env` or `.env.local` file 
by adding the following lines with your customer ID and license key: 

```
RECOMMENDATION_CUSTOMER_ID=12345
RECOMMENDATION_LICENSE_KEY=67890-1234-5678-90123-4567
RECOMMENDATION_HOST_URI=https://server_uri
```

## Configuring event tracking

Next, you must [configure the recommendation client](recommendation_client.md#configuration) 
that tracks visitor events in relation to Content Types.

## Configuring recommendation logic

Once you enable the recommendation client, you can go back to the Back Office, 
refresh the Personalization dashboard and proceed with [configuring the logic]([[= user_doc =]]/personalization/perso_configuration) used to calculate 
the recommendation results.
