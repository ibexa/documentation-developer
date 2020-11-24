# Caching FAQ [[% include 'snippets/commerce_badge.md' %]]

## Basket preview and the box showing the logged-in user are not up to date

This can be caused by invalid cache purge configuration.

Check if the `purge_type` setting in `ezplatform.yml` is set correctly:

``` yaml
ezpublish:
    http_cache:
        purge_type: local
```

`local` means Symfony proxy is used.
If Varnish or a CDN is used, set `purge_type` to `http`.
