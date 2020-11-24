# Logging FAQ [[% include 'snippets/commerce_badge.md' %]]

## Which log entries are stored in the database?

By default, ERP messages and emails are stored in the database.

All other log entries are stored in the .log file.

## `log` database tables cannot be found

If you get an error that `log` database tables cannot be found, update your database schema:

``` bash
php bin/console doctrine:schema:update [--dump-sql|--force]
```

## How do I invoke a simple log instruction?

The ID for the standard logging is `silver_common.logger`. This is an instance of `Monolog\Logger`.
You can write a simple debug log in a container action in the following way:

``` 
$logger = $this->get('silver_common.logger');
$additionalContext = array('exception' => $ex);
$logger->debug('My log message', $additionalContext);
```

## How do I log a newly created ERP message?

All transmitted messages are logged automatically, because the mandatory transport layer automatically logs all messages.
But if a new transport is implemented (other than `WebConnectorMessageTransport`),
this implementation has to take care of logging the measuring point on a lower level.
See [Measuring Points in the ERP logging documentation](../erp_integration/erp_communication/erp_logging.md#logging-architecture-measuring-points)
for more information.

## How do I log an email that is sent by the shop?

All emails that are sent with [`MailHelperService`](../../api/commerce_api/helper_services/mailhelperservice.md) are logged automatically.

## How do I avoid logging the password in the database?

If the email contains a password that should not be logged in the DB, you have to specify this password as a template parameter.

[`MailHelperService`](../../api/commerce_api/helper_services/mailhelperservice.md) replaces the template parameter `password` with `***`.

## Where can I find the log file?

The standard log file is located in `var/logs/silver.eshop.log`

More precisely, Monolog's [StreamHandler](https://github.com/Seldaek/monolog/blob/master/doc/02-handlers-formatters-processors.md#log-to-files-and-syslog) writes logs into files.
The path to the file is a [constructor parameter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/StreamHandler.php#L33) of the StreamHandler.
For an example of service configuration, see [ERP Logging](../erp_integration/erp_communication/erp_logging.md#configuration).
