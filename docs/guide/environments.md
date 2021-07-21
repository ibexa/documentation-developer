# Environments

Environment configuration is provided by Symfony. eZ Platform additionally enables you to specify environments in virtual host configuration.
You can configure several environments, such as production, development or staging. You can have different configuration sets for each of them.

!!! tip

    See also [the Symfony Recipe about "How to Master and Create new Environments"]([[= symfony_doc =]]/configuration/environments.html)

## Web server configuration

For example, using Apache, in the `VirtualHost` example in [doc/apache2/](https://github.com/ezsystems/ezplatform/tree/v2.5.6/doc/apache2) in your installation, the required `VirtualHost` configurations have been already included. You can switch to the desired environment by setting the `ENVIRONMENT` variable to `prod`, `dev` or another custom value, like in the following example:

```
# Environment.
# Possible values: "prod" and "dev" out-of-the-box, other values possible with proper configuration
# Defaults to "prod" if omitted (uses SetEnvIf so value can be used in rewrite rules)
SetEnvIf Request_URI ".*" SYMFONY_ENV="dev"
```

## Using custom environments

If you want to use a custom environment (something other than `prod` and `dev`), you need to create the dedicated configuration files for your environment:

- `app/config/config_<env_name>.yml`
- `app/config/ezplatform_<env_name>.yml`

The name used as `<env_name>` is the one that can be used as value of the `ENVIRONMENT` variable.

Those files must import the main configuration file, just like the default [`config_dev.yml`](https://github.com/ezsystems/ezpublish-community/blob/master/ezpublish/config/config_dev.yml) does:

``` yaml
imports:
    - { resource: config.yml }
```

This enables you to override settings defined in the main configuration file, depending on your environment (for example database settings).
