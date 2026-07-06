---
description: TODO.
---

# Security advisories

## Ibexa security advisories

Ibexa security advisories are released via [your Service portal](https://support.ibexa.co/), or via [Security advisories](https://developers.ibexa.co/security-advisories) if you're not a subscriber.

## Package security advisories

Overall, it's recommended to keep your Composer packages up to date.

You can run the following command to check for available updates without installing them:

```bash
composer update --dry-run
```

When a security issue is discovered on a Composer package, a security advisory is emitted, and the disrecommended affected versions of the package can't be installed without action.

When installing or updating, Composer avoids the installation of packages that are affected by security advisories.
But there might be some constraint issues making the installation or update impossible.
For example, security fixes might not be deployed for [unsupported PHP versions](https://www.php.net/supported-versions.php).

Example of a Composer output about a package with security issues when trying to install:

```text
- Root composer.json requires twig/cssinliner-extra v3.11.0 (exact version match), found twig/cssinliner-extra[v3.11.0] but these were not loaded, because they are affected by security advisories ("PKSA-fs5b-x5k4-1h39").
```

Composer output isn't always as verbose about security advisories blocking installation or update.

For example, imagine this error appeared recently when trying to install Ibexa DXP 4.6 on PHP 7.4:

```text
- ibexa/user[v4.6.0, ..., v4.6.31] require twig/twig ^3.0 -> satisfiable by twig/twig[v3.27.0, v3.27.1, v3.28.0].
- twig/twig[v3.27.0, ..., v3.28.0] require php >=8.1.0 -> your php version (7.4.33) does not satisfy that requirement.
```

It was working before. You can check about the package on packagist.org, or on an already running Ibexa DXP what version of this package was previously accepted.

In this example, [`twig/twig` v3.11.3](https://packagist.org/packages/twig/twig#v3.11.3) matches the constraints.
```terminal
% composer require twig/twig:3.11.3
Your requirements could not be resolved to an installable set of packages.

  Problem 1
    - Root composer.json requires twig/twig 3.11.3 (exact version match: 3.11.3 or 3.11.3.0), found twig/twig[v3.11.3] but these were not loaded, because they are affected by security advisories ("PKSA-8zx5-v2nz-58pb").
```

It's highly recommended to not install affected package and meet the requirements of the fixed versions.

You can use https://packagist.org/security-advisories/ resource to know more about a security advisory, like the affected packages and versions, detailed issue, or the other possible reference IDs for the advisory - PKSA (Packagist Security Advisory), GHSA (GitHub Security Advisories), CVE (Common Vulnerabilities and Exposures)

If you need to, upgrade PHP, and migrate custom code to be compatible with higher version of PHP, for example by using [Rector](https://github.com/rectorphp/rector).

If updating the affected package isn't possible, review the security issues carefully and assess the danger.
If you choose to implement countermeasures without upgrading requirements, you can ignore the security advisory.
We recommand to use Composer [config.policy.advisories.ignore-id](https://getcomposer.org/doc/06-config.md#ignore-id) setting with for each entry the reason why you allow yourself to ignore it.
This way, if a package is affected by a new security advisory, you are warned.

```json
{
    "config": {
        "policy": {
            "advisories": {
                "ignore-id": {
                    "PKSA-fs5b-x5k4-1h39": "Description of the countermeasures you've implemented causing this one to be safe to ignore.",
                    "PKSA-8zx5-v2nz-58pb": "Description of the countermeasures you've implemented causing this one to be safe to ignore."
                }
            }
        }
    }   
}
```
