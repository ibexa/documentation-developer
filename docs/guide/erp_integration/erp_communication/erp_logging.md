# ERP Logging [[% include 'snippets/experience_badge.md' %]]

All communication (request- and response messages) that is performed by the [ERP transport](erp_components/erp_component_transport.md) is recorded by the `siso_erp.logger`.
It is a special service of the class `Monolog/Logger`.

To learn more about logging in [[= product_name_exp =]] in general, see [Logging](../../../guide/logging/logging.md).

## Adding a log entry

You can add a new log entry in the following way:

``` php
/** @var \Silversolutions\Bundle\EshopBundle\Message\AbstractMessage $message */
/** @var \Psr\Log\LoggerInterface $erpLogger */
$erpLogger->debug(
    'This message text is overridden with message_data from context array by the ErpMessageProcessor',
    array(
        'message_identifier' => get_class($message),
        'message_data' => $message->getRequestDocument(),
        'measuring_point' => '190_late_request_point',
    )
);
```

## ErpLog entity and repository

ERP messages are logged in a database for more sophisticated administrative handling.
Database logging is handled by [the Doctrine logger](../../../guide/logging/logging_api.md).

### ErpLog

Class `Silversolutions\Bundle\EshopBundle\Entity\ErpLog` is the ERP-message logging extension of `AbstractLog`.
It adds the following attributes:

- `$requestId` (string) - uniquely identifies every HTTP request across all logs.
- `$sessionId` (string) - uniquely identifies every client session across all logs and requests.
- `$userId` (string) - the identifier for the user (mostly User Content item ID).
- `$measuringPoint` (string) - the specific point in the process of ERP communication when this message is logged.
- `$responseStatus` (integer) - status code of the ERP response. Not set in request logs.
- `$errorText` (string) - details of an error, if occurred, empty otherwise.
- `$processingTime` (integer) - time in microseconds that has passed from request to response.
- `$messageIdentifier` (string) - identifies the type of message.

### ErpMessageProcessor

The ERP log entity has no field for the ERP message content.
It is intended to log this data within the log-message attribute.

Class `Silversolutions\Bundle\EshopBundle\Service\Logging\ErpMessageProcessor` is a Monolog data processor
that replaces the original log message with the serialized content of context/message_data if this context field is set.

### ErpMappingProcessor

ERP-message mapping is an optional step in the communication process. As for this, the mapped content is not always logged. If a mapper wants to log messages, they must put their content into a mapping_data field in the log context and this processor will take care of it.

Class `Silversolutions\Bundle\EshopBundle\Service\Logging\` is a Monolog data processor
that replaces the original log message with the serialized content of context/mapping_data if this context field is set.
It also adds the measuring points for mapping.

### ErpLogRepositoryInterface

Interface `Silversolutions\Bundle\EshopBundle\Entity\ErpLogRepositoryInterface` is supposed to define methods
that are used to obtain statistical data about ERP communication from the logs.
It currently has no concrete methods.

### ErpOrmLogRepository

Class `Silversolutions\Bundle\EshopBundle\Entity\ErpOrmLogRepository` is the doctrine repository class for ErpLog entities.
It implements `ErpLogRepositoryInterface` and is supposed to provide its statistical methods.
Currently, it exists to comply with the doctrine conventions only and to inject it into the ERP logging instance of `DoctrineHandler`.

## Configuration

### Container setup for ERP logging

In `ses_services.xml`:

``` xml
<parameters>
    <parameter key="siso_erp.logging_processor.message.class">Silversolutions\Bundle\EshopBundle\Service\Logging\ErpMessageProcessor</parameter>
    <parameter key="siso_erp.logging_processor.mapping.class">Silversolutions\Bundle\EshopBundle\Service\Logging\ErpMappingProcessor</parameter>
    <parameter key="siso_erp.logging_repository.doctrine.class">Silversolutions\Bundle\EshopBundle\Entity\ErpOrmLogRepository</parameter>
