---
description: Manage user invitations to create an account in the frontend or the Back Office.
---

# Inviting users

[[= product_name =]] allows you to create and send invitations to create an account in
the frontend as a customer, the Back Office as an employee, or the Corporate Portal as an organisation member.
You can send invitations to individual users or in bulk.

## Roles and Policies

To invite other members to the site or the Back Office, a user needs to have the `User:Invite` permission added to their Role.
You can limit the ability to invite other members to specific User Groups, 
such as Editors, or to the specific Roles within the group, for example: Admin, Buyer.

## Creating and sending invitations

Invitations are created with [InvitationService](https://github.com/ibexa/user/blob/main/src/lib/Invitation/InvitationService.php),
but sending them requires additional setup.
[[= product_name =]] provides you with `Ibexa\User\Invitation\MailSender` implementation of
`InvitationSender` interface for sending invitations via email.
If you want to send invitations through different channels, you will need to create a custom setup.

## Invitation and registration form templates

### Semantic configuration

To set up custom templates for invitation or registration forms,
create a template file and inform the system, through configuration, when to use this template.

For example, use the following configuration:


```yaml
 ibexa:
     system:
         <scope>:
             user_invitation:
                 hash_expiration_time: P7D
                 templates:
                     mail: "@@App/invitation/mail.html.twig"
 ```

Here, you can specify which template should be used for the invitation mail,
and what should be the expiration time for the invitation link included in that mail.

### Configuration in YAML

This is not a recommended way of configuring templates, if you can, use the [semantic configuration](#semantic-configuration) from above.
You can also configure invitation templates in `user/src/bundle/Resources/config/ezplatform_default_settings.yaml`.
There, you can point to the specific forms and invitation email templates.

```yaml
# Invitation
ibexa.site_access.config.site.user_invitation.templates.form: "@@IbexaUser/invitation/form.html.twig"
ibexa.site_access.config.site.user_invitation.templates.mail: "@@IbexaUser/invitation/mail/user_invitation.html.twig"
```

For all those parameters, you might also set a SiteAccess, to which the new user will be invited, for example, site frontend:

```yaml
ibexa.site_access.config.site.user_invitation.templates.form: "@@IbexaUser/invitation/site_user_form.html.twig"
ibexa.site_access.config.site.user_invitation.templates.mail: "@@IbexaUser/invitation/mail/site_user_invitation.html.twig"
```

If the SiteAccess is not set, it falls back to the default value.

## Expiring and refreshing invitations

You can configure expiration time for an invitation link in `user/src/bundle/Resources/config/ezplatform_default_settings.yaml` under an Invitation section.

```yaml
# Invitation
ibexa.site_access.config.default.user_invitation.hash_expiration_time: 'P7D'
```

If a user does not click the invitation link sent to them in time, you can refresh the invitation.
Refresh resets the time limit and changes the hash in the invitation link.
