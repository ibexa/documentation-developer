# ERP Message-Class-Generator [[% include 'snippets/experience_badge.md' %]]

## XML to PHP generator

The XML to PHP generator is used to create PHP objects out of sample XML files.

This component:

- Reads a pair of custom XML documents of a specified ERP message (request and response)
- Generates PHP objects with a constructor which initializes all members
- Generates a message class which contains a reference to the request and response POPO
- Generates a factory class for the generated message class
- Generates all necessary configuration files which may be imported or copied into the projects configuration

"Message" refers to a unit of a request and response document.
"Document" is a single XML document for ERP communication. One document may be sent to the ERP and another document may be received from the ERP.

Document example:

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<PartyRequest>
    <Party>
        <Id>1234</Id>
        <Name>Example & Co.</Name>
        <Address>
            <FirstName>Peter</FirstName>
            <LastName>Smith</LastName>
            <Street>Long Street 12</Street>
            <PostalCode>12345</PostalCode>
            <City>Big City</City>
            <Region>Random County</Region>
        </Address>
    </Party>
</PartyRequest>
```

## Usage

### XML format (necessary additional attributes)

For the automated generation of PHP classes, additional information in the XML is necessary.
The XML can be extended with the following attributes:

#### `ses_type`

Required for elements which are defined in external XML files and provide standard elements.

If an element value is a complex type which is intended to be reused in several messages (e.g. a business party record) it must be defined in this attribute.
The value represents a space-separated list of child element names that are supposed to be of the reusable type. The name of the elements is also the name of the applicable classes.

The names of the types should be prefixed with either `ses:` or `cust:`

- `ses:` type classes are stored in the [[= product_name_exp =]] path. XML definition files are always read from the [[= product_name_exp =]] path.
- `cust:` type classes are stored in the defined target directory. XML definition files are always read from the source path.

For each type an XML file must be stored in the `src` folder which defines the reusable datatype which is named <elementName>.xml

``` xml
Example (request.selectContact.xml): 
<?xml version="1.0" encoding="UTF-8"?>
<BuyerCustomerParty ses_type="ses:Party">
    <Party>
    </Party>
</BuyerCustomerParty>
```

Example (`Party.xml`):

``` xml
<Party ses_unbounded="Address">
    <Id></Id>
    <Name></Name>
    <Address>
        <FirstName></FirstName>
        <LastName></LastName>
        <Street></Street>
        <PostalCode></PostalCode>
        <City></City>
        <Region></Region>
    </Address>
</Party>
```

#### `ses_unbounded`

Not required, but must be set for elements that may occur more than once.

Contains a (space-separated) list of sub-element names, that have `maxOccurence="unbounded"` in XSD. These elements must always be arrays in PHP classes/objects.

Example (`Party.xml`):

``` xml
<Party ses_unbounded="Address">
    <Id></Id>
    <Name></Name>
    <Address>
        <FirstName></FirstName>
        <LastName></LastName>
        <Street></Street>
        <PostalCode></PostalCode>
        <City></City>
        <Region></Region>
    </Address>
</Party>
```

#### `ses_tree`

Not required, but must be set for XML elements that should be serialized and deserialized without being defined by the generated PHP classes.

This is a space-separated list of elements which are intended to contain arbitrary tree data. It is mainly used for the SesExtension field. Elements defined in this attribute are considered by serialization processes to contain any XML tree structure, which is directly converted into an PHP, accordingly.	

Example (`Party.xml`):

``` xml
<Party ses_tree="SesExtension">
    <Id></Id>
    <Name></Name>
    <Address>
        <FirstName></FirstName>
        <LastName></LastName>
        <Street></Street>
        <PostalCode></PostalCode>
        <City></City>
        <Region></Region>
    </Address>
    <SesExtension>
        <AdditionalId></AdditionalId>
    </SesExtension>
</Party>
```

### `ses_desc`

Optional but recommended.

Used for documentation purposes, for example to document possible value-formats of a field.

This value is written in the PHP docHeader of the member. (Not implemented, yet)

Example:

``` xml
<Example ses_desc="Default ISO date format">2013-01-11</Example>
```

### Usage of the generator script

Workflow of the message generation:

1\. Create request and response XML files

The XML content should be available in a concept documentation in form of example XML or at least as a common structured data description.

- The file names must fit to the following scheme: `request|response.<messageName>.xml` whereas the content of `<messageName>` will be the base name for the generated files.
- You must define one file for each: request and response.
- The files must contain well-formed XML code.

Examples:

`request.party.xml`:

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<PartyRequest ses_type="cust:Party">
    <Party>
    </Party>
</PartyRequest>
```

