---
description: You can create custom view matchers to configure template and controller usage for specific custom cases.
---

# Create custom view matcher

In addition to the [built-in view matchers](view_matcher_reference.md),
you can also create custom matchers to use in [template configuration](template_configuration.md#view-rules-and-matching).

To do it, create a matcher class that extends `Ibexa\Core\MVC\Symfony\Matcher\ContentBased\MultipleValued`.

## Matcher class

The matcher class must implement the following methods:

- `matchLocation` - checks if a Location object matches.
- `matchContentInfo` - checks if a ContentInfo object matches.
- `match` - checks if the View object matches.
- `setMatchingConfig` - receives the matcher's config from the view rule.

The following example shows how to implement an `Owner` matcher.
This matcher identifies Content items that have the provided owner or owners.

``` php hl_lines="44"
[[= include_file('code_samples/front/view_matcher/src/View/Matcher/Owner.php') =]]
```

The matcher checks whether the owner of the current content (by its ContentInfo or Location)
matches any of the values passed in configuration (line 44).

## Matcher service

You can configure your matcher as a service to have the opportunity to give him a matcher identifier easier to use than its fully qualified class name.
A matcher identifier is associated to its service using the `ibexa.view.matcher` tag as follows:

``` yaml
[[= include_file('code_samples/front/view_matcher/config/services.yaml') =]]
```

## View configuration

To apply the matcher in view configuration, indicate the matcher

- by its fully qualified class name (FQCN) preceded by `\`,
- or by its identifier.

The following configuration uses a special template to render articles owned by the users with provided logins
(the FQCN as been commented to prefer its identifier):

``` yaml
[[= include_file('code_samples/front/view_matcher/config/packages/views.yaml') =]]
```

!!! note

    If you use a matcher that is a service instead of a simple class,
    tag the service with `ibexa.view.matcher`.
