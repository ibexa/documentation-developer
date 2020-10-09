# StandardCountryZoneService

`StandardCountryZoneService` is uses as a helper to resolve settings based on a region or zone.
It uses simple configuration to determine the zone by given country.

It is used for example to select template debitors in [`StandardTemplateDebitorService`](standardtemplatedebitorservice.md).

## Configuration

Service ID: `siso_core.country_zone.standard`

Default zones configuration:

``` yaml
#values for the siso_core.country_zone.standard service
silver_eshop.zone_country:
    EU: ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'EL', 'ES', 'FI', 'FR', 'GB', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK']
```

## CountryZoneServiceInterface

|Method|Description|
|--- |--- |
|`public function getCountries($zone);`|This method returns a list of countries for the given zone|
|`public function getZone($country);`|This method returns zone for the given country|
