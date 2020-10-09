# Basket functions

## getBasket

`/api/ezp/v2/siso-rest/basket/current (GET)`

Returns the current basket of the user with header information and order lines.

Standard service ID: `silver_basket.basket_service`

### Request

empty

??? note "Response"

    ```
    "Basket": {
            "_media-type": "application\/vnd.ez.api.Basket+json",
            "basketId": 107,
            "originId": null,
            "erpOrderId": null,
            "guid": null,
            "state": "new",
            "type": "basket",
            "erpFailCounter": null,
            "erpFailErrorLog": null,
            "sessionId": "haub3a7963sg9mj7vbtt2dj403",
            "userId": null,
            "basketName": null,
            "invoiceParty": {
                "_media-type": "application\/vnd.ez.api.Party+json",
                "PartyIdentification": [],
                "PartyName": [
                    {
                        "_media-type": "application\/vnd.ez.api.PartyPartyName+json",
                        "Name": "Anke Test"
                    },
                    {
                        "_media-type": "application\/vnd.ez.api.PartyPartyName+json",
                        "Name": null
                    }
                ],
                "PostalAddress": {
                    "_media-type": "application\/vnd.ez.api.PartyPostalAddress+json",
                    "StreetName": "Teststr. 11",
                    "AdditionalStreetName": null,
                    "BuildingNumber": null,
                    "CityName": "Testingen",
                    "PostalZone": "1111",
                    "CountrySubentity": "Dummy",
                    "CountrySubentityCode": null,
                    "AddressLine": [],
                    "Country": {
                        "_media-type": "application\/vnd.ez.api.PartyPostalAddressCountry+json",
                        "IdentificationCode": "NO",
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
                    "ElectronicMail": "aka_test1@silversolutions.de",
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
                "SesExtension": {
                    "forceInvoice": false,
                    "customer_type": "private"
                }
            },
            "deliveryParty": null,
            "buyerParty": {
                "_media-type": "application\/vnd.ez.api.Party+json",
                "PartyIdentification": [],
                "PartyName": [
                    {
                        "_media-type": "application\/vnd.ez.api.PartyPartyName+json",
                        "Name": "Anke Test"
                    },
                    {
                        "_media-type": "application\/vnd.ez.api.PartyPartyName+json",
                        "Name": null
                    }
                ],
                "PostalAddress": {
                    "_media-type": "application\/vnd.ez.api.PartyPostalAddress+json",
                    "StreetName": "Teststr. 11",
                    "AdditionalStreetName": null,
                    "BuildingNumber": null,
                    "CityName": "Testingen",
                    "PostalZone": "1111",
                    "CountrySubentity": "Dummy",
                    "CountrySubentityCode": null,
                    "AddressLine": [],
                    "Country": {
                        "_media-type": "application\/vnd.ez.api.PartyPostalAddressCountry+json",
                        "IdentificationCode": "NO",
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
                    "ElectronicMail": "aka_test1@silversolutions.de",
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
                "SesExtension": {
                    "forceInvoice": false,
                    "customer_type": "private"
                }
            },
            "remark": null,
            "dateCreated": {
                "_media-type": "application\/vnd.ez.api.DateTime+json",
                "_exception": {
                    "Name": "eZ\\Publish\\Core\\REST\\Common\\Output\\Exceptions\\NoVisitorFoundException",
                    "Message": "No visitor found for DateTime!"
                }
            },
            "dateLastModified": {
                "_media-type": "application\/vnd.ez.api.DateTime+json",
                "_exception": {
                    "Name": "eZ\\Publish\\Core\\REST\\Common\\Output\\Exceptions\\NoVisitorFoundException",
                    "Message": "No visitor found for DateTime!"
                }
            },
            "shop": "haugenbok",
            "requirePriceUpdate": false,
            "totals": {
                "lines": {
                    "_media-type": "application\/vnd.ez.api.BasketTotals+json",
                    "name": "",
                    "totalNet": null,
                    "totalGross": null,
                    "vatList": {},
                    "groupType": "order",
                    "currency": "NOK"
                },
                "additionalLines": {
                    "_media-type": "application\/vnd.ez.api.BasketTotals+json",
                    "name": "",
                    "totalNet": null,
                    "totalGross": null,
                    "vatList": {},
                    "groupType": "order",
                    "currency": "NOK"
                }
            },
            "totalsSum": {
                "_media-type": "application\/vnd.ez.api.BasketTotals+json",
                "name": "",
                "totalNet": null,
                "totalGross": null,
                "vatList": {},
                "groupType": "order",
                "currency": "NOK"
            },
            "currency": null,
            "totalsSumNet": null,
            "totalsSumGross": null,
            "additionalLines": null,
            "lines": [],
            "dateLastPriceCalculation": {
                "_media-type": "application\/vnd.ez.api.DateTime+json",
                "_exception": {
                    "Name": "eZ\\Publish\\Core\\REST\\Common\\Output\\Exceptions\\NoVisitorFoundException",
                    "Message": "No visitor found for DateTime!"
                }
            },
            "shippingMethod": "expressDel",
            "paymentMethod": "invoice",
            "paymentTransactionId": null,
            "confirmationEmail": null,
            "salesConfirmationEmail": null,
            "allProductsAvailable": true,
            "dataMap": {
                "voucher_1234567": "1234567"
            }
        }
    ```

