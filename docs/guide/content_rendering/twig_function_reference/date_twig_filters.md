---
description: Use date Twig filters to select the date and time format used in templates.
---

# Date Twig filters

Date and time Twig filters format a date and time object (`DateTimeInterface`)
in one of the formats defined in [user preferences](../../../extending/extending_date_and_time.md#using-user-settings-menu).

- `ez_full_datetime`
- `ez_full_date`
- `ez_full_time`
- `ez_short_datetime`
- `ez_short_date`
- `ez_short_time`

If the `DateTimeInterface` argument is null, the filter returns the current date and time in the selected format.

``` html+twig
{{ content.contentInfo.publishedDate|ez_full_datetime }}
```

The filters also accept an optional `timezone` parameter for displaying date and time in a chosen time zone:

``` html+twig
{{ content.contentInfo.publishedDate|ez_short_datetime('PST')  }}
```
