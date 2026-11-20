# Ibexa CDP installation

Installation of standalone Ibexa CDP package.

Editions: Experience

There are three steps required to install Ibexa CDP. First, you need to register your Ibexa CDP account, then you can download a CDP package and update the configuration.

## Register in Ibexa CDP dashboard

If you decide to acquire Ibexa CDP, contact your sales representative to receive a registration link to Ibexa CDP. After registration, you get access to a separate instance where you can find data required for configuring, activating, and using this feature.

## Install CDP package

Ibexa CDP comes in an additional package that is opt-in and needs to be downloaded separately.

To download it run:

```bash
composer require ibexa/cdp
```

Symfony Flex installs and activates the package. After an installation process is finished, go to `config/packages/security.yaml` and uncomment `ibexa_cdp` rule.

```yaml
security:
    firewalls:
        # ...
        ibexa_cdp:
            request_matcher: Ibexa\Cdp\Security\RequestMatcher
            custom_authenticators:
                - 'Ibexa\Cdp\Security\CdpRequestAuthenticator'
            stateless: true
```

Now, you can configure Ibexa CDP. Go to [the activation documentation](../cdp_activation/cdp_activation/index.md) and follow the steps.
