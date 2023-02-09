---
description: Ensure that your logs are secure and GDPR compliant by clearing them of sensitive user data.
---

# Logging

## Sensitive user data

Some logs can contain personal information such as User ID or password.

By default, [[= product_name =]] does not log User IDs.
You can change this behavior by modifying the following setting:

``` yaml
ibexa.commerce.site_access.config.core.default.gdpr.store_user_id_in_logs: false
```

If the email text contains a password that should not be logged in the DB, you have to specify this password as a template parameter.

`MailHelperService` replaces the template parameter `password` with `***`.
