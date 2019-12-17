# Updating from <2.4
    
If you are updating from a version prior to 2.3, you have implement all the changes from [Updating from <2.3](4_update_2.3.md) before following the steps below.

!!! note

    During database update, you have to go through all the changes between your current version and your final version
    **e.g. during update from v2.2 to v2.5 you have to perform all the steps from: <2.3, <2.4 and <2.5**.
    Only after applying all changes your database will work properly.

## Workflow

!!! enterprise

    When updating an Enterprise installation, you need to run a script to add database tables for the Editorial Workflow.
    You can find it in https://github.com/ezsystems/ezplatform-ee-installer/blob/2.4/Resources/sql/schema.sql#L198

## Changes to the Forms folder

!!! enterprise

    The built-in Forms folder is located in the Form Section in versions 2.4+.

    If you are updating your installation, you need to add this Section manually and move the folder to it.

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

You can now follow the steps from [Updating to <2.5](4_update_2.5.md).
