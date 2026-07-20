---
description: Find [[= product_name_base =]] security advisories, and learn how to handle Composer package security advisories.
---

# Security advisories

## [[= product_name_base =]] security advisories

[[= product_name_base =]] security advisories are released via [your Service portal](https://support.ibexa.co/), and via [Security advisories](https://developers.ibexa.co/security-advisories). The latter is available to non-subscribers.

## Package security advisories

Overall, it's recommended to keep your Composer packages up to date.

You can run the following command to check for available updates without installing them:

```bash
composer update --dry-run
```

When a security issue is discovered in a Composer package, a security advisory is issued, and the affected versions of the package become blocked from installation unless you take action.

When installing or updating, Composer avoids installing packages that are affected by security advisories.
However, this can create constraint issues that make installation or updates impossible.
For example, security fixes might not be available for [unsupported PHP versions](https://www.php.net/supported-versions.php).

Example of a Composer output about a package with security issues when trying to install:

```text
- Root composer.json requires twig/cssinliner-extra v3.11.0 (exact version match),
  found twig/cssinliner-extra[v3.11.0] but these were not loaded, because they are
  affected by security advisories ("PKSA-fs5b-x5k4-1h39").
```

Composer's output doesn't always mention that a security advisory is blocking installation or updates.

For example, when trying to install [[= product_name =]] 4.6 on PHP 7.4 you might see an error like the following one:

```text
- ibexa/user[v4.6.0, ..., v4.6.31] require twig/twig ^3.0 -> satisfiable by twig/twig[v3.27.0, v3.27.1, v3.28.0].
- twig/twig[v3.27.0, ..., v3.28.0] require php >=8.1.0 -> your php version (7.4.33) does not satisfy that requirement.
```

To gather more information, check package information on [Packagist](https://packagist.org/) and try installing a specific version of the package blocking installation.

In this case, trying to install [`twig/twig:3.11.3`](https://packagist.org/packages/twig/twig#v3.11.3) shows explicitly that this version is blocked by a security advisory:
```terminal
% composer require twig/twig:3.11.3
Your requirements could not be resolved to an installable set of packages.

  Problem 1
    - Root composer.json requires twig/twig 3.11.3 (exact version match: 3.11.3 or 3.11.3.0),
      found twig/twig[v3.11.3] but these were not loaded, because they are affected by
      security advisories ("PKSA-8zx5-v2nz-58pb").
```

It's highly recommended that you not install the affected package, and instead meet the requirements of the fixed version.

You can use the [Packagist Security Advisories database](https://packagist.org/security-advisories/) to learn more about a security advisory, such as the affected packages and versions, a detailed description of the issue, and other possible reference IDs for the advisory: PKSA (Packagist Security Advisory), GHSA (GitHub Security Advisories), and CVE (Common Vulnerabilities and Exposures).

If you need to, upgrade PHP and migrate your custom code to be compatible with the newer PHP version, for example by using [Rector](https://github.com/rectorphp/rector).

If updating the affected package isn't possible, carefully review the security issue and assess the risk.
If you choose to implement countermeasures instead of upgrading, you can ignore the security advisory.
Use Composer's [`config.policy.advisories.ignore-id`](https://getcomposer.org/doc/06-config.md#ignore-id) setting, providing for each entry the reason why you consider it safe to ignore.
This way, you'll still be warned if the package is affected by a new security advisory.

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
