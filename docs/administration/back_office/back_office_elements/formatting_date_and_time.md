---
description: Use different formats to render dates and times in the back office and website front.
---

# Formatting date and time

Two methods exist that allow you to specify how the date and time should be formatted.

## With Twig filters and PHP services

You can format date and time by using the following services:

- `@ibexa.user.settings.short_datetime_format.formatter`
- `@ibexa.user.settings.short_datet_format.formatter`
- `@ibexa.user.settings.short_time_format.formatter`
- `@ibexa.user.settings.full_datetime_format.formatter`
- `@ibexa.user.settings.full_date_format.formatter`
- `@ibexa.user.settings.full_time_format.formatter`

To use them, create an `src/Service/MyService.php` file containing:

``` php
<?php

namespace App\Service;

use Ibexa\User\UserSetting\DateTimeFormat\FormatterInterface;

class MyService
{
    /** @var \Ibexa\User\UserSetting\DateTimeFormat\FormatterInterface */
    private $shortDateTimeFormatter;

    public function __construct(FormatterInterface $shortDateTimeFormatter)
    {
        // your code

        $this->shortDateTimeFormatter = $shortDateTimeFormatter;

        // your code
    }

    public function foo()
    {
        // your code

        $now = new \DateTimeImmutable();
        $date = $this->shortDateTimeFormatter->format($now);
        $utc = $this->shortDateTimeFormatter->format($now, 'UTC');

        // your code
    }
}
```

Then, add the following to `config/services.yaml`:

``` yaml
services:
    App\Service\MyService:
        arguments:
            $shortDateTimeFormatter: '@ibexa.user.settings.short_datetime_format.formatter'
```

## Within User settings menu

Users can set their preferred date and time formats in the user settings menu.
This format is used throughout the back office.

You can set the list of available formats under the `ibexa.system.<scope>.user_preferences` [configuration key](configuration.md#configuration-files):

``` yaml
ibexa:
    system:
        <scope>:
            user_preferences:
                allowed_short_date_formats:
                    'label for dd/MM/yyyy': 'dd/MM/yyyy'
                    'label for MM/dd/yyyy': 'MM/dd/yyyy'
                allowed_short_time_formats:
                    'label for HH:mm' : 'HH:mm'
                    'label for hh:mm a' : 'hh:mm a'
                allowed_full_date_formats:
                    'label for dd/MM/yyyy': 'dd/MM/yyyy'
                    'label for MM/dd/yyyy': 'MM/dd/yyyy'
                allowed_full_time_formats:
                    'label for HH:mm': 'HH:mm'
                    'label for hh:mm a': 'hh:mm a'
```

The default date and time format is set using:

``` yaml
ibexa:
    system:
        <scope>:
            user_preferences:
                short_datetime_format:
                    date_format: 'dd/MM/yyyy'
                    time_format: 'hh:mm'
                full_datetime_format:
                    date_format: 'dd/MM/yyyy'
                    time_format: 'hh:mm'
```

## Allowed formats

The following subset of the [ICU date and time formats](https://unicode-org.github.io/icu-docs/apidoc/released/icu4c/classSimpleDateFormat.html#details) is allowed:

|Symbol|Meaning|
|---|---|
|y, yy, yyyy, Y, YY, YYYY|year|
|q, Q|quarter|
|M, MM, MMM, MMMM, L, LL, LLL, LLLL|month|
|w, WW|week|
|d, dd|day of the month|
|D, DDD|day of the year|
|E, EE, EEE, EEEE, EEEEEE, e, ee, eee, eeee, eeeeee, c, cc, ccc, cccc, cccccc|weekday|
|a|AM or PM|
|h, hh, H, HH, k, kk|hour|
|m, mm|minute|
|s, ss, S...|second|
|Z, ZZ, ZZZ, ZZZZZ|timezone|
