# Updating [[= product_name =]]

This section explains how to update eZ Platform or [[= product_name =]] to a new version.

In the following instructions, replace `<version>` with the version of eZ Platform or [[= product_name =]] you are updating to (for example: `v2.5.0`).
If you are testing a release candidate, use the latest `-rc` tag (for example: `v2.5.0-rc1`).

You may upgrade from any eZ Platform version to the latest 2.5 version. For example, if you are using v2.0. you can then
upgrade your distribution directly to the latest 2.5 version, but follow all the database updates steps from 2.0 up to 2.5. It is
recommended that you first run all the database schema updates up to 2.5 before you run other update scripts or procedures.

## Update procedure

To update your eZ Platform installation follow the steps below:

1. [Check out a tagged version](1_check_out_version.md)
1. [Merge composer.json](2_merge_composer.md)
1. [Update the app](3_update_app.md)
1. [Update database](4_update_database.md)
1. [Platform.sh changes](5_platform_sh_changes.md)
1. [Dump assets](6_dump_assets.md)
1. [Commit, test and merge](7_commit_test_merge.md)

**Your eZ Platform should now be up-to-date with the chosen version!**
