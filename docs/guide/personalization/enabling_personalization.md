# Enable personalization

The personalization service is based on a client-server architecture.
To enable it, you must set up authentication parameters that you receive from Ibexa.

## Get authentication parameters

First, either you or another Ibexa user responsible for managing the website 
must [request access to the service](https://doc.ibexa.co/projects/userguide/en/latest/personalization/enabling_personalization/#requesting-access-to-the-server).

## Set up customer credentials

When you receive the confirmation email, add the credentials to your configuration.
In the root folder of your project, edit either the `.env` or `.env.local` file 
by adding the following lines with your customer ID and license key: 

```
RECOMMENDATION_CUSTOMER_ID=12345
RECOMMENDATION_LICENSE_KEY=67890-1234-5678-90123-4567
```

!!! note "Configuring user credentials for different customers"

    If your installation [supports multiple sites](https://doc.ibexa.co/projects/userguide/en/latest/personalization/use_cases/#support-for-multiple-websites) with different 
    customer IDs, for example, to provide separate recommendations for different 
    language versions of the store, you can store all credentials in the same file:
    
    ```
    # Main credentials - ENU store
    RECOMMENDATION_CUSTOMER_ID=12345
    RECOMMENDATION_LICENSE_KEY=67890-1234-5678-90123-4567

    # Additional credentials - FRA store 
    FRA_CUSTOMER_ID=54321
    FRA_LICENSE_KEY=09876-5432-1098-7654-3210
    ```

## Configure event tracking

Next, you must [configure the recommendation client](recommendation_client.md#configuration) 
that tracks visitor events in relation to Content Types.

## Set up user roles and permissions

Depending on your requirements, you may need to set up `edit` and `view` [permissions](../permissions.md) 
to grant users access to recommendation settings that relate to different SiteAccesses 
and results that come from these websites.

## Configure recommendation logic

Once you enable the recommendation client, you can go back to the Back Office, 
refresh the Personalization dashboard and proceed with [configuring the logic](https://doc.ibexa.co/projects/userguide/en/latest/personalization/perso_configuration) 
used to calculate the recommendation results.