## readBasketList

`/api/ezp/v2/siso-rest/basket/header/{basket_type} (GET)`

Returns all baskets of the given type of the user with header information.

Standard service ID: `silver_basket.basket_service`

### Request

empty

??? note "Response"

    ```
    {
      "BasketListResponse": {
        "_media-type": "application/vnd.ez.api.BasketListResponse+json",
        "basketList": [
          {
            "_media-type": "application/vnd.ez.api.stdClass+json",
            "basketId": 1198,
            "state": "new",
            "type": "basket",
            "userId": 26569,
            "invoiceParty": {
              "_media-type": "application/vnd.ez.api.Party+json",
              "PartyIdentification": [],
              "PartyName": [
                {
                  "_media-type": "application/vnd.ez.api.PartyPartyName+json",
                  "Name": "Anke Test"
                },
                {
                  "_media-type": "application/vnd.ez.api.PartyPartyName+json",
                  "Name": null
                }
              ],
              "PostalAddress": {
                "_media-type": "application/vnd.ez.api.PartyPostalAddress+json",
                "StreetName": "610 N Elm DR",
                "AdditionalStreetName": null,
                "BuildingNumber": null,
                "CityName": "Beverly Hills",
                "PostalZone": "90210",
                "CountrySubentity": "CA",
                "CountrySubentityCode": "CA",
                "AddressLine": [],
                "Country": {
                  "_media-type": "application/vnd.ez.api.PartyPostalAddressCountry+json",
                  "IdentificationCode": "US",
                  "Name": null
                },
                "Department": null,
                "SesExtension": {}
              },
              "Contact": {
                "_media-type": "application/vnd.ez.api.Contact+json",
                "ID": null,
                "Name": null,
                "Telephone": null,
                "Telefax": null,
                "ElectronicMail": "mal@silversolutions.de",
                "OtherCommunication": null,
                "Note": null,
                "SesExtension": {}
              },
              "Person": {
                "_media-type": "application/vnd.ez.api.PartyPerson+json",
                "FirstName": null,
                "FamilyName": null,
                "Title": null,
                "MiddleName": null,
                "SesExtension": {}
              },
              "SesExtension": {
                "forceInvoice": false,
                "customer_type": "private"
              }
            },
            "deliveryParty": {
              "_media-type": "application/vnd.ez.api.Party+json",
              "PartyIdentification": [],
              "PartyName": [
                {
                  "_media-type": "application/vnd.ez.api.PartyPartyName+json",
                  "Name": "Anke Test"
                },
                {
                  "_media-type": "application/vnd.ez.api.PartyPartyName+json",
                  "Name": null
                }
              ],
              "PostalAddress": {
                "_media-type": "application/vnd.ez.api.PartyPostalAddress+json",
                "StreetName": "610 N Elm DR",
                "AdditionalStreetName": null,
                "BuildingNumber": null,
                "CityName": "Beverly Hills",
                "PostalZone": "90210",
                "CountrySubentity": "CA",
                "CountrySubentityCode": "CA",
                "AddressLine": [],
                "Country": {
                  "_media-type": "application/vnd.ez.api.PartyPostalAddressCountry+json",
                  "IdentificationCode": "US",
                  "Name": null
                },
                "Department": null,
                "SesExtension": {}
              },
              "Contact": {
                "_media-type": "application/vnd.ez.api.Contact+json",
                "ID": null,
                "Name": null,
                "Telephone": null,
                "Telefax": null,
                "ElectronicMail": "mal@silversolutions.de",
                "OtherCommunication": null,
                "Note": null,
                "SesExtension": {}
              },
              "Person": {
                "_media-type": "application/vnd.ez.api.PartyPerson+json",
                "FirstName": null,
                "FamilyName": null,
                "Title": null,
                "MiddleName": null,
                "SesExtension": {}
              },
              "SesExtension": {
                "forceInvoice": false,
                "customer_type": "private"
              }
            },
            "buyerParty": {
              "_media-type": "application/vnd.ez.api.Party+json",
              "PartyIdentification": [],
              "PartyName": [
                {
                  "_media-type": "application/vnd.ez.api.PartyPartyName+json",
                  "Name": "Anke Test"
                },
                {
                  "_media-type": "application/vnd.ez.api.PartyPartyName+json",
                  "Name": null
                }
              ],
              "PostalAddress": {
                "_media-type": "application/vnd.ez.api.PartyPostalAddress+json",
                "StreetName": "610 N Elm DR",
                "AdditionalStreetName": null,
                "BuildingNumber": null,
                "CityName": "Beverly Hills",
                "PostalZone": "90210",
                "CountrySubentity": "CA",
                "CountrySubentityCode": "CA",
                "AddressLine": [],
                "Country": {
                  "_media-type": "application/vnd.ez.api.PartyPostalAddressCountry+json",
                  "IdentificationCode": "US",
                  "Name": null
                },
                "Department": null,
                "SesExtension": {}
              },
              "Contact": {
                "_media-type": "application/vnd.ez.api.Contact+json",
                "ID": null,
                "Name": null,
                "Telephone": null,
                "Telefax": null,
                "ElectronicMail": "mal@silversolutions.de",
                "OtherCommunication": null,
                "Note": null,
                "SesExtension": {}
              },
              "Person": {
                "_media-type": "application/vnd.ez.api.PartyPerson+json",
                "FirstName": null,
                "FamilyName": null,
                "Title": null,
                "MiddleName": null,
                "SesExtension": {}
              },
              "SesExtension": {
                "forceInvoice": false,
                "customer_type": "private"
              }
            },
            "remark": "Test remark",
            "dateCreated": {
              "_media-type": "application/vnd.ez.api.DateTime+json",
              "date": "2018-07-11 11:28:42.000000",
              "timezone_type": 3,
              "timezone": "Europe/Berlin"
            },
            "dateLastModified": {
              "_media-type": "application/vnd.ez.api.DateTime+json",
              "date": "2018-07-31 13:16:09.000000",
              "timezone_type": 3,
              "timezone": "Europe/Berlin"
            },
            "totals": [
              {
                "_media-type": "application/vnd.ez.api.BasketTotals+json"
              },
              {
                "_media-type": "application/vnd.ez.api.BasketTotals+json"
              }
            ],
            "totalsSum": {
              "_media-type": "application/vnd.ez.api.BasketTotals+json"
            },
            "currency": "USD",
            "totalsSumNet": 784,
            "totalsSumGross": 784,
            "dateLastPriceCalculation": {
              "_media-type": "application/vnd.ez.api.DateTime+json",
              "date": "2018-07-31 12:48:58.000000",
              "timezone_type": 3,
              "timezone": "Europe/Berlin"
            },
            "paymentMethod": "invoice"
          }
        ]
      }
    }
    ```

