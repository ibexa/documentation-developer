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

    Using the MD5-based deprecated hash types is a security risk, because if the hashes are leaked, they are too easily broken by brute-force attacks.
    The plaintext type offers no security. It was only ever intended for testing, and should never be used now.

    We strongly recommend switching to one of the new hash types. If you do, it will be used for new users.
    Existing users will also have their hashes updated to the new type when they log in.
    (A mass update of all hashes is not possible, because this requires knowing the passwords, which only the users themselves do.)

    Removal notice: https://doc.ibexa.co/en/latest/releases/ez_platform_v3.0_deprecations/#password-hashes
