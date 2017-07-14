1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [Tutorials](Tutorials_31429522.html)
4.  [Extending PlatformUI with new navigation](Extending-PlatformUI-with-new-navigation_31430235.html)

# Create the extension Bundle 

Created by Dominika Kurek, last modified on May 06, 2016

To extend PlatformUI, the very first thing to do is to create a Symfony bundle. For that, you can use [the Symfony generate bundle command](http://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_bundle.html) in the following way:

``` brush:
$ app/console generate:bundle --namespace=EzSystems/ExtendingPlatformUIConferenceBundle --dir=src --format=yml --no-interaction
```

This will generate a new bundle skeleton in `src/EzSystems/ExtendingPlatformUIConferenceBundle`, add it to the application kernel and configure eZ Platform to use the generated `routing.yml` without asking any question. Of course, you are free to tweak the bundle's namespace and directory or to integrate the PlatformUI extension code in an existing bundle.

Results and next step:

If you run this exact command, you will pretty much get [the code available under the 1\_bundle tag on Github](https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle/tree/1_bundle).

The next step is then to [prepare the bundle to handle PlatformUI specific configuration](Set-up-the-configuration_31430239.html).

**Tutorial path**






