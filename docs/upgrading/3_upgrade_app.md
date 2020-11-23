# 3. Upgrade the app

At this point, you should have a `composer.json` file with the correct requirements. Run `composer update` to update the dependencies. 

``` bash
composer update
```

If you want to first test how the update proceeds without actually updating any packages, you can try the command with the `--dry-run` switch:

`composer update --dry-run`

!!! caution "Upgrading packages"

    If your application consists of several packages that are placed in locations other than the `src/` folder, 
    apply the suggestions from the upgrade documentation to all the packages before you run `composer update`.

!!! tip "Common errors"

    If you experience issues during the update, such as a [cloning failure](../getting_started/troubleshooting.md#cloning-failed-using-an-ssh-key), see the Common errors section on the Composer about page.
