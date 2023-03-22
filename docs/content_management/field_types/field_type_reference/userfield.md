# User Field Type

This Field Type validates and stores information about a user.

| Name   | Internal name | Expected input |
|--------|---------------|----------------|
| `User` | `ezuser`      | ignored        |

## PHP API Field Type

### Value Object

|Property|Type|Description|Example|
|------|------|------|------|
|`hasStoredLogin`|`boolean`|Denotes if user has stored login.|`true`|
|`contentId`|`int|string`|ID of the Content item corresponding to the user.|`42`|
|`login`|`string`|Username.|`john`|
|`email`|`string`|The user's email address.|`john@smith.com`|
|`passwordHash`|`string`|Hash of the user's password.|`1234567890abcdef`|
|`passwordHashType`|`mixed`|Algorithm user for generating password hash as a `PASSWORD_HASH_*` constant defined in `Ibexa\Contracts\Core\Repository\Values\User\User` class.|`User::PASSWORD_HASH_PHP_DEFAULT`|
|`maxLogin`|`int`|Maximum number of concurrent logins.|`1000`|

##### Available password hash types

|Constant|Description|
|------|------|
|`Ibexa\Contracts\Core\Repository\Values\User\User::DEFAULT_PASSWORD_HASH`|Default password hash, used when none is specified, may change over time.|
|`Ibexa\Contracts\Core\Repository\Values\User\User::PASSWORD_HASH_PHP_DEFAULT`|Passwords hashed by PHP's default algorithm, which may change over time.|
|`Ibexa\Contracts\Core\Repository\Values\User\User::PASSWORD_HASH_BCRYPT`|Bcrypt hash of the password.|

!!! caution

    Old password hash types like MD5 have numerical hash type value from 1 to 5. These types were deprecated in v1.13 and removed in v3.0.
    Between v1.13 and v3.0 it was possible to update hashes automatically when users logged in.
    Since v3.0, login is only possible with hash type 6 or larger. Automatic updates of older types on login are not possible anymore.
    A mass migration of all hashes has never been possible, because this would require knowing the passwords, which only users themselves do.
    Users who still have an old, unsupported password hash type can request a new, valid password using the "Forgot password" feature.

    Removal notice: https://doc.ibexa.co/en/latest/release_notes/ez_platform_v3.0_deprecations/#password-hashes
