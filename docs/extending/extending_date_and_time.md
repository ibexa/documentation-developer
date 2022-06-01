# Formatting date and time

You can format date and time by using the following services:

- `@ibexa.user.settings.short_datetime_format.formatter`
- `@ibexa.user.settings.short_datet_format.formatter`
- `@ibexa.user.settings.short_time_format.formatter`
- `@ibexa.user.settings.full_datetime_format.formatter`
- `@ibexa.user.settings.full_date_format.formatter`
- `@ibexa.user.settings.full_time_format.formatter`

To use them, create an `src\Service\MyService.php` file containing:

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
