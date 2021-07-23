# Update database to v3.1
    
!!! caution "Before you proceed"

    When you are updating from a version prior to v3.0, you must implement all the changes from [eZ Platform v3.0 project update instructions](../updating/4_upgrade_the_code.md) and [database updates from v3.0](5_update_3.0.md) before you proceed to the steps below.

## Site Factory

To be able to create a Location for the Site skeletons, run `php ./bin/console ezplatform:site-factory:create-site-skeletons-container` during the update procedure.

Additionally, you can specify:

- `--section-name "Custom section"` - a name of the Section to which the Site skeleton container will be assigned.
- `--section-identifier custom_section_identifier` - an identifier of the Ssection to which the Site skeleton container will be assigned.

If a Section with the provided name or identifier does not exist, it is created in the update process.

``` bash
bin/console ezplatform:site-factory:create-site-skeletons-container --section-identifier "Custom section" --section-name custom_section_identifier
```

If you do not provide a Section name or an identifier, the default values will be used: `Site skeleton` and `site_skeleton`.
