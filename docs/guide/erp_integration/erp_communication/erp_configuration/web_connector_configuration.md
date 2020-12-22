# Web.Connector configuration [[% include 'snippets/experience_badge.md' %]]

## General parameters

``` yaml
parameters:
    siso_erp.default.web_connector.service_location: "http://mydomain.com/mywebconnector"
    siso_erp.default.web_connector.username: admin
    siso_erp.default.web_connector.password: passwo
    siso_erp.default.web_connector.soapTimeout: 5
    siso_erp.default.web_connector.erpTimeout: 5
    siso_erp.default.web_connector.allow_self_signed_ssl: true
```

!!! note

    Check the configuration for the Web.Connector URL in the Back Office (Configuration settings) as well.
    The Back Office settings will set the default setting and may override the settings.

`siso_erp.default.web_connector.url` - the service location defines the remote service URL of the Web.Connector.
`siso_erp.default.web_connector.username` - defines the user name for Web.Connector
`siso_erp.default.web_connector.password` - defines the password for Web.Connector
`siso_erp.default.web_connector.soapTimeout` - defines the SOAP timeout.
`siso_erp.default.web_connector.erpTimeout` - defines the timeout for ERP.
`siso_erp.default.web_connector.allow_self_signed_ssl` - defines for SOAP request if a self-signed SSL certificate is allowed.

## Check ERP status

If a message to the ERP system fails the shop will send a test message to the ERP in order to check

- if it is a general issue and the ERP is offline or
- if just this one message failed

If it is a general error the shop sets the ERP connection to offline.
All requests after setting the connection to offline are not be sent to the ERP and are immediately handled as an error. 

This parameter sets the ERP offline for 60 seconds before another request is sent. 

``` yaml
siso_erp.erp_semaphore.max_lock_time: 60
```

The status is stored in stash using the key defined in `siso_erp.erp_semaphore.stash_item_id`.

## Configuration for Web.Connector installation

The Web.Connector supports the mapping of simple XML messages from one (source) structure to another (target) structure.
The rules for that mapping are defined in XSL files in a configurable directory (`mapping/nav_nas` is currently default).
This configured directory must contain two subdirectories: `xslbase` and `xsl`. The base mapping rules are delivered in the `xslbase` directory. Variations from the base mapping can be overridden in the `xsl` directory (files must have the same name).

This mapping defines the translation of the UBL-based message to the format used by the ERP system.  

In order to activate this mapping in the Web.Connector, set up the corresponding configuration file:

``` php
$cfg->setSetting('Mapping', 'XsltPathOffset', 'mapping/noop/');
```
