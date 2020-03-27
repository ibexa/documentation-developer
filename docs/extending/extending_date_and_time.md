# Format date and time

## Twig filters

Apart from changing the [date and time formats](../guide/config_back_office.md#date-and-time-formats), you can use Twig filters:

- `ez_short_datetime`
- `ez_short_date`
- `ez_short_time`
- `ez_full_datetime`
- `ez_full_date`
- `ez_full_time`

The following are examples of using the filters:

``` php hl_lines="3 6"
<div>
    // Date formatted in the preferred time zone and short datetime format:
    {{ content.versionInfo.creationDate|ez_short_datetime }}

    // Date formatted in UTC and preferred short datetime format:
    {{ content.versionInfo.creationDate|ez_short_datetime('UTC') }}
</div>
```

The filters accept an optional `timezone` parameter for displaying date and time in a chosen time zone.
The default time zone is set in the User settings menu.

For details, see reference materials on the [full format filters](../guide/twig_functions_reference.md#ez_full_datetime-ez_full_date-ez_full_time) and [short format filters](../guide/twig_functions_reference.md#ez_short_datetime-ez_short_date-ez_short_time).

## Services

You can also format date and time by using the following services:

- `@ezplatform.user.settings.short_datetime_format.formatter`
- `@ezplatform.user.settings.short_datet_format.formatter`
- `@ezplatform.user.settings.short_time_format.formatter`
- `@ezplatform.user.settings.full_datetime_format.formatter`
- `@ezplatform.user.settings.full_date_format.formatter`
- `@ezplatform.user.settings.full_time_format.formatter`

To use them, create an `src\Service\MyService.php` file containing:

``` php
<?php

namespace App\Service;

use EzSystems\EzPlatformUser\UserSetting\DateTimeFormat\FormatterInterface;

class MyService
{
    /** @var \EzSystems\EzPlatformUser\UserSetting\DateTimeFormat\FormatterInterface */
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
            $shortDateTimeFormatter: '@ezplatform.user.settings.short_datetime_format.formatter'
```
