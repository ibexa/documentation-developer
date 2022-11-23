---
description: Ensure that your Ibexa DXP installation is secure by following our set of recommendations.
---

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
    
    `print bin2hex(random_bytes(32));`
    
!!! note

    On Ibexa Cloud, if `APP_SECRET` is not set, the system sets it to [`PLATFORM_PROJECT_ENTROPY`](https://docs.platform.sh/development/variables.html#platformsh-provided-variables)

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

## [[= product_name =]]

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

!!! tip "Password rules"

    See [setting up password rules](user_management.md#password-rules).

### Secure secrets

Ensure all other secrets are similarly secured: Varnish invalidate token, JWT passphrase (if in use),
and any other application-specific secrets.

### Protect against brute force attacks

Introduce a measure against brute force login attacks (captcha, etc.).

### Disable Varnish when using Fastly

If you are using Fastly, disable Varnish.
See [Security advisory: EZSA-2020-002.](https://developers.ibexa.co/security-advisories/ezsa-2020-002-unauthorised-cache-purge-with-misconfigured-fastly)

### Block execution of scripts in `var` directory

Make sure the web server blocks the execution of PHP files and other scripts in the `var` directory.
See [vhost.template.](https://github.com/ezsystems/developer-documentation/tree/master/code_samples/install/vhost_template/vhost.template#L80)

### Use secure password hashing

Use the most secure supported password hashing method. This is currently `bcrypt`.

### Restrict access to the Back Office

If possible, make the Back Office unavailable on the open internet.

### Use UTF8MB4 with MySQL/MariaDB

If you are using MySQL/MariaDB, use the UTF8MB4 database character set and related collation.
The older UTF8 can lead to truncation with 4-byte characters, like some emoji, which may have unpredictable side effects.

See [Change from UTF8 to UTF8MB4](update_db_to_2.5.md#change-from-utf8-to-utf8mb4).

### Use secure Roles and Policies

Use the following checklist to ensure the Roles and Policies are secure:

- Do Roles restrict read/write access to content as they should? Is read/write access to personal data, like User Content items, properly restricted?
- Are the Roles and their use properly differentiated and restricted? Is an editor Role used for everyday editorial work?
- Is the admin Role used only for high-level administrative work? Is the number of people with admin access properly restricted and vetted?
- Should people be allowed to create new user accounts themselves? Should such accounts be enabled by default, or require vetting by admins?
- Is the Role of self-created new users restricted as intended?
- Is there a clear Role separation between the organisation's internal and external users?
- Is access to user data properly restricted, in accordance with GDPR?

## Underlying stack

Once you have properly configured secure user roles and permissions, to avoid exposing your application to any DDOS vulnerabilities or other yet unknown security threats, make sure that you do the following:

- Avoid exposing servers on the open internet when not strictly required.
- Ensure any servers, services, ports and virtual hosts that were opened for testing purposes are locked down before going live.
- Secure the database with a good password, keys, firewall, etc.
- Consider whether certain interfaces must be left available on the open internet. Roles protect your content on all interfaces, but you may prefer to reduce your attack surface. For example:
    - The `/search` and `/graphql` endpoints
    - The REST API endpoints

!!! tip "Access control"
    One way to lock down an endpoint that should not be openly available is to restrict access to logged-in users, by using the [`access_control`](https://symfony.com/doc/5.4/security/access_control.html) feature. In your YAML configuration, under the `security` key, add an entry similar to the following one, which redirects requests to a login page:

    ```yaml
    security:
        access_control:
            - { path: ^/search, roles: ROLE_USER}
    ```

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
