# Security checklist

When getting ready to go live with your project for the first time, or when re-launching it,
make sure that your setup is secure.

!!! caution

    Security is an ongoing process. After going live, you should pay attention to security advisories
    released via [your service portal,](https://support.ibexa.co/)
    or via [Security advisories](https://developers.ibexa.co/security-advisories) if you're not a subscriber.
    
## Symfony

### `APP_SECRET`

`APP_SECRET` needs to be a strong, random, securely stored value.

- Do not use a default value like `ff6dc61a329dc96652bb092ec58981f7` or `ThisTokenIsNotSoSecretChangeIt`.
- The secret must be secured against unwanted access. Do not commit the value to a version control system.
- The secret must be long enough. 32 characters is minimum, longer is better.

!!! tip
    
    The following command will generate a 64-character-long secure random value:
    
    `php -r "print bin2hex(random_bytes(32));"`

### Symfony production mode

Only expose Symfony production mode openly on the internet.
Do not expose the dev mode on the internet, otherwise you may disclose things like `phpinfo` and environment variables.
Exposing the dev mode exposes things like `phpinfo`, environment variables and so on.

!!! tip "More information about Symfony security"

    For more information about securing Symfony-based systems, see:
    
    - [Authentication and authorisation]([[= symfony_doc =]]/security.html), and [more on this subject]([[= symfony_doc =]]/security.html#learn-more)
    - Symfony's [secrets management system]([[= symfony_doc =]]/configuration/secrets.html)

## PHP

### Enable `zend.exception_ignore_args` in PHP 7.4 and newer

PHP 7.4 introduced the `zend.exception_ignore_args` setting in `php.ini`.
The default value is 0 (disabled) for backwards compatibility.
On production sites this should be set to 1 (enabled), to ensure stack traces do not include arguments passed to functions.
Such arguments could include passwords or other sensitive information.
You should also make sure no stack trace is ever visible to end users of production sites,
though visible arguments are unsafe even if the stack traces only show up in log files.

## eZ Platform

### Fully-vetted admin users

Make sure Admin users and other privileged users who have access to System Information and setup in the back end
are vetted and fully trustworthy.

As administrator you have access to full information about the system through the `setup/system_info` Policy,
and also to user data, Role editing, and many other critical aspects.

### Strong passwords

Enforce strong passwords for all users. 
This is specially important for admin accounts and other privileged users.

- Never go online with admin password set to `publish` or any other default value.
- Introduce password quality checks. Make sure the checks are strict enough (length/complexity).
- 16 characters is a quite secure minimum length. Do not go below 10.

### Secure secrets

Ensure all other secrets are similarly secured: Varnish invalidate token, JWT passphrase (if in use),
and any other application-specific secrets.

### Protect against brute force attacks

Consider introducing a measure against brute force login attacks, like CAPTCHA. Adjust timeout limits to your needs:

When using the "forgot password" feature, a token is created which expires if the user doesn't click the password reset
link that gets mailed to them in time. The time before it expires is set in the configuration parameter
`ezsettings.default.security.token_interval_spec`. By nature this feature must be available to users
before they have logged in, including would-be attackers. If an attacker uses this feature with someone else's email
address, the attacker does not receive the email. But they could still try to guess the password reset link. That's why
this interval should be as short as possible. 5 minutes is often enough.

These timeouts are both entered as [PHP DateInterval duration strings](https://www.php.net/manual/en/dateinterval.construct.php).
The forgot password feature defaults to "PT1H" (one hour).
The account invitation feature defaults to "P7D" (seven days).

### Disable Varnish when using Fastly

If you are using Fastly, disable Varnish.
See [Security advisory: EZSA-2020-002.](https://developers.ibexa.co/security-advisories/ezsa-2020-002-unauthorised-cache-purge-with-misconfigured-fastly)

### Block upload of unwanted file types

The `ezsettings.default.io.file_storage.file_type_blacklist` setting is defined in the config file `eZ/Bundle/EzPublishCoreBundle/Resources/config/default_settings.yml` in the `ezpublish-kernel` bundle.
It prevents uploading files that might be executed on the server, a Remote Code Execution (RCE) vulnerability. The setting lists filename extensions for files that shouldn't be uploaded.
Attempting to upload files from the list results in an error message.
There are also other safety measures in place, like using the web server configuration to block execution of uploaded scripts, see the next point.

You should adapt this list to your needs. Note that `svg` images are blocked because they may contain JavaScript code.
If you opt to allow them, make sure you take steps to mitigate the risk.

The default list of blocked file types contains: `hta htm html jar js jse pgif phar php php3 php4 php5 phps phpt pht phtml svg swf xhtm xhtml`.

### Block the execution of scripts in the `var` directory

Make sure the web server blocks the execution of PHP files and other scripts in the `var` directory.
See the line below `# Disable .php(3) and other executable extensions in the var directory` in the example virtual host files for Apache and Nginx, provided in the [installation documentation](install_ez_platform.md#set-up-virtual-host).

### Use secure password hashing

Use the most secure supported password hashing method. This is currently `bcrypt`.

### Restrict access to the back end

If possible, make the back end unavailable on the open internet.
Use the most secure supported password hashing method. This is currently `bcrypt`, and it is enabled by default.

### Use UTF8MB4 with MySQL/MariaDB

If you are using MySQL/MariaDB, use the UTF8MB4 database character set and related collation.
The older UTF8 can lead to truncation with 4-byte characters, like some emoji, which may have unpredictable side effects.

See [Change from UTF8 to UTF8MB4](../updating/from_1.x_2.x/update_db_to_2.5.md#change-from-utf8-to-utf8mb4).

### Use secure Roles and Policies

Use the following checklist to ensure the Roles and Policies are secure:

- Do Roles restrict read/write access to content as they should? Is read/write access to personal data, like User Content items, properly restricted?
- Are the Roles and their use properly differentiated and restricted? Is an editor Role used for everyday editorial work?
- Is the admin Role used only for high-level administrative work? Is the number of people with admin access properly restricted and vetted?
- Should people be allowed to create new user accounts themselves? Should such accounts be enabled by default, or require vetting by admins?
- Is the Role of self-created new users restricted as intended?
- Is there a clear Role separation between the organisation's internal and external users?
- Is access to user data properly restricted, in accordance with GDPR?

### Do not use "hide" for read access restriction

The [visibility switcher](https://doc.ibexa.co/en/latest/content_management/locations/#location-visibility) is a convenient feature for withdrawing content from the frontend.
It acts as a filter in the frontend by default. You can choose to respect it or ignore it in your code.
It isn't permission-based, and doesn't restrict read access to content. Hidden content can be read through other means, like the REST API or GraphQL.

If you need to restrict read access to a given Content item, you could create a role that grants read access for a given
[**Section**](https://doc.ibexa.co/en/latest/administration/content_organization/sections/)
or [**Object State**](https://doc.ibexa.co/en/latest/administration/content_organization/object_states/),
and set a different Section or Object State for the given Content.
Or use other permission-based [**Limitations**](https://doc.ibexa.co/en/latest/permissions/limitations/).

### Minimize exposure

Security should be a multi-layered exercise. It is wise to minimize what features you make available to the world, even if there are no known or suspected vulnerabilities in those features, and even if your content is properly protected by roles and policies. Reduce your attack surface by exposing only what you must.

- If possible, make the Back Office unavailable on the open internet.
- [Symfony FOSJsRoutingBundle](https://github.com/FriendsOfSymfony/FOSJsRoutingBundle) is required in those releases where it is included, to expose routes to JavaScript. It exposes only the required routes, nothing more. It is only required in the Back Office site access though, so you can consider blocking it in other site accesses. You should also go through your own custom routes, and decide for each if you need to expose them or not. See the documentation on [YAML route definitions for exposure](https://github.com/FriendsOfSymfony/FOSJsRoutingBundle/blob/master/Resources/doc/usage.rst#generating-uris).
- By default, a [Powered-By header](https://doc.ibexa.co/en/latest/update_and_migration/from_1.x_2.x/update_db_to_2.5/#powered-by-header) is set. It specifies what version of the DXP is running. For example, `x-powered-by: Ibexa Experience v4`. This doesn't expose anything that couldn't be detected through other means. But if you wish to obscure this, you can either omit the version number, or disable the header entirely.
- Consider whether certain interfaces must be left available on the open internet. For example:
    - The `/search` and `/graphql` endpoints
    - The REST API endpoints

!!! tip "Access control"
    One way to lock down an endpoint that should not be openly available is to restrict access to logged-in users, by using the [`access_control`](https://symfony.com/doc/5.4/security/access_control.html) feature. In your YAML configuration, under the `security` key, add an entry similar to the following one, which redirects requests to a login page:

    ```yaml
    security:
        access_control:
            - { path: ^/search, roles: ROLE_USER}
    ```

## Underlying stack

Once you have properly configured secure user roles and permissions, to avoid exposing your application to any DDOS vulnerabilities or other yet unknown security threats, make sure that you do the following:

- Avoid exposing servers on the open internet when not strictly required.
- Ensure any servers, services, ports and virtual hosts that were opened for testing purposes are shut down before going live.
- Secure the database with a good password, keys, firewall, etc. Ensure that the database user used by the web app only has access to do the operations needed by [[= product_name =]]. The Data Definition Language (DDL) commands (create, alter, drop, truncate, comment) are not needed for running [[= product_name =]], only for installing and upgrading it. If the web app user does not have these rights, then that reduces the damage that can be done if there is a security breach.

### Security headers

There are a number of security related HTTP response headers that you can use to improve your security. 
Headers must be adapted to the site in question, and in most cases it is site owner's responsibility. 
The headers can be set either by the web server, or by a proxy like Varnish. 
You can also set headers in PHP code by making a Symfony `RequestListener` for the `kernel.response` event and adding the header to the response object headers list.

You will likely need to vary the security headers based on the SiteAccess in question and site implementation details, such as frontend code and libraries used.

- `Strict-Transport-Security` - ensures that all requests are sent over HTTPS, with no fallback to HTTP. 
All production sites should use HTTPS and this header unless they have very particular needs. 
This header is less important during development provided that the site is on an internal, protected network. 
- `X-Frame-Options` - ensures that the site is not be embedded in a frame by a compliant browser. 
Set the header to `SAMEORIGIN` to allow embedding by your own site, or `DENY` to block framing completely. 
- `X-Content-Type-Options` - prevents the browser from second-guessing the mime-type of delivered content. 
This header is less important if users cannot upload content and/or you trust your editors. However, it is safer to use it at all times. 
Make sure that the `Content-Type` header is also correctly set, including for the top-level document, to avoid issues with HTML documents being downloaded while they should be rendered. 
- `Content-Security-Policy` - blocks cross site scripting (XSS) attacks by setting an allowlist (whitelist) of resources to be loaded for a given page. 
You can set separate lists for scripts, images, fonts, and so on. 
For experimentation and testing, you can use `Content-Security-Policy-Report-Only` before activating the actual policy. 
- `Referrer-Policy` - limits what information is sent from the previous page or site when navigating to a new page or site. 
This header has several directives for fine-tuning the referrer information. 
- `Permissions-Policy` - limits what features the browser can use, such as fullscreen, notifications, location, camera, or microphone. 
For example, if someone succeeds in injecting their JavaScript into your site, this header prevents them from using those features to attack your users. 

### Track dependencies

- Run servers on a recent operating system and install security patches for dependencies.
- Configure servers to alert you about security updates from vendors. Pay special attention to dependencies used by your project directly, or by PHP. The provider of the operating system usually has a service for this.
- Enable [GitHub Dependabot](https://docs.github.com/en/code-security/supply-chain-security/managing-vulnerabilities-in-your-projects-dependencies/about-dependabot-security-updates)
to receive notifications when a security fix is released in a Github-hosted dependency.
- If you're not using Github for your project, you can create a dummy project on Github with the same dependencies as your real project, and enable Dependabot notifications for that.
- Ensure you get notifications about security fixes in JavaScript dependencies.

## eZ Publish Legacy

If you are using Legacy Bridge, there are a few more things to check:

- Is there a measure in place against brute force login attacks? `MaxNumberOfFailedLogin > 0` will do.
- Do `MinPasswordLength` and `GeneratePasswordLength` (if used) have sane values? The default values are low.
16 characters is a secure minimum. Do not go below 10.
- Is verification of user email enabled? See `VerifyUserType=email`.
- If the site is from the era of MD5 hashes, is `UpdateHash=true` set?
This will update hashes as they are used, to the much more secure bcrypt algorithm.
- Do you require unique emails? You should, if emails are allowed to be used when logging in. See `site.ini`:

```
AuthenticateMatch=login;email
RequireUniqueEmail=true
```