</parameters>
<services>
    <!-- Define the repository as an injectable service -->
    <service id="siso_erp.logging_repository.doctrine" class="%siso_erp.logging_repository.doctrine.class%">
        <factory service="doctrine.orm.default_entity_manager" method="getRepository" />
        <argument type="string">SilversolutionsEshopBundle:ErpLog</argument>
    </service>
    <!-- Define the doctrine handler that logs into the ERP log repository -->
    <service id="siso_erp.logging_handler.doctrine" class="%siso_tools.logging_handler.doctrine.class%">
        <!-- Inject the ERP log repository -->
        <call method="setLogRepository">
            <argument type="service" id="siso_erp.logging_repository.doctrine" />
        </call>
        <!-- Inject the doctrine formatter -->
        <call method="setFormatter">
            <argument type="service" id="siso_tools.logging_formatter.doctrine"/>
        </call>
    </service>
    <!-- Define the doctrine handler that logs into the ERP log file -->
    <service id="siso_erp.logging_handler.file" class="%monolog.handler.stream.class%">
        <argument type="string">%kernel.logs_dir%/%kernel.environment%-siso.eshop.erp.log</argument>
    </service>
    <!-- Define the processor that copies the ERP-message content to the log-message field -->
    <service id="siso_erp.logging_processor.message" class="%siso_erp.logging_processor.message.class%">
    </service>
    <!-- Define the processor that copies the mapped content to the log-message field -->
    <service id="siso_erp.logging_processor.mapping" class="%siso_erp.logging_processor.mapping.class%">
    </service>
    <!-- This is the actual logger that is to be injected into the MessageTransport and the Mapper
         or any other instance, which is invoked in ERP message communication -->
    <service id="siso_erp.logger" class="%monolog.logger.class%">
        <!-- The logging channel -->
        <argument type="string">silver_eshop_erp</argument>
        <!-- Inject the doctrine handler -->
        <call method="pushHandler">
            <argument type="service" id="siso_erp.logging_handler.doctrine" />
        </call>
        <!-- Inject the file handler -->
        <call method="pushHandler">
            <argument type="service" id="siso_erp.logging_handler.file" />
        </call>
        <!-- Register all processors that add the session data and copy the message content -->
        <call method="pushProcessor">
            <argument type="collection" >
                <argument type="service" id="siso_tools.logging_processor.request_data" />
                <argument type="string">processRecord</argument>
            </argument>
        </call>
        <call method="pushProcessor">
            <argument type="collection" >
                <argument type="service" id="siso_erp.logging_processor.message" />
                <argument type="string">processRecord</argument>
            </argument>
        </call>
        <call method="pushProcessor">
            <argument type="collection" >
                <argument type="service" id="siso_erp.logging_processor.mapping" />
                <argument type="string">processRecord</argument>
            </argument>
        </call>
    </service>
```

### Entity table `ses_log_erp`

Currently, ORM is defined by annotations in `Silversolutions\Bundle\EshopBundle\Entity\ErpLog`.

Example of a generated MySQL table:

``` sql
CREATE TABLE `ses_log_erp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_timestamp` datetime NOT NULL,
  `log_channel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `log_level` int(11) NOT NULL,
  `log_message` longtext COLLATE utf8_unicode_ci,
  `request_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `measuring_point` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `response_status` int(11) DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `error_text` longtext COLLATE utf8_unicode_ci,
  `processing_time` int(11) DEFAULT NULL,
  `message_identifier` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=671 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

## Logging architecture: measuring points

During communication between the [[= product_name_exp =]] and ERP, messages pass several instances of processing.
In order to reconstruct how a message is processed, [the transport layer](erp_components/erp_component_transport.md)
writes a message's content multiple times into the log - once for every important process step.
These points in time of writing a message into the log are called measuring points.
As the message communication is basically split into a request and a response, there are always two mirrored measuring points.
In the log, measuring points are identified by a simple string in the `measuringPoint` (or `measuring_point`) field.
These identifiers are a combination of two pieces of information separated with `_`:

||Description|Example|
|---|---|---|
|sequentially-ordered number (chronological index in the communication)|Technically, the numbers can be chosen arbitrarily (besides of the correct order). Currently, all requests are in the 100-199 range and responses are in the 200-299 range.|`120`|
|code word for hierarchical position (in the process stack)|There should be always two logs with the same code word for a single message communication, one for the request and one for the response.|`complete`|