## updateBasketParty

```
/api/ezp/v2/siso-rest/basket/current/party/invoice (PATCH)
/api/ezp/v2/siso-rest/basket/current/party/delivery (PATCH)
/api/ezp/v2/siso-rest/basket/current/party/buyer (PATCH)
```

Validates party data and stores it in basket.

Standard service ID: `siso_rest_api.basket_helper_service` (methods `validateParty` and `storePartyInBasket`)

### Validation in standard

!!! note

    Due to a bug in the Symfony Validation component, it is not possible to pass groups to sub-constraints of composite constraints.
    Composite constraints themselves can be configured with validation groups.
    This means that if the sub-constraints should be validated in different groups,
    the composite (in this example `StringObject`) must be duplicated with the respective combinations of groups.
    An example of this can be found in the ElectronicMail field of the Contact class below.
    
``` yaml
Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\Party:
    properties:
        PartyName:
            - Valid: ~
        PostalAddress:
            - Valid: ~
        Contact:
            - Valid: ~
    constraints:
        - Callback: [Siso\RestApiBundle\Validator\Constraints\PartyValidator, validatePartyName]
 
Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\PartyPartyName:
    properties:
       Name:
        - NotBlank: ~
        - Siso\RestApiBundle\Validator\Constraints\StringObject:
            - Length:
                min: 2
                max: 30
                minMessage: 'Please enter minimum {{ limit }} chars'
                maxMessage: 'Maximum {{ limit }} chars'
 
Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\PartyPostalAddress:
    properties:
        StreetName:
            - Siso\RestApiBundle\Validator\Constraints\StringObject:
                - NotBlank: ~
                - Length:
                    min: 2
                    max: 30
                    minMessage: 'Please enter minimum {{ limit }} chars'
                    maxMessage: 'Maximum {{ limit }} chars'
        AdditionalStreetName:
            - Siso\RestApiBundle\Validator\Constraints\StringObject:
                - Length:
                    min: 2
                    max: 30
                    minMessage: 'Please enter minimum {{ limit }} chars'
                    maxMessage: 'Maximum {{ limit }} chars'
        CityName:
            - Siso\RestApiBundle\Validator\Constraints\StringObject:
                - NotBlank: ~
                - Length:
                    min: 2
                    max: 30
                    minMessage: 'Please enter minimum {{ limit }} chars'
                    maxMessage: 'Maximum {{ limit }} chars'
        PostalZone:
            - Siso\RestApiBundle\Validator\Constraints\StringObject:
                - NotBlank: ~
                - Siso\RestApiBundle\Validator\Constraints\Zip: ~
        CountrySubentity:
            - Siso\RestApiBundle\Validator\Constraints\StringObject:
                - Length:
                    min: 2
                    max: 30
                    minMessage: 'Please enter minimum {{ limit }} chars'
                    maxMessage: 'Maximum {{ limit }} chars'
        Country:
            - Valid: ~
 
Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\PartyPostalAddressCountry:
    properties:
        IdentificationCode:
            - Siso\RestApiBundle\Validator\Constraints\StringObject:
                - NotBlank: ~
 
Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\Contact:
    properties:
        ElectronicMail:
            - Siso\RestApiBundle\Validator\Constraints\StringObject:
                groups: ['invoice']
                constraints:
                    - NotBlank: ~
                    - Silversolutions\Bundle\EshopBundle\Entities\Forms\Constraints\Email: ~
            - Siso\RestApiBundle\Validator\Constraints\StringObject:
                groups: ['Default']
                constraints:
                    - Silversolutions\Bundle\EshopBundle\Entities\Forms\Constraints\Email: ~
        Telephone:
            - Siso\RestApiBundle\Validator\Constraints\StringObject:
                - Silversolutions\Bundle\EshopBundle\Entities\Forms\Constraints\Phone: ~
```

