# First steps

This page lists first steps you can take after installing eZ Platform.
These are most common actions you may need to take in a new installation.

!!! tip "Beginner tutorial"

    To go through a full tutorial that leads from a clean installation to creating a full site,
    see [Building a bicycle route tracker in eZ Platform](../tutorials/platform_beginner/building_a_bicycle_route_tracker_in_ez_platform.md).

## Create a Content Type

1\. Go to the Back Office: `<your_domain>/ez`.

2\. Select Admin Panel and go to Content Types.

3\. Enter the Content group and create a new Content Type.

![Creating a Content Type](img/first-steps-create-ct.png)

4\. Input the Content Type's name, for example "Blog Post", and identifier: `blog_post`.

5\. Below, add a Field definition of the type Text Line. Name it "Title" and give it identifier `title`.

6\. Add another Field definition: Text (type Rich text) with identifier `text`.

7\. Save the Content Type.

!!! tip "More information"

    - [Content model](../guide/content_model.md)

## Create Twig templates and match then with view config

To display Content in the front page you need to define content views and templates.

Content views decide which templates and controllers are used to display Content.

1\. In `app/config/ezplatform.yml` add the following block under `ezpublish.system.site_group`
(pay attention to indentation: `content_view` should be one level below `site_group`):

``` yaml
content_view:
    full:
        blog_post:
            template: 'full\blog_post.html.twig'
            match:
                Identifier\ContentType: [blog_post]
```

Content view templates use the [Twig templating engine](https://twig.symfony.com/).

2\. Create a template file `app/Resources/views/full/blog_post.html.twig`:

``` twig
<h1>{{ ez_render_field(content, 'title') }}</h1>
<div>{{ ez_render_field(content, 'text') }}</div>
```

!!! tip "More information"

    - [Displaying content with simple templates](../cookbook/displaying_content_with_simple_templates.md)
    - [Templates](../guide/templates.md)
    - [Twig documentation](https://twig.symfony.com/doc/2.x/)

## Create content and test view templates

1\. Go to the Back Office, activate Content/Content structure and create a new Content item using the button in the right menu.

![Creating a Blog Post](img/first-steps-create-content.png)

2\. Select a Blog Post Content Type. Fill in the Content item and publish it.

3\. To preview the new Content item on the front page, go to `<yourdomain>/<Content-item-name>`.
For example, if the title of the Blog post is "First blog post", the address will be `<yourdomain>/first-blog-post`.

![Previewing Content](img/first-steps-preview-content.png)

## Add SiteAccesses

You can use SiteAccesses to serve different versions of the website.

SiteAccesses are used depending on matching rules. They are set up in YAML configuration under the `ezpublish.siteaccess.list` key.

1\. In `app/config/ezplatform.yml` add a new SiteAccess called `de` for the German version of the website:

``` yaml
ezpublish:
    # ...
    siteaccess:
        list: [site, de]
        groups:
            site_group: [site, de]
```

The SiteAccess will automatically be matched using the last part of the URI.

2\. You can now access the front page through the new SiteAccess: `<yourdomain>/de`.

!!! note "Log in"

    At this point you need to log in to preview the new SiteAccess,
    because an anonymous visitor does not have permissions to view it.
    See [section about permissions below](#set-up-permissions).

For now the new SiteAccess does not differ from the main site.

!!! tip "More information"

    - [SiteAccess](../guide/siteaccess.md)
    - [SiteAccess matchers](../guide/siteaccess.md#available-matchers)

## Add a language and translate Content

One of the most common use cases for SiteAccesses is having different language versions of a site.

1\. To set up the `de` SiteAccess to use a different language, add its configuration under `ezpublish.system`:

``` yaml
site:
    languages:
        - eng-GB
de:
    languages:
        - ger-DE
        - eng-GB
```

This means that German will be used as the main language for this SiteAccess, and English as a fallback.

2\. Remove or comment the following line under `ezpublish.system.site_group`: `languages: [eng-GB]`.

3\. Go to the Back Office and select Admin Panel > Languages. Add a new language called "German", with language code `ger-DE`.
Make sure it is enabled. Afterwards, clear the cache: `app/console cache:clear`.

![Creating a language](img/first-steps-create-language.png)

4\. Next, go to the Content structure and open the blog post you had created earlier.
Select Translations in the menu and add a new translation.

![Adding a translation](img/first-steps-add-translation.png)

5\. Select German and base the new translation on the English version. Edit the Content item and publish it.

6\. Go to the front page. The blog post will now display different content depending on which SiteAccess you enter it from:
`<yourdomain>/<content-name>` or `<yourdomain>/de/<content-name>`.

![Previewing translated Content](img/first-steps-translated-content.png)

!!! tip "More information"

    - [Internationalization](../guide/internationalization.md)
    - [Setting up multi-language SiteAccesses and corresponding translations](../cookbook/setting_up_multi_language_siteaccesses.md)

## Set up permissions

To allow a group of users to edit only a specific Content Type (in this example, blog posts), you need to set up permissions for them.

Users and User Groups are assigned Roles. A Role can contain a number of Policies, which are rules that permit the user to perform a specific function.
Policies can be additionally restricted by Limitations.

1\. Go to Admin Panel > Users. Create a new User Group (the same way you create regular Content).
Call the group "Bloggers".

2\. In the new group create a User. Remember their username and password.

![Creating a User](img/first-steps-create-user.png)

3\. Go to Admin Panel > Roles. Create a new Role called "Blogger".

4\. Enter the Role and add Policies that will allow the User to log in:

- `user/login`
- `content/read`
- `content/versionread`
- `section/view`
- `content/reverserelatedlist`

5\. Now add Policies that will allow the User to create and publish content, limited to Blog Posts:

- `content/create` with Limitation for Class (Content Type) Blog Post
- `content/edit` with Limitation for Class (Content Type) Blog Post
- `content/publish` with Limitation for Class (Content Type) Blog Post

![Adding Limitations to a Policy](img/first-steps-policy-limitations.png)

6\. In the "Users and groups using the <Blogger> role" tab assign the Role to the "Bloggers" group.

![Assigning a Role](img/first-steps-assign-roles.png)

You can now log out and log in again as the new User.
You will be able to create Blog Posts only.

!!! tip  "More information"

    - [Permissions](../guide/permissions.md)
