---
description: Ensure that your logs are secure and GDPR compliant by clearing them of sensitive user data.
---

# Logging

[[= product_name =]] uses [Monolog](https://github.com/Seldaek/monolog) to log shop-related information.

By default, ERP messages and emails are stored in the database.
All other log entries are stored in `var/log/silver.eshop.log`.

All emails that are sent with `MailHelperService` are logged automatically.

## Sensitive user data

Some logs can contain personal information such as User ID or password.

By default, [[= product_name =]] does not log User IDs.
You can change this behavior by modifying the following setting:

``` yaml
siso_core.default.gdpr.store_user_id_in_logs: false
```

If the email text contains a password that should not be logged in the DB, you have to specify this password as a template parameter.

`MailHelperService` replaces the template parameter `password` with `***`.
