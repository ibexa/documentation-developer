# SisoRestApiBundle

## Using the REST interface

For GET requests a token is not required.

``` 
axios.get('/api/ezp/v2/siso-rest/basket')
    .then(function (response) {

           app.basketObject = response.data;
           if(app.basketObject.Basket) {
                   .....
           }
                
}
```

If you are using a PATCH request, a token is required. A Twig function provides the current token.

``` 
var token = "{{ csrf_token('rest') }}";
axios.patch('/api/ezp/v2/siso-rest/basket/current/shippingmethod', {
    "ShippingMethodData": {
        "shippingMethod": app.shippingMethod
    }
}, {
    headers: {
        'X-CSRF-Token': token,
        'Content-Type': 'application/vnd.ez.api.ShippingMethodData+json',
        'Accept': 'application/vnd.ez.api.Basket+json'
    }
})
```

## Error handling / responses

```
{
    "ValidationResponse": {
        "_media-type": "application\/vnd.ez.api.ValidationResponse+json",
        "messages": {
            "Party": {
                "_errors": [
                    {
                        "_code": 103,
                        "_message": "This address is already stored in your address book"
                    }
                ]
                "PartyName": [
                    {
                        "Name": {
                            "_errors": [
                                {
                                    "_code": 100,
                                    "_message": "This value should not be blank."
                                }
                            ]
                        }
                    }
                ],
                "PostalAddress": {
                    "StreetName": {
                        "_errors": [
                            {
                                "_code": 100,
                                "_message": "This value should not be blank."
                            }
                        ]
                    },
                    "CityName": {
                        "_errors": [
                            {
                                "_code": 100,
                                "_message": "This value should not be blank."
                            }
                        ]
                    },
                    "PostalZone": {
                        "_errors": [
                            {
                                "_code": 100,
                                "_message": "This value should not be blank."
                            },
                            {
                                "_code": 101,
                                "_message": "\"\" is not a valid ZIP code. For valid ZIP code use following pattern \"1234\"."
                            }
                        ]
                    }
                },
                "Contact": {
                    "ElectronicMail": {
                        "_errors": [
                            {
                                "_code": 100,
                                "_message": "This value should not be blank."
                            }
                        ]
                    }
                }
            }
        }
    }
}
```

``` 
{{ error_message([Party][PartyName][Name]) }}
```