For example: `120_complete`

### `120_complete`

This measuring point specifies the point before specific transport implementation and after all event handlers.
The content includes all changes from the handlers and is a serialized object.
It contains the state of data which goes either into the mapping or directly into the specific transport (e.g. SOAP).
The processing time is calculated including the handlers (starting time-stamp before the event).

??? note "Example content" 

    ``` 
    O:80:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\BuyerCustomerParty":1:{s:5:"Party";O:85:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\BuyerCustomerPartyParty":1:{s:19:"PartyIdentification";a:1:{i:0;O:104:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\BuyerCustomerPartyPartyPartyIdentification":1:{s:2:"ID";s:6:"D00210";}}}}
    ```

### `150_mapping`

This measuring point specifies the point after serializing the object data into an XML string.
The mapping step is optional and depends on the concrete implementation of the transport and the configuration of the message.
The content is a serialized array, which contains the following fields:

- `mapping_type` - identifies the first part of the XSL file name (`request`)
- `stylesheet` - fully-qualified path of the XSL file
- `input_xml` - XML content before XSLT mapping
- `output_xml` - XML content after XSLT mapping

??? note "Example content"

    ``` 
    a:4:{s:12:"mapping_type";s:7:"request";s:10:"stylesheet";s:88:"app/Resources/xslbase/request.selectcontact.xsl";s:9:"input_xml";s:178:"<?xml version="1.0" encoding="UTF-8"?>
    <BuyerCustomerParty>
      <Party>
        <PartyIdentification>
          <ID>D00210</ID>
        </PartyIdentification>
      </Party>
    </BuyerCustomerParty>
    ";s:10:"output_xml";s:228:"<?xml version="1.0"?>
    <WC_USER_MANAGEMENT><PROCESS_TYPE>SELECTCONTACT</PROCESS_TYPE><WEB_SITE>HOME</WEB_SITE><NUMBER>D00210</NUMBER><MAXCOUNT>10</MAXCOUNT><LAST_DATE_MODIFIED/><LOGIN_ID/><ONLINE_USER_TYPE/></WC_USER_MANAGEMENT>
    ";}
    ```

### `180_soap`

This measuring point specifies the point right before the SOAP communication, after mapping and events.
The content is a serialized array that is passed as parameters to the SoapClient's request method.

??? note "Example content"

    ``` 
    a:4:{s:4:"user";s:5:"admin";s:8:"password";s:6:"passwo";s:14:"erp_parameters";a:1:{s:7:"timeout";i:10000;}s:4:"data";s:228:"<?xml version="1.0"?>
    <WC_USER_MANAGEMENT><PROCESS_TYPE>SELECTCONTACT</PROCESS_TYPE><WEB_SITE>HOME</WEB_SITE><NUMBER>D00210</NUMBER><MAXCOUNT>10</MAXCOUNT><LAST_DATE_MODIFIED/><LOGIN_ID/><ONLINE_USER_TYPE/></WC_USER_MANAGEMENT>
    ";}
    ```

### `220_soap`

This measuring point specifies the point right after the SOAP communication, before mapping and events.
The content is a serialized array that is returned from the SoapClient's request method.

