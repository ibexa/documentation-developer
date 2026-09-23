---
description: Ensure that your Cohesivo installation is secure by following our set of recommendations.
---

# Security checklist

When getting ready to go live with your project for the first time, or when re-launching it, make sure that your setup is secure.

!!! caution

    Security is an ongoing process. After going live, you should pay attention to Ibexa security advisories released via [your Service portal](https://support.ibexa.co/).

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
