# User field type

This field type validates and stores information about a user.

| Name   | Internal name | Expected input |
|--------|---------------|----------------|
| `User` | `ibexa_user`  | ignored        |

## PHP API field type

### Value object

| Property           | Type      | Description                                                                                                                                      | Example                                           |
|--------------------|-----------|--------------------------------------------------------------------------------------------------------------------------------------------------|---------------------------------------------------|
| `hasStoredLogin`   | `boolean` | Denotes if user has stored login.                                                                                                                | `true`                                            |
| `contentId`        | `int      | string`                                                                                                                                          | ID of the content item corresponding to the user. |`42`|
| `login`            | `string`  | Username.                                                                                                                                        | `john`                                            |
| `email`            | `string`  | The user's email address.                                                                                                                        | `john@smith.com`                                  |
| `passwordHash`     | `string`  | Hash of the user's password.                                                                                                                     | `1234567890abcdef`                                |
| `passwordHashType` | `mixed`   | Algorithm user for generating password hash as a `PASSWORD_HASH_*` constant defined in `Ibexa\Contracts\Core\Repository\Values\User\User` class. | `User::PASSWORD_HASH_PHP_DEFAULT`                 |
| `maxLogin`         | `int`     | Maximum number of concurrent logins.                                                                                                             | `1000`                                            |

##### Available password hash types

| Constant                                                                      | Description                                                               |
|-------------------------------------------------------------------------------|---------------------------------------------------------------------------|
| `Ibexa\Contracts\Core\Repository\Values\User\User::DEFAULT_PASSWORD_HASH`     | Default password hash, used when none is specified, may change over time. |
| `Ibexa\Contracts\Core\Repository\Values\User\User::PASSWORD_HASH_PHP_DEFAULT` | Passwords hashed by PHP's default algorithm, which may change over time.  |
| `Ibexa\Contracts\Core\Repository\Values\User\User::PASSWORD_HASH_BCRYPT`      | Bcrypt hash of the password.                                              |
