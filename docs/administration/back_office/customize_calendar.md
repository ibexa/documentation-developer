---
description: Add custom events to the calendar and customize its looks.
---

# Customize calendar

By default, the Calendar displays scheduled events of the following types:

- Content publication (`future_publication`)
- Content hide (`future_hide`)
- Block reveal (`page_block_reveal`)
- Block hide (`page_block_hide`)

You can perform basic actions on these events.

You can also configure the calendar to display custom event types.

## Customize colors and icons

You can change the color of a calendar event or change the icon of an action.
The setting is SiteAccess-aware.

To customize the appearance settings, add the following configuration:

``` yaml hl_lines="6"
[[= include_file('code_samples/back_office/calendar/config/packages/calendar.yaml') =]]
```

Line 6 contains the name of the event type, either a built-in custom one.

`color` defines the color in which events of this type are displayed in the calendar.
`icon` is the icon used for a button with the relevant event action.

![Bank holiday with custom color](extending_calendar_view.png)

## Configure custom events

The following example shows how to create custom events which add different holidays to the calendar.

First, create a new event in `src/Calendar/Holidays/Event.php`:

``` php
[[= include_file('code_samples/back_office/calendar/src/Calendar/Holidays/Event.php') =]]
```

Here, you define a new class for your event based on `Ibexa\Contracts\Calendar\Event`.

Next, create `src/Calendar/Holidays/EventType.php`:

```php hl_lines="20-23"
[[= include_file('code_samples/back_office/calendar/src/Calendar/Holidays/EventType.php') =]]
```

You can use the identifier defined in lines 20-23 to configure [event colors](#customize-colors-and-icons).

Complete the procedure by registering the new event type as a service:

``` yaml
[[= include_file('code_samples/back_office/calendar/config/custom_services.yaml', 0, 6) =]]
```

## Configure event sources

To add specific events to your calendar, you need to create an event source.

An event source must implement `Ibexa\Contracts\Calendar\EventSource\EventSourceInterface`.

One such built-in implementation is `InMemoryEventSource`.
To add an in-memory collection as an event source, create `src/Calendar/Holidays/EventSourceFactory.php`:

```php
[[= include_file('code_samples/back_office/calendar/src/Calendar/Holidays/EventSourceFactory.php', 0, 23) =]][[= include_file('code_samples/back_office/calendar/src/Calendar/Holidays/EventSourceFactory.php', 29, 40) =]]
```

!!! note

    When creating the list of events, you must list all the `createEvent()` entities chronologically.
    
    For example:
    
    ``` php
    $collection = new EventCollection([
        $this->createEvent("Event 1", new DateTime("2020-01-01")),
        $this->createEvent("Event 2", new DateTime("2020-01-02")),
        // ...
    ```    

Next, register the event source as a service:

``` yaml
[[= include_file('code_samples/back_office/calendar/config/custom_services.yaml', 0, 1) =]][[= include_file('code_samples/back_office/calendar/config/custom_services.yaml', 7, 16) =]]
```

Now you can go to the **Calendar** tab and see the configured holiday.

![Custom events list view](extending_calendar_list_view.png)

### Import events from external sources

You can also import events from external sources, for example, a JSON file.
To do this, place the following `holidays.json` file in `src/Calendar/Holidays`:

``` json
[[= include_file('code_samples/back_office/calendar/src/Calendar/Holidays/holidays.json') =]]
```

Next, import this file in `src/Calendar/Holidays/EventSourceFactory.php`:

``` php hl_lines="6-9"
[[= include_file('code_samples/back_office/calendar/src/Calendar/Holidays/EventSourceFactory.php', 19, 33) =]]
```

The calendar now displays the events listed in the JSON file.
