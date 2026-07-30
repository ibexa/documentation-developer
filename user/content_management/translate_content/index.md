# Translate content

Create multiple language versions of content items.

The content on your website can be translated into different languages. Each content item can have different language versions. The version visible to a visitor depends on the way your installation is set up (see [SiteAccess concept](#edit-page-for-different-language-versions-of-a-website)).

## Add website languages

You can only add translations in languages that have been set up for your website in the **Admin** panel. If your user [role](../../permission_management/work_with_permissions/index.md) has the right permissions, you can create a new language for the website. To do it, go to the **Admin** panel, open the **Languages** tab, and click **Add language**.

Every new language must have a name and a language code written in the xxx-XX format, for example, eng-US, fre-FR, or nor-NO. After adding a language, you may have to reload the application to be able to use it.

> **Caution: Caution**
>
> Depending on the way the website is set up, additional configuration may be necessary for the new translations to be displayed properly. Contact your administrator and inform them that you need to add a new language to the website. For more information, see [Developer Documentation on language versions](../../../developer/multisite/languages/languages/index.md)).

## Add translations

1. In the left panel, go to **Content** -> **Content structure**. Then select a content item.

2. Go to **Translations** tab and click **+ Add**.

3. In the **Create a new translation** modal, select the source and target languages, then click **Create**.

All the fields are then pre-filled with the values they have in the base translation. If you do not choose a base translation, the fields remain empty.

While working, you can save your work and continue or click **Delete draft** to discard your changes. When done, you can save your work and close the window, publish the translated article immediately, or pick another publication date.

Every time you add or edit a translation, a new version of the content item is created, the same way as when editing only one language.

![Adding a new translation](https://doc.ibexa.co/projects/userguide/en/5.0/content_management/img/adding_translation.png "Adding a new translation")

### Automated translation

If your application comes with a [properly configured automated translation feature](https://doc.ibexa.co/en/5.0/multisite/languages/automated_translations), you can have your content machine-translated into multiple languages by using external translation services like Google Translate and DeepL.

To use it, in the **Create a new translation** modal, select the source and target languages and the **Use automatic translation with...** checkbox. If more than one service is configured, you can choose either of the available options.

![Automated translation](https://doc.ibexa.co/projects/userguide/en/5.0/content_management/img/automated_translation.png "Automated translation")

When you click **Create**, all the Fields are pre-filled with the values in target language, provided by the selected translation service.

## Translation comparison

You can compare different versions of the translations of the content item.

1. [Disable the Focus mode](../../getting_started/discover_ui/index.md#disable-focus-mode).

2. In the left panel, go to **Content** -> **Content structure**. Then select a content item.

3. Go to **Versions** tab and click the **Version compare** icon: ![Version Compare Icon](https://doc.ibexa.co/projects/userguide/en/5.0/content_management/img/version_compare_icon.png).

4. In the **Comparing versions** screen, use the switcher in the top right corner, and click the split view:

![View switcher](https://doc.ibexa.co/projects/userguide/en/5.0/content_management/img/view_switcher.png "View switcher")

5. From the drop-downs, select two different language versions of the same content item. The screen refreshes to display the side by side view of its fields.

![Compare translations screen](https://doc.ibexa.co/projects/userguide/en/5.0/content_management/img/compare_translations.png "Compare translations screen")

For more information, see [Work with versions](../workflow_management/work_with_versions/index.md#compare-versions).

## Edit page for different language versions of a website (Experience, Commerce)

When you edit a page, a bar at the top of the screen lists the most recently used [SiteAccesses](../../website_organization/multisite/index.md#siteaccess) on your website. Use this bar to switch between the different versions and work on them.

> **Note: SiteAccess concept**
>
> SiteAccesses are a means to present different versions of the website to different categories of users. You could treat SiteAccesses as different "entrance points" to your website. They allow you to show different content or design to visitors, for example, to serve different language versions to visitors from different countries.
>
> See [Work with websites](../../website_organization/work_with_sites/index.md) for more information about setting up websites.
