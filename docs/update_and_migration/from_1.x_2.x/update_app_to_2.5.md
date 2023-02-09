---
target_version: '2.5'
latest_tag: '2.5.30'
---

# Update app to v2.5

## 1. Check out a version

[[% include 'snippets/update/check_out_version.md' %]]

## 2. Resolve conflicts

[[% include 'snippets/update/merge_composer.md' %]]

## 3. Update the app

If `EzSystemsPlatformEEAssetsBundle` is present in `app/AppKernel.php`, 
disable it by removing the `new EzSystems\PlatformEEAssetsBundle\EzSystemsPlatformEEAssetsBundle(),` entry.

Since v2.5 eZ Platform uses [Webpack Encore]([[= symfony_doc =]]/frontend.html#webpack-encore) for asset management.
You need to install [Node.js](https://nodejs.org/en/) and [Yarn](https://yarnpkg.com/lang/en/docs/install) to update to this version.

In v2.5 it is still possible to use Assetic, like in earlier versions.
However, if you are using the latest Bootstrap version, [`scssphp`](https://github.com/leafo/scssphp)
will not compile correctly with Assetic.
In this case, use Webpack Encore. See [Importing assets from a bundle](project_organization.md#importing-assets-from-a-bundle) for more information.

If you experience issues during the update, see [Troubleshooting](troubleshooting.md#cloning-failed-using-an-ssh-key).

### Run composer update

[[% include 'snippets/update/update_app.md' %]]

## Next steps

Now, proceed to the next step, [updating the database to v2.5](update_db_to_2.5.md).
