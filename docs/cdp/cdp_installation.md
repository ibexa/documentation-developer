---
description: Installation of standalone Ibexa CDP package.
---

# Ibexa CDP installation

There are three steps required to install Ibexa CDP.
First, you need to register your Ibexa CDP account, then you can download a CDP package and update the configuration. 

## Register in Ibexa CDP dashboard

If you decide to acquire Ibexa CDP contact your sales representative,
they will provide you with a registration link to Ibexa CDP.
After registration, you will get access to a separate instance
where you will find data required for configuring, activating and using this feature.

## Install CDP package

Ibexa CDP comes in an additional package that is opt-in and needs to be downloaded separately.

To download it run:

```bash
composer require ibexa/cdp
```

Flex will install and activate the package.
After an installation process is finished, go to `config/packages/security.yaml`
and uncomment `ibexa_cdp` rule.

```yaml
ibexa_cdp:
    pattern: /cdp/webhook
    guard:
        authenticator: 'Ibexa\Cdp\Security\CdpRequestAuthenticator'
    stateless: true
```

Now, you can configure Ibexa CDP.
Go to [the activation documentation](cdp_activation.md) and follow the steps.
