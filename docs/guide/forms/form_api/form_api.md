# Form API [[% include 'snippets/commerce_badge.md' %]]

## PreDataProcessor and DataProcessors

The main services for form services are `preDataProcessor` and `dataProcessors`.
Both implement the `AbstractDataProcessor`, so the services must implement the `execute()` method.

Every form entity is a custom class, therefore, when the form is passed to `AbstractDataProcessor`,
it is encapsulated and passed in a `NormalizedEntity $formEntity`.

Every implementation of the `AbstractDataProcessor` can get and set the form data from/in the original form.
Every implementation must return `lastResult`.

Every `dataProcessor` can get/update the results of the previous `dataProcessors` that are stored in `lastResult`.
Every `dataProcessor` can set an additional error message that is displayed for the user if the process is not successful.

## Form validators

Besides standard [Symfony validators,](http://symfony.com/doc/3.4/validation.html)
[[= product_name_com =]] offers additional validators.

### ZIP validator

The ZIP code validation rules are different for each country.
To define the different code pattern for each ZIP code a new service is defined.

!!! note

    This validator validates the ZIP code based on the submitted country.
    If you want to use this validator in your project, make sure that your Form contains the `country` attribute.

The validator takes the pattern by country from the configuration, and compares it with the value in the form.
Country codes, pattern and code rules are defined in `ses_patern_zip.yml`.

### Email validator

A custom email validator extends the standard Symfony validation.

#### NonExistingEmailValidator

`NonExistingEmailValidator` checks if a user with the given email already exists.

#### User searching

You can set the Location where Users are contained in the following configuration:

``` yaml
ses_ez_helper.default.parent_location_id_users_members: 12
```

### Phone/fax number validator

A phone and/or fax validator verifies a valid number format. The following formats are supported:

- 0123456789
- +490123456789
- +49-0123456789
- 030-1234567
- 030/1234567
- +4930/1234567
- 0123 456 789 (spaces)

The following regex allows all combinations of 0-9, `+`, `-` and `/`, if minimum and maximum length fit.

``` 
('/^[0-9\-\+\/]{%min%,%max%}$/')
```

You can define the minimum and maximum length for the validator:

``` yaml
ses_phone_validator:
    min: 9
    max: 15
```

### VAT number validator

`VatNumberValidator` checks if the VAT number for commercial customers inside the European Union is valid.
The [VIES web-service (SOAP)](http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl) of the European Commission is used. 
A condition for validation is that the VAT number contains a country code.
