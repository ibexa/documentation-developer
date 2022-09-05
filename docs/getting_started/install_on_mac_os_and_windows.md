---
description: Install Ibexa DXP on a macOS or Windows system to use it for development.
---

# Install [[= product_name =]] on macOS or Windows

This page explains how to install [[= product_name =]] on macOS or Windows.

!!! caution

    This procedure is **for development purposes only**.
    Installing [[= product_name =]] for production purposes is supported only on Linux.

    For information about installing the product on Linux, see [Install [[= product_name =]]](install_ibexa_dxp.md).  

### Prepare work environment

To install [[= product_name =]], you need a stack with MySQL and PHP.
Additionally, you need [Node.js](https://nodejs.org/en/) and [Yarn](https://yarnpkg.com/lang/en/docs/install/) for asset management.
If you want to use a web server, you need to install it as well:

- For Windows: Apache
- For macOS: Apache/nginx

The instructions below assume that you are using Apache.

??? note "Windows"

    Locate the `php.ini` file and open it in a text editor.
    Provide the missing values to relevant parameters, for example, `date.timezone` and `memory_limit`:

    ``` bash
    date.timezone = "Europe/Warsaw"
    memory_limit = 4G
    ```

    Uncomment or add extensions relevant to your project, for example, `opcache` extension for PHP (recommended, not required):

    ``` bash
    zend_extension=opcache.so
    ```
    
    You can install Apache as a Windows service by running the following command in CMD as administrator:

    ``` bash
    httpd.exe -k -install
    ```

    You can then start it with:

    ``` bash
    httpd.exe -k start
    ```

    Edit Apache configuration file `httpd.conf`.
    Replace placeholder values with corresponding values from your project, for example, `ServerName localhost:80`.
    Uncomment relevant modules, for example:

    ``` bash
    LoadModule rewrite_module modules/mod_rewrite.so
    LoadModule vhost_alias_module libexec/apache2/mod_vhost_alias.so
    ```

## Get Composer

=== "macOS"

    Install Composer using a package manager, for example, [Homebrew.](https://brew.sh/)

=== "Windows"

    Download and run [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe) - it will install the latest Composer version.

## Install [[= product_name =]]

At this point the installation procedure is the same as when installing on Linux.
Follow the steps from the main [Install [[= product_name =]]](install_ibexa_dxp.md#install-ibexa-dxp) page.

## Set up virtual host

Prepare a [virtual host configuration](https://httpd.apache.org/docs/2.4/vhosts/) for your site in your Apache directory:

- For Windows: `<Apache>\conf\vhosts`
- For macOS: `/private/etc/apache2/users/`

Then restart the Apache server.

## Set up permissions

Directories `var` and `web/var` need to be writable by CLI and web server user.
Future files and directories created by these two users will need to inherit those permissions.

For more information, see [Setting up or Fixing File Permissions.]([[= symfony_doc =]]/setup/file_permissions.html)

!!! note "Security checklist"

    See the [Security checklist](security_checklist.md) for a list of security-related issues
    that you should take care of before going live with a project.
