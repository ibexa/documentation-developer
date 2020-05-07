# Bundles starter pack

eZ Platform application bundle system changed along with the [Symfony 5 bundle system](http://symfony.com/doc/5.0/book/bundles.html).
Clean installation comes with set of build in packages, which you can preview in [composer.json](https://github.com/ezsystems/ezplatform/blob/v3.0/composer.json).

For more information about eZ Platform bundle structure, see [Bundle section](../guide/bundles.md) in our Guide.

## External packages

If basic bundles do not give you enough flexibility or functionalities, you can extend your project with external packages.
They provide additional ways of customizing your installation, and can help you with Content management, further development,integrations, security, social engagement, and system management.

You can easily browse the external bundles and download them from [eZ Platform Packages](https://ezplatform.com/packages).
Refer to their respective pages for instructions on how to install them.

## Contributors

|Bundle|Description|
|------|-----------|
|[RepositoryProfilerBundle](https://github.com/ezsystems/RepositoryProfilerBundle)| profiles Platform API/SPI and sets up scenarios to be able to continuously test to keep track of performance regressions of repository and underlying storage engines|

## Educational

These bundles are not necessarily something you would install, but they are useful for learning process:

|Bundle|Description|
|------|-----------|
|[ezplatform-com](https://github.com/ezsystems/ezplatform-com)|the eZ Systems Developer Hub for the Open Source PHP CMS eZ Platform (example site)|
|[ezplatform-ee-demo](https://github.com/ezsystems/ezplatform-ee-demo)|fork of the "ezplatform-ee" meta repository, contains changes necessary to enable eZ Platform Enterprise Edition Demo. Not recommended for a clean install for new projects, but great for observation and learning (example site)|