`Party.xml`:

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<Party ses_unbounded="Address">
    <Id></Id>
    <Name></Name>
    <Address>
        <FirstName></FirstName>
        <LastName></LastName>
        <Street></Street>
        <PostalCode></PostalCode>
        <City></City>
        <Region></Region>
    </Address>
</Party>
```

`response.party.xml`:

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<ResponseParty>
    <Status></Status>
</ResponseParty>
```

2\. Extend the XML according to the format described above, if necessary.

3\. Upload the XML documents to the resources folder.

For standard messages:
    
- `vendor/silversolutions/silver.e-shop/src/Silversolutions/Bundle/EshopBundle/Resources/xml/request.party.xml`
- `vendor/silversolutions/silver.e-shop/src/Silversolutions/Bundle/EshopBundle/Resources/xml/response.party.xml`

For non standard messages

- `src/Example/Bundle/ExampleBundle/Resources/xml/request.party.xml`
- `src/Example/Bundle/ExampleBundle/Resources/xml/response.party.xml`

4\. Start the generation (check for any error messages):
    
Standard schema for command line:

``` 
php bin/console silversolutions:generatemessages --message <messageName> --sourceDir <path/to/src> --targetDir <path/to/target>
```

Example:

``` 
php bin/console silversolutions:generatemessages --message party --sourceDir src/Example/Bundle/ExampleBundle/Resources/xml --targetDir src/Example/Bundle/ExampleBundle
```

The target and source directories must exist. The target path must contain an `src` directory. All directories beneath `src` are considered as namespaces according to PSR-0.
The target path should be a Symfony bundle because all created sub-directories, like `Resources`, are intended to be used in a Symfony bundle.

Using the `--force` parameter overwrites all existing files. Use this parameter with caution as it also overwrites standard classes if used in the defined message.

The script now generates all necessary files into the following directories. Depending of the type of the class, `<targetDir>` can be `SilversolutionsEshopBundle` (for `ses_standard` classes) or the defined target directory (in this example `src/Example/Bundle/ExampleBundle`):

- `<targetDir>/Services/Factory/PartyFactoryListener.php`
- `<targetDir>/Resources/config/partyfactorylistener.service.yml`
- `<targetDir>/Resources/config/partymessage.message.yml`

`<targetDir>/Resources/config/` stores configuration that must be included into the Symfony application in order to activate the generated message factory.

-`<targetDir>/Entities/Messages/Document/PartyMessage.php`

### Creating and working with messages

After creating messages via `MessageInquiryService`, you can change the values of a document.

For example, the following code sends an RMA message:

``` php
<?
// In the context of a controller action you can pull service dependencies
// with $this->get('service_id');
 
/** @var \Silversolutions\Bundle\EshopBundle\Services\MessageInquiryService $inqService */
$inqService = $this->get('silver_erp.message_inquiry_service');
$message    = $inqService->inquireMessage(PartyFactoryListener::PARTY);
$request    = $message->getRequestDocument();
$request->Id->value = '23456';
$request->Name->value = 'Example & Co.';
$request->Address[] = new \Example\Bundle\ExampleBundle\Entities\Messages\Document\Address();
$request->Address[0]->FirstName->value = 'Peter';
$request->Address[0]->LastName->value = 'Smith';
// ... set further document values here ...
 
/** @var \Silversolutions\Bundle\EshopBundle\Services\Transport\AbstractMessageTransport $transport */
$transport  = $this->get('silver_erp.message_transport');
$response   = $transport->sendMessage($message)->getResponseDocument();
$status     = $response->Status->value;
// ... further work with the response via $response
```

- The converter is implemented within the `SilversolutionsEshopBundle` (`Command/GenerateMessagesCommand.php` and `Generator/XmlToPhpGenerator.php`)
- The target directory for standard elements / messages is `SilversolutionsEshopBundle`, it is not configurable.
- The generated PHP classes and configurations are not validated automatically. This should be done manually after the generation.
