# 6. Dump assets

The web assets must be dumped again if you are using the `prod` environment. In `dev` this happens automatically:

``` bash
php bin/console assetic:dump -e prod
yarn install
yarn encore prod
```

If you encounter problems, additionally clear the cache and install assets:

``` bash
php bin/console cache:clear -e prod
php bin/console assets:install --symlink -e prod
php bin/console assetic:dump -e prod
yarn install
yarn encore prod
```
