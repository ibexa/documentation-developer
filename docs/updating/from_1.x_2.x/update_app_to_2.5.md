---
target_version: '2.5'
latest_tag: '2.5.25'
---

# Update app to v2.5

## 1. Check out a version

[[% include 'snippets/update/check_out_version.md' %]]

## 2. Resolve conflicts

[[% include 'snippets/update/merge_composer.md' %]]

## 3. Update the app

First, perform version-specific steps depending on which version you are updating from.

### A. v2.2
    
When upgrading an Enterprise installation to v2.2, you need to disable `EzSystemsPlatformEEAssetsBundle` by removing
`new EzSystems\PlatformEEAssetsBundle\EzSystemsPlatformEEAssetsBundle(),` from `app/AppKernel.php`.

### B. v2.5

Since v2.5 eZ Platform uses [Webpack Encore](https://symfony.com/doc/2.8/frontend.html#webpack-encore) for asset management.
You need to install [Node.js](https://nodejs.org/en/) and [Yarn](https://yarnpkg.com/lang/en/docs/install) to update to this version.

In v2.5 it is still possible to use Assetic, like in earlier versions.
However, if you are using the latest Bootstrap version, [`scssphp`](https://github.com/leafo/scssphp)
will not compile correctly with Assetic.
In this case, use Webpack Encore. See [Importing assets from a bundle](https://doc.ibexa.co/en/master/guide/project_organization/#importing-assets-from-a-bundle) for more information.

If you experience issues during the update, see [Troubleshooting](../../getting_started/troubleshooting.md#cloning-failed-using-an-ssh-key).

### C. Run composer update

[[% include 'snippets/update/update_app.md' %]]

## Next steps

Now, proceed to the next step, [updating the database to v2.5](update_db_to_2.5.md).
