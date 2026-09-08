# Manage users

You can view and manage user accounts in your system.

Users in Ibexa DXP are treated the same way as other content items. They're organized in groups, which helps you manage them and their permissions.

You can view all user groups and Users in the **Admin** panel by selecting **Users**. Here, you can manage users, their relations, roles, and policies. As you can see, the interface is the same as when working with regular content items.

> **Caution: Caution**
>
> If you are creating a new user group, remember to [exclude it in product tour configuration](https://doc.ibexa.co/en/5.0/administration/back_office/configure_product_tour#user-group-restrictions) if necessary.

![Users section](https://doc.ibexa.co/projects/userguide/en/5.0/user_management/img/users_section.png)

> **Caution: Caution**
>
> Be careful not to delete an existing user account. If you do this, content created by this user can be broken and the application can face malfunction.

## Register as a user

In most cases it's the administrator who invites users to log into the application. You can still access the registration form for the website by adding `/register` to the address, for example: `www.my-site.com/register`. By default, new users created in this way are placed in the Guest accounts group.

## Invite users

To invite users, go to **Admin** -> **Users** and click **Invite members** in the top right corner.

![Inviting users](https://doc.ibexa.co/projects/userguide/en/5.0/user_management/img/users_invitation.png)

To send invitations, fill out email addresses one by one, or use drag and drop to upload a file with an email list, then click **Send**.

Invited users then receive an email message with a registration link. With it, they can register and create their account in the frontend as customers or in the back office as members of the team.
