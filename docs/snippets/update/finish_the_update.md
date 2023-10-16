### A. Platform.sh changes

If you are hosting your site on [[= product_name_cloud =]] be aware of the fact that Varnish is enabled by default as of v1.13.5, v2.4.3 and v2.5.0.
If you are using Fastly, read about [how to disable Varnish](https://docs.platform.sh/frameworks/ibexa/fastly.html#remove-varnish-configuration).

### B. Dump assets

Dump web assets if you are using the `prod` environment. In `dev` this happens automatically:

``` sh
yarn install
yarn encore prod
```

If you encounter problems, additionally clear the cache and install assets:

``` sh
php bin/console cache:clear -e prod
php bin/console assets:install --symlink -e prod
yarn install
yarn encore prod
```

### C. Commit, test and merge

When you resolve all conflicts and update `composer.lock`, commit the merge.

You may or may not keep `composer.lock`, depending on your version management workflow.
If you do not want to keep it, run `git reset HEAD composer.lock` to remove it from the changes.
Run `git commit`, and adapt the message if necessary.

Go back to `master`, and merge the `update-[[= target_version =]]` branch:

``` sh
git checkout master
git merge update-[[= target_version =]]
```

!!! note "Insecure password hashes"

    To ensure that no users have unsupported, insecure password hashes, run the following command:
    
    ``` bash
    # In v1 and v2:
    php bin/console ezplatform:user:validate-password-hashes
    # In v3:
    php bin/console ibexa:user:validate-password-hashes
    ```
    
    This command checks if all user hashes are up-to-date and informs you if any of them need to be updated.

### D. Complete the update

Complete the update by running the following commands:

``` bash
# In v2.5:
php bin/console ezplatform:graphql:generate-schema
# In v3:
php bin/console ibexa:graphql:generate-schema

composer run post-install-cmd
```
