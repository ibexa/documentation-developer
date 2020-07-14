# Updating from <3.1
    
If you are updating from a version prior to 3.0, you have to implement all the changes from [Upgrading eZ Platform to v3](upgrading_to_v3.md) before following the steps below.

!!! note

    During database update, you have to go through all the changes between your current version and your final version
    **e.g. during update from v2.2 to v2.5 you have to perform all the steps from: <2.3, <2.4 and <2.5**.
    Only after applying all changes your database will work properly.
    
## 3\. Check out and update the app

1\. [Check out a tagged version](../updating/1_check_out_version.md)

2\. [Merge composer.json](../updating/2_merge_composer.md)

3\. [Update the app](../updating/3_update_app.md)

## Site Factory

To be able to create a Location for the Site skeletons, run `php ./bin/console ezplatform:site-factory:create-site-skeletons-container` during the update procedure.

## 6\. Continue update procedure

At this point you can continue with the standard update procedure:

5\. [Platform.sh changes](../updating/5_platform_sh_changes.md)

6\. [Dump assets](../updating/../updating/6_dump_assets.md)

7\. [Commit, test and merge](../updating/7_commit_test_merge.md)