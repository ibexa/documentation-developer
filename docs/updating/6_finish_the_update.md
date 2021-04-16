# 6. Finish the update

## 6.1. Platform.sh changes

If you are hosting your site on Platform.sh be aware of the fact that Varnish is enabled by default as of eZ Platform v1.13.5, v2.4.3 and v2.5.0.
If you are using Fastly, read about [how to disable Varnish](https://docs.platform.sh/frameworks/ibexa/fastly.html#remove-varnish-configuration).

## 6.2. Dump assets

The web assets must be dumped again if you are using the `prod` environment. In `dev` this happens automatically:

``` bash
# In v1 and v2:
php bin/console assetic:dump -e prod
# In v2 and v3:
yarn install
yarn encore prod
```

If you encounter problems, additionally clear the cache and install assets:

``` bash
php bin/console cache:clear -e prod
php bin/console assets:install --symlink -e prod
# In v1 and v2:
php bin/console assetic:dump -e prod
# In v2 and v3:
yarn install
yarn encore prod
```

## 6.3. Commit, test and merge

Once all the conflicts have been resolved, and `composer.lock` updated, you can commit the merge.

Note that you may or may not keep `composer.lock`, depending on your version management workflow.
If you do not wish to keep it, run `git reset HEAD composer.lock` to remove it from the changes.
Run `git commit`, and adapt the message if necessary.

Go back to `master`, and merge your update branch:

``` bash
git checkout master
git merge <branch_name>
```

!!! note "Insecure password hashes"

    To ensure that no users have unsupported, insecure password hashes, run the following command:
    
    ``` bash
    # In v3.2:
    php bin/console ezplatform:user:validate-password-hashes
    # In v3.3:
    php bin/console ibexa:user:validate-password-hashes
    ```
    
    This command checks if all user hashes are up-to-date and informs you if any of them need to be updated.

**Your Ibexa DXP / eZ Platform should now be up-to-date with the chosen version!**
