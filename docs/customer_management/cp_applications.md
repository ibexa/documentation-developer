---
description: Customization of an approval process for new companies applications.
edition: experience
---

# Customer Portal applications

New business customers can apply for a company account.
Applications go through the approval process in the Back Office where they can be accepted, rejected or put on hold.
If they are accepted, the business partner receives an invitation link to the Customer Portal,
where they can set up their team and manage their account.

For more information on company self-registration, see [user guide documentation](https://doc.ibexa.co/projects/userguide/en/latest/shop_administration/company_self_registration/).
If provided options are too limited, you can customize an approval process by yourself.

## Roles and policies

Any user can become application approver, as long as they have the `Company Application/Workflow` Policy assigned to their Role.
There, you can define between which states the user may move applications.
For example, the assistant can put new applications on hold, or reject them, and only the manager can accept them.

![Company Application Policy](img/cp_company_application_policy.png)

## Customer Portal application configuration

Below, you can find possible configurations for Customer Portal applications.

### Reasons for rejecting application

To change or add reasons for not accepting Corporate Portal application go to
`vendor/ibexa/corporate-account/src/bundle/Resources/config/default_settings.yaml`.

```yaml
parameters:
    ibexa.site_access.config.default.corporate_accounts.reasons:
        reject: [Malicious intent / Spam]
        on_hold: [Verification in progress]
```

### Timeout

Registration form locks for 5 minutes after unsuccessful registration,
if the user, for example, tried to use an email address that already exists in a Customer Portal clients database.
To change that duration, go to `config/packages/ibexa.yaml`.

```yaml
framework:
    rate_limiter:
        corporate_account_application:
            policy: 'fixed_window'
            limit: 1
            interval: '5 minutes'
            lock_factory: 'lock.corporate_account_application.factory'
```

## Customization of an approval process

In this procedure, you add a new status to the approval process of business account application.

### Add new status

First, go to `config/packages/ibexa.yaml` and add a `verify` status to the configuration:

```yaml
ibexa:
    system:
        default:
            corporate_accounts:
                application:
                    states: [ 'new', 'accept', 'on_hold', 'reject', 'verify' ]
```

### Create new Form Type

Next, create a new form type in `src/Form/VerifyType.php`.
It will be displayed in the application review stage.

``` php hl_lines="21 22 29"
[[= include_file('code_samples/customer_portal/src/Form/VerifyType.php') =]]
```

Line 29 defines where the form should be displayed, line 21 adds **Note** field, and line 22 adds the **Verify** button.

### Create event subscriber to pass the form

Add an event subscriber that passes a new form type to the frontend.
Create `src/Corporate/EventSubscriber/ApplicationDetailsViewSubscriber.php` following the example below:

``` php hl_lines="39"
[[= include_file('code_samples/customer_portal/src/Corporate/EventSubscriber/ApplicationDetailsViewSubscriber.php') =]]
```

In line 39, you can see the `verify_form` parameter that passes the `verify` form to the application review view.

### Add form template

To be able to see the changes you need to add
a new template `templates/themes/admin/corporate_account/application/details.html.twig`.

``` html+twig
[[= include_file('code_samples/customer_portal/templates/themes/admin/corporate_account/application/details.html.twig') =]]
```

It overrides the default view and adds a **Verify** button to the review view.
To check the progress, go to **Members** -> **Applications**.
Select one application from the list and inspect application review view for a new button.

![Verify button](img/cp_new_status.png)

### Create event subscriber to verify state

Now, you need to pass the information that the button has been selected
to the list of applications to change the application status.
Create another event subscriber that passes the information
from the created form to the application list `src/Corporate/EventSubscriber/VerifyStateEventSubscriber.php`.

``` php hl_lines="46 72"
[[= include_file('code_samples/customer_portal/src/Corporate/EventSubscriber/VerifyStateEventSubscriber.php') =]]
```

In line 46, you can see that it handles changes to verify status.
The subscriber only informs that the status has been changed (line 72).

Now, if you click the **Verify** button during application review, the application will get **Verify** status.

![Verify status](img/cp_verify_status.png)