### Request

```
"PartyData": {
    "_data-type": "invoice",
    "_media-type": "application\/vnd.ez.api.Party+json",
    "PartyIdentification": [],
    "PartyName": [
        {
            "_media-type": "application\/vnd.ez.api.PartyPartyName+json",
            "Name": "Anke Test"
        },
        {
            "_media-type": "application\/vnd.ez.api.PartyPartyName+json",
            "Name": ""
        }
    ],
    "PostalAddress": {
        "_media-type": "application\/vnd.ez.api.PartyPostalAddress+json",
        "StreetName": "Teststr. 11",
        "AdditionalStreetName": "",
        "BuildingNumber": null,
        "CityName": "Testingen",
        "PostalZone": "1111",
        "CountrySubentity": "Dummy",
        "CountrySubentityCode": null,
        "AddressLine": [],
        "Country": {
            "_media-type": "application\/vnd.ez.api.PartyPostalAddressCountry+json",
            "IdentificationCode": "NO",
            "Name": null
        },
        "Department": null,
        "SesExtension": {}
    },
    "Contact": {
        "_media-type": "application\/vnd.ez.api.Contact+json",
        "ID": null,
        "Name": null,
        "Telephone": "",
        "Telefax": null,
        "ElectronicMail": "aka_test1@silversolutions.de",
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
    "SesExtension": {
        "forceInvoice": false,
        "customer_type": "private"
    }
}
```

