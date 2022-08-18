# 4.1. Update templates

## Back-Office templates

The naming and location of templates in the Back Office have been changed.
If you extend or modify these templates, you need to adapt your code.

For the full list of template changes, see [the list of removals and deprecations](ez_platform_v3.0_deprecations.md#template-organization).

## Twig functions and filters

A number of [Twig functions, filters and helpers have been renamed](ez_platform_v3.0_deprecations.md#functions-renamed).
If your templates use them, you need to update them.

## Templating component

[The templating component integration is now deprecated.](https://symfony.com/blog/new-in-symfony-4-3-deprecated-the-templating-component-integration)
As a result, the way to indicate a template path has changed.

For example:

- **Use:** `"@@EzPlatformUser/user_settings/list.html.twig"` **instead of:** `"EzPlatformUserBundle:user_settings:list.html.twig"`
- **Use:** `{% extends "@EzPublishCore/content_fields.html.twig" %}` **instead of:** `{% extends "EzPublishCoreBundle::content_fields.html.twig" %}`

## Form templates

Content Type editing has been [moved from `repository-forms` to `ezplatform-admin-ui`](ez_platform_v3.0_deprecations.md#content-type-forms).

Forms for content creation have been [moved from `repository-forms` to `ezplatform-content-forms`](ez_platform_v3.0_deprecations.md#repository-forms).

If your templates extend any of those built-in templates, you need to update their paths.

## Deprecated controller actions

If your templates still use the deprecated `viewLocation` and `embedLocation` actions of `ViewController`,
you need to rewrite them to use `viewAction` and `embedAction` respectively.

## Referencing controller actions

To reference a controller, you now need to use `serviceOrFqcn::method` syntax instead of
`bundle:controller:action`:

**Use:** `controller: My\ExampleBundle\Controller\DefaultController::articleViewAction`

**Instead of:** `controller: AcmeExampleBundle:Default:articleView`
