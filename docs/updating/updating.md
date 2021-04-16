# Updating Ibexa DXP

This section explains how to update Ibexa DXP or eZ Platform to a new version.

In the following instructions, replace `<version>` with the version of eZ Platform or Ibexa DXP you are updating to (for example: `v2.5.0`).
If you are testing a release candidate, use the latest `-rc` tag (for example: `v2.5.0-rc1`).

You may upgrade from any eZ Platform version to the latest v3.2 version,
but you need to follow all database update steps between the versions.

For example, if you are using v3.0, follow all the database update steps from v3.0 up to v3.2.

!!! note "Update to v3.3"

    If you want to update from v3.2 to v3.3, follow the [Updating to v3.3](updating_to_3.3.md) procedure instead.

## Update procedure

To update your Ibexa DXP / eZ Platform installation, follow the steps below:

1. [Check out a version](1_check_out_version.md)
1. [Resolve conflicts](2_merge_composer.md)
1. [Update the app](3_update_app.md)
1. [Upgrade the code](4_upgrade_the_code.md) - perform this step only if you are updating to v3.0
1. [Update the database](5_update_database.md)
1. [Finish the update](6_finish_the_update.md)