### Response

Success:

```
"ValidationResponse": {
        "_media-type": "application\/vnd.ez.api.ValidationResponse+json",
        "messages": []
    }
```

Error:

```
{
    "ValidationResponse": {
        "_media-type": "application\/vnd.ez.api.ValidationResponse+json",
        "messages": {
            "Party": {
                "PartyName": [
                    {
                        "Name": "This value should not be blank."
                    }
                ],
                "PostalAddress": {
                    "StreetName": "This value should not be blank.",
                    "CityName": "This value should not be blank.",
                    "PostalZone": [
                        "This value should not be blank.",
                        "\"\" is not a valid ZIP code. For valid ZIP code use following pattern \"1234\"."
                    ]
                },
                "Contact": {
                    "ElectronicMail": "This value should not be blank."
                }
            }
        }
    }
}
```

## updateStoredBasket

`/api/ezp/v2/siso-rest/basket/update-stored/{basketId} (POST)`

Adds lines to stored basket with `basketId`.

### Request

```
{
        "BasketLineData": [{
            "basketLineId": 900,
            "lineNumber": 1,
            "sku": "000000000000001134",
            "variantCode": null,
            "productType": "OrderableProductNode",
            "quantity": 1,
            "unit": null,
            "price": 300,
            "priceNet": 300,
            "priceGross": 300,
            "linePriceAmountNet": 300,
            "linePriceAmountGross": 300,
            "vat": 0,
            "isIncVat": false,
            "currency": "EUR",
            "catalogElement": {
                "groupCalc": null,
                "groupOrder": null,
                "remark": null,
                "remoteDataMap": {
                    "isPriceValid": true,
                    "lineRemark": null,
                    "scaledPrices": null,
                    "sapLineId": 10,
                    "dlvDate": "2018-08-14",
                    "discount": 35,
                    "hasDeliveryDateEmpty": false,
                    "sapListPrice": {
                        "price": 300,
                        "currency": "EUR",
                        "stock": {
                            "variantCharacteristics": null,
                            "assignedLines": null
                        }
                    }
 
                }
            }
        },
            {
                "basketLineId": 900,
                "lineNumber": 1,
                "sku": "000000000000001134",
                "variantCode": null,
                "productType": "OrderableProductNode",
                "quantity": 1,
                "unit": null,
                "price": 300,
                "priceNet": 300,
                "priceGross": 300,
                "linePriceAmountNet": 300,
                "linePriceAmountGross": 300,
                "vat": 0,
                "isIncVat": false,
                "currency": "EUR",
                "catalogElement": {
                    "groupCalc": null,
                    "groupOrder": null,
                    "remark": null,
                    "remoteDataMap": {
                        "isPriceValid": true,
                        "lineRemark": null,
                        "scaledPrices": null,
                        "sapLineId": 10,
                        "dlvDate": "2018-08-14",
                        "discount": 35,
                        "hasDeliveryDateEmpty": false,
                        "sapListPrice": {
                            "price": 300,
                            "currency": "EUR",
                            "stock": {
                                "variantCharacteristics": null,
                                "assignedLines": null
                            }
                        }
                    }
                }
            }
        ]};
}
```

### Response

Success:

```
"ValidationResponse": {
        "_media-type": "application\/vnd.ez.api.ValidationResponse+json",
        "messages": {
            "_success":""
        }
    }
```

Error:

```
"ValidationResponse": {
        "_media-type": "application\/vnd.ez.api.ValidationResponse+json",
        "messages": {
            "_error":[
                "error_message"
            ]
        }
    }
```


## updateBasketShippingMethod

`/api/ezp/v2/siso-rest/basket/current/shippingmethod (PATCH)`

Validates and stores shipping method in the current basket.

Standard service ID: `siso_rest_api.basket_helper_service` (methods `validateShippingMethod` and `storeShippingMethodInBasket`)

### Validation in standard

```
Siso\RestApiBundle\Model\ShippingMethod:
    constraints:
        - Siso\RestApiBundle\Validator\Constraints\ShippingMethodConstraint: ~
```

### Request

```
"ShippingMethodData":{
    "shippingMethod":"mail"
}
```

### Reponse

Success:

