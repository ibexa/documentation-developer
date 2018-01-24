# Conclusion

## Potential improvements and bugs

We now have a basic interface but it already has some bugs and it could be improved in a lots of ways. Here is a list of things that are left as exercises:

- Improve the look and feel and output: it's partially of done in commit [13d5a0b2](https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle/commit/13d5a0b2f4d957425a751a2cc4cbd6566ed0b57a) but can probably improved further.
- Reload only the table, not the full view when filtering.
- Sorting.
- More filters, more columns, etc.
- The server side code deserves to be refactored.
- Unit tests.
- **\[bug\]** Highlight is buggy in navigation because we have several routes while the navigation item added in [Configure the navigation](5_configure_the_navigation.md) only recognizes the first route we add.
- **\[bug\]** 'eng-GB' hard-coded when getting Content Type name.

## Documentation pages to go further

This tutorial talks and uses a lots of concepts coming from Symfony, eZ Platform, PlatformUI itself or YUI. Here is a list of documentation pages that are worth reading to completely understand what's going on behind the scenes:

### Symfony-related documentation pages

- From a Symfony point of view, in this tutorial we mainly wrote a controller and with the associated routing configuration, [the Controller book page](http://symfony.com/doc/current/book/controller.html) is definitively the most important Symfony related page to read
- We also defined a Controller as a service in this tutorial, this is detailed in [How to Define Controllers as Services](http://symfony.com/doc/current/cookbook/controller/service.html).
- [Twig for Template Designers](http://twig.sensiolabs.org/doc/templates.html) explains how to write Twig templates

### eZ Platform-related documentation pages

- The Public API is described in both the [Public API basics page](../../api/public_php_api.md#getting-started-with-the-public-api) and in [the Public API Cookbook](../../api/public_php_api.md#public-api-guide).
- For any usage beyond what is covered in those pages, you can refer to [the auto-generated API doc](http://apidoc.ez.no/sami/trunk/NS/html/index.html).
- While extending PlatformUI, you'll also have to work with the [REST API which has its own section in the documentation](../../api/rest_api_guide.md).
- There is also [an auto-generated API doc for the JavaScript REST Client](http://ezsystems.github.io/javascript-rest-client/).

### PlatformUI-related documentation pages

- [The PlatformUI technical introduction](../../guide/architecture.md) gives an overview of the architecture and explains some its concepts.
- PlaformUI also has [an auto-generated API doc](http://ezsystems.github.io/platformui-javascript-api/).

### YUI-related documentation pages

The whole YUI documentation could be useful when working with PlatformUI, but amongst others things here is a list of the most important pages:

- For the very low level foundations, the guides about [Attribute](http://yuilibrary.com/yui/docs/attribute/) and [Base](http://yuilibrary.com/yui/docs/base/) (almost everything in PlatformUI is YUI Base object with attributes), [EventTarget](http://yuilibrary.com/yui/docs/event-custom/) (custom events) and [Plugin](http://yuilibrary.com/yui/docs/plugin/) (for tweaking almost any PlatformUI components) can be very useful
- A large part of the application is about manipulating the DOM and subscribing to DOM events, this is covered in the [Node](http://yuilibrary.com/yui/docs/node/) and [DOM Events](http://yuilibrary.com/yui/docs/event/) guides.
- The PlatformUI Application is based on the YUI App Framework which itself is mainly described in [the App Framework](http://yuilibrary.com/yui/docs/app/), [Router](http://yuilibrary.com/yui/docs/router/) and [View](http://yuilibrary.com/yui/docs/view/) guides.

------

⬅ Previous: [Filter by Content Type](8_filter_by_content_type.md)
