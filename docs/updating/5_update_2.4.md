# Update database to v2.4
    
If you are updating from a version prior to v2.3, you have implement all the changes [from v2.3](5_update_2.3.md) before following the steps below.

!!! note

    During database update, you have to go through all the changes between your current version and your final version.
    For example, during update from v2.2 to v2.5, you have to perform all the steps from v2.3, v2.4 and v2.5.

## Workflow

When updating an Enterprise installation, you need to [run a script](https://github.com/ezsystems/ezplatform-ee-installer/blob/2.4/Resources/sql/schema.sql#L198)
to add database tables for the Editorial Workflow.

## Changes to the Forms folder

The built-in Forms folder is located in the Form Section in versions 2.4+.

If you are updating your Enterprise installation, you need to add this Section manually and move the folder to it.

To allow anonymous users to access Forms, you also need to add the `content/read` Policy
with the *Form* Section to the Anonymous User.

## Changes to Custom tags

v2.4 changed the way of configuring custom tags. They are no longer configured under the `ezpublish` key,
but one level higher in the YAML structure:

``` yaml
ezpublish:
    system:
        <siteaccess>:
            fieldtypes:
                ezrichtext:
                    custom_tags: [exampletag]

ezrichtext:
    custom_tags:
        exampletag:
            # ...
```

The old configuration is deprecated, so if you use custom tags, you need to modify your config accordingly.
