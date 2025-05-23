<!-- vale VariablesVersion = NO -->

# eZ Platform v2.4

**Version number**: v2.4

**Release date**: December 21, 2018

**Release type**: Fast Track

## Notable changes

!!! dxp

    ### Editorial workflow

    [Editorial Workflow](https://doc.ibexa.co/en/2.5/guide/workflow) enables you to pass content through a series of stages.

    Each step can be used to represent for example contributions and approval of different teams and editors.
    For instance, an article can pass through draft, design and proofreading stages.

    The workflow mechanism is [permission-aware](https://doc.ibexa.co/en/2.5/guide/workflow/#permissions).
    You can limit access to content in different workflow stages, or the ability to pass content through specific transitions.

    ![Workflow event timeline](2.4_workflow_events_timeline.png "Timeline of workflow stages a content item has gone through")

    Workflow Engine is located in the [ezplatform-workflow bundle](https://github.com/ezsystems/ezplatform-workflow).

### RichText

#### RichText field type

RichText field type has been extracted to a separate bundle, [ezsystems/ezplatform-richtext](https://github.com/ezsystems/ezplatform-richtext). Relying on any class from the `eZ\Publish\Core\FieldType\RichText` namespace is deprecated.

If you're implementing any interface or extending any base class from the old namespace, refer to its PHPDoc to see what to implement or extend instead.
Make sure to enable the new eZ Platform RichTextBundle.

See [RichText field type Reference](https://doc.ibexa.co/en/2.5/api/field_types_reference/richtextfield).

#### RichText block

In the Page Builder you can make use of the RichText block.
It enables you to insert text created using the Online Editor with all features of a RichText Field.

![RichText block](2.4_rich_text_block.png)

#### Improved styling in Online Editor

Online Editor has been improved with new styling.

![Online Editor menu](2.4_oe_menu.png)

#### Images in RichText

You can now attach links to images in the Online Editor:

![Adding a link to an image in Online Editor](2.4_link_in_image.png)

#### Formatted text in RichText

You can now use formatted text in RichText Fields (provided by means of a `literal` tag).

![Formatted Text in Online Editor](2.4_formatted_text.png)

#### Inline embedding in RichText

The new `embed-inline` built-in view type enables embedding content items within a block element in RichText.

#### Custom tag - `ezcontent`

The `ezcontent` property is now editable in the UI and can be used to store the output/preview of a custom tag.
To learn how it works, see [FactBox tag](https://doc.ibexa.co/en/2.5/guide/extending/extending_online_editor/#example-factbox-tag).

### Content type translation

You can now translate content type names and Field definitions.

This possibility is available automatically when you have the target language configured
(in the same way as for translating content, see [Languages](https://doc.ibexa.co/en/2.5/guide/internationalization)).

![Content type with existing translations](2.4_content_type_translations.png "Available translation of a content type")

When you translate Content of this type, the content type information is displayed in the new language.

![Editing a content translation with translated Field names](2.4_translated_ct.png)

### Multi-file management

New multi-file content management functionalities enable you to move and delete multiple files at the same time.

For more information, see[Multi-file content management](https://doc.ibexa.co/projects/userguide/en/2.5/multi_file_content_management/#multi-file-content-management).

!!! dxp

    ### Forms

    #### Create form on the fly

    You can now create Forms on the fly from the Universal Discovery Widget.

    ![Creating a Form on the Fly](2.4_form_on_the_fly.png)

    #### Embedding forms in Pages

    You can use the new Form block to embed an existing form on a Page.

### Draft list

The list of all drafts can now be found in the **Administrator User** menu under **Drafts**.

![Administrator User list of all Drafts](2.4_drafts_admin_user.png "Administrator User list of all Drafts")

For more information, see [Reviewing a draft](https://doc.ibexa.co/projects/userguide/en/2.5/publishing/flex_workflow/#reviewing-a-draft).

### Subtree search filter

A new filter enables you to filter search results by Subtree.

For more information, see [Simplified Filtered search](https://doc.ibexa.co/projects/userguide/en/2.5/search/#simplified-filtered-search).

### Sub-items limit

You can now set a number of items displayed in the table with the **Sub-items** setting in your User Settings.

![Setting for subitems limit in user preferences](2.4_subitems_limit_pref.png)

### Policy labels update

The outdated policy labels are now updated:

|Old|New|
|---|---|
|class|Content type|
|ParentClass|Content type of Parent|
|node|Location|
|parentdepth|Parent Depth|
|parentgroup|Content type Group of Parent|
|parentowner|Owner of Parent|
|subtree|Subtree of Location|

![Updated policy labels](2.4_policy_verbs.png)

### API improvements

#### Simplified use of content type objects

This release introduces a few simplifications to API use for content types:

- Exposes `content->getContentType()` for easier use, including from Twig as `content.contentType`. When iterating over the result set of content/Locations these are effectively loaded all at once.
- Adds a possibility to load several content types in bulk with `ContentTypeService->loadContentTypeList()`.
- `UserService` now exposes `isUser()` and `isUserGroup()`. They don't need to do a lookup to the database to tell if a content item is of type user or user group.

#### Load multiple locations

You're now able to load multiple locations at once, with `LocationService->loadLocationList()`.
The biggest benefit of this feature is saving load time on complex landing pages when HTTP cache is cold or disabled, including when in development mode.

### BC breaks and important behavior changes

- Online Editor format for `ezlink` inside `ezembed` tag changed to an anchor tag. See [ezplatform-richtext/pull/20](https://github.com/ezsystems/ezplatform-richtext/pull/20).
- The merge order of content edit forms has been changed. It can affect you if you extended the content edit template. See [ezplatform-admin-ui/pull/720](https://github.com/ezsystems/ezplatform-admin-ui/pull/720).
- Changes to the handling of multilingual content types, see [BC notes in the kernel](https://github.com/ezsystems/ezpublish-kernel/blob/7.5/doc/bc/changes-7.4.md).

## Full list of new features, improvements and bug fixes since v2.3

| eZ Platform   | eZ Enterprise  |
|--------------|------------|
| [List of changes for final of eZ Platform v2.4.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.4.0) | [List of changes for final for eZ Platform Enterprise Edition v2.4.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.4.0) |
| [List of changes for rc1 of eZ Platform v2.4.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.4.0-rc1) | [List of changes for rc1 for eZ Platform Enterprise Edition v2.4.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.4.0-rc1) |
| [List of changes for beta1 of eZ Platform v2.4.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.4.0-beta1) | [List of changes for beta1 of eZ Platform Enterprise Edition v2.4.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.4.0-beta1) |

## eZ Platform v2.4.2

!!! dxp

    ### Update eZ Enterprise v2.4 to v2.4.2

    This release brings [full support for Map\Host matcher](https://issues.ibexa.co/browse/EZEE-2572) when SiteAccesses are configured for different domains.

    Token-based authentication (based on JSON Web Token specification) replaced cookie-based authentication that did not work with SiteAccesses configured for a different domains in the Page Builder.
    Authentication mechanizm is enabled by default in v2.4.2, however, the following steps are required during upgrade from v2.4 to v2.4.2+ Enterprise installation:

    1\. Register `LexikJWTAuthenticationBundle` bundle in `/app/AppKernel.php`

    ``` php
     public function registerBundles()
     {
         $bundles = array(
             // ...
            new Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle(),
             // Ibexa
             // ...
         );
     }
    ```

    2\. Add the following configuration to `/app/config/config.yml`

    ``` yaml
     lexik_jwt_authentication:
         secret_key: '%secret%'
         encoder:
             signature_algorithm: HS256
         # Disabled by default, because Page Builder uses custom extractor
         token_extractors:
             authorization_header:
                 enabled: false
             cookie:
                 enabled: false
             query_parameter:
                 enabled: false
    ```

    By default `HS256` is used as signature algorithm for generated token but we strongly recommend switching to SSH keys.
    
    For more information, see [`LexikJWTAuthenticationBundle` installation instruction](https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#installation).

    3\. Add `EzSystems\EzPlatformPageBuilder\Security\EditorialMode\TokenAuthenticator` authentication provider to `ezpublish_front` firewall before `form_login` in `app/config/security.yml`:

    ``` yaml
     security:
         # ...
         firewalls:
             ezpublish_front:
                 # ...
                 simple_preauth:
                     authenticator: 'EzSystems\EzPlatformPageBuilder\Security\EditorialMode\TokenAuthenticator'
                 form_login:
                     require_previous_session: false
                 # ...
    ```

    4\. Make sure that parameter `page_builder.token_authenticator.enabled` has value `true`. If the parameter isn't present, add it to `/app/config/config.yml`:

    ``` yaml
     # ...
     parameters:
        # ...
        page_builder.token_authenticator.enabled: true
    ```
