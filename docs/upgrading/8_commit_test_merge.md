# 7. Commit, test and merge

Once all the conflicts have been resolved, and `composer.lock` updated, the merge can be committed.
Note that you may or may not keep `composer.lock`, depending on your version management workflow.
If you do not wish to keep it, run `git reset HEAD <file>` to remove it from the changes.
Run `git commit`, and adapt the message if necessary.

You can now verify the project and once the update has been approved, go back to `master`, and merge your update branch:

``` bash
git checkout master
git merge <branch_name>
```

!!! note "Insecure password hashes"

    To ensure that no users have unsupported, insecure password hashes, run the following command:
    
    ``` bash
    php bin/console ezplatform:user:validate-password-hashes
    ```
    
    This command checks if all user hashes are up-to-date and informs you if any of them need to be updated.

**Your eZ Platform should now be up-to-date with the chosen version!**