??? note "Example content"

    ``` 
    a:2:{s:18:"WC_USER_MANAGEMENT";a:4:{s:12:"PROCESS_TYPE";s:13:"SELECTCONTACT";s:4:"GUID";s:46:"{96284C22-3F6C-4AE4-8CD3-137087BB0B74}\1202183";s:8:"WEB_SITE";s:4:"HOME";s:7:"CONTACT";a:4:{i:0;a:18:{s:16:"ONLINE_USER_TYPE";s:1:"0";s:6:"NUMBER";s:8:"KT000197";s:9:"JOB_TITLE";s:0:"";s:6:"E_MAIL";s:0:"";s:12:"ON_BEHALF_OF";s:0:"";s:4:"NAME";s:28:"Company for customercenter 1";s:7:"ADDRESS";s:14:"Färberstr. 26";s:23:"ADDITIONAL_ADDRESS_INFO";s:0:"";s:4:"CITY";s:6:"Berlin";s:12:"COUNTRY_CODE";s:2:"DE";s:10:"FAX_NUMBER";s:0:"";s:8:"ZIP_CODE";s:5:"12555";s:12:"PHONE_NUMBER";s:12:"030/65481990";s:13:"LANGUAGE_CODE";s:0:"";s:8:"LOGIN_ID";s:0:"";s:16:"PASSWORD_PADDING";s:0:"";s:8:"PASSWORD";s:0:"";s:8:"PRIORITY";s:1:"3";}i:1;a:18:{s:16:"ONLINE_USER_TYPE";s:1:"1";s:6:"NUMBER";s:8:"KT000199";s:9:"JOB_TITLE";s:0:"";s:6:"E_MAIL";s:27:"test_max@silversolutions.de";s:12:"ON_BEHALF_OF";s:6:"D00210";s:4:"NAME";s:14:"Max Mustermann";s:7:"ADDRESS";s:14:"Färberstr. 26";s:23:"ADDITIONAL_ADDRESS_INFO";s:0:"";s:4:"CITY";s:6:"Berlin";s:12:"COUNTRY_CODE";s:2:"DE";s:10:"FAX_NUMBER";s:0:"";s:8:"ZIP_CODE";s:5:"12555";s:12:"PHONE_NUMBER";s:12:"030/65481990";s:13:"LANGUAGE_CODE";s:3:"DEU";s:8:"LOGIN_ID";s:0:"";s:16:"PASSWORD_PADDING";s:0:"";s:8:"PASSWORD";s:0:"";s:8:"PRIORITY";s:1:"3";}i:2;a:18:{s:16:"ONLINE_USER_TYPE";s:1:"1";s:6:"NUMBER";s:8:"KT000200";s:9:"JOB_TITLE";s:0:"";s:6:"E_MAIL";s:0:"";s:12:"ON_BEHALF_OF";s:6:"D00210";s:4:"NAME";s:10:"Tina Tinte";s:7:"ADDRESS";s:14:"Färberstr. 26";s:23:"ADDITIONAL_ADDRESS_INFO";s:0:"";s:4:"CITY";s:6:"Berlin";s:12:"COUNTRY_CODE";s:2:"DE";s:10:"FAX_NUMBER";s:0:"";s:8:"ZIP_CODE";s:5:"12555";s:12:"PHONE_NUMBER";s:12:"030/65481990";s:13:"LANGUAGE_CODE";s:3:"DEU";s:8:"LOGIN_ID";s:0:"";s:16:"PASSWORD_PADDING";s:0:"";s:8:"PASSWORD";s:0:"";s:8:"PRIORITY";s:1:"3";}i:3;a:18:{s:16:"ONLINE_USER_TYPE";s:1:"1";s:6:"NUMBER";s:8:"KT000202";s:9:"JOB_TITLE";s:0:"";s:6:"E_MAIL";s:29:"test_willi@silversolutions.de";s:12:"ON_BEHALF_OF";s:6:"D00210";s:4:"NAME";s:12:"Willi Wonker";s:7:"ADDRESS";s:14:"Färberstr. 26";s:23:"ADDITIONAL_ADDRESS_INFO";s:0:"";s:4:"CITY";s:6:"Berlin";s:12:"COUNTRY_CODE";s:2:"DE";s:10:"FAX_NUMBER";s:0:"";s:8:"ZIP_CODE";s:5:"12555";s:12:"PHONE_NUMBER";s:12:"030/65481990";s:13:"LANGUAGE_CODE";s:3:"ENG";s:8:"LOGIN_ID";s:0:"";s:16:"PASSWORD_PADDING";s:0:"";s:8:"PASSWORD";s:0:"";s:8:"PRIORITY";s:1:"3";}}}s:6:"status";a:2:{s:4:"code";i:0;s:10:"erp_status";i:0;}}
    ```

### `250_mapping`

