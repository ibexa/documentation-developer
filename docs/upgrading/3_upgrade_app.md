# 3. Upgrade the app

At this point, you should have a `composer.json` file with the correct requirements. Run `composer update` to update the dependencies. 

``` bash
composer update
```

If you want to first test how the update proceeds without actually updating any packages, you can try the command with the `--dry-run` switch:

`composer update --dry-run`

!!! caution "Common errors"

    If you experienced issues during the update, please check [Common errors](../getting_started/troubleshooting.md#cloning-failed-using-an-ssh-key) section on the Composer about page.
