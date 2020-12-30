# Enabling Personalization

The Ibexa Personalization solution is based on a client-server architecture.
To make it operational, you must obtain and set up certain configuration parameters.

## Requesting access to the engine

At first you must request credentials required to access the recommendation engine.

To do this, in the Back Office, select **Personalization** and then **Dashboard**.
On the welcome screen, enter the following details in their respective fields:

* a full name of the person responsible for accepting the terms and conditions of the Personalization service
* an e-mail address to which you want the credentials to be sent to
* an Installation key that can be found on the **Maintenance and Support agreement details** page in the service portal

Select a checkbox to confirm that you've read the terms and conditions, and then click **Submit**.
Your request is sent to Ibexa, and you will receive a confirmation e-mail in response.

## Configuring mandator credentials

When you've received the confirmation e-mail, you must add the credentials to your configuration.
In the root folder of your project, edit either the `.env` or `.env.local` file by adding two lines that may look similar to the following example. 

```
RECOMMENDATION_CUSTOMER_ID=12345
RECOMMENDATION_LICENSE_KEY=67890-1234-5678-90123-4567
```

You can now go back to the Back Office, refresh the personalization dashboard and proceed to configuring the Personalization solution.

## Changing the Installation key

If necessary, you can modify the Installation key configured in the personalization settings.
To do this, in the Back Office, select **Personalization** and then **Settings**.
Modify the value in the **Installation key** field and save your changes.

!! note 

  Clearing the **Installation key** field disables the Personalization solution for your account temporarily.
  Entering the same key re-enables the feature.

## Unregistering the installation key

You can also revoke your agreement to the terms and conditions of the Personalization solution and permanently disable the feature for your account.

To do this, use your browser to navigate to an address similar to the following example:

 ```
 https://support.ibexa.co/personalisation/remove-customer-data/<your_installation_key>
 ```