This measuring point specifies the point before the deserialization of the received XML data.
The mapping step is optional and depends on the concrete implementation of the transport and the configuration of the message.
The content is a serialized array which contains the following fields:

- `mapping_type` - identifies the first part of the XSL file name (`response`)
- `stylesheet` - fully-qualified path of the XSL file
- `input_xml` - XML content before XSLT mapping
- `output_xml` - XML content after XSLT mapping

??? note "Example content"

    ``` 
    a:4:{s:12:"mapping_type";s:8:"response";s:10:"stylesheet";s:89:"app/Resources/xslbase/response.selectcontact.xsl";s:9:"input_xml";s:2442:"<?xml version="1.0" encoding="UTF-8"?>
    <WC_USER_MANAGEMENT><PROCESS_TYPE>SELECTCONTACT</PROCESS_TYPE><GUID>{96284C22-3F6C-4AE4-8CD3-137087BB0B74}\1202183</GUID><WEB_SITE>HOME</WEB_SITE><CONTACT><ONLINE_USER_TYPE>0</ONLINE_USER_TYPE><NUMBER>KT000197</NUMBER><JOB_TITLE></JOB_TITLE><E_MAIL></E_MAIL><ON_BEHALF_OF></ON_BEHALF_OF><NAME>Company for customercenter 1</NAME><ADDRESS>Färberstr. 26</ADDRESS><ADDITIONAL_ADDRESS_INFO></ADDITIONAL_ADDRESS_INFO><CITY>Berlin</CITY><COUNTRY_CODE>DE</COUNTRY_CODE><FAX_NUMBER></FAX_NUMBER><ZIP_CODE>12555</ZIP_CODE><PHONE_NUMBER>030/65481990</PHONE_NUMBER><LANGUAGE_CODE></LANGUAGE_CODE><LOGIN_ID></LOGIN_ID><PASSWORD_PADDING></PASSWORD_PADDING><PASSWORD></PASSWORD><PRIORITY>3</PRIORITY></CONTACT><CONTACT><ONLINE_USER_TYPE>1</ONLINE_USER_TYPE><NUMBER>KT000199</NUMBER><JOB_TITLE></JOB_TITLE><E_MAIL>test_max@silversolutions.de</E_MAIL><ON_BEHALF_OF>D00210</ON_BEHALF_OF><NAME>Max Mustermann</NAME><ADDRESS>Färberstr. 26</ADDRESS><ADDITIONAL_ADDRESS_INFO></ADDITIONAL_ADDRESS_INFO><CITY>Berlin</CITY><COUNTRY_CODE>DE</COUNTRY_CODE><FAX_NUMBER></FAX_NUMBER><ZIP_CODE>12555</ZIP_CODE><PHONE_NUMBER>030/65481990</PHONE_NUMBER><LANGUAGE_CODE>DEU</LANGUAGE_CODE><LOGIN_ID></LOGIN_ID><PASSWORD_PADDING></PASSWORD_PADDING><PASSWORD></PASSWORD><PRIORITY>3</PRIORITY></CONTACT><CONTACT><ONLINE_USER_TYPE>1</ONLINE_USER_TYPE><NUMBER>KT000200</NUMBER><JOB_TITLE></JOB_TITLE><E_MAIL></E_MAIL><ON_BEHALF_OF>D00210</ON_BEHALF_OF><NAME>Tina Tinte</NAME><ADDRESS>Färberstr. 26</ADDRESS><ADDITIONAL_ADDRESS_INFO></ADDITIONAL_ADDRESS_INFO><CITY>Berlin</CITY><COUNTRY_CODE>DE</COUNTRY_CODE><FAX_NUMBER></FAX_NUMBER><ZIP_CODE>12555</ZIP_CODE><PHONE_NUMBER>030/65481990</PHONE_NUMBER><LANGUAGE_CODE>DEU</LANGUAGE_CODE><LOGIN_ID></LOGIN_ID><PASSWORD_PADDING></PASSWORD_PADDING><PASSWORD></PASSWORD><PRIORITY>3</PRIORITY></CONTACT><CONTACT><ONLINE_USER_TYPE>1</ONLINE_USER_TYPE><NUMBER>KT000202</NUMBER><JOB_TITLE></JOB_TITLE><E_MAIL>test_willi@silversolutions.de</E_MAIL><ON_BEHALF_OF>D00210</ON_BEHALF_OF><NAME>Willi Wonker</NAME><ADDRESS>Färberstr. 26</ADDRESS><ADDITIONAL_ADDRESS_INFO></ADDITIONAL_ADDRESS_INFO><CITY>Berlin</CITY><COUNTRY_CODE>DE</COUNTRY_CODE><FAX_NUMBER></FAX_NUMBER><ZIP_CODE>12555</ZIP_CODE><PHONE_NUMBER>030/65481990</PHONE_NUMBER><LANGUAGE_CODE>ENG</LANGUAGE_CODE><LOGIN_ID></LOGIN_ID><PASSWORD_PADDING></PASSWORD_PADDING><PASSWORD></PASSWORD><PRIORITY>3</PRIORITY></CONTACT></WC_USER_MANAGEMENT>
    ";s:10:"output_xml";s:834:"<?xml version="1.0"?>
    <ContactResponse><ErpContact><Contact><ID>KT000199</ID><Name>Max Mustermann</Name><Telephone>030/65481990</Telephone><Telefax/><ElectronicMail>test_max@silversolutions.de</ElectronicMail><OtherCommunication/><Note/><SesExtension><LanguageCode>DEU</LanguageCode><IsMain/></SesExtension></Contact><Contact><ID>KT000200</ID><Name>Tina Tinte</Name><Telephone>030/65481990</Telephone><Telefax/><ElectronicMail/><OtherCommunication/><Note/><SesExtension><LanguageCode>DEU</LanguageCode><IsMain/></SesExtension></Contact><Contact><ID>KT000202</ID><Name>Willi Wonker</Name><Telephone>030/65481990</Telephone><Telefax/><ElectronicMail>test_willi@silversolutions.de</ElectronicMail><OtherCommunication/><Note/><SesExtension><LanguageCode>ENG</LanguageCode><IsMain/></SesExtension></Contact></ErpContact></ContactResponse>
    ";}
    ```

