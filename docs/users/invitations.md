---
description: Manage user invitations to create an account in the frontend or the back office.
---

# Inviting users

[[= product_name =]] allows you to create and send invitations to create an account in the frontend as a customer, the back office as an employee, or the Corporate Portal as an organisation member.
You can send invitations to individual users or in bulk.

## Roles and policies

To invite other members to the site or the back office, a user needs to have the `User:Invite` permission added to their role.
You can limit the ability to invite other members to specific user groups, such as Editors, or to the specific roles within the group, for example: Admin, Buyer.

## Creating and sending invitations

Invitations are created with [InvitationService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-User-Invitation-InvitationService.html), but sending them requires additional setup.
[[= product_name =]] provides you with `Ibexa\User\Invitation\MailSender` implementation of `InvitationSender` interface for sending invitations via email.
If you want to send invitations through different channels, you need to create a custom setup.

## Invitation and registration form templates

### Semantic configuration

To set up custom templates for invitation or registration forms, create a template file and inform the system, through configuration, when to use this template.

You might also set a SiteAccess under `scope`, to which the new user is invited.
If the SiteAccess isn't set, it falls back to the default `site` value.

For example, use the following [configuration](configuration.md#configuration-files):

```yaml
 ibexa:
     system:
         <scope>:
             user_invitation:
                 hash_expiration_time: P7D
                 templates:
                     mail: "@@App/invitation/mail.html.twig"
```

Here, you can specify which template should be used for the invitation mail, and what should be the expiration time for the invitation link included in that mail.
If a user doesn't click the invitation link sent to them in time, you can refresh the invitation.
Refresh resets the time limit and changes the hash in the invitation link.

You can find more registration related templates in [Register new users documentation](user_registration.md#other-user-management-templates).
