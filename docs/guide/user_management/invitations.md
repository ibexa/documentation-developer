---
description: Managing user invitations to the frontend and the Back Office.
---

# Inviting Users

## Creating and sending invitations

You create invitations with [InvitationService](https://github.com/ibexa/user/blob/main/src/lib/Invitation/InvitationService.php), but sending them requires additional setup.
[[= product_name =]] only provides `InvitationSender` interface for sending invitations via email.
Sending invitations through different channels requires custom setup.

## Invitations templates

To configure invitations go to `user/src/bundle/Resources/config/ezplatform_default_settings.yaml`.
There, you can point to the specific form and invitation email templates.

```yaml
# Invitation
ibexa.site_access.config.default.user_invitation.templates.form: "@@IbexaUser/invitation/form.html.twig"
ibexa.site_access.config.default.user_invitation.templates.mail: "@@IbexaUser/invitation/mail/user_invitation.html.twig"
```

For all those parameters, you must also set a SiteAccess, to which the new user will be invited for example frontend:

```yaml
ibexa.site.config.default.user_invitation.templates.form: "@@IbexaUser/invitation/site_user_form.html.twig"
ibexa.site.config.default.user_invitation.templates.mail: "@@IbexaUser/invitation/mail/site_user_invitation.html.twig"
```

## Expiring and refreshing invitations

You can configure expiration time for invitation link in `user/src/bundle/Resources/config/ezplatform_default_settings.yaml` under Invitation section.

```yaml
# Invitation
ibexa.site_access.config.default.user_invitation.hash_expiration_time: 'P2D'
```
If a User does not manage to click the invitation link sent to him, you can refresh the invitation.
Refresh will reset the time limit on sent link.

## Roles and Policies

To invite other members to the site or the Back Office User needs to have `User:Invite` permission added to his Role.
You can limit the ability to invite other members to the specific User Groups e.g. Editors, or to the specific roles within the group e.g. Admin, Buyer.
