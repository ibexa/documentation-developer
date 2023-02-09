---
description: Migrate an older eZ Publish installation to eZ Platform.
---

# Migrating from eZ Publish

eZ Publish was eZ Platform's predecessor, a CMS in development for five major versions and several years.

Users of eZ Publish will find eZ Platform largely similar to what they know. The improvements and enhancements did not turn the fundamental concepts underlying the system, such as the content model, upside down. However, specific features, solutions and recipes may work differently between the two versions.

The release of eZ Platform brought about an inevitable disruption in backwards compatibility with eZ Publish. This means that the process of migrating existing installations requires more effort than simply upgrading from one version to another. Here you can find details on moving existing Publish-powered websites to eZ Platform.

## Changes overview

### Incompatibilities with legacy

eZ Platform represents the 6th generation of eZ Publish, and while the 5th generation had* *a major focus on backwards code compatibility with the 3rd and 4th generations *(legacy)*, the 6th generation does not.

The 6th generation is aimed at being fully backwards compatible on the following:

- **Content** from 4th and later 5th generation installation
- **Code** from 5th generation system when written for *Platform (Symfony) stack*

The specific incompatibilities

The specific changes that will be migrated and are incompatible with legacy are: 

- XmlText fields have been replaced with a new [RichText](richtextfield.md) field
- Page field (ezflow) has been replaced by the [LandingPage](pagefield.md) field, and is now provided by our commercial product [eZ Platform Enterprise Edition](http://ezstudio.com/)
- Incremental future improvements to the database schema to improve features and scalability of the content repository 

Together these major improvements make it practically impossible to run eZ Platform side by side with eZ Publish legacy, like it was possible in 5.x series. *For these reasons we recommend that you use eZ Publish Enterprise 5.4  ([which is supported until end of 2021](https://support.ez.no/Public/Service-Life)) if you don't have the option to remake your web application yet, or want to do it gradually.*

## Migration Path

### From legacy (4.x or 5.x) to Platform stack (5.4/2014.11)

If you are coming directly from legacy (4.x), you need to follow the best practice 5.x Platform migration path and do the following:

- Rewrite custom Field Types for the new Platform stack. Alternatively you can use Null Field Type as a dummy implementation for the custom Field Types that you don't want to migrate. Using Null Field Type will prevent errors from the Platform Stack, see [Null Field Type Reference](nullfield.md)
- Rewrite custom web front end to use the new Platform/Symfony stack, see [Beginner Tutorial](beginner_tutorial.md)
- Rewrite custom admin modules to use the new Platform/Symfony stack
    - And if you do this while on 5.x, you can use several of the [available legacy migration features](https://doc.ez.no/display/EZP/Legacy+code+and+features) to make the new code appear in legacy admin

See Upgrade documentation on how to perform the actual upgrade: [Upgrade (eZ Publish Platform page)](https://doc.ez.no/display/EZP/Upgrade).

!!! caution "Avoid exception when migrating the database"

    If you plan to migrate from from eZ Publish through eZ Publish Platform 5.4 to eZ Platform and further, an exception may occur when you try to migrate the database while it contains internal drafts of Landing Pages.
    This can happen because such drafts do not have an expected row in the `ezcontentobject_name` table.<a id="migration_exception"></a> 
    
    To avoid this exception, you must remove all internal drafts before you migrate. 
    First, in `content.ini`, set the `InternalDraftsCleanUpLimit` and `InternalDraftsDuration` values to 0. 
    Then run the [internal drafts cleanup](https://github.com/ezsystems/ezpublish-legacy/blob/2019.03/cronjobs/internal_drafts_cleanup.php) cron job. 

### From Platform stack (5.4/2014.11) to eZ Platform

As eZ Platform introduced completely new user interfaces with greatly improved user experience, the following custom developments needs to be made if you have customization needs:

- Write UI code for custom Field Types for the new JavaScript-based editorial interface, (see [Page blocks](render_page.md)
- Adjust custom admin modules for the new Symfony-based admin interface

For a detailed guide through these developments see [Upgrading from 5.4.x and 2014.11 to 16.xx](migrating_from_ez_publish_platform.md#upgrading-from-54x-and-201411-to-16xx) 