```
"ValidationResponse": {
        "_media-type": "application\/vnd.ez.api.ValidationResponse+json",
        "messages": []
    }
```

Error:

```
"ValidationResponse": {
        "_media-type": "application\/vnd.ez.api.ValidationResponse+json",
        "messages": [
            "Object(Siso\\RestApiBundle\\Model\\ShippingMethod):\n    The value is not valid"
        ]
    }
```

## updateBasketPaymentMethod

`/api/ezp/v2/siso-rest/basket/current/paymentmethod (PATCH)`

Validates and stores shipping method in the current basket.

Standard service ID: `siso_rest_api.basket_helper_service` (methods `validatePaymentMethod` and `storePaymentMethodInBasket`)

### Validation in standard

```
Siso\RestApiBundle\Model\PaymentMethod:
    constraints:
        - Siso\RestApiBundle\Validator\Constraints\PaymentMethodConstraint: ~
```

### Request

```
"PaymentMethodData":{
    "paymentMethod":"invoice"
}
```

### Response

Success:

```
"ValidationResponse": {
        "_media-type": "application\/vnd.ez.api.ValidationResponse+json",
        "messages": []
    }
```

Error:

```
"ValidationResponse": {
        "_media-type": "application\/vnd.ez.api.ValidationResponse+json",
        "messages": [
            "Object(Siso\\RestApiBundle\\Model\\PaymentMethod):\n    The value is not valid"
        ]
    }
```

## updateBasketVoucher

`/api/ezp/v2/siso-rest/basket/current/voucher (PATCH)`

Validates and stores the voucher code in the current basket. If an empty field is sent, the current voucher is deleted.

Standard service ID: `siso_rest_api.basket_helper_service` (method `validateAndStoreVoucherCode`)

### Request

```
"VoucherData":{
    "voucherCode":"1234567"
}
```

### Response

Success:

```
"ValidationResponse": {
        "_media-type": "application\/vnd.ez.api.ValidationResponse+json",
        "messages": []
    }
```

Error:

```
"ValidationResponse": {
        "_media-type": "application\/vnd.ez.api.ValidationResponse+json",
        "messages": [
            "Object(Siso\\RestApiBundle\\Model\\Voucher):\n    The value is not valid"
        ]
    }
```

## AddToBasket

`/api/ezp/v2/siso-rest/basket/current/lines (POST)`

Call to add one or more items to the current basket.

### Request

```
{
    "BasketLineData":[
        {
            "sku": "9788202544683",
            "quantity": 3,
            "isVariant": 0,
            "variantCode": ''
        },
        {
            "sku":"9788210056116",
            "quantity": 1,
            "isVariant": 0,
            "variantCode": ''
        }
    ]
 
}
```

### Response

Success:

```
{
    "ValidationResponse": {
        "_media-type": "application\/vnd.ez.api.ValidationResponse+json",
        "messages": []
    }
}
```

Error:

```
{
    "ValidationResponse": {
        "_media-type": "application\/vnd.ez.api.ValidationResponse+json",
        "messages": [
            "Product with the sku: 9788210056115 not found"
        ]
    }
}
```

## UpdateBasket

`/api/ezp/v2/siso-rest/basket/update (POST)`

Calls to update one or more items in the current basket.

If the quantity is 0, the line is removed from the basket

Currently only the following properties are updated:

- `quantity`
- `RemoteDataMap`
- `remark`

### Request

