1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [Get Started with eZ Platform](Get-Started-with-eZ-Platform_31429520.html)
4.  [Step 1: Installation](31429538.html)

# Starting eZ Platform

Created by Dominika Kurek, last modified on May 17, 2016

Once you have your eZ Platform installed, all you need to do to start it is to run your Apache server. Then you can access your eZ Platform's front and back office. To access the UI backend, add `/ez` to your installation URL.

When it comes to the server, you can use the following options:

-   [Web Server](Web-Server_31429554.html)
-   [PHP's built-in server](31429556.html)

 
# Web Server

Created by Dominika Kurek, last modified by Rui Silva on Jun 23, 2016

# Configuration files

You can find configuration files in the `doc/` directory of the software, for the following web server engines:

-   [Apache](https://github.com/ezsystems/ezplatform/tree/master/doc/apache2)
-   [Nginx](https://github.com/ezsystems/ezplatform/tree/master/doc/nginx)

and also configuration files for

-   [Varnish](https://github.com/ezsystems/ezplatform/blob/master/doc/varnish/varnish.md)

# Generate vhost config script

In addition to that, you have a Bash script for generating a virtual host configuration based on template, containing variables among the once define below.
For help text, execute: `./bin/vhost.sh -h`

## Help

 

``` brush:
./bin/vhost.sh [-h|--help]
```

 

## Usage

``` brush:
$> ./bin/vhost.sh --basedir=/var/www/ezplatform \\

  --template-file=doc/apache2/vhost.template \\

  | sudo tee /etc/apache2/sites-enabled/my-site > /dev/null
```

Default values will be fetched from the environment variables `$env_list`, but might be overridden using the arguments listed below.

## Arguments

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th>Option</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><p>--basedir=&lt;path&gt;</p></td>
<td>Root path to where the eZ installation is placed, used for &lt;path&gt;/web</td>
</tr>
<tr class="even">
<td><p>--template-file=&lt;file.template&gt;</p></td>
<td><p>The file to use as template for the generated output file</p></td>
</tr>
<tr class="odd">
<td>--host-name=localhost</td>
<td>Primary host name, default &quot;localhost&quot;</td>
</tr>
<tr class="even">
<td><p>--host-alias=*.localhost</p></td>
<td>Space separated list of host aliases, default &quot;*.localhost&quot;</td>
</tr>
<tr class="odd">
<td><p>--ip=*|127.0.0.1</p></td>
<td>IP address web server should accept traffic on.</td>
</tr>
<tr class="even">
<td><p>--port=80]</p></td>
<td>Port number web server should listen to</td>
</tr>
<tr class="odd">
<td><p>--sf-env=prod|dev|..</p></td>
<td>Symfony environment used for the virtual host, default is &quot;prod&quot;</td>
</tr>
<tr class="even">
<td><p>--sf-debug=0|1</p></td>
<td>Set if Symfony debug should be on, by default on if env is &quot;dev&quot;</td>
</tr>
<tr class="odd">
<td><p>--sf-trusted-proxies=127.0.0.1,....</p></td>
<td>Comma separated trusted proxies (e.g. Varnish), that we can get client IP from</td>
</tr>
<tr class="even">
<td><p>--sf-http-cache=0|1</p></td>
<td>To disable Symfony HTTP cache Proxy for using a different reverse proxy
<p>By default disabled when env is &quot;dev&quot;, enabled otherwise.</p></td>
</tr>
<tr class="odd">
<td>--sf-http-cache-class=&lt;class-file.php&gt;</td>
<td>To specify a different class than the default one, to use as the Symfony proxy</td>
</tr>
<tr class="even">
<td>--sf-classloader-file=&lt;class-file.php&gt;</td>
<td>To specify a different class than the default one, to use for PHP auto loading</td>
</tr>
<tr class="odd">
<td><p>--body-size-limit=&lt;int&gt;</p></td>
<td>Limit in megabytes for max size of request body, 0 value disables limit</td>
</tr>
<tr class="even">
<td>--request-timeout=&lt;int&gt;</td>
<td>Limit in seconds before timeout of request, 0 value disables timeout limit</td>
</tr>
</tbody>
</table>

# PHP's built-in server

Created by Dominika Kurek, last modified on Apr 25, 2016

## Description

PHP, in 5.4 and later, comes with a [built-in webserver for development purposes](http://php.net/manual/en/features.commandline.webserver.php). This is very handy, as it allows you to **kickstart development quickly**, avoiding having to install and configure [Apache](https://github.com/ezsystems/ezplatform/tree/master/doc/apache2) / [Nginx](https://github.com/ezsystems/ezplatform/tree/master/doc/nginx). All you need here is PHP 5.4+ with command line binary.

## Usage

Symfony comes with a wrapper script for booting the built-in webserver: `server:run`. It's a nice shortcut as it will correctly set the web root depending on your configuration, and with eZ Platform it can be used as is.

Use this command for **local development purpose only**!
DO NOT use this on production servers, the use of `--env=prod` below is just showcasing that you can use the command both with Symfony's dev and prod environment depending on if you are debugging or just testing out your application locally.

##### Examples

The following example will start the webserver on <http://127.0.0.1:8000> on your machine, in Symfony dev environment for debug use:

**Debug example**

``` brush:
php app/console server:run
```

The following example will start the webserver on [http://localhost:8000](http://localhost:8000/) on your machine, in Symfony prod environment for demo/testing use:

**Testing/Demo example**

``` brush:
php app/console server:run --env=prod localhost:8000
```

 

##### **Help with the command**

As with any Symfony command, you may execute the command with a `-h` flag to get up-to-date help text for the command:

**Help info example**

``` brush:
php app/console server:run -h
```

 

 

#### Further reading:

<http://symfony.com/doc/current/cookbook/web_server/built_in.html>



# Hello World!

Created by Dominika Kurek, last modified on Apr 29, 2016

Now your installation is ready and you're on your way to starting work with eZ Platform.

To access the back office of your installation, append `/ez` to its path: &lt;`your_installation path>/ez`. You will be prompted for the username and password, which by default are:

username: admin
password: publish

 

A clean installation of eZ Platform is empty, so you only get a single page with a rudimentary content model. This is a blank canvas for you to create and customize your own structure.

If you'd like to take a look at an example of using the system to construct a fully functional page, you can also [install eZ Platform with the Demo Bundle](eZ-Platform-Demo_31429540.html).

 