### `280_complete`

This measuring point specifies the point after specific transport implementation and after all event handlers.
The content includes all changes from the handlers and is a serialized object.
It contains the state of data that is finally available for the instance that initiated the message.
The processing time is calculated including the handlers (final time-stamp after the event).

??? note "Example content"

    ``` 
    O:77:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\ContactResponse":1:{s:10:"ErpContact";O:87:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\ContactResponseErpContact":1:{s:7:"Contact";a:3:{i:0;O:69:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\Contact":8:{s:2:"ID";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:8:"KT000199";}s:4:"Name";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:14:"Max Mustermann";}s:9:"Telephone";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:12:"030/65481990";}s:7:"Telefax";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:0:"";}s:14:"ElectronicMail";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:27:"test_max@silversolutions.de";}s:18:"OtherCommunication";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:0:"";}s:4:"Note";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:0:"";}s:12:"SesExtension";O:72:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\TreeObject":1:{s:5:"value";a:2:{s:12:"LanguageCode";s:3:"DEU";s:6:"IsMain";s:0:"";}}}i:1;O:69:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\Contact":8:{s:2:"ID";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:8:"KT000200";}s:4:"Name";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:10:"Tina Tinte";}s:9:"Telephone";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:12:"030/65481990";}s:7:"Telefax";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:0:"";}s:14:"ElectronicMail";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:0:"";}s:18:"OtherCommunication";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:0:"";}s:4:"Note";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:0:"";}s:12:"SesExtension";O:72:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\TreeObject":1:{s:5:"value";a:2:{s:12:"LanguageCode";s:3:"DEU";s:6:"IsMain";s:0:"";}}}i:2;O:69:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\Contact":8:{s:2:"ID";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:8:"KT000202";}s:4:"Name";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:12:"Willi Wonker";}s:9:"Telephone";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:12:"030/65481990";}s:7:"Telefax";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:0:"";}s:14:"ElectronicMail";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:29:"test_willi@silversolutions.de";}s:18:"OtherCommunication";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:0:"";}s:4:"Note";O:74:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\StringObject":1:{s:5:"value";s:0:"";}s:12:"SesExtension";O:72:"Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\TreeObject":1:{s:5:"value";a:2:{s:12:"LanguageCode";s:3:"ENG";s:6:"IsMain";s:0:"";}}}}}}
    ```

