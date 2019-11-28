# Step 1 - Creating a bundle

To extend eZ Platform's Back Office, the very first thing to do is to create a Symfony bundle.
For that, you can use [the Symfony generate bundle command](https://symfony.com/doc/3.0/bundles/SensioGeneratorBundle/commands/generate_bundle.html) in the following way:

``` bash
bin/console generate:bundle --namespace=EzSystems/ExtendingTutorialBundle --dir=src --format=yml --no-interaction
```

This will generate a new bundle skeleton in `src/EzSystems/ExtendingTutorialBundle`,
add it to the application kernel and configure eZ Platform to use the generated `routing.yml`.

!!! tip "Bundle name"

    You can pick a different namespace and directory for the bundle.
    If you do so, remember to modify the code provided in the tutorial to suit your names.

!!! caution

    During bundle generation you can see the error "The command was not able to configure everything automatically".
    Then [add the following line to `composer.json` under `autoload:psr-4`](https://github.com/symfony/symfony/issues/23630):

    `"EzSystems\\ExtendingTutorialBundle\\": "src/EzSystems/ExtendingTutorialBundle"`

    Then execute `composer dump-autoload` to regenerate the autoload files.
