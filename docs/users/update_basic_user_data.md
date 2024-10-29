---
description: Update basic user account data from the console.
---

# Update basic user data from CLI

Multiple user management scenarios may result in having to update basic user account data, such as user status, the password, or email.
Especially, when a security breach occurs, you may need to revoke user access by disabling the account, or change the user's password.

You can do it without accessing the Admin UI, by running a console command.
You reference the user account with either user id or login.

## Disable or enable user account

To change the status of a user account, you must have the `user/activation` permission.

Disable the user account:

```bash
php bin/console ibexa:user:update-user --disable <user_reference>
```

Enable the user account:

```bash
php bin/console ibexa:user:update-user --enable <user_reference>
```

## Change password

To change the password, you must have the `user/password` permission.

Change the password associated with the user account:

```bash
php bin/console ibexa:user:update-user --password <user_reference>
```

After you run the command, enter the new password when prompted.
The command runs in silent mode and inputs are not echoed.

For more information about changing and revoking passwords, see [Passwords](passwords.md#revoking-passwords).

## Change email address

Change the email address associated with the user account:

```bash
php bin/console ibexa:user:update-user --email=<new_email_address> <user_reference>
```