## Errors during communication

In case of an error during communication with the Web.Connector the error is logged additionally into the standard `silver.eshop.log` log file.

??? note "Example"

    ``` 
    [2014-12-23 09:53:15] silver.eshop.ERROR: ERP request returned an error. Web-Connector: "Send of message 841785 failed " ERP: "" {"request":{"Order":{"DocumentCurrencyCode":"EUR","BuyerCustomerParty":{"SupplierAssignedAccountID":"","Party":{"PartyIdentification":{"ID":"10000"}}},"SellerSupplierParty":{"Party":{"PostalAddress":{"StreetName":"","AdditionalStreetName":"","BuildingNumber":"","CityName":"","PostalZone":"","CountrySubentity":"","CountrySubentityCode":"","Country":{"IdentificationCode":"","Name":""},"Department":"","SesExtension":""},"Contact":{"ID":"","Name":"","Telephone":"","Telefax":"","ElectronicMail":"","OtherCommunication":"","Note":"","SesExtension":""},"Person":{"FirstName":"","FamilyName":"","Title":"","MiddleName":"","SesExtension":""},"SesExtension":""}},"AccountingCustomerParty":{"Party":{"PostalAddress":{"StreetName":"","AdditionalStreetName":"","BuildingNumber":"","CityName":"","PostalZone":"","CountrySubentity":"","CountrySubentityCode":"","Country":{"IdentificationCode":"","Name":""},"Department":"","SesExtension":""},"Contact":{"ID":"","Name":"","Telephone":"","Telefax":"","ElectronicMail":"","OtherCommunication":"","Note":"","SesExtension":""},"Person":{"FirstName":"","FamilyName":"","Title":"","MiddleName":"","SesExtension":""},"SesExtension":""}},"Delivery":{"RequestedDeliveryPeriod":{"EndDate":"","EndTime":""},"DeliveryParty":{"PostalAddress":{"StreetName":"","AdditionalStreetName":"","BuildingNumber":"","CityName":"","PostalZone":"","CountrySubentity":"","CountrySubentityCode":"","Country":{"IdentificationCode":"","Name":""},"Department":"","SesExtension":""},"Contact":{"ID":"","Name":"","Telephone":"","Telefax":"","ElectronicMail":"","OtherCommunication":"","Note":"","SesExtension":""},"Person":{"FirstName":"","FamilyName":"","Title":"","MiddleName":"","SesExtension":""},"SesExtension":""}},"PaymentMeans":{"PaymentMeansCode":"","PaymentDueDate":"","PaymentChannelCode":"","InstructionID":"","PayeeFinancialAccount":{"ID":"","CurrencyCode":"","FinancialInstitutionBranch":{"ID":"","Name":""}},"CardAccount":{"PrimaryAccountNumberID":"","NetworkID":"","ExpiryDate":""}},"TransactionConditions":{"ID":"","ActionCode":""},"OrderLine":{"LineItem":{"ID":"","SalesOrderID":"","Quantity":"1","LineExtensionAmount":"","TotalTaxAmount":"","MinimumQuantity":"","MaximumQuantity":"","MinimumBackorderQuantity":"","MaximumBackorderQuantity":"","PartialDeliveryIndicator":"","BackOrderAllowedIndicator":"","Price":{"PriceAmount":"","BaseQuantity":""},"Item":{"Name":"","SellersItemIdentification":{"ID":"12003","ExtendedID":""},"BuyersItemIdentification":{"ID":""}},"SesExtension":""},"SesExtension":""},"SesExtension":""}},"response":{"status":{"code":2,"erp_status":0},"error":"Send of message 841785 failed","erp_message":""}} []
    ```