```
{
    "BasketLineData":[
    {
        "_media-type": "application/vnd.ez.api.BasketLine+json",
        "basketLineId": 122,
        "lineNumber": 3,
        "sku": "000000000000001134",
        "variantCode": null,
        "productType": "OrderableProductNode",
        "quantity": 2,
        "unit": null,
        "price": 392,
        "priceNet": 392,
        "priceGross": 392,
        "linePriceAmountNet": 392,
        "linePriceAmountGross": 392,
        "vat": 0,
        "isIncVat": false,
        "currency": "USD",
        "catalogElement": {
            "_media-type": "application/vnd.ez.api.OrderableProductNode+json",
            "sku": "000000000000001134",
            "manufacturerSku": "",
            "ean": "4053913000014",
            "type": null,
            "isOrderable": null,
            "price": {
                "_media-type": "application/vnd.ez.api.PriceField+json"
            },
            "customerPrice": null,
            "scaledPrices": null,
            "stock": null,
            "shortDescription": {
                "_media-type": "application/vnd.ez.api.TextBlockField+json"
            },
            "longDescription": {
                "_media-type": "application/vnd.ez.api.TextBlockField+json"
            },
            "specifications": null,
            "imageList": {
                "0": {
                    "_media-type": "application/vnd.ez.api.ImageField+json"
                },
                "1": {
                    "_media-type": "application/vnd.ez.api.ImageField+json"
                },
                "2": {
                    "_media-type": "application/vnd.ez.api.ImageField+json"
                }
            },
            "minOrderQuantity": null,
            "maxOrderQuantity": null,
            "allowedQuantity": null,
            "packagingUnit": null,
            "unit": null,
            "vatCode": "VATUNIT",
            "name": "2/2-way-piston-operated angle-seat valve",
            "text": "",
            "image": {
                "_media-type": "application/vnd.ez.api.ImageField+json"
            },
            "path": null,
            "url": "/process-and-control-valves/shut-off-valves-on-off/angle-seat-valves/pneumatic/1134",
            "parentElementIdentifier": "1000015",
            "identifier": "1005576",
            "cacheIdentifier": null,
            "checkProperties": null
        },
        "groupCalc": null,
        "groupOrder": null,
        "remark": null,
        "remoteDataMap": {
            "isPriceValid": true,
            "lineRemark": null,
            "scaledPrices": null,
            "hasDeliveryDateEmpty": true
        },
        "variantCharacteristics": null,
        "assignedLines": null
    },
    {
        "_media-type": "application/vnd.ez.api.BasketLine+json",
        "basketLineId": 123,
        "lineNumber": 4,
        "sku": "000000000000134590",
        "variantCode": null,
        "productType": "OrderableProductNode",
        "quantity": 3,
        "unit": null,
        "price": 623,
        "priceNet": 623,
        "priceGross": 623,
        "linePriceAmountNet": 623,
        "linePriceAmountGross": 623,
        "vat": 0,
        "isIncVat": false,
        "currency": "USD",
        "catalogElement": {
            "_media-type": "application/vnd.ez.api.OrderableProductNode+json",
            "sku": "000000000000134590",
            "manufacturerSku": "",
            "ean": "4053913025352",
            "type": null,
            "isOrderable": null,
            "price": {
                "_media-type": "application/vnd.ez.api.PriceField+json"
            },
            "customerPrice": null,
            "scaledPrices": null,
            "stock": null,
            "shortDescription": {
                "_media-type": "application/vnd.ez.api.TextBlockField+json"
            },
            "longDescription": {
                "_media-type": "application/vnd.ez.api.TextBlockField+json"
            },
            "specifications": null,
            "imageList": {
                "0": {
                    "_media-type": "application/vnd.ez.api.ImageField+json"
                },
                "1": {
                    "_media-type": "application/vnd.ez.api.ImageField+json"
                },
                "2": {
                    "_media-type": "application/vnd.ez.api.ImageField+json"
                }
            },
            "minOrderQuantity": null,
            "maxOrderQuantity": null,
            "allowedQuantity": null,
            "packagingUnit": null,
            "unit": null,
            "vatCode": "VATUNIT",
            "name": "2/2-way-solenoid valve; servo-piston",
            "text": "",
            "image": {
                "_media-type": "application/vnd.ez.api.ImageField+json"
            },
            "path": null,
            "url": "/solenoid-valves/general-purpose-2-2-solenoids/134590",
            "parentElementIdentifier": "1000001",
            "identifier": "1006516",
            "cacheIdentifier": null,
            "checkProperties": null
        },
        "groupCalc": null,
        "groupOrder": null,
        "remark": null,
        "remoteDataMap": {
            "isPriceValid": true,
            "lineRemark": null,
            "scaledPrices": null,
            "hasDeliveryDateEmpty": true
        },
        "variantCharacteristics": null,
        "assignedLines": null
    }
]
 
}
```

### Response

Success:

```
{
    "ValidationResponse": {
        "_media-type": "application\/vnd.ez.api.ValidationResponse+json",
        "messages": []
    }
}
```

Error:

```
{
    "ValidationResponse": {
        "_media-type": "application\/vnd.ez.api.ValidationResponse+json",
        "messages": [
            "Product with the sku: 9788210056115 not found"
        ]
    }
}
```
