# Install eZ Platform

!!! note

    Installation for production is only supported on Linux.

    To install eZ Platform for development on macOS or Windows,
    see [Install on macOS or Windows](../community_resources/installing-on-mac-os-and-windows.md).

## Prepare the work environment

To install eZ Platform you need a stack with your operating system, MySQL and PHP.

You can install it by following your favorite tutorial, for example: [Install LAMP stack on Ubuntu](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-ubuntu-18-04).

Additional requirements:

- [Node.js](https://nodejs.org/en/) and [Yarn](https://yarnpkg.com/lang/en/docs/install/#debian-stable) for asset management.
- `git` for version control.
- to use search in the shop front end, you must [install Solr](#install-solr).

[For production](#prepare-installation-for-production) you also need Apache or nginx as the HTTP server (Apache is used as an example below).

Before getting started, make sure you review other [requirements](requirements.md) to see the systems we support and use for testing.

## Get Composer

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

## Get eZ Platform

!!! enterprise "Enterprise and Commerce"

    ### Set up authentication tokens

    Enterprise and Commerce subscribers have access to commercial packages at [updates.ez.no/bul/](https://updates.ez.no/bul/).
    The site is password-protected. 
    You must set up authentication tokens to access the site.

    Log in to your service portal on [support.ez.no](https://support.ez.no), go to your **Service Portal**, and look for the following on the **Maintenance and Support agreement details** screen:

    ![Authentication token](img/Using_Composer_Auth_token.png)

    1. Select **Create token** (this requires the **Portal administrator** access level).
    2. Fill in a label describing the use of the token. This will allow you to revoke access later.
    3. Save the password, **you will not get access to it again**!

    !!! tip "Save the authentication token in `auth.json` to avoid re-typing it"

        Composer will ask whether you want to save the token every time you perform an update.
        If you prefer, you can decline and create an `auth.json` file manually in one of the following ways:

        - A: Store your credentials in the project directory (for security reasons, do not check them in to git):

        ``` bash
        composer config http-basic.updates.ez.no <installation-key> <token-password>
        ```

        - B: If you only have one project on the machine/server/vm, and want to install globally in [`COMPOSER_HOME`](https://getcomposer.org/doc/03-cli.md#composer-home) directory for machine-wide use:

        ``` bash
        composer config --global http-basic.updates.ez.no <installation-key> <token-password>
        ```

    After this, when running Composer to get updates, you will be asked for a username and password. Use:

    - as username - your Installation key found on the **Maintenance and Support agreement details** page in the service portal
    - as password - the token password you retrieved in step 3.

    !!! note

        If you are using Platform.sh, you can set the token as an environment variable.

        When you do, make sure the **Visible during runtime** box in Platform.sh configuration is unchecked.
        This will ensure that the token is not exposed.

        ![Setting token to be invisible during runtime](img/psh_addvariable.png)

    !!! note "Authentication token validation delay"

        You can encounter some delay between creating the token and being able to use it in Composer. It might take up to 15 minutes.

    !!! caution "Support agreement expiry"

        If your Support agreement expires, your authentication token(s) will no longer work.
        They will become active again if the agreement is renewed, but this process may take up to 24 hours.
        _(If the agreement is renewed before the expiry date, there will be no disruption of service.)_

## Create project

There are two ways to get an instance of eZ Platform. 
The result is the same, so you can use the way you prefer:

- [Download or clone](#a-download-or-clone)
- [Create a project with Composer](#b-create-project-with-composer)

### A. Download or clone

=== "eZ Platform"

    You can either:

    - download an archive from [ezplatform.com](https://ezplatform.com/#download-option)
    and extract the archive into the location where you want your project root directory to be, or
    - clone the [`ezplatform` GitHub repository](https://github.com/ezsystems/ezplatform).

    ``` bash
    git clone https://github.com/ezsystems/ezplatform .
    ```

    Check out a tag (e.g. `git checkout v1.13.4`) that you want to use in a project.
    Use branches (e.g. `master` or `1.13`) only when contributing.

=== "Enterprise and Commerce"

    Download an archive from the [Support portal](https://support.ez.no/Downloads).

    Extract the archive into the location where you want your project root directory to be.

Next, install dependencies with Composer. From the folder into which you downloaded the files, run:

``` bash
composer install
```

Composer looks inside the `composer.json` file and installs all packages required to run the product.

### B. Create a project with Composer

=== "eZ Platform"

    To use Composer to instantly create a project in the current folder with all the dependencies, run the following command:

    ``` bash
    composer create-project --keep-vcs ezsystems/ezplatform .
    ```

=== "Enterprise"

    To install a new project with the `composer create-project` command to get the latest version of eZ Enterprise,
    you must first inform the Composer, which token to use before the project folder is created.

    To do this, select the correct updates.ez.no channel. The following channels are available:

    - Trial (limited access to try for up to 120 days): [ttl](https://updates.ez.no/ttl/)
    - Enterprise Business User License (requires valid subscription): [bul](https://updates.ez.no/bul/)

    For example, you select the `bul` channel in the following way:

    ``` bash
    COMPOSER_AUTH='{"http-basic":{"updates.ez.no":{"username":"<installation-key>","password":"<token-password>"}}}' composer create-project --keep-vcs --repository=https://updates.ez.no/bul/ ezsystems/ezplatform-ee my-new-ee-project
    ```

    Edit `composer.json` in your project root and change the URL defined in the `repositories` section to `https://updates.ez.no/bul/`.
    Once that is done, you can execute `composer update` to get packages with the correct license.

    !!! note "Moving from trial"

        If you started with a trial installation and want to use the software under the [BUL license instead of a TTL license](https://ibexa.co/About-our-Software/Licenses-and-agreements/), you must change the channel setting that you have just made.

=== "Commerce"

    To install a new project with the `composer create-project` command to get the latest version of eZ Commerce,
    you must first inform the Composer, which token to use before the project folder is created.

    To do this, select the correct updates.ez.no channel. The following channels are available:

    - Trial (limited access to try for up to 120 days): [ttl_com](https://updates.ez.no/ttl_com/)
    - Enterprise Business User License (requires valid subscription): [bul_com](https://updates.ez.no/bul_com/)

    For example, you select the `bul_com` channel in the following way:

    ``` bash
    COMPOSER_AUTH='{"http-basic":{"updates.ez.no":{"username":"<installation-key>","password":"<token-password>"}}}' composer create-project --keep-vcs --repository=https://updates.ez.no/bul_com/ ezsystems/ezcommerce my-new-com-project
    ```

    Edit `composer.json` in your project root and change the URL defined in the `repositories` section to `https://updates.ez.no/bul_com/`.
    Once that is done, you can execute `composer update` to get packages with the correct license.

    !!! note "Moving from trial"

        If you started with a trial installation and want to use the software under the [BUL license instead of a TTL license](https://ibexa.co/About-our-Software/Licenses-and-agreements/), you must change the channel setting that you have just made.

!!! tip

    You can set [different version constraints](https://getcomposer.org/doc/articles/versions.md):
    specific tag (`v2.2.0`), version range (`~1.13.0`), stability (`^2.3@rc`), etc.
    For example if you want to get the latest stable 2.x release, with a minimum of v2.3.1, use:

    ``` bash
    composer create-project --keep-vcs ezsystems/ezplatform . ^2.3.1
    ```

!!! tip "Different tokens for different projects on a single host"

    If you configure several projects on one machine, make sure that
    you set different tokens for each of the projects in their respective `auth.json` files.

## Change installation parameters

At this point you can configure your database via the `DATABASE_URL` in the `.env` file:
`DATABASE_URL=mysql://user:password@host:port/name`.

Choose a [secret](http://symfony.com/doc/5.0/reference/configuration/framework.html#secret)
and provide it in the `APP_SECRET` parameter in `.env`.
It should be a random string, made up of up to 32 characters, numbers, and symbols.
This is used by Symfony when generating [CSRF tokens](https://symfony.com/doc/5.0/security/csrf.html),
[encrypting cookies](http://symfony.com/doc/5.0/cookbook/security/remember_me.html),
and for creating signed URIs when using [ESI (Edge Side Includes)](https://symfony.com/doc/5.0/http_cache/esi.html).

Instead of setting `DATABASE_URL`, you can change individual installation parameters in `.env`.

!!! tip

    It is recommended to store the database credentials in your `.env.local` file and not commit it to the Version Control System.

The configuration requires providing the following parameters:

- `DATABASE_USER`
- `DATABASE_PASSWORD`
- `DATABASE_NAME`
- `DATABASE_HOST`
- `DATABASE_PORT`
- `DATABASE_PLATFORM` - prefix for distinguishing the database you are connecting to (e.g. `mysql` or `pgsql`)
- `DATABASE_DRIVER` - driver used by Doctrine to connect to the database (e.g. `pdo_mysql` or `pdo_pgsql`)
- `DATABASE_VERSION` - database server version (for a MariaDB database, prefix the value with `mariadb-`)

!!! caution

    When you use the `.env.local` file with the `DATABASE_*` parameters mentioned above, you must re-define the `DATABASE_URL` parameter for interpolation after overriding those parameters:

    ```
    DATABASE_URL=${DATABASE_PLATFORM}://${DATABASE_USER}:${DATABASE_PASSWORD}@${DATABASE_HOST}:${DATABASE_PORT}/${DATABASE_NAME}
    ```

!!! tip "Using PostgreSQL"

    If you want an installation with PostgreSQL instead of MySQL, refer to [Using PostgreSQL](../guide/databases.md#using-postgresql).

!!! enterprise "Commerce"

    ## Install and configure Solr for Commerce

    Search in the shop front end requires Solr as search engine. To install it, run the included script:

    ``` bash
    bash ./install-solr.sh
    ```

    Configure the following parameters in the `.env` file:

    - `SISO_SEARCH_SOLR_HOST`
    - `SISO_SEARCH_SOLR_PORT`
    - `SISO_SEARCH_SOLR_CORE`

    Also in the `.env` file, set Solr as the search engine:

    ```
    SEARCH_ENGINE=solr
    ```

## Install eZ Platform

Install eZ Platform and create a database with:

``` bash
composer ezplatform-install
```

Before executing the command make sure that the database user has sufficient permissions.

If Composer asks for your token, you must log in to your GitHub account and generate a new token
(edit your profile and go to **Developer settings** > **Personal access tokens** > **Generate new token** with default settings).
This operation is performed only once, when you install eZ Platform for the first time.

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

## Prepare the installation for production

To use eZ Platform with an HTTP server, you need to [set up directory permissions](#set-up-permissions) and [prepare a virtual host](#set-up-virtual-host).

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
See [Setting up or Fixing File Permissions](http://symfony.com/doc/5.0/setup/file_permissions.html) in Symfony documentation
for information on how to do it on different systems.

### Set up a virtual host

#### Option A: Scripted configuration

Use the included shell script: `/<your installation directory>/bin/vhost.sh` to generate a ready to use `.conf` file.
Check out the source of `vhost.sh` to see the options provided.

#### Option B: Manual configuration

Copy `/<your installation directory>/doc/apache2/vhost.template` to `/etc/apache2/sites-available` as a `.conf` file.

Modify the file to fit your project.

Specify `/<your installation directory>/public` as the `DocumentRoot` and `Directory`.
Uncomment the line that starts with `#if [SYMFONY_ENV]` and set the value to `prod` or `dev`,
depending on the environment that you are configuring:

```
SetEnvIf Request_URI ".*" SYMFONY_ENV=prod
```

#### Enable the virtual host

When the virtual host file is ready, enable the virtual host and disable the default:

``` bash
a2ensite ezplatform
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

!!! tip "eZ Launchpad for quick deployment"

    To get your eZ Platform installation up and running quickly,
    use the Docker-based [eZ Launchpad](https://ezsystems.github.io/launchpad/), which takes care of the whole setup for you.
    eZ Launchpad is supported by the eZ Community.

## Post-installation steps

!!! enterprise

    ### Enable Date-based Publisher

    To enable delayed publishing of Content using the Date-based Publisher, you must set up cron to run the `bin/console ezplatform:scheduled:run` command periodically.

    For example, to check for publishing every minute, add the following script:

    `echo '* * * * * cd [path-to-ezplatform]; php bin/console ezplatform:cron:run --quiet --env=prod' > ezp_cron.txt`

    For 5-minute intervals:

    `echo '*/5 * * * * cd [path-to-ezplatform]; php bin/console ezplatform:cron:run --quiet --env=prod' > ezp_cron.txt`

    Next, append the new cron to user's crontab without destroying existing crons.
    Assuming the web server user data is `www-data`:

    `crontab -u www-data -l|cat - ezp_cron.txt | crontab -u www-data -`

    Finally, remove the temporary file:

    `rm ezp_cron.txt`

!!! enterprise

    ### Enable the Link manager

    To make use of the [Link Manager](../guide/url_management.md), you must [set up cron](../guide/url_management.md#enable-automatic-url-validation).

!!! enterprise "Commerce"

    #### JMS payment secret

    To provide the `JMS_PAYMENT_SECRET` secret for the Commerce payment system, run `./vendor/defuse/php-encryption/bin/generate-defuse-key`
    and use the generated secret.
