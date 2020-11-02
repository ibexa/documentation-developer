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
    
    This will generate a 64-character-long secure random secret:
    
    `print bin2hex(random_bytes(32));`
    
!!! tip

    On Ibexa Cloud, if `APP_SECRET` is not set, the system sets it to [`PLATFORM_PROJECT_ENTROPY`](https://docs.platform.sh/development/variables.html#platformsh-provided-variables)

### Symfony production mode

Only expose Symfony production mode openly on the internet. If you have exposed dev mode, secure and change all passwords/secrets.
Exposing the dev mode exposes things like `phpinfo`, environment variables and so on.

!!! tip "More information about Symfony security"

    - [Authentication and authorisation](https://symfony.com/doc/current/security.html), and [more on this subject](https://symfony.com/doc/current/security.html#learn-more)
    - Symfony's [secrets management system](https://symfony.com/doc/current/configuration/secrets.html)

## [[= product_name_ee =]]

### Fully-vetted admin users

Make sure Admin users and other privileged users who have access to System Information and setup in the back end
are vetted and fully trustworthy.

As administrator you have access to full information about the system through the `setup/system_info` Policy,
and also to user data, Role editing, and many other critical aspects.

### Strong passwords

Enforce strong passwords for all users. This is specially important for admin accounts and other privileged users.

- Never go online with admin password set to `publish` or any other default value.
- Introduce password quality checks. Make sure they are secure enough (length/complexity).
- 16 characters is a quite secure minimum length. Do not go below 10.

!!! tip "Password rules"

    See [setting up password rules](user_management/user_management.md#password-rules).

### Secure secrets

Ensure all other secrets are similarly secured: Varnish invalidate token, JWT passphrase (if in use),
and any other application-specific secrets.

### Protect against brute force attacks

Introduce a measure against brute force login attacks (captcha, etc.).

### Disable Fastly when using Varnish

If you are using Fastly, disable Varnish.
See [Security advisory: EZSA-2020-002.](https://developers.ibexa.co/security-advisories/ezsa-2020-002-unauthorised-cache-purge-with-misconfigured-fastly)

### Block the execution of scripts in the `var` directory

Make sure the web server blocks the execution of PHP files and other scripts in the `var` directory.
See [vhost.template.](https://github.com/ezsystems/ezplatform/blob/master/doc/apache2/vhost.template#L80)

### Use secure password hashing

Use the most secure supported password hashing method.
This is currently `bcrypt`, see [Increased password hash length](../updating/4_update_1.13.md#increased-password-hash-length).

### Restrict access to the back end

If possible, make the back end unavailable on the open internet.

### Use UTF8MB4 with MySQL/MariaDB

If you are using MySQL/MariaDB, use the UTF8MB4 database character set and related collation.
The older UTF8 can lead to truncation with 4-byte characters, like some emoji, which may have unpredictable side effects.

See [Change from UTF8 to UTF8MB4](../updating/4_update_2.2.md#change-from-utf8-to-utf8mb4).

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

- Avoid exposing servers on the open internet when not strictly required.
- Ensure any servers, services, ports and virtual hosts that were opened for testing purposes are locked down before going live.
- Secure the database with a good password, keys, firewall, etc.
- Run the server on a recent operating system and dependencies with security patches installed.
- Configure the server to alert you about security updates from vendors.
Pay special attention to dependencies used by your project directly, or by PHP.
