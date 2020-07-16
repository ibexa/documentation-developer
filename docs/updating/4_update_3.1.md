# Updating from <3.1
    
If you are updating from a version prior to 3.0, you have to implement all the changes from [Upgrading eZ Platform to v3](upgrading_to_v3.md) before following the steps below.

!!! note

    During database update, you have to go through all the changes between your current version and your final version
    **e.g. during update from v2.2 to v2.5 you have to perform all the steps from: <2.3, <2.4 and <2.5**.
    Only after applying all changes your database will work properly.
    
## Check out and update the app

1\. [Check out a tagged version](../updating/1_check_out_version.md)

2\. [Merge composer.json](../updating/2_merge_composer.md)

3\. [Update the app](../updating/3_update_app.md)

## Site Factory

To be able to create a Location for the Site skeletons, run `php ./bin/console ezplatform:site-factory:create-site-skeletons-container` during the update procedure.

Additionally, you can specify:

- `--section-name "Custom section"` - a name of the Section to which the Site skeleton container will be assigned.
- `--section-identifier custom_section_identifier` - an identifier of the Ssection to which the Site skeleton container will be assigned.

If a section with the provided name or identifier does not exist, it is created in the update process.

`bin/console ezplatform:site-factory:create-site-skeletons-container --section-identifier "Custom section" --section-name custom_section_identifier`

If you do not provide a Section name or an identifier, the default values will be used: `Site skeleton` and `site_skeleton`.

## Continue update procedure

At this point you can continue with the standard update procedure:

5\. [Platform.sh changes](../updating/5_platform_sh_changes.md)

6\. [Dump assets](../updating/../updating/6_dump_assets.md)

7\. [Commit, test and merge](../updating/7_commit_test_merge.md)
