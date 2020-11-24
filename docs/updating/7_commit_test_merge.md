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

**Your eZ Platform / [[= product_name =]] should now be up-to-date with the chosen version!**
