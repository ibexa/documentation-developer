# Enabling Personalization

The Ibexa Personalization solution is based on a client-server architecture.
To make enable it, you must get and set up authentication parameters.

## Requesting access to the server

First, you must accept the terms and conditions of the Personalization service.

To do this, in the Back Office, select **Personalization** and then **Dashboard**.
On the welcome screen, enter the following details in their respective fields:

* full name of the person responsible for accepting the terms and conditions
* e-mail address to which you want the confirmation to be sent
* Installation key that can be found on the **Maintenance and Support agreement details** page in the service portal

Select the **I have read and agree to the Terms and Conditions.** checkbox, and then click **Submit**.
Your request is sent to Ibexa, and you will receive a confirmation email in response.

## Configuring mandator credentials

When you receive the confirmation email, you must add the credentials to your configuration.
In the root folder of your project, edit either the `.env` or `.env.local` file by adding two lines that 
may look similar to the following example. 

```
RECOMMENDATION_CUSTOMER_ID=12345
RECOMMENDATION_LICENSE_KEY=67890-1234-5678-90123-4567
```

You can now go back to the Back Office, refresh the Personalization dashboard and proceed to configuring 
the Personalization solution.

## Changing the Installation key

If necessary, you can modify the Installation key configured in the personalization settings.
To do this, in the Back Office, select **Personalization** and then **Settings**.
Modify the value in the **Installation key** field and save your changes.

!!! note 

    Clearing the **Installation key** field disables the Personalization solution for your account temporarily.
    Entering the same key re-enables the feature.
