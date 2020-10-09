# CountryService

`CountryService` returns a list of countries with corresponding country codes.
The country names are translated for every SiteAccess.
This list of countries is used in all forms in the shop as a list of choices.

Because this service is aware of the form type name, it can return different countries for every form.
It can display a different list for the checkout process and a different list for the registration process.  

Service ID: `siso_tools.country`

## Configuration

The list of possible countries can be configured in `siso_tools.default.countries`.

## `getCountryNames`

The `getCountryNames` method takes the following parameters:

- `$formTypeName = null`
- `$locale = null`

It returns an array of country codes and names.
The country names are translated for required `Locale $locale`. If `$locale` is not set, current Locale is used.
This function can be customized depending on the given `$formTypeNam`e, e.g.:

```
array (
    'AF' => 'Afghanistan',
    ...
    'DE' => 'Germany'
)
```
