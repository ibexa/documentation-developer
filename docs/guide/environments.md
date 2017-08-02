# Environments

Environment configuration as provided by Symfony is enhanced in eZ Platform to allow specifying this in the virtual host configuration.
You can configure several environments, from production, development or staging, even if for each one of them you need to use different configuration sets.

!!! tip

    See also [the Symfony Recipe about "How to Master and Create new Environments"](http://symfony.com/doc/current/cookbook/configuration/environments.html)

## Web server configuration

For example, using Apache, in the `VirtualHost` example in [doc/apache2/](https://github.com/ezsystems/ezplatform/tree/master/doc/apache2) in your install, the required `VirtualHost` configurations have been already included. You can switch to the desired environment by setting the `ENVIRONMENT` environment variable to "`prod`", "`dev`" or other custom value, as you can see in the following example:

```
# Environment.
# Possible values: "prod" and "dev" out-of-the-box, other values possible with proper configuration
# Defaults to "prod" if omitted (uses SetEnvIf so value can be used in rewrite rules)
SetEnvIf Request_URI ".*" SYMFONY_ENV="prod"
```

## Configuration

If you want to use a custom environment (something else than `prod` and `dev`) the next step is to create the dedicated configuration files for your environment:

- `app/config/config_ <env_name> .yml`
- `app/config/ezplatform_ <env_name> .yml`

The name used as `<env_name>` will be the one that can be used as value of the `ENVIRONMENT` environment variable.

Those files must import the main configuration file, just like the default [`config_dev.yml`](https://github.com/ezsystems/ezpublish-community/blob/master/ezpublish/config/config_dev.yml) already does. Here's an example:

``` yaml
imports:
    - { resource: config.yml }
```

This allows you to override settings defined in the main configuration file, depending on your environment (like the DB settings or any other setting you may want to override).
