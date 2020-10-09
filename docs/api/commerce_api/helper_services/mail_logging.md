# Mail logging

Every email sent by `MailHelperService` is recorded by `siso_tools.mailer.logger`.
It is a special service of the `Monolog/Logger` class.

For more information about logging, see [logging documentation](../../../guide/logging/logging.md).

## MailLog entity and repository

Emails are logged in a database. Database logging is handled by [the Doctrine logger](../../../guide/logging/logging_api.md#base-classes-of-doctrine-based-logging).

### Siso\Bundle\ToolsBundle\Entity\MailLog

This is the mail logging extension of `AbstractLog`. It contains the following attributes:

- `private $requestId` - string - A value which identifies uniquely every HTTP request across all logs.
- `private $sessionId` - string - A value which identifies uniquely every client session across all logs and requests.
- `private $userId` - string - The identifier for the user (mostly eZ User object ID).
- `private $sender` - string - The sender's email address.
- `private $receiver` - string - The receiver's email address.
- `private $subject` - string - The mail subject content.
- `private $sentTimestamp` - `\DateTime` - The date and time of sending.
- `private $status` - boolean - True if the mail has been sent successfully, false otherwise.

### Class Siso\Bundle\ToolsBundle\Service\Logging\MailDataProcessor

This Monolog data processor replaces the original log message with the non-empty contents of `context/content_html` or `context/content_text`, in this order of precedence.

!!! note:

    Most emails are sent with `MailHelperService`.
    Error messages during the email process are only logged to the database if the email body cannot be rendered.
    If sending of the email failed, the email body is logged and any error message is ignored in this logging process.

The email log entity has no field for the content body. It is intended to log this data within the message attribute.

### Siso\Bundle\ToolsBundle\Entity\MailOrmLogRepository

This is the Doctrine repository class for `MailLog` entities.
It exists to comply with the Doctrine conventions and to inject it into the mail logging instance of `DoctrineHandler`.

## Configuration

### Container `set-tp` for mail logging

``` xml
<parameters>
    <parameter key="siso_tools.mailer.logging_processor.class">Siso\Bundle\ToolsBundle\Service\Logging\MailDataProcessor</parameter>
    <parameter key="siso_tools.mailer.logging_repository.doctrine.class">Siso\Bundle\ToolsBundle\Entity\MailOrmLogRepository</parameter>
    <parameter key="siso_tools.mailer.logging.entity">SisoToolsBundle:MailLog</parameter>
</parameters>
<services>
    <!-- Define the repository as an injectable service -->
    <service id="siso_tools.mailer.logging_repository.doctrine" class="%siso_tools.mailer.logging_repository.doctrine.class%">
        <factory service="doctrine.orm.default_entity_manager" method="getRepository" />
        <argument type="string">%siso_tools.mailer.logging.entity%</argument>
    </service>
    <!-- Define the doctrine handler that logs into the mail log repository -->
    <service id="siso_tools.mailer.logging_handler.doctrine" class="%siso_tools.logging_handler.doctrine.class%">
        <!-- Inject the mail log repository -->
        <call method="setLogRepository">
            <argument type="service" id="siso_tools.mailer.logging_repository.doctrine" />
        </call>
        <!-- Inject the doctrine formatter -->
        <call method="setFormatter">
            <argument type="service" id="siso_tools.logging_formatter.doctrine"/>
        </call>
    </service>
    <!-- Define the processor that copies the mail body to the message field -->
    <service id="siso_tools.mailer.logging_processor" class="%siso_tools.mailer.logging_processor.class%">
    </service>
    <!-- This is the actual logger that is to be injected into the MailHelperService
         or any other instance, which sends mails -->
    <service id="siso_tools.mailer.logger" class="%monolog.logger.class%">
        <!-- The logging channel -->
        <argument>silver_eshop_mail</argument>
        <!-- Inject the doctrine handler -->
        <call method="pushHandler">
            <argument type="service" id="siso_tools.mailer.logging_handler.doctrine"/>
        </call>
        <!-- Register the processor that adds the sessionId and requestId -->
        <call method="pushProcessor">
            <argument type="collection" >
                <argument type="service" id="siso_tools.logging_processor.request_data" />
                <argument type="string">processRecord</argument>
            </argument>
        </call>
        <!-- Register the mail processor -->
        <call method="pushProcessor">
            <argument type="collection" >
                <argument type="service" id="siso_tools.mailer.logging_processor" />
                <argument type="string">processRecord</argument>
            </argument>
        </call>
    </service>
</services>
 
```

### Entity table `ses_log_mail`

The ORM is defined by annotations in `Siso\Bundle\ToolsBundle\Entity\MailLog`.

Example of a generated MySQL table:

``` sql
CREATE TABLE `ses_log_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_timestamp` datetime NOT NULL,
  `log_channel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `log_level` int(11) NOT NULL,
  `log_message` longtext COLLATE utf8_unicode_ci,
  `request_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receiver` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sent_timestamp` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 
```
