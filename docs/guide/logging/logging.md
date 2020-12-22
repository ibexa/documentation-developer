# Logging [[% include 'snippets/commerce_badge.md' %]]

[[= product_name_com =]] uses [Monolog](https://github.com/Seldaek/monolog) to log the most important information.
The default implementation writes standard shop-related information into a single log file.
Emails and ERP communication are written into the database to make it easier to process them for administrative (HTML) presentation.

## GDPR

Some logs can contain personal information which can be affected by the GDPR regulations.

By default, [[= product_name_com =]] does not log the User ID for logging search query:

``` yaml
siso_core.default.gdpr.store_user_id_in_logs: false
```
