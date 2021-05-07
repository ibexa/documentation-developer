# Enabling personalization

The personalization service is based on a client-server architecture.
To enable it, you must set up authentication parameters that you receive from Ibexa.

## Getting authentication parameters

First, either you or another Ibexa user responsible for managing the website 
must [request access to the service](https://doc.ibexa.co/projects/userguide/en/latest/personalization/enabling_personalization/#requesting-access-to-the-server).

## Setting up customer credentials

When you receive the confirmation email, add the credentials to your configuration.
In the root folder of your project, edit either the `.env` or `.env.local` file 
by adding two lines that may look similar to the following example. 

```
RECOMMENDATION_CUSTOMER_ID=12345
RECOMMENDATION_LICENSE_KEY=67890-1234-5678-90123-4567
```

## Configuring event tracking

Next, you must [configure the recommendation client](recommendation_client.md#configuration) 
that tracks visitor events in relation to Content Types.

## Configuring recommendation logic

Once you enable the recommendation client, you can go back to the Back Office, 
refresh the Personalization dashboard and proceed with [configuring the logic](https://doc.ibexa.co/projects/userguide/en/latest/personalization/perso_configuration) used to calculate 
the recommendation results.
