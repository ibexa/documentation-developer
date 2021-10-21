# Ibexa DXP v4.0

**Version number**: v4.0

**Release date**: September 27, 2021

**Release type**: [Fast Track](../community_resources/release_process.md#release-process)

## Notable changes

### New Product Catalog

Lorem ipsum

### Separate recommendations for different websites

Personalization service has been enhanced to allow returning separate recommendations 
for different websites. 
This way you can eliminate irrelevant recommendations when you set up stores that 
operate on different markets or under different brands.

For more information, see [Support for multiple websites](https://doc.ibexa.co/projects/userguide/en/latest/personalization/use_cases/#hosting-multiple-websites).

## Other changes

### Draft locking

You can now configure and use the locking feature to lock a draft of a Content item, 
so that only an assigned person can edit it, and no other user can take it over. 

For more information, see the [developer](../guide/workflow.md#draft-locking) and the [user](https://doc.ibexa.co/projects/userguide/en/master/publishing/editorial_workflow/#draft-locking) documentation.

### Enhanced GraphQL location handling

Lorem ipsum

### Migration API

You can now manage [data migrations](../guide/data_migration.md) by using the PHP API,
including getting migration information and running individual migration files.

See [Managing migrations](../api/public_php_api_managing_migrations.md) for more information.

### Decide whether alternative text for Image field is optional

Alternative text for an Image field is now optional by default. 
You can set it as required when adding the Image field to a Content Type.

### Purge all submissions of given form

You can purge all submissions of a given form. 
To do this, run the following command, where `form-id` stands for a Content ID 
of the form, for which you want to purge data:

```bash
bin/console ibexa:form-builder:purge-form-submissions [options] [--] <form-id>
```

The following table lists the available options and their meaning:

| Switch | Option | Description |
|--------------|------------|------------|
| `-l` | `--language-code=LANGUAGE-CODE` | Passes a language code, for example, "eng-GB". |
| `-u` | `--user[=USER]` | Passes a repository username. By default it is "admin". |
| `-f` | `--force` | Prevents confirmation dialog when used with `--no-interaction`. |
| `-c` | `--batch-size[=BATCH-SIZE]` | Passes a number of URLs to check in a single iteration. Set it to avoid using too much memory. By default it is set to 50. |
| | `--siteaccess[=SITEACCESS]` | Passes a SiteAccess to use for operations. If not provided, the default SiteAccess is used. |
| `-h` | `--help` | Displays help for the given command. When no command is given, displays help for the list command. |
| `-q` | `--quiet` | Prevents outputting any message. |
| `-V` | `--version` | Returns a version of the application. |
| | `--ansi` | Forces ANSI output. |
| | `--no-ansi` | Disables ANSI output. |
| `-n` | `--no-interaction` | Suppresses interactive questions. |
| `-e` | `--env=ENV` | Passes a name of the environment. By default it is set to "dev". |
| | `--no-debug` | Disables the debug mode. |
| `-v/-vv/-vvv` | `--verbose` | Sets the verbosity of messages. Set it to 1 for normal output, 2 for verbose output, and 3 for debug. |


## Deprecations

### Code cleanup results

Lorem ipsum

## Full changelog

See [list of changes in Symfony 5.3.](https://symfony.com/blog/symfony-5-3-3-released)

| Ibexa Content  | Ibexa Experience  | Ibexa Commerce |
|--------------|------------|------------|
| [Ibexa Content v4.0](https://github.com/ibexa/content/releases/tag/v4.0.0) | [Ibexa Experience v4.0](https://github.com/ibexa/experience/releases/tag/v4.0.0) | [Ibexa Commerce v4.0](https://github.com/ibexa/commerce/releases/tag/v4.0.0)
