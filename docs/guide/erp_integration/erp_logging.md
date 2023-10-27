---
edition: commerce
---

# ERP logging

All communication with the ERP (requests and responses) is recorded by the `siso_erp.logger`.
It is a special service of the `Monolog/Logger` class.

To learn more about logging in the shop, see [Logging](../logging/logging.md).

## Accessing logs

Log messages are logged to the database.
You can use a command to check the messages that were exchanged with the ERP system.

The command waits for the next message and displays the request and result as XML.

You can search for a specific message by using the `--search-text` option:

``` bash
php bin/console ibexa:commerce:display-erp-log --search-text 123456788
```

To dump the most recent messages, use the `--dump-last-messages` option:

``` bash
php bin/console ibexa:commerce:display-erp-log --dump-last-messages 20 > /tmp/erp_messages.txt
```

You can remove messages from the database with the `--delete-messages` option.

The following example removes messages older than three days:

``` bash
php bin/console ibexa:commerce:display-erp-log --delete-messages 3
```

## Measuring points

The log communication with ERP has measuring points - points that correspond to important steps in the communication process.

There are always two measuring points for each step, one for the request and one for the response.

### `120_complete`

`120_complete` indicates the point before a specific transport implementation and after all event handlers.

The content includes all changes from the handlers and is a serialized object.
It contains the state of data which goes either into the mapping or directly into the specific transport (e.g. SOAP).
The processing time is calculated including the handlers (starting time-stamp before the event).

### `150_mapping`

`150_mapping` indicates the point after serializing the object data into an XML string.
The mapping step is optional and depends on the concrete implementation of the transport and the configuration of the message.

The content is a serialized array, which contains the following fields:

- `mapping_type` - identifies the first part of the XSL file name (`request`)
- `stylesheet` - fully-qualified path of the XSL file
- `input_xml` - XML content before XSLT mapping
- `output_xml` - XML content after XSLT mapping

### `180_soap`

`180_soap` indicates the point right before the SOAP communication, after mapping and events.

The content is a serialized array that is passed as parameters to the SoapClient's request method.

### `220_soap`

`220_soap` indicates the point right after the SOAP communication, before mapping and events.

The content is a serialized array that is returned from the SoapClient's request method.

### `250_mapping`

`250_mapping` indicates the point before the deserialization of the received XML data.
The mapping step is optional and depends on the concrete implementation of the transport and the configuration of the message.

The content is a serialized array which contains the following fields:

- `mapping_type` - identifies the first part of the XSL file name (`response`)
- `stylesheet` - fully-qualified path of the XSL file
- `input_xml` - XML content before XSLT mapping
- `output_xml` - XML content after XSLT mapping

### `280_complete`

`280_complete` indicates the point after a specific transport implementation and after all event handlers.

The content includes all changes from the handlers and is a serialized object.
It contains the state of data that is finally available for the instance that initiated the message.
The processing time is calculated including the handlers (final time-stamp after the event).
