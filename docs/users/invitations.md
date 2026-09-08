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

Invitations are sent by email.
The invitation contains a link with a unique hash that lets the recipient create their account.

## Invitation expiration

The expiration time for the invitation link is set under the `user_invitation` [configuration key](configuration.md#configuration-files).
You might also set a SiteAccess under `scope`, to which the new user is invited.
If the SiteAccess isn't set, it falls back to the default `site` value.

```yaml
ibexa:
    system:
        <scope>:
            user_invitation:
                hash_expiration_time: P7D
```

If a user doesn't click the invitation link sent to them in time, you can refresh the invitation.
Refresh resets the time limit and changes the hash in the invitation link.
