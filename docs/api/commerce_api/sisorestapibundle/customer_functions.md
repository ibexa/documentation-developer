# Customer functions

## getShippingAddresses

`/api/ezp/v2/siso-rest/customer/addresses/shipping (GET)`

Returns available delivery addresses for the current customer.

Use the standard `ses.customer_profile_data.ez_erp` service to get shipping addresses: 

```
getCustomerProfileData()->deliveryParties
```

### Request

empty

### Response

```
{
    "ShippingAddressesResponse": {
        "_media-type": "application\/vnd.ez.api.ShippingAddressesResponse+json",
        "Parties": [
            {
                "_media-type": "application\/vnd.ez.api.Party+json",
                "PartyIdentification": [],
                "PartyName": [],
                "PostalAddress": {
                    "_media-type": "application\/vnd.ez.api.PartyPostalAddress+json",
                    "StreetName": null,
                    "AdditionalStreetName": null,
                    "BuildingNumber": null,
                    "CityName": null,
                    "PostalZone": null,
                    "CountrySubentity": null,
                    "CountrySubentityCode": null,
                    "AddressLine": [],
                    "Country": {
                        "_media-type": "application\/vnd.ez.api.PartyPostalAddressCountry+json",
                        "IdentificationCode": null,
                        "Name": null
                    },
                    "Department": null,
                    "SesExtension": {}
                },
                "Contact": {
                    "_media-type": "application\/vnd.ez.api.Contact+json",
                    "ID": null,
                    "Name": null,
                    "Telephone": null,
                    "Telefax": null,
                    "ElectronicMail": null,
                    "OtherCommunication": null,
                    "Note": null,
                    "SesExtension": {}
                },
                "Person": {
                    "_media-type": "application\/vnd.ez.api.PartyPerson+json",
                    "FirstName": null,
                    "FamilyName": null,
                    "Title": null,
                    "MiddleName": null,
                    "SesExtension": {}
                },
                "SesExtension": {}
            }
        ]
    }
}
```
