# Common functions

## getCountrySelection

`/api/ezp/v2/siso-rest/country-selection (GET)`

Returns the list of configured country codes and their translations for the current SiteAccess.

Service ID: `siso_rest_api.country_selection_service`.

Inside this service the countries are fetched from the `siso_tools.country` service.

Parameter `ses_forms.default.preferred_country` is used for `defaultCountry`.

### Request

empty

### Response

```
{
    "CountrySelectionResponse": {
        "_media-type": "application\/vnd.ez.api.CountrySelectionResponse+json",
        "countryOptions": {
            "DZ": "Algerien",
            "AU": "Australien",
            "BE": "Belgien",
            "BR": "Brasilien",
            "BG": "Bulgarien",
            "DK": "D\u00e4nemark",
            "DE": "Deutschland",
            "EE": "Estland",
            "FI": "Finnland",
            "FR": "Frankreich",
            "GR": "Griechenland",
            "IN": "Indien",
            "ID": "Indonesien",
            "IE": "Irland",
            "IS": "Island",
            "IT": "Italien",
            "CA": "Kanada",
            "KE": "Kenia",
            "LV": "Lettland",
            "LT": "Litauen",
            "MY": "Malaysia",
            "MT": "Malta",
            "MX": "Mexiko",
            "MZ": "Mosambik",
            "NZ": "Neuseeland",
            "NL": "Niederlande",
            "NG": "Nigeria",
            "NO": "Norwegen",
            "AT": "\u00d6sterreich",
            "PH": "Philippinen",
            "PL": "Polen",
            "PT": "Portugal",
            "RO": "Rum\u00e4nien",
            "RU": "Russland",
            "SE": "Schweden",
            "CH": "Schweiz",
            "SG": "Singapur",
            "SK": "Slowakei",
            "SI": "Slowenien",
            "MO": "Sonderverwaltungsregion Macau",
            "ES": "Spanien",
            "ZA": "S\u00fcdafrika",
            "SZ": "Swasiland",
            "TZ": "Tansania",
            "TH": "Thailand",
            "CZ": "Tschechische Republik",
            "TN": "Tunesien",
            "TR": "T\u00fcrkei",
            "UG": "Uganda",
            "HU": "Ungarn",
            "AE": "Vereinigte Arabische Emirate",
            "US": "Vereinigte Staaten",
            "GB": "Vereinigtes K\u00f6nigreich",
            "CY": "Zypern"
        },
        "defaultCountry": "DE"
    }
}
```

## getCustomerprice

`/api/ezp/v2/siso-rest/customerprice (POST)`

Returns the customer price.

### Request

```
{
    "PriceRequest": {
        "Meta": {
            "Context": "product_list",
            "CatalogElement": true
        }
        "Items": [{
            "Sku": "1234",
            "Quantity": 2,
            "UnitOfMeasure": "ST",
            "DataMap": {}
        }]
    }
}
```

### Response

```
{
    "PriceResponse": [{
        "Sku": "1234",
        "RequestedQuantity": 2,
        "RequestedUnitOfMeasure": "ST",
        "CustomerPrice": {
            "Quantity": 2,
            "UnitOfMeasure": "ST",
            "Price": 1.50,
            "LinePrice": 3.00,
            "Currency": "EUR",
            "PriceFormatted": "1.50 €",
            "LinePriceFormatted": "3.00 €"
        },
        "ListPrice": {
            "Quantity": 2,
            "UnitOfMeasure": "ST",
            "Price": 1.5,
            "LinePrice": 3.00,
            "Currency": "EUR",
            "PriceFormatted": "1.50 €",
            "LinePriceFormatted": "3.00 €"
        },
        "Stock": 32,
        "Message": "",
        "DataMap": {}
    }]
}
```
