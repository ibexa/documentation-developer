---
description: Update basic user account data from the console.
---

# Update basic user data from CLI

Multiple user management scenarios may result in having to update basic user account data, such as user status, the password, or email.
Especially, you may need to revoke user access by disabling the account when offboarding an employee, or change the user's forgotten password.

You can do it without accessing the Admin UI, by running a console command.
You reference the user account by passing the user login.

## Disable or enable user account

Disable the user account:

```bash
php bin/console ibexa:user:update-user --disable <login>
```

For example:

```bash
php bin/console ibexa:user:update-user --disable johndoe
```

Enable the user account:

```bash
php bin/console ibexa:user:update-user --enable <login>
```

## Change password

Change the password associated with the user account:

```bash
php bin/console ibexa:user:update-user --password <login>
```

After you run the command, enter the new password when prompted.
The command runs in silent mode and inputs are not echoed.

For more information about changing and revoking passwords, for example, when a security breach occurs, see [Passwords](passwords.md#revoking-passwords).

## Change email address

Change the email address associated with the user account:

```bash
php bin/console ibexa:user:update-user --email=<new_email_address> <login>
```