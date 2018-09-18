# URL management

## Regenerating URL aliases

You can use the `ezplatform:urls:regenerate-aliases` command to regenerate all URL aliases.
After the command is applied, old aliases will redirect to the new ones.

Use it when:

- you change URL alias configuration and want to regenerate old aliases
- you encounter database corruption
- you have content that for whatever reason does not have a URL alias

Before applying the command, back up your database and make sure it is not modified while the command is running.

``` bash
app/console ezplatform:urls:regenerate-aliases
```

Use an `--iteration-count` parameter to define how many Locations should be processed at once, to avoid too much memory use.
