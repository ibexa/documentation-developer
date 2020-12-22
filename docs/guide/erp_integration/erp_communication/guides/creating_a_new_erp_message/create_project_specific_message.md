# Create project-specific message [[% include 'snippets/experience_badge.md' %]]

## ERP expectations

ERP expects the a request and response with the following XML:

Request SELECTMODIFIEDDATA:

``` xml
<WC_MANAGEMENT>
    <PROCESS_TYPE>GETNEWCONTACT</PROCESS_TYPE>
    <GUID>1</GUID>
    <WEB_SITE>HOME</WEB_SITE>
    <ENTRY_NO>43</ENTRY_NO>
    <MAXCOUNT>10</MAXCOUNT>
</WC_MANAGEMENT>
```

Response SELECTMODIFIEDDATA:

``` xml
<WC_MANAGEMENT>
    <PROCESS_TYPE>GETNEWCONTACT</PROCESS_TYPE>
    <GUID />
    <WEB_SITE>HOME</WEB_SITE>
    <ENTRY_NO>43</ENTRY_NO>
    <MAXCOUNT>10</MAXCOUNT>
    <CUSTOMER>
        <LINE>
            <CUSTOMER_NO>POITOU03</CUSTOMER_NO>
            <CONTACT_NO>CON0358</CONTACT_NO>
            <ENTRY_NO>43</ENTRY_NO>
        </LINE>
    </CUSTOMER>
    <LAST_ENTRY_NO>43</LAST_ENTRY_NO>
</WC_MANAGEMENT>
```

!!! tip

    You have to know the webservice operation that is used for this message.

    If you see that all XML elements are written with capital letters, usually it means that the webservice operation is `SV_RAW_MESSAGE`.

## Define request and response document

The request and response documents are used as a frame for the generating PHP classes that are used in shop.
The generator uses them to create the classes automatically.

!!! tip

    Instead of the `src/MyCompany/Bundle/MyCompanyBundle/Resources/specifications/xml` folder
    you can use a different structure, for example: `src/MyCompany/Bundle/MyCompanyBundle/Resources/xml`.

    The path to this folder set up anyway when you use command to generate the messages.

### Message name

Create two .xml files, one for request, one for response,
in `src/MyCompany/Bundle/MyCompanyBundle/Resources/specifications/xml`.

!!! note "Naming conventions"

    The files must be named:

    ```
    request.[messageName].xml
    response.[messageName].xml
    ```
    
    For example:
    
    ```
    src/MyCompany/Bundle/MyCompanyBundle/Resources/specifications/xml/request.selectModifiedData.xml
    src/MyCompany/Bundle/MyCompanyBundle/Resources/specifications/xml/response.selectModifiedData.xml
    ```

### Request XML

Copy the content of the request `SELECTMODIFIEDDATA` and use it as content for your request .xml:

`src/MyCompany/Bundle/MyCompanyBundle/Resources/specifications/xml/request.selectModifiedData.xml`

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<WC_MANAGEMENT>
    <PROCESS_TYPE>GETNEWCONTACT</PROCESS_TYPE>
    <GUID>1</GUID>
    <WEB_SITE>HOME</WEB_SITE>
    <ENTRY_NO>43</ENTRY_NO>
    <MAXCOUNT>10</MAXCOUNT>
</WC_MANAGEMENT>
```

!!! tip

    The root tag must be unique in the target directory (in this example, `vendor/silversolutions/silver.e-shop/src/Silversolutions/Bundle/EshopBundle`).

### Response XML

Copy the content of the response `SELECTMODIFIEDDATA` and use it as content for your response .xml:

`src/MyCompany/Bundle/MyCompanyBundle/Resources/specifications/xml/response.selectModifiedData.xml`

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<WC_USER_MANAGEMENT ses_unbounded="LINE">
    <PROCESS_TYPE />
    <GUID />
    <WEB_SITE />
    <ENTRY_NO />
    <MAXCOUNT />
    <CUSTOMER>
        <LINE>
            <CUSTOMER_NO />
            <CONTACT_NO />
            <ENTRY_NO />
        </LINE>
    </CUSTOMER>
    <LAST_ENTRY_NO />
</WC_USER_MANAGEMENT>
```

## Generator

Now you can use the generator to generate the classes automatically:

``` bash
//Usage
php bin/console silversolutions:generatemessages --message [message name] --sourceDir [path to the request and response .xml dir] --targetDir [path to the target bundle]

//Example
php bin/console silversolutions:generatemessages --message selectModifiedData --sourceDir src/MyCompany/Bundle/MyCompanyBundle/Resources/specifications/xml --targetDir src/MyCompany/Bundle/MyCompanyBundle

//Re-generation of messages
//If you are re-creating the messages (e.g. the request .xml has been adapted) you have to use to optional --force parameter
php bin/console silversolutions:generatemessages --message selectModifiedData --sourceDir src/MyCompany/Bundle/MyCompanyBundle/Resources/specifications/xml --targetDir src/MyCompany/Bundle/MyCompanyBundle --force
```

## Mapping

!!! tip "Symlinks"

    There should be a symlink to the mapping in `app/Resources`:
    
    `xsl` - project symlink for the specific project - always has a higher priority
    `xslbase` - standard symlink for [[= product_name_exp =]] as a default
    
    ``` bash
    cd app/Resources
    ls -l

    xsl -> ../../src/MyCompany/Bundle/MyCompanyBundle/Resources/xsl
    xslbase -> ../../vendor/silversolutions/silver.e-shop/src/Silversolutions/Bundle/EshopBundle/Resources/xslbase
    ```

Mapping is done inside the `src/MyCompany/Bundle/MyCompanyBundle/Resources/xsl` folder.

!!! tip

    If you are creating a new message that is specific only for the project and you are not using any standard .xml documents as a part of your message, you usually don't need to define any kind of mapping.

## Message configuration

You also have to configure the message. The [generator](#generator) has created some frames already.

You can create a special .yml file only for message configuration, such as `project.messages.yml`.

``` xml
//Import the auto-generated listener here
imports:
    - { resource: "@MyCompanyBundle/Resources/config/selectmodifieddatafactorylistener.service.yml" }

//Add message configuration
parameters:
    silver_erp.config.messages:
        ...
        //take a look in the auto-generated src/MyCompany/Bundle/MyCompanyBundle/Resources/config/selectmodifieddatamessage.message.yml
        selectmodifieddata:
            //path to the auto-generated message
            message_class: "\\MyCompany\\Bundle\\MyCompanyBundle\\Entities\\Messages\\SelectModifiedDataMessage"
            //path to the auto-generated response class
            response_document_class: "\\MyCompany\\Bundle\\MyCompanyBundle\\Entities\\Messages\\Document\\SelectModifiedDataResponse"
            //name of the webservice operation
            webservice_operation: "SV_RAW_MESSAGE"
            //mapping name - if you don't have any mapping, leave it empty
            mapping_identifier: ""
```