The text after "ERP request returned an error. Web-Connector:" defines the reason for the error.
The content of the message depends on the ERP system.
In this case the error message is: "Send of message 841785 failed"

If SOAP causes an exception, it is logged as well. The logged data contains the request and response with header information.

??? note "Example"

    ``` 
    [2015-09-25 11:14:45] silver.eshop.ERROR: Error during SOAP communication: Array (     [request] => <?xml version="1.0" encoding="UTF-8"?> <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.silversolutions.de" xmlns:xsd="h
    ttp://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:ns2="http://xml.apache.org/xml-soap" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"><SOAP-ENV:Body>
    <ns1:SV_OPENTRANS_SELECT_CUSTOMERINFO><user xsi:type="xsd:string">admin</user><password xsi:type="xsd:string">passwo</password><erp_parameters xsi:type="ns2:Map"><item><key xsi:type="xsd:string">timeout</key><value xsi:type="xsd:int">10000</value></item></erp_parameters><data xsi:type="ns2:Map"><item><key xsi:type="xsd:string">BuyerCustomerParty</key><value xsi:type="ns2:Map"><item><key xsi:type="xsd:string">Party</key><value xsi:type="ns2:Map"><item><key xsi:type="xsd:string">PartyIdentification</key><value xsi:type="ns2:Map"><item><key xsi:type="xsd:string">ID</key><value xsi:type="xsd:string">D00210</value></item></value></item><item><key xsi:type="xsd:string">PostalAddress</key><value xsi:type="ns2:Map"><item><key xsi:type="xsd:string">StreetName</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">AdditionalStreetName</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">BuildingNumber</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">CityName</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">PostalZone</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">CountrySubentity</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">CountrySubentityCode</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">Country</key><value xsi:type="ns2:Map"><item><key xsi:type="xsd:string">IdentificationCode</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">Name</key><value xsi:type="xsd:string"></value></item></value></item><item><key xsi:type="xsd:string">Department</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">SesExtension</key><value xsi:type="xsd:string"></value></item></value></item><item><key xsi:type="xsd:string">Contact</key><value xsi:type="ns2:Map"><item><key xsi:type="xsd:string">ID</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">Name</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">Telephone</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">Telefax</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">ElectronicMail</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">OtherCommunication</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">Note</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">SesExtension</key><value xsi:type="xsd:string"></value></item></value></item><item><key xsi:type="xsd:string">Person</key><value xsi:type="ns2:Map"><item><key xsi:type="xsd:string">FirstName</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">FamilyName</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">Title</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">MiddleName</key><value xsi:type="xsd:string"></value></item><item><key xsi:type="xsd:string">SesExtension</key><value xsi:type="xsd:string"></value></item></value></item><item><key xsi:type="xsd:string">SesExtension</key><value xsi:type="xsd:string"></value></item></value></item></value></item></data></ns1:SV_OPENTRANS_SELECT_CUSTOMERINFO></SOAP-ENV:Body></SOAP-ENV:Envelope>      [requestHeaders] => POST /webconnector/webcon_opentrans/webconnector_opentrans.ph HTTP/1.1 Host: 192.168.2.76:81 Connection: Keep-Alive User-Agent: PHP-SOAP/5.5.9-1ubuntu4.12 Content-Type: text/xml; charset=utf-8 SOAPAction: "http://www.silversolutions.de#SV_OPENTRANS_SELECT_CUSTOMERINFO" Content-Length: 3892       [response] =>      [responseHeaders] => HTTP/1.1 404 Not Found Date: Fri, 25 Sep 2015 09:14:44 GMT Server: Apache Content-Length: 315 Keep-Alive: timeout=15, max=100 Connection: Keep-Alive Content-Type: text/html; charset=iso-8859-1  )  {"exception":"[object] (SoapFault(code: 0): Not Found at /var/www/silver.e-shop.application/vendor/silversolutions/silver.e-shop/src/Silversolutions/Bundle/EshopBundle/Services/Transport/WebConnectorMessageTransport.php:420)","fault_code":"HTTP","fault_text":"Not Found"} []
    ```
