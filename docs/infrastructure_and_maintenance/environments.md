---
description: In Ibexa DXP you can use environment provided by Symfony in virtual host configuration, as well as to create custom environments.
---

# Environments

Environment configuration is provided by Symfony. [[= product_name =]] additionally enables you to specify environments in virtual host configuration.
You can configure several environments, such as production, development or staging. You can have different configuration sets for each of them.

!!! tip

    See also [Environments in Symfony doc]([[= symfony_doc =]]/configuration.html#configuration-environments).
    
## Web server configuration

For example, using Apache, in the [`VirtualHost` example](https://github.com/ezsystems/developer-documentation/tree/master/code_samples/install/vhost_template/vhost.template) in your installation, the required `VirtualHost` configurations have been already included. You can switch to the desired environment by setting the `ENVIRONMENT` variable to `prod`, `dev` or another custom value, like in the following example:

```
# Environment.
# Possible values: "prod" and "dev" out-of-the-box, other values possible with proper configuration
# Defaults to "prod" if omitted (uses SetEnvIf so value can be used in rewrite rules)
SetEnvIf Request_URI ".*" APP_ENV="dev"
```

## Custom environments

If you want to use a custom environment (something other than `prod` and `dev`), you need to place dedicated configuration files in a separate folder:
`config/packages/<env_name>/config_<env_name>.yaml`

The name used as `<env_name>` is the one that can be used as value of the `ENVIRONMENT` variable.

This enables you to override settings defined in the main configuration file, depending on your environment (for example database settings).
