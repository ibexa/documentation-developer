---
description: Use date Twig filters to select the date and time format used in templates.
---

# Date Twig filters

Date and time Twig filters format a date and time object (`DateTimeInterface`)
in one of the formats defined in [user preferences](formatting_date_and_time.md#using-user-settings-menu).

- `ibexa_full_datetime`
- `ibexa_full_date`
- `ibexa_full_time`
- `ibexa_short_datetime`
- `ibexa_short_date`
- `ibexa_short_time`

If the `DateTimeInterface` argument is null, the filter returns the current date and time in the selected format.

``` html+twig
{{ content.contentInfo.publishedDate|ibexa_full_datetime }}
```

The filters also accept an optional `timezone` parameter for displaying date and time in a chosen time zone:

``` html+twig
{{ content.contentInfo.publishedDate|ibexa_short_datetime('PST')  }}
```
