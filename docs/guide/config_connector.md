# Connector configuration

## DAM configuration

You can configure a connection with a Digital Asset Management (DAM) system.

``` yaml
ezplatform:
    system:
        default:
            content:
                dam: [ dam_name ]
```

The configuration for each connector depends on the requirements of the specific DAM system.

You can create your own connectors, or use the provided example DAM connector for [Unsplash](https://unsplash.com/).

To add the Unsplash connector to your system add the `ezsystems/ezplatform-connector-unsplash` bundle to your installation.
