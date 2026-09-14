# User field type

This field type validates and stores information about a user.

| Name   | Internal name |
|--------|---------------|
| `User` | `ibexa_user`  |

## Field value

The field value is an object with the following keys, or `null` when the field is empty:

| Key                 | Type              | Description                                                                | Example                  |
|---------------------|-------------------|----------------------------------------------------------------------------|--------------------------|
| `hasStoredLogin`    | `boolean`         | Denotes if the user has a stored login.                                    | `true`                   |
| `contentId`         | `integer`         | ID of the content item corresponding to the user.                          | `144`                    |
| `login`             | `string`          | Username.                                                                  | `jay.kowalski`           |
| `email`             | `string`          | The user's email address.                                                  | `jay.kowalski@email.invalid` |
| `passwordUpdatedAt` | `integer`, `null` | Unix timestamp of the last password change.                                | `1682691427`             |
| `enabled`           | `boolean`         | Whether the user account is enabled.                                       | `false`                  |
| `maxLogin`          | `integer`         | Maximum number of concurrent logins.                                       | `5`                      |
| `plainPassword`     | `string`, `null`  | Write-only. Set it to assign a new password. It's never returned on output. | `null`                   |

``` json
{
    "fieldDefinitionIdentifier": "user",
    "languageCode": "eng-GB",
    "fieldValue": {
        "hasStoredLogin": true,
        "contentId": 144,
        "login": "jay.kowalski",
        "email": "jay.kowalski@email.invalid",
        "passwordUpdatedAt": 1682691427,
        "enabled": false,
        "maxLogin": 5,
        "plainPassword": null
    }
}
```

!!! note "Password hashes are never exposed"

    The password hash and the hashing algorithm are stripped from the field value before it's returned.
    Provide new passwords through the `plainPassword` key.

## Validation

The field type supports `PasswordValueValidator`, defining the password policy:

| Name                                        | Type      | Default value | Description                                                             |
|---------------------------------------------|-----------|---------------|---------------------------------------------------------------------------|
| `requireAtLeastOneUpperCaseCharacter`       | `integer` | `1`           | Minimum number of required upper case characters.                       |
| `requireAtLeastOneLowerCaseCharacter`       | `integer` | `1`           | Minimum number of required lower case characters.                       |
| `requireAtLeastOneNumericCharacter`         | `integer` | `1`           | Minimum number of required numeric characters.                          |
| `requireAtLeastOneNonAlphanumericCharacter` | `integer` | `null`        | Minimum number of required non-alphanumeric characters.                 |
| `requireNewPassword`                        | `integer` | `null`        | Number of previous passwords that the new password must differ from.    |
| `requireNotCompromisedPassword`             | `boolean` | `false`       | When `true`, the password is checked against known compromised passwords. |
| `minLength`                                 | `integer` | `10`          | Minimum password length.                                                |

``` json
{
    "validatorConfiguration": {
        "PasswordValueValidator": {
            "requireAtLeastOneUpperCaseCharacter": 1,
            "requireAtLeastOneLowerCaseCharacter": 1,
            "requireAtLeastOneNumericCharacter": 1,
            "minLength": 10
        }
    }
}
```

## Settings

| Name                 | Type      | Default value | Description                                                                    |
|----------------------|-----------|---------------|----------------------------------------------------------------------------------|
| `PasswordTTL`        | `integer` | `null`        | Number of days after which the password expires.                               |
| `PasswordTTLWarning` | `integer` | `null`        | Number of days before password expiry when the user starts getting a warning. |
| `RequireUniqueEmail` | `boolean` | `true`        | When `true`, the email address must be unique across users.                   |
| `UsernamePattern`    | `string`  | `"^[^@]+$"`   | Regular expression that the username must match.                              |

``` json
{
    "fieldSettings": {
        "PasswordTTL": 90,
        "PasswordTTLWarning": 14,
        "RequireUniqueEmail": true,
        "UsernamePattern": "^[^@]+$"
    }
}
```
