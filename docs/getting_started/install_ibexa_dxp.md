---
description: Install Ibexa DXP on a Linux system and prepare your installation for production.
---

# Install Ibexa DXP

!!! note

    Installation for production is only supported on Linux.

    To install [[= product_name =]] for development on macOS or Windows,
    see the [installation guide for macOS and Windows](install_on_mac_os_and_windows.md).

!!! note "Installing Ibexa OSS"

    This installation guide details the steps to install Ibexa DXP for users who have a subscription agreement with Ibexa.
    If you want to install Ibexa OSS, you do not need authentication tokens or an account on updates.ibexa.co,
    but must adapt the steps shown here to the product edition and the `ibexa/oss-skeleton` repository.

## Prepare work environment

To install [[= product_name =]] you need a stack with your operating system, MySQL and PHP.

You can install it by following your favorite tutorial, for example: [Install LAMP stack on Ubuntu](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-ubuntu-18-04).

Additional requirements:

- [Node.js](https://nodejs.org/en/) and [Yarn](https://yarnpkg.com/lang/en/docs/install/#debian-stable) for asset management.
- `git` for version control.
- to use search in the shop front end, you must [install a search engine](#install-and-configure-a-search-engine).

[For production](#prepare-installation-for-production) you also need Apache or nginx as the HTTP server (Apache is used as an example below).

Before getting started, make sure you review other [requirements](requirements.md) to see the systems we support and use for testing.

### Get Composer

Install a recent stable version of Composer, the PHP command line dependency manager.
Use the package manager for your Linux distribution.
For example, on Ubuntu:

``` bash
apt-get install composer
```

To verify that you have the most recent stable version of Composer, you can run:

``` bash
composer -V
```

!!! tip "Install Composer locally"

    If you want to install Composer inside your project root directory only,
    run the following command in the terminal:

    ``` bash
    php -r "readfile('https://getcomposer.org/installer');" | php
    ```

    If you do so, you must replace `composer` with `php -d memory_limit=-1 composer.phar` in all commands below.

## Install [[= product_name =]]

### Set up authentication tokens

[[= product_name =]] subscribers have access to commercial packages at [updates.ibexa.co](https://updates.ibexa.co/).
The site is password-protected. 
You must set up authentication tokens to access the site.

Log in to your service portal on [support.ibexa.co](https://support.ibexa.co), go to your **Service Portal**, and look for the following on the **Maintenance and Support agreement details** screen:

![Authentication token](using_composer_auth_token.png)

1. Select **Create token** (this requires the **Portal administrator** access level).
2. Fill in a label describing the use of the token. This will allow you to revoke access later.
3. Save the password, **you will not get access to it again**!

!!! tip "Save the authentication token in `auth.json` to avoid re-typing it"

    Composer will ask whether you want to save the token every time you perform an update.
    If you prefer, you can decline and create an `auth.json` file globally
    in [`COMPOSER_HOME`](https://getcomposer.org/doc/03-cli.md#composer-home) directory for machine-wide use:

    ``` bash
    composer config --global http-basic.updates.ibexa.co <installation-key> <token-password>
    ```

    To store your credentials per project, add the credentials to the `COMPOSER_AUTH` variable:

    ``` bash
    export COMPOSER_AUTH='{"http-basic":{"updates.ibexa.co": {"username": "<your-key>", "password": "<your-password>"}}}'
    ```
    
    You then need to [add the contents of this variable to `auth.json`](#authentication-token).

!!! tip "Different tokens for different projects on a single host"

    If you configure several projects on one machine, make sure that
    you set different tokens for each of the projects in their respective `auth.json` files.

After this, when running Composer to get updates, you will be asked for a username and password. Use:

- as username - your Installation key found on the **Maintenance and Support agreement details** page in the service portal
- as password - the token password you retrieved in step 3 above.

!!! note "Authentication token validation delay"

    You can encounter some delay between creating the token and being able to use it in Composer. It might take up to 15 minutes.

!!! caution "Support agreement expiry"

    If your Support agreement expires, your authentication token(s) will no longer work.
    They will become active again if the agreement is renewed, but this process may take up to 24 hours.
    _(If the agreement is renewed before the expiry date, there will be no disruption of service.)_

### Create project

To use Composer to instantly create a project in the current folder with all the dependencies,
run the following command:

=== "[[= product_name_content =]]"

    ``` bash
    composer create-project ibexa/content-skeleton .
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer create-project ibexa/experience-skeleton .
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer create-project ibexa/commerce-skeleton .
    ```

!!! tip "Authentication token"

    <a id="authentication-token"></a>If you added credentials to the `COMPOSER_AUTH` variable,
    at this point add this variable to `auth.json` (for example, by running `echo $COMPOSER_AUTH > auth.json`).

!!! tip

    You can set [different version constraints](https://getcomposer.org/doc/articles/versions.md):
    specific tag (`3.3.2`), version range (`~3.3.2`), stability (`^3.3@rc`), etc.:

    ``` bash
    composer create-project ibexa/content-skeleton:3.3.2 .
    ```

!!! note "Platform.sh"

    If you are deploying your installation on [Platform.sh](https://docs.platform.sh/frameworks/ibexa.html),
    run the following command:
    
    ``` bash
    composer ibexa:setup --platformsh
    ```
    
    This command provides the necessary configuration for using Platform.sh.

#### Add project to version control

It is recommended to add your project to version control.

First, create a `.gitignore` file based on the `.gitignore.dist` provided in the project.

Then, initiate your project repository:

``` bash
git init; git add . > /dev/null; git commit -m "init" > /dev/null
```

### Change installation parameters

At this point configure your database via the `DATABASE_URL` in the `.env` file,
depending of the database you are using:

`DATABASE_URL=mysql://user:password@host:port/database_name`.

or

`DATABASE_URL=postgresql://user:password@host:port/database_name`.

!!! tip "Encoding database password"

    The password entered in `DATABASE_URL` must either be URL encoded, or not contain any special characters that would require URL encoding.

    For more information, see [Encoding database password](troubleshooting.md#encoding-database-password).

### Add entropy to improve cryptographic randomness

Choose a [secret]([[= symfony_doc =]]/reference/configuration/framework.html#secret)
and provide it in the `APP_SECRET` parameter in `.env`.
It should be a random string, made up of at least 32 characters, numbers, and symbols.
This is used by Symfony when generating [CSRF tokens]([[= symfony_doc =]]/security/csrf.html),
[encrypting cookies]([[= symfony_doc =]]/cookbook/security/remember_me.html),
and for creating signed URIs when using [ESI (Edge Side Includes)]([[= symfony_doc =]]/http_cache/esi.html).

!!! caution

    The app secret is crucial to the security of your installation. Be careful about how you generate it, and how you store it.
    Here's one way to generate a 64 characters long, secure random string as your secret, from command line:
    
    ``` bash
    php -r "print bin2hex(random_bytes(32));"
    ```

    Do not commit the secret to version control systems, or share it with anyone who does not strictly need it.
    If you have any suspicion that the secret may have been exposed, replace it with a new one.
    The same goes for other secrets, like database password, Varnish invalidate token, JWT passphrase, etc.
    
    After changing the app secret, make sure that you clear the application cache and log out all the users.
    For more information, see [Symfony documentation]([[= symfony_doc =]]/reference/configuration/framework.html#secret).   

    It is recommended to store the database credentials in your `.env.local` file and not commit it to the Version Control System.

In `DATABASE_VERSION` you can also configure the database server version (for a MariaDB database, prefix the value with `mariadb-`).

!!! tip "Using PostgreSQL"

    If you want an installation with PostgreSQL instead of MySQL, refer to [Using PostgreSQL](databases.md#using-postgresql).

#### Install and configure a search engine

You may choose to replace the [default search engine](search.md#legacy-search-engine) with either Solr or Elasticsearch.

!!! note "Shop front end requirement [[% include 'snippets/commerce_badge.md' %]]"

    Search in the shop front end requires that you have either Solr or Elasticsearch as a search engine.

=== "Solr"

    Follow [How to set up Solr search engine](solr_search_engine.md#how-to-set-up-solr-search-engine) to install Solr.

=== "Elasticsearch"

    Do the following steps to enable Elasticsearch:

    1. [Download and install Elasticsearch](elasticsearch_search_engine.md#step-1-download-and-install-elasticsearch)
    2. [Verify that the Elasticsearch instance is up](elasticsearch_search_engine.md#step-2-verify-that-the-elasticsearch-instance-is-up)
    3. [Set the default search engine](elasticsearch_search_engine.md#step-3-set-the-default-search-engine)
    4. [Configure the search engine](elasticsearch_search_engine.md#step-4-configure-the-search-engine)
    5. [Push the templates](elasticsearch_search_engine.md#step-5-push-the-templates)

    Configure the following parameter in the `.env` file:

    ```
    ELASTICSEARCH_DSN=http://localhost:9200
    ```

### Create a database

Install [[= product_name =]] and create a database with:

``` bash
php bin/console ibexa:install
php bin/console ibexa:graphql:generate-schema
```

Before executing the command make sure that the database user has sufficient permissions.

If Composer asks for your token, you must log in to your GitHub account and generate a new token
(edit your profile and go to **Developer settings** > **Personal access tokens** > **Generate new token** with default settings).
This operation is performed only once, when you install [[= product_name =]] for the first time.

### Run post-installation script

Run the post-installation script with the following command:

``` bash
composer run post-install-cmd
```

## Use PHPs built-in server

For development you can use the built-in PHP server.

```bash
php -S 127.0.0.1:8000 -t public
```

Your PHP web server will be accessible at `http://127.0.0.1:8000`

You can also use [Symfony CLI](https://symfony.com/download):

```bash
symfony serve
```

## Prepare installation for production

To use [[= product_name =]] with an HTTP server, you need to [set up directory permissions](#set-up-permissions) and [prepare a virtual host](#set-up-virtual-host).

### Set up permissions

For development needs, the web user can be made the owner of all your files (for example with the `www-data` web user):

``` bash
chown -R www-data:www-data <your installation directory>
```

Directories `var` and `public/var` must be writable by CLI and the web server user.
Future files and directories created by these two users will need to inherit those permissions.

!!! caution

    For security reasons, in production, the web server cannot have write access to other directories than `var`. 
    Skip the step above and follow the link below for production needs instead.

    You must also make sure that the web server cannot interpret the files in the `var` directory through PHP.
    To do so, follow the instructions on [setting up a virtual host below](#set-up-virtual-host).

To set up permissions for production, it is recommended to use an ACL (Access Control List).
See [Setting up or Fixing File Permissions]([[= symfony_doc =]]/setup/file_permissions.html) in Symfony documentation
for information on how to do it on different systems.

### Set up virtual host

Prepare a [virtual host configuration](https://httpd.apache.org/docs/2.4/vhosts/) for your site.

You can copy [the example vhost file](https://github.com/ezsystems/developer-documentation/tree/master/code_samples/install/vhost_template/vhost.template)
to `/etc/apache2/sites-available` as a `.conf` file and modify it to fit your project.

Specify `/<your installation directory>/public` as the `DocumentRoot` and `Directory`.
Uncomment the line that starts with `#if [APP_ENV]` and set the value to `prod` or `dev`,
depending on the environment that you are configuring:

```
SetEnvIf Request_URI ".*" APP_ENV=prod
```

#### Enable virtual host

When the virtual host file is ready, enable the virtual host and disable the default:

``` bash
a2ensite ibexa
a2dissite 000-default.conf
```

Finally, restart the Apache server.
The command may vary depending on your Linux distribution.
For example, on Ubuntu use:

``` bash
service apache2 restart
```

Open your project in the browser by visiting the domain address, for example `http://localhost:8080`.
You should see the welcome page.

## Post-installation steps

!!! note "Security checklist"

    See the [Security checklist](security_checklist.md) for a list of security-related issues
    you should take care of before going live with a project.

### Enable Date-based Publisher

To enable delayed publishing of Content using the Date-based Publisher, you must set up cron to run the `bin/console ibexa:scheduled:run` command periodically.

For example, to check for publishing every minute, add the following script:

`echo '* * * * * cd [path-to-ibexa-dxp]; php bin/console ibexa:cron:run --quiet --env=prod' > ezp_cron.txt`

For 5-minute intervals:

`echo '*/5 * * * * cd [path-to-ibexa-dxp]; php bin/console ibexa:cron:run --quiet --env=prod' > ezp_cron.txt`

Next, append the new cron to user's crontab without destroying existing crons.
Assuming the web server user data is `www-data`:

`crontab -u www-data -l|cat - ezp_cron.txt | crontab -u www-data -`

Finally, remove the temporary file:

`rm ezp_cron.txt`

### Enable the Link manager

To make use of the [Link Manager](url_management.md#enable-automatic-url-validation).

#### JMS payment secret [[% include 'snippets/commerce_badge.md' %]]

To provide the `JMS_PAYMENT_SECRET` secret for the [[= product_name_com =]] payment system, run `./vendor/defuse/php-encryption/bin/generate-defuse-key`
and use the generated secret.

## Ibexa Cloud

If you want to host your application on Ibexa Cloud, follow the [Install on Ibexa Cloud](install_on_ibexa_cloud.md) procedure.
