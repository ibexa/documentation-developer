# Languages

## Language versions

eZ Platform offers the ability to create multiple language versions (translations) of a Content item.
Translations are created per version of the item, so each version of the content can have a different set of translations.

A version always has at least one translation which by default is the *initial/main* translation. Further versions can be added, but only for languages that have previously been [added to the global translation list](#adding-available-languages), that is a list of all languages available in the system. The maximum number of languages in the system is 64.

Different translations of the same Content item can be edited separately. This means that different users can work on translations into different languages at the same time.

### Adding available languages

The multilanguage system operates based on a global translation list that contains all languages available in the installation. Languages can be [added to this list from the Admin Panel](https://doc.ezplatform.com/projects/userguide/en/latest/creating_content_advanced/#languages) in the Back Office. After adding a language be sure to dump all assets to the file system:

```
php bin/console assetic:dump
yarn encore <environment>
# OR php bin/console ezplatform:encore:compile
```

**The new language must then be added to the [SiteAccess](siteaccess.md) configuration**. Once this is done, any user with proper permissions can create Content item versions in these languages in the user interface.

### Translatable and untranslatable Fields

Language versions consist of translated values of the Content item's Fields. In the Content Type definition every Field is set to be Translatable or not.

eZ Platform does not decide by itself which Fields can be translated and which cannot. For some Field values the need for a translation can be obvious, for example for the body of an article. In other cases, for instance images without text, integer numbers or e-mail addresses, translation is usually unnecessary. Despite that, eZ Platform gives you the possibility to mark any Field as translatable regardless of its Field Type. It is only your decision to exclude the translation possibility for those Fields where it makes no sense.

When a Field is not flagged as Translatable, its value will be copied from the initial/main translation when a new language version is created. This copied value cannot be modified. When a Field is Translatable, you will have to enter its value in a new language version manually.

For example, let's say that you need to store information about marathon contestants and their results. You build a "contestant" Content Type using the following Fields: name, photo, age, nationality, finish time. Allowing the translation of anything other than nationality would be pointless, since the values stored by the other Fields are the same regardless of the language used to describe the contestant. In other words, the name, photo, age and finish time would be the same in, for example, both English and Norwegian.

### Access control

You can control whether a User or User group is able to translate content or not. You do this by adding a [Language Limitation](limitation_reference.md#language-limitation) to Policies that allow creating or editing content. This limitation enables you to define which Role can work with which languages in the system. (For more information of the permissions system, see [Permissions](permissions.md).)

In addition, you can also control the access to the global translation list by using the Content/Translations Policy. This Policy allows users to add and remove languages from the global translation list.

## Exposing translations to the user

Once more than one language is defined in the global translation list and there is content in different languages, the question is how can this be exposed to use by the visitor. There are two ways to do this:

1. Implement a mechanism called [language switcher](#language-switcher). It lets you create links to switch between different translations of a Content item.
1. If you want to have completely separate versions of the website, each with content in its own language, you can [use SiteAccesses](#using-siteaccesses-for-handling-translations). In this case, depending on the URI used to access the website, a different site will open, with a language set in configuration settings. All Content items will then be displayed in this language.

## Language switcher

When viewing a Content item, it may be useful to let the user switch from one translation to another, more appropriate to them. This is precisely the goal of the language switcher.

The language switcher relies on the [Cross-SiteAccess linking feature](siteaccess.md#cross-siteaccess-links) to generate links to the Content item's translation, and on RouteReference feature.

#### In a template

To generate a language switch link, you need to generate the `RouteReference`, with the `language` parameter. This can easily be done with the `ez_route()` Twig function:

``` html+twig
{# Given that "location" variable is a valid Location object #}
<a href="{{ url( ez_route( location, {"language": "fre-FR"} ) ) }}">{{ ez_content_name( content ) }}</a>

{# Generating a link to a declared route instead of Location #}
<a href="{{ url( ez_route( 'my_route', {"language": "fre-FR"} ) ) }}">My link</a>
```

You can also omit the route, in this case, the current route will be used (i.e. switch the current page):

``` html+twig
{# Using Twig named parameters #}
<a href="{{ url( ez_route( params={"language": "fre-FR"} ) ) }}">My link</a>

{# Identical to the following, using ordered parameters #}
<a href="{{ url( ez_route( null, {"language": "fre-FR"} ) ) }}">My link</a>
```

### Using sub-requests

When using sub-requests, you lose the context of the master request (e.g. current route, current location, etc.). This is because sub-requests can be displayed separately, with [ESI](templates.md#rendering-and-cache).

If you want to render language switch links in a sub-request with a correct `RouteReference`, you must pass it as an argument to your sub-controller from the master request.

``` html+twig
{# Render the language switch links in a sub-controller #}
{{ render( controller( 'AcmeTestBundle:Default:languages', {'routeRef': ez_route()} ) ) }}
```

``` php
namespace Acme\TestBundle\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use eZ\Publish\Core\MVC\Symfony\Routing\RouteReference;

class DefaultController extends Controller
{
    public function languagesAction( RouteReference $routeRef )
    {
        return $this->render( 'AcmeTestBundle:Default:languages.html.twig', [ 'routeRef' => $routeRef ] );
    }
}
```

``` html+twig
{# languages.html.twig #}

{# Looping over all available languages to display the links #}
{% for lang in ezpublish.availableLanguages %}
    {# This time, alter the "siteaccess" parameter directly. #}
    {# You get the right SiteAccess with the help of ezpublish.translationSiteAccess() helper #}
    {% do routeRef.set( "siteaccess", ezpublish.translationSiteAccess( lang ) ) %}
    <a href="{{ url( routeRef ) }}">{{ lang }}</a><br />
{% endfor %}
```

- `ezpublish.translationSiteAccess( language )` returns the SiteAccess name for provided language (or `null` if it cannot be found)
- `ezpublish.availableLanguages()` returns the list of available languages.

### Using PHP

You can generate language switch links from PHP too, with the `RouteReferenceGenerator` service:

``` php
// Assuming you're in a controller
/** @var \eZ\Publish\Core\MVC\Symfony\Routing\Generator\RouteReferenceGeneratorInterface $routeRefGenerator */
$routeRefGenerator = $this->get( 'ezpublish.route_reference.generator' );
$routeRef = $routeRefGenerator->generate( $location, [ 'language' => 'fre-FR' ] );
$link = $this->generateUrl( $routeRef );
```

You can also retrieve all available languages with the `TranslationHelper`:

``` php
/** @var \eZ\Publish\Core\Helper\TranslationHelper $translationHelper */
$translationHelper = $this->get( 'ezpublish.translation_helper' );
$availableLanguages = $translationHelper->getAvailableLanguages();
```

## Using SiteAccesses for handling translations

Another way of using multiple languages is setting up a separate SiteAccess for each language.

### Explicit *translation SiteAccesses*

Configuration is not mandatory, but can help to distinguish which SiteAccesses can be considered *translation SiteAccesses*.

``` yaml
# ezplatform.yml

ezpublish:
    siteaccess:
        default_siteaccess: eng
        list:
            - site
            - eng
            - fre
            - site_admin

        groups:
            frontend_group:
                - site
                - eng
                - fre

    # ...

    system:
        # Specifying which SiteAccesses are used for translation
        frontend_group:
            translation_siteaccesses: [fre, eng]
        eng:
            languages: [eng-GB]
        fre:
            languages: [fre-FR, eng-GB]
        site:
            languages: [eng-GB]
```

!!! note

    The top prioritized language is always used the SiteAccess language reference (e.g. `fre-FR` for `fre` SiteAccess in the example above).

If several translation SiteAccesses share the same language reference, **the first declared SiteAccess always applies**.

#### Custom locale configuration

If you need to use a custom locale, you can configure it in `ezplatform.yml`, adding it to the *conversion map*:

``` yaml
ezpublish:
    # Locale conversion map between eZ Publish format (e.g. fre-FR) to POSIX (e.g. fr_FR).
    # The key is the eZ Publish locale. Check locale.yml in EzPublishCoreBundle to see natively supported locales.
    locale_conversion:
        eng-DE: en_DE
```

A locale *conversion map* example [can be found in the `core` bundle, on `locale.yml`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/config/locale.yml).

### More complex translation setup

There are some cases where your SiteAccesses share settings (repository, content settings, etc.), but you don't want all of them to share the same `translation_siteaccesses` setting. This can be for example the case when you use separate SiteAccesses for mobile versions of a website.

The solution is defining new groups:

``` yaml
# ezplatform.yml

ezpublish:
    siteaccess:
        default_siteaccess: eng
        list:
            - site
            - eng
            - fre
            - mobile_eng
            - mobile_fre
            - site_admin

        groups:
            # This group can be used for common front settings
            common_group:
                - site
                - eng
                - fre
                - mobile_eng
                - mobile_fre

            frontend_group:
                - site
                - eng
                - fre

            mobile_group:
                - mobile_eng
                - mobile_fre

    # ...

    system:
        # Translation SiteAccesses for regular frontend
        frontend_group:
            translation_siteaccesses: [fre, eng]

        # Translation SiteAccesses for mobile frontend
        mobile_group:
            translation_siteaccesses: [mobile_fre, mobile_eng]

        eng:
            languages: [eng-GB]
        fre:
            languages: [fre-FR, eng-GB]
        site:
            languages: [eng-GB]

        mobile_eng:
            languages: [eng-GB]
        mobile_fre:
            languages: [fre-FR, eng-GB]
```

### Using implicit *related SiteAccesses*

If the `translation_siteaccesses` setting is not provided, implicit *related SiteAccesses* will be used instead. SiteAccesses are considered *related* if they share:

- The same repository
- The same root `location_id` (see [Multisite](multisite.md))

### Fallback languages and missing translations

When setting up SiteAccesses with different language versions, you can specify a list of preset languages for each SiteAccess. When this SiteAccess is used, the system will go through this list. If a Content item is unavailable in the first (prioritized) language, it will attempt to use the next language in the list, and so on. Thanks to this you can have a fallback in case of a lacking translation.

You can also assign a Default content availability flag to Content Types (available in the Admin Panel). When this flag is assigned, Content items of this type will be available even when they do not have a language version in any of the languages configured for the current SiteAccess.

Note that if a language is not provided in the list of prioritized languages and it is not the Content item's first language, the URL alias for this content in this language will not be generated.

## Back Office languages

### Installing new UI translations

If you want to install a new language in your project, install the corresponding package.

For example, if you want to translate your application into French, run:

`composer require ezplatform-i18n/ezplatform-i18n-fr_fr`

and then clear the cache.

Now you can reload your eZ Platform back end which will be translated in French (if your browser is configured to `fr_FR`.)

!!! tip

    If you do not want to add a bundle with Back Office translation, you can manually add the necessary xliff files.
    Add the language to an array under `ezpublish.system.<siteaccess>.user_preferences.additional_translations`, for example:

    `ezpublish.system.<siteaccess>.user_preferences.additional_translations: ['pl_PL', 'fr_FR']`

    Then, run `composer run post-update-cmd` and clear the cache.

##### Contributing Back Office translations

To learn how to contribute to a translation, see [Contributing translations](../community_resources/translations.md).

### Choosing language of the Back Office

Once you have language packages installed, you can switch the language of the Back Office
in the User Settings menu.

Otherwise, the language will be selected based on the browser language.
If you do not have a language defined in the browser, the language will be selected
based on `parameters.locale_fallback` in `default_parameters.yml`
