# 3. Update the app

At this point, you should have a `composer.json` file with the correct requirements. Run `composer update` to update the dependencies. 

``` bash
composer update
```

If you want to first test how the update proceeds without actually updating any packages, you can try the command with the `--dry-run` switch:

`composer update --dry-run`

??? note "When updating from <1.13"

    ##### Adding EzSystemsPlatformEEAssetsBundle

    !!! enterprise "EZ ENTERPRISE"

        When upgrading to v1.10, you need to enable the new `EzSystemsPlatformEEAssetsBundle` by adding:

        `new EzSystems\PlatformEEAssetsBundle\EzSystemsPlatformEEAssetsBundle(),`

        in `app/AppKernel.php`.

!!! note "Updating from <2.5"

    Since v2.5 eZ Platform uses [Webpack Encore](https://symfony.com/doc/4.3/frontend.html#webpack-encore) for asset management.
    You need to install [Node.js](https://nodejs.org/en/) and [Yarn](https://yarnpkg.com/lang/en/docs/install) to update to this version.

    In v2.5 it is still possible to use Assetic, like in earlier versions.
    However, if you are using the latest Bootstrap version, [`scssphp`](https://github.com/leafo/scssphp)
    will not compile correctly with Assetic.
    In this case, use Webpack Encore. See [Importing assets from a bundle](../guide/bundles.md#importing-assets-from-a-bundle) for more information.

!!! caution "Common errors"

    If you experienced issues during the update, please check [Common errors](../getting_started/troubleshooting.md#cloning-failed-using-an-ssh-key) section on the Composer about page.
