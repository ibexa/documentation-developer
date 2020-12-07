# 6. Dump assets

The web assets must be dumped again if you are using the `prod` environment. In `dev` this happens automatically:

``` bash
yarn install
yarn encore prod
```

If you encounter problems, additionally clear the cache and install assets:

``` bash
php bin/console cache:clear -e prod
yarn install
yarn encore prod
```
