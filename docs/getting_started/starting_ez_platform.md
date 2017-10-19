# Starting eZ Platform

Once you have your eZ Platform installed, all you need to do to start it is to run your Apache server. Then you can access your eZ Platform's front and back office. To access the UI backend, add `/ez` to your installation URL.
 
## Web Server

### Configuration files

You can find configuration files in the `doc/` directory of the software, for the following web server engines:

-   [Apache](https://github.com/ezsystems/ezplatform/tree/master/doc/apache2)
-   [Nginx](https://github.com/ezsystems/ezplatform/tree/master/doc/nginx)

and also configuration files for

-   [Varnish](https://github.com/ezsystems/ezplatform/blob/master/doc/varnish/varnish.md)

### Generate vhost config script

In addition to that, you have a Bash script for generating a virtual host configuration based on template, containing variables among the once define below.
For help text, execute: `./bin/vhost.sh -h`

### Help

``` bash
./bin/vhost.sh [-h|--help]
```

### Usage

``` bash
$> ./bin/vhost.sh --basedir=/var/www/ezplatform \\

  --template-file=doc/apache2/vhost.template \\

  | sudo tee /etc/apache2/sites-enabled/my-site > /dev/null
```

Default values will be fetched from the environment variables `$env_list`, but might be overridden using the arguments listed below.

#### Arguments

|Option  | Description|
|-------|------|
|--basedir=<path>  | Root path to where the eZ installation is placed, used for <path>/web|
|--template-file=<file.template> | The file to use as a template for the generated output file|
|--host-name=localhost | Primary host name, default "localhost"|
|--host-alias=* .localhost | Space separated list of host aliases, default ".localhost"|
|--ip=127.0.0.1/* | IP address web server should accept traffic on|
|--port=80 | Port number web server should accept traffic on|
|--sf-env=prod/dev | Symfony environment used for the virtual host, default is prod|
|--sf-debug=0/1 | Set if Symfony debug should be on, by default on if env is dev|
|--trusted-proxies=127.0.0.1/* | Comma separated trusted proxies(e.g. Varnish), that we can get client IP from.|
|--sf-http-cache=0/1 | To disable Symfony HTTP cache proxy for using a different reverse proxy. By default disabled when env is "dev", enabled otherwise.|
|--sf-http-cache-class=<class-file.php> | To specify a different class than the default one, to use as the Symfony proxy|
|--sf-classloader-file=<class-file.php> | To specify a different class than the default one, to use for PHP auto loading|
|--body-size-limit =<int>| Limit in megabytes for max sizeof request body, 0 value disables limit|
|--request-timeout=<int> | Limit in seconds before timeout of request, 0 value disables timeout limit|

## PHP's built-in server

### Description

PHP comes with a [built-in webserver for development purposes](http://php.net/manual/en/features.commandline.webserver.php). This is very handy, as it allows you to **kickstart development quickly**, avoiding having to install and configure [Apache](https://github.com/ezsystems/ezplatform/tree/master/doc/apache2) / [Nginx](https://github.com/ezsystems/ezplatform/tree/master/doc/nginx). All you need here is PHP 5.4+ with command line binary.

### Usage

Symfony comes with a wrapper script for booting the built-in webserver: `server:run`. It's a nice shortcut as it will correctly set the web root depending on your configuration, and with eZ Platform it can be used as is.

!!! caution "Use this command for **local development purpose only**!"

    DO NOT use this on production servers, the use of `--env=prod` below is just showcasing that you can use the command both with Symfony's dev and prod environment depending on if you are debugging or just testing out your application locally.

##### Examples

The following example will start the webserver on <http://127.0.0.1:8000> on your machine, in Symfony dev environment for debug use:

**Debug example**

``` bash
php bin/console server:run
```

The following example will start the webserver on [http://localhost:8000](http://localhost:8000/) on your machine, in Symfony prod environment for demo/testing use:

**Testing/Demo example**

``` bash
php bin/console server:run --env=prod localhost:8000
```

##### **Help with the command**

As with any Symfony command, you may execute the command with a `-h` flag to get up-to-date help text for the command:

**Help info example**

``` bash
php bin/console server:run -h
```

#### Further reading:

<http://symfony.com/doc/current/cookbook/web_server/built_in.html>

## Hello World!

Now your installation is ready and you're on your way to starting work with eZ Platform.

To access the back office of your installation, append `/admin` to its path: `<your_installation path>/admin>`. You will be prompted for the username and password, which by default are:

username: `admin`
password: `publish`

A clean installation of eZ Platform is empty, so you only get a single page with a rudimentary content model. This is a blank canvas for you to create and customize your own structure.

If you'd like to take a look at an example of using the system to construct a fully functional page, you can also [install eZ Platform with the Demo Bundle](install_ez_platform.md).

 
