# 3. Update the app

At this point, you should have a `composer.json` file with the correct requirements. Run `composer update` to update the dependencies. 

``` bash
composer update
```

If you want to first test how the update proceeds without actually updating any packages, you can try the command with the `--dry-run` switch:

``` bash
composer update --dry-run
```

Next, you need to perform version-specific steps depending on which version you are updating from:

??? note "Updating from <2.2"
    
    When upgrading an Enterprise installation to v2.2, you need to disable `EzSystemsPlatformEEAssetsBundle` by removing
    `new EzSystems\PlatformEEAssetsBundle\EzSystemsPlatformEEAssetsBundle(),` from `app/AppKernel.php`.

??? note "Updating from <2.5"

    Since v2.5 eZ Platform uses [Webpack Encore](https://symfony.com/doc/3.4/frontend.html#webpack-encore) for asset management.
    You need to install [Node.js](https://nodejs.org/en/) and [Yarn](https://yarnpkg.com/lang/en/docs/install) to update to this version.

    In v2.5 it is still possible to use Assetic, like in earlier versions.
    However, if you are using the latest Bootstrap version, [`scssphp`](https://github.com/leafo/scssphp)
    will not compile correctly with Assetic.
    In this case, use Webpack Encore. See [Importing assets from a bundle](../guide/bundles.md#importing-assets-from-a-bundle) for more information.

??? note "Updating from <3.0"

    If your application consists of several packages that are placed in locations other than the `src/` folder, 
    apply the suggestions from the [3.0 upgrade documentation](4_upgrade_the_code.md) to all the packages before you run `composer update`.

If you experience issues during the update, see [Troubleshooting](../getting_started/troubleshooting.md#cloning-failed-using-an-ssh-key).
