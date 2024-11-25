---
description: Installation of standalone Ibexa CDP package.
edition: experience
---

# [[= product_name_cdp =]] installation

There are three steps required to install [[= product_name_cdp =]].
First, you need to register your [[= product_name_cdp =]] account, then you can download a CDP package and update the configuration.

## Register in [[= product_name_cdp =]] dashboard

If you decide to acquire [[= product_name_cdp =]] contact your sales representative, they provide you with a registration link to [[= product_name_cdp =]].
After registration, you get access to a separate instance where you can find data required for configuring, activating, and using this feature.

## Install CDP package

[[= product_name_cdp =]] comes in an additional package that is opt-in and needs to be downloaded separately.

To download it run:

```bash
composer require ibexa/cdp
```

Flex installs and activates the package.
After an installation process is finished, go to `config/packages/security.yaml` and uncomment `ibexa_cdp` rule.

```yaml
ibexa_cdp:
    pattern: /cdp/webhook
    guard:
        authenticator: 'Ibexa\Cdp\Security\CdpRequestAuthenticator'
    stateless: true
```

Now, you can configure [[= product_name_cdp =]].
Go to [the activation documentation](cdp_activation.md) and follow the steps.
