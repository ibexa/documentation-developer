---
description: Ensure that your Cohesivo installation is secure by following our set of recommendations.
---

# Security checklist

When getting ready to go live with your project for the first time, or when re-launching it, make sure that your setup is secure.

!!! caution

    Security is an ongoing process. After going live, you should pay attention to Ibexa security advisories released via [your Service portal](https://support.ibexa.co/), or via [Security advisories](https://developers.ibexa.co/security-advisories) if you're not a subscriber.

## [[= product_name =]]

### Carefully select admin users

Make sure Admin users and other privileged users who have access to System Information and setup in the back end are vetted and fully trustworthy.

As administrator, you have access to full information about the system through the `setup/system_info` policy, and also to user data, role editing, and many other critical aspects.

The users in your organization who have backend access must be kept up-to-date.
Any user leaving the organization must be disabled without delay.
If a user takes on a new role in the organization, any required role changes for them in [[= product_name =]] must also be made as soon as possible.

### Strong passwords

Enforce strong passwords for all users.
This is specially important for admin accounts and other privileged users.

- Never go online with admin password set to `publish` or any other default value.
- Introduce password quality checks. Make sure the checks are strict enough (length/complexity).
- 16 characters is a quite secure minimum length. Don't go below 10.
- Enable the password rule that rejects any password which has been exposed in a public breach.

!!! tip "Password rules"

    See [setting up password rules](passwords.md#password-rules).

### Use secure roles and policies

Use the following checklist to ensure the roles and policies are secure:

- Do roles restrict read/write access to content as they should? Is read/write access to personal data, like User content items, properly restricted?
- Are the roles and their use properly differentiated and restricted? Is an editor role used for everyday editorial work?
- Is the admin role used only for high-level administrative work? Is the number of people with admin access properly restricted and vetted?
- Should people be allowed to create new user accounts themselves? Should such accounts be enabled by default, or require vetting by admins?
- Is the role of self-created new users restricted as intended?
- Is there a clear role separation between the organisation's internal and external users?
- Is access to user data properly restricted, in accordance with GDPR?
- Is access to Form Builder uploads managed properly? Files uploaded with the Form Builder are accessible to any user by default. If this doesn't suit you, restrict access to the Form Uploads folder.

### Don't use "hide" for read access restriction

The [visibility switcher](locations.md#location-visibility) acts as a flag.
You can choose to respect it or ignore it in your code.
It isn't permission-based, and doesn't restrict read access to content.
Hidden content can be read through the REST API.

If you need to restrict read access to a given content item, you could create a role that grants read access for a given [**Section**](sections.md) or [**Object State**](object_states.md), and set a different section or object State for the given content.
Or use other permission-based [**Limitations**](limitations.md).

### Minimize exposure

Security should be a multi-layered exercise.
It's wise to minimize what features you make available to the world, even if there are no known or suspected vulnerabilities in those features, and even if your content is properly protected by roles and policies.
Reduce your attack surface by exposing only what you must.

### Limit access to Code blocks

The [Code block]([[= user_doc =]]/content_management/block_reference/#code-block) in Page Builder is designed to accept any HTML, which includes embedded JavaScript.
This means that editors who have access to Code blocks could add malicious JS including [cross site scripting (XSS)](https://en.wikipedia.org/wiki/Cross-site_scripting).
As site administrator, be aware of this when giving editors access to the Page Builder features, and limit that access only to trusted editors.
You can [limit access to specific blocks per content type]([[= user_doc =]]/content_management/configure_ct_field_settings/#default-configuration-of-pages) by defining which page blocks are available to editors.

## Security headers

There are a number of security related HTTP response headers that you can use to improve your security.
Headers must be adapted to the site in question, and in most cases it's site owner's responsibility.

You most likely need to vary the security headers based on the SiteAccess in question and site implementation details, such as frontend code and libraries used.

- `Strict-Transport-Security` - ensures that all requests are sent over HTTPS, with no fallback to HTTP.
All production sites should use HTTPS and this header unless they have particular needs.
This header is less important during development provided that the site is on an internal, protected network.
- `X-Frame-Options` - ensures that the site isn't embedded in a frame by a compliant browser.
Set the header to `SAMEORIGIN` to allow embedding by your own site, or `DENY` to block framing completely.
- `X-Content-Type-Options` - prevents the browser from second-guessing the mime-type of delivered content.
This header is less important if users cannot upload content and/or you trust your editors. However, it's safer to use it at all times.
Make sure that the `Content-Type` header is also correctly set, including for the top-level document, to avoid issues with HTML documents being downloaded while they should be rendered.
- `Content-Security-Policy` - blocks cross site scripting (XSS) attacks by setting an allowlist (whitelist) of resources to be loaded for a given page.
You can set separate lists for scripts, images, fonts, and more.
For experimentation and testing, you can use `Content-Security-Policy-Report-Only` before activating the actual policy.
- `Referrer-Policy` - limits what information is sent from the previous page or site when navigating to a new page or site.
This header has several directives for fine-tuning the referrer information.
- `Permissions-Policy` - limits what features the browser can use, such as fullscreen, notifications, location, camera, or microphone.
For example, if someone succeeds in injecting their JavaScript into your site, this header prevents them from using those features to attack your users.

## Domain

### Enable Domain Name System Security Extensions (DNSSEC)

DNSSEC is a DNS feature that authenticates responses to DNS requests.
It protects against DNS poisoning attacks, which is when an attacker manipulates the responses to DNS requests with the goal of directing users to an IP address the attacker controls.
Enabling DNSSEC involves creating the DNSSEC records in your domain, activating DNSSEC with your domain registrar, and enabling DNSSEC signature validation on all DNS servers.
[Read more on DNSSEC on ICANN's website](https://www.icann.org/resources/pages/dnssec-what-is-it-why-important-2019-03-05-en).

### Enable domain update/delete protection

Domain update/delete protection is a DNS setting that makes it harder for an attacker to take over a domain from the real owner, or hinder availability for users.
You can enable this protection at your domain registrar's site.
Log in to their site to enable these protection settings and save the new configuration.

### Enable Certificate Authority Authorization (CAA)

CAA allows domain owners to specify which Certificate Authorities (CAs) are permitted to issue SSL/TLS certificates for their domain.
This prevents attackers from having certificates issued for domains they don't own, hindering some types of attack.
CAA is configured in your DNS zone file.
