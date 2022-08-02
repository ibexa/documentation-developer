---
description: Managing user invitations to create an account in the frontend or the Back Office.
---

# Inviting Users

[[= product_name =]] allows you to create and send invitations to create an account in
the frontend as a customer, the Back Office as employee, or the Corporate Portal as an organisation member.
You can send invitations to individual users or in bulk.

## Roles and Policies

To invite other members to the site or the Back Office, User needs to have `User:Invite` permission added to his Role.
You can limit the ability to invite other members to the specific User Groups, 
e.g. Editors, or to the specific Roles within the group, e.g. Admin, Buyer.

## Creating and sending invitations

Invitations are created with [InvitationService](https://github.com/ibexa/user/blob/main/src/lib/Invitation/InvitationService.php),
but sending them requires additional setup.
[[= product_name =]] provides you with `Ibexa\User\Invitation\MailSender` implementation of
`InvitationSender` interface for sending invitations via email.
If you want to send invitations through different channels, you will need to create a custom setup.

## Invitations and registration forms templates

## Semantic configuration

To set up custom templates for invitations or registration forms,
create a template file and inform the system, through configuration, when to use this template.

For example, use the following configuration:


```yaml
 ibexa:
   system:
      default: # configuration per siteaccess or siteaccess group
          user_invitation:
              hash_expiration_time: P7D
              templates:
                  mail: "@@App/invitation/mail.html.twig"
 ```

Here, you can specify which template should be used for the invitation mail,
and what should be the expiration time for an invitation link included in that mail.

## Configuration in YAML

You can also configure invitation templates in `user/src/bundle/Resources/config/ezplatform_default_settings.yaml`.
There, you can point to the specific forms and invitation email templates.

```yaml
# Invitation
ibexa.site_access.config.site.user_invitation.templates.form: "@@IbexaUser/invitation/form.html.twig"
ibexa.site_access.config.site.user_invitation.templates.mail: "@@IbexaUser/invitation/mail/user_invitation.html.twig"
```

For all those parameters, you might also set a SiteAccess, to which the new user will be invited to, for example, site frontend:

```yaml
ibexa.site_access.config.site.user_invitation.templates.form: "@@IbexaUser/invitation/site_user_form.html.twig"
ibexa.site_access.config.site.user_invitation.templates.mail: "@@IbexaUser/invitation/mail/site_user_invitation.html.twig"
```

If the Site Access is not set, it will fall back to a default value.

## Expiring and refreshing invitations

You can configure expiration time for an invitation link in `user/src/bundle/Resources/config/ezplatform_default_settings.yaml` under an Invitation section.

```yaml
# Invitation
ibexa.site_access.config.default.user_invitation.hash_expiration_time: 'P7D'
```
If a User does not manage to click the invitation link sent to him, you can refresh the invitation.
Refresh resets the time limit and a hash in the invitation link.
