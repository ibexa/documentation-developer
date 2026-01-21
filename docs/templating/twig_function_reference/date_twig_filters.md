---
description: Use date Twig filters to select the date and time format used in templates.
page_type: reference
---

# Date Twig filters

Date and time Twig filters format a date and time object (`DateTimeInterface`) in one of the formats defined in [user preferences](formatting_date_and_time.md#within-user-settings-menu).

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

## Considerations for use outside the back office

The filters rely on user preferences.
When the preferences are not set, for example, for logged out users, the filters fall back to a default date format.
For some filters, the fallback date format includes locale-aware fragments, such as the full month or day name.
When combined with [reverse proxies like Varnish or Fastly](http_cache.md), it's possible to cache a localized version of a date and display it to other users, even if they're not using the same locale.

Consider these alternatives:

- Use Twig's built-in `date` filter with a fixed, locale-independent format

    ``` html+twig
    {{ content.contentInfo.publishedDate|date('Y-m-d H:i:s') }}
    ```

- Use ESI for dynamic rendering of the date

    ``` html+twig
    {{ render_esi(controller('App\\Controller\\CustomDateController::format', {
        'date': content.contentInfo.publishedDate
    })) }}
    ```

    Don't cache the ESI response.
    By implementing this solution, you can keep the date format locale-aware.

- Client-side JavaScript formatting

    ``` html+twig
    <span data-datetime="{{ content.contentInfo.publishedDate|date('c') }}">{{ content.contentInfo.publishedDate|date('Y-m-d H:i:s') }}</span>
    …
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[data-datetime]').forEach(function(elem) {
            var datetime = new Date(elem.getAttribute('data-datetime'));
            elem.innerHTML = datetime.toLocaleString();
        });
    });
    </script>
    ```

For more information, see [HTTP Cache](http_cache.md) and [Delivering personalized responses](context_aware_cache.md#personalize-responses).
