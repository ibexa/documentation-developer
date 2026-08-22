# Ibexa DXP v5.0 LTS

Ibexa DXP v5.0 incorporates features brought by LTS Updates from previous versions, brings upgrades to the tech stack and improvements to developer experience.

## Translations management v5.0.10 (Headless, Experience, Commerce, LTS Update, New feature, First release)

Release date: 2026-08-20

Translations management is a new LTS Update that extends Ibexa DXP's built-in language management tools with machine translation, a side-by-side editing view, and a command-line translation utility.

### Machine translation providers

Translation providers are the services that perform the actual text translation. Translations management uses two provider types to connect to the translation services:

- REST API-based providers: Google Translate and DeepL, configured with API keys
- AI-based providers: OpenAI, Anthropic Claude, and Google Gemini, routed through AI Actions

For more information, see [Configure translation providers](../../multisite/translations_management/configure_translations_management/index.md#configure-translation-providers).

### Side-by-side translation view

A [side-by-side translation view](../../../user/content_management/translate_content/index.md#side-by-side-translation-view) displays the source and target text of the content item or product on one screen. Editors can translate or compare source and target content, copy all content from the source column to the target column in a single action, and use the distraction-free mode for focused editing of individual fields.

For more information, see [User Documentation](../../../user/content_management/translate_content/index.md#side-by-side-translation-view).

### CLI translation command

A new console command translates content items from the command line, enabling batch processing and automated workflows.

For more information, see \[Translate content items with CLI\](<https://doc.ibexa.co/en/5.0/multisite/translations_management/translate_with_cli/>.

### Translation review

When a draft is created through automatic translation, it receives the "For review" status. Editors can accept or reject the translation in the side-by-side view, which displays a review bar. Accepted translations are given the "Translated" status.

The **Versions** tab shows a **Translation status** column with review status badges for draft translations created with automatic translation.

For more information, see [Translation review](https://doc.ibexa.co/en/5.0/multisite/translations_management/configure_translations_management/translations_management_guide/#translation-review).

### Developer experience

The Translations management package brings multiple new classes and interfaces as part of the [`Ibexa\Contracts\TranslationsManagement` namespace](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-translationsmanagement.html).

Changes include multiple extension points, including:

- [`Ibexa\Contracts\TranslationsManagement\AutoTranslate\Provider\TranslationProviderInterface`](../../../../../ibexa/translations-management/src/contracts/AutoTranslate/Provider/TranslationProviderInterface.php) for creating custom translation providers
- [`Ibexa\Contracts\TranslationsManagement\AutoTranslate\Transformer\Field\FieldValueTransformerInterface`](../../../../../ibexa/translations-management/src/contracts/AutoTranslate/Transformer/Field/FieldValueTransformerInterface.php) for enabling custom field type support
- [`Ibexa\Contracts\TranslationsManagement\SideBySide\Service\SideBySideExclusionRuleInterface`](../../../../../ibexa/translations-management/src/contracts/SideBySide/Service/SideBySideExclusionRuleInterface.php) for defining custom content type exclusion rules

For more information, see [Extend translations management](../../multisite/translations_management/extend_translations_management/index.md).

## MCP Servers v5.0.10 (Headless, Experience, Commerce, LTS Update, New feature)

Release date: 2026-08-20

### Tools and configuration

- Added `create_content_type_draft` [built-in tool](../../ai/mcp/mcp_config/index.md#built-in-tools) to create a draft for an existing content type.
- [MCP server's session storage configuration](../../ai/mcp/mcp_config/index.md#session-storage) now has a default value to use the default cache service out-of-the-box equivalent to the following:

```yaml
ibexa:
    repositories:
        <repository>:
            mcp:
                <server>:
                    session:
                        type: psr16
                        service: ibexa.cache_pool
```

## Ibexa DXP v5.0.10 (Headless, Experience, Commerce, New feature)

Release date: 2026-08-20

### Security

This release includes security fixes. To learn more, see the corresponding [security advisory](https://developers.ibexa.co/security-advisories/ibexa-sa-2026-004-firewall-access-control-issue-and-xss-vulnerabilities).

### Cohesivo v6.0 deprecations

As announced during Ibexa Summit 2026, the upcoming 6.0 version will be renamed to Cohesivo.

To prepare your project ahead of the release, see the newly available [Cohesivo v6.0 renames, deprecations and removals](../cohesivo_v6.0_deprecations/index.md).

### SiteAccess-aware background tasks

Ibexa Messenger now attaches a [`SiteAccessStamp`](../../infrastructure_and_maintenance/background_tasks/index.md#siteaccessstamp) to every dispatched message. With this, one worker process can handle messages coming from different SiteAccesses.

### Labels and descriptions for custom tags

You can now provide the label and description of a Rich Text custom tag, and the labels of its attributes, directly in the custom tag configuration.

For more information, see [Provide translations for custom tags](../../content_management/rich_text/extend_online_editor/index.md#provide-translations-for-custom-tags).

### Updating languages in data migrations

The `language` migration step now supports the `update` mode. Use it to rename an existing language or change its enabled state.

For more information, see [Importing data](../../content_management/data_migration/importing_data/index.md#languages).

### New translation key in the block configuration

You can now add the new `name.help` translation key. It’s rendered as a helper text under the **Name** field in the block configuration form in the Page Builder.

For more information and an example of block configuration, see [Block name and help text](../../content_management/pages/page_blocks/index.md#block-name-and-help-text).

### Full changelog

To learn more about all the included changes, see the full release change logs:

- [Ibexa Headless v5.0.10](https://github.com/ibexa/headless/releases/tag/v5.0.10)
- [Ibexa Experience v5.0.10](https://github.com/ibexa/experience/releases/tag/v5.0.10)
- [Ibexa Commerce v5.0.10](https://github.com/ibexa/commerce/releases/tag/v5.0.10)

To update your application, see the [update instructions](../../update_and_migration/from_5.0/update_from_5.0/index.md#v5010).

## MCP Servers v5.0.9 (Headless, Experience, Commerce, LTS Update, New feature)

Release date: 2026-07-01

### Tools

Several new experimental content type tools were added to the MCP Servers feature:

- `create_content_type`
- `get_content_type`
- `get_content_type_by_identifier`
- `get_content_type_list`
- `get_content_type_draft`
- `publish_content_type_draft`
- `add_field_definition`
- `remove_field_definition`
- `update_field_definition`
- `get_content_type_groups`

Among translation tools:

- `list_non_translated_content_ids` tool is added
- `list_content_translations` is now renamed to `list_content_languages`

For more information, see [Built-in tools](../../ai/mcp/mcp_config/index.md#built-in-tools).

### Configuration

- An `allowed_hosts` parameter is added to configuration to restrict access to an MCP server. It's default value covers only few cases for local development. For more information, see [Allowed hosts](../../ai/mcp/mcp_config/index.md#allowed-hosts).
- A `title` property is added to capability attributes to optionally provide a friendly UI label. For more information, see [MCP server capabilities](../../ai/mcp/mcp_usage/index.md#mcp-server-capabilities).

## Ibexa DXP v5.0.9 (Headless, Experience, Commerce, New feature)

Release date: 2026-07-01

### Raptor connector

#### Hybrid tracking

New `hybrid` tracking mode is available alongside [`client` and `server`](../../recommendations/raptor_integration/tracking_functions/index.md). In this mode, the browser uses a first-party tracking shim provided by the DXP instance. Tracking events are forwarded through a same-origin endpoint and processed server side before being sent to Raptor, helping reduce the impact of ad blockers while preserving client side event tracking.

For more information, see [hybrid tracking](../../recommendations/raptor_integration/hybrid_tracking/index.md).

#### New recommendation blocks (Experience, Commerce)

Two new recommendation blocks are available in Page Builder:

- **Items of Customized Feeds sorted by personal preferences and popularity or trendiness** sorts items from Customized Feeds based on user preferences, popularity, and current trends
- **Merchandising content sorted by personal preferences and popularity** uses merchandising content and sorts it by personal preferences and popularity

For more information, see [recommendation blocks](../../recommendations/raptor_integration/recommendation_blocks/index.md).

### Developer experience

#### PHP API

The following additions were made to the PHP API:

- [`Ibexa\Contracts\ConnectorRaptor\Message\TrackProxiedEventMessage`](../../../../../ibexa/connector-raptor/src/contracts/Message/TrackProxiedEventMessage.php)
- [`Ibexa\Contracts\ConnectorRaptor\Tracking\ContextProvider\WebsiteIdContextProviderInterface`](../../../../../ibexa/connector-raptor/src/contracts/Tracking/ContextProvider/WebsiteIdContextProviderInterface.php)
- [`Ibexa\Contracts\ConnectorRaptor\Tracking\TrackingBehaviorProviderInterface`](../../../../../ibexa/connector-raptor/src/contracts/Tracking/TrackingBehaviorProviderInterface.php)
- [`Ibexa\Contracts\Messenger\Stamp\DeduplicateStamp`](../../../../../ibexa/messenger/src/contracts/Stamp/DeduplicateStamp.php)
- [`Ibexa\Contracts\Messenger\Stamp\SudoStamp`](../../../../../ibexa/messenger/src/contracts/Stamp/SudoStamp.php)
- [`Ibexa\Contracts\Messenger\Stamp\UserPermissionStamp`](../../../../../ibexa/messenger/src/contracts/Stamp/UserPermissionStamp.php)

### Full changelog

To learn more about all the included changes, see the full release change logs:

- [Ibexa Headless v5.0.9](https://github.com/ibexa/headless/releases/tag/v5.0.9)
- [Ibexa Experience v5.0.9](https://github.com/ibexa/experience/releases/tag/v5.0.9)
- [Ibexa Commerce v5.0.9](https://github.com/ibexa/commerce/releases/tag/v5.0.9)

To update your application, see the [update instructions](../../update_and_migration/from_5.0/update_from_5.0/index.md#v509).

## MCP Servers v5.0.8 (Headless, Experience, Commerce, LTS Update, New feature, First release)

Release date: 2026-05-21

MCP servers make it easier for AI agents to discover the available interactions with Ibexa DXP. With the MCP Servers feature, you can configure multiple MCP servers with their specific sets of tools.

For more information, see [MCP Servers product guide](../../ai/mcp/mcp_guide/index.md).

## Ibexa DXP v5.0.8 (Headless, Experience, Commerce, New feature)

Release date: 2026-05-21

### Security

This release includes security fixes. To learn more, see the [corresponding security advisory](https://developers.ibexa.co/security-advisories/ibexa-sa-2026-003-vulnerabilities-in-forms-submissions-rest-sessions-and-solr-logs).

### Raptor connector

#### New recommendation blocks (Experience, Commerce)

Four new recommendation blocks are available in Page Builder:

- **User's content history** compiles a chronological list of recently interacted content or a list of most interacted content
- **Items associated with the given Content** generates a list of complementary and relevant products that customers often view with a given content
- **The Personal Shopping Assistant (additional sales)** encourages additional purchases by suggesting complementary cross-selling items
- **The Personal Shopping Assistant (conversion)** helps users discover better product matches by suggesting similar items based on their activity

For more information, see [recommendation blocks](../../recommendations/raptor_integration/recommendation_blocks/index.md).

#### Category parameter for product events

You can now configure which product category is sent in tracking events.

Raptor accepts only a single category value. By default, the connector uses the first category assigned to a product, but you can override this behavior and select a different category to be included in tracking events.

To learn more, see [category parameter for product events](../../recommendations/raptor_integration/tracking_php_api/index.md#category-parameter-for-product-events).

#### Cookie lifetime configuration

A new `cookie_id_lifetime_days` configuration option controls the lifetime in days of the server-side tracking identifier cookie.

For more information, see [connector installation and configuration](../../recommendations/raptor_integration/connector_installation_configuration/index.md).

### Anonymous user segmentation in Ibexa CDP (Experience, Commerce)

Ibexa CDP can now build audiences for anonymous visitors. Use them in Ibexa DXP to deliver personalized experiences even before users log in.

For more information, see [Anonymous user segmentation](../../cdp/cdp_activation/cdp_configuration/index.md#anonymous-user-segmentation).

### Gaussian blur optimization in Image Editor

The [Image Editor](../../../user/image_management/edit_images/index.md) now supports configuring the strength of the gaussian blur that is used for image optimization. You can adjust the blur level to balance between file size reduction and image sharpness. For more information, see [Configure image editor](../../content_management/images/configure_image_editor/index.md#gaussian-blur-strength).

### Developer experience

#### Repeatable migration steps with items

The `repeatable` migration type now supports an `items` key, allowing you to provide a list of items to iterate over, similar to a `foreach` loop.

For more information, see [Repeatable steps with items](../../content_management/data_migration/importing_data/index.md#repeatable-steps-with-items).

#### Twig Component groups

Three new [Twig Component groups](../../templating/components/index.md) are added to the back office:

- `admin-ui-content-column-end`
- `admin-ui-content-translations-row-actions`
- `admin-ui-form-product-add-translation-body`

For more information, see [available Admin UI Twig Component groups](../../administration/back_office/back_office_elements/custom_components/index.md#admin-ui).

#### PHP API

##### Product API: Computed availability for products

[`Ibexa\Contracts\ProductCatalog\Values\Availability\AvailabilityInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/Availability/AvailabilityInterface.php) now uses separate values for availability and computed availability:

- `getAvailability()` returns whether the product or variant is manually set as available
- `getComputedAvailability()` returns whether the product or variant can be ordered, for example, based on its stock level

For more information, see [Availability and computed availability](../../product_catalog/products/index.md#product-availability-and-stock).

##### Workflow API: new `loadWorkflowMetadataForVersionInfo` method

The new [`WorkflowServiceInterface::loadWorkflowMetadataForVersionInfo`](../../../../../ibexa/workflow/src/contracts/Service/WorkflowServiceInterface.php) method loads workflow information directly from a [`Ibexa\Contracts\Core\Repository\Values\Content\VersionInfo`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/VersionInfo.php) object, without loading the content item.

For more information, see [Workflow API](../../content_management/workflow/workflow_api/index.md#getting-workflow-information).

##### Addition summary

The following additions were made to the PHP API:

- [`Ibexa\Contracts\Cdp\Exception\MembershipApiException`](../../../../../ibexa/cdp/src/contracts/Exception/MembershipApiException.php)
- [`Ibexa\Contracts\Cdp\Membership`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-cdp-membership.html)
- [`Ibexa\Contracts\ConnectorRaptor\Message\TrackServerSideEventMessage`](../../../../../ibexa/connector-raptor/src/contracts/Message/TrackServerSideEventMessage.php)
- [`Ibexa\Contracts\ConnectorRaptor\Tracking\Event\PageViewEventData`](../../../../../ibexa/connector-raptor/src/contracts/Tracking/Event/PageViewEventData.php)
- [`Ibexa\Contracts\ConnectorRaptor\Tracking\PageViewTrackerInterface`](../../../../../ibexa/connector-raptor/src/contracts/Tracking/PageViewTrackerInterface.php)
- [`Ibexa\Contracts\Mcp`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-mcp.html)

### Full changelog

To learn more about all the included changes, see the full release change logs:

- [Ibexa Headless v5.0.8](https://github.com/ibexa/headless/releases/tag/v5.0.8)
- [Ibexa Experience v5.0.8](https://github.com/ibexa/experience/releases/tag/v5.0.8)
- [Ibexa Commerce v5.0.8](https://github.com/ibexa/commerce/releases/tag/v5.0.8)

To update your application, see the [update instructions](../../update_and_migration/from_5.0/update_from_5.0/index.md#v508).

## Google Gemini connector v5.0.7 (Headless, Experience, Commerce, LTS Update, New feature, First release)

Release date: 2026-04-20

This release introduces a new AI connector that allows you to integrate [AI Actions](../../ai/ai_actions/ai_actions/index.md) with [Google Gemini](https://gemini.google/overview/#what-gemini-is). You can also use it as an alternative embeddings provider for the [taxonomy suggestions feature](../../content_management/taxonomy/taxonomy/index.md#taxonomy-suggestions).

For more information, see how to [install and configure the Google Gemini connector](../../ai/ai_actions/configure_ai_actions/index.md#install-google-gemini-connector).

## Integrated help v5.0.7 (Headless, Experience, Commerce, LTS Update, New feature)

Release date: 2026-04-20

### Product tour

The product tour is a new Integrated help feature that helps back office contributors to discover Ibexa DXP.

With product tours, you can create customized onboarding journeys. This accelerates user adoption, reduces training time, and helps users confidently navigate the platform.

For more information, see [Product tour](../../administration/back_office/product_tour/index.md).

## Ibexa DXP v5.0.7 (Headless, Experience, Commerce, New feature)

Release date: 2026-04-20

### Security

This release includes security fixes. To learn more, see the [corresponding security advisory](https://developers.ibexa.co/security-advisories/ibexa-sa-2026-002-access_control-in-security.yaml-not-working).

### Raptor connector

The Raptor connector provides a seamless integration between Ibexa DXP and [Raptor Recommendation Engine](https://www.raptorservices.com/website-recommendations/).

For more information, see [Raptor connector](../../recommendations/raptor_integration/raptor_connector/index.md).

#### Tracking

This add-on includes two Twig functions to ease tracking setting:

- `ibexa_tracking_script` to load the JavaScript tracking code
- `ibexa_tracking_track_event` to send tracking events from your pages

For more information, see [Raptor tracking functions](../../recommendations/raptor_integration/tracking_functions/index.md).

#### Recommendations blocks (Experience, Commerce)

This add-on introduces a set of recommendation blocks available in the [Page Builder](../../content_management/pages/page_builder_guide/index.md), designed to suggest relevant content or products to users, such as the most popular items or viewed by others.

For more information about Recommendation blocks in Page Builder, see the relevant [Developer Documentation](../../recommendations/raptor_integration/recommendation_blocks/index.md) and [User Documentation](../../../user/recommendations/raptor_integration/raptor_recommendation_blocks/index.md).

### Quable PIM

The Quable integration add-on allows you to connect Ibexa DXP with [Quable Product Information Management (PIM)](https://www.quable.com/en), making Quable the authoritative source of product information for every website powered by Ibexa DXP.

Quable can serve as the single source of truth for all product data, including attributes, classifications, variants, and translations. Ibexa DXP consumes this data and makes it available for use in content and digital experiences.

For more information, see [Quable PIM Integration](../../product_catalog/quable/quable/index.md).

### AI Actions in Page Builder blocks (Experience, Commerce)

You can now use the [refining text AI Actions](../../ai/ai_actions/ai_actions_guide/index.md#refining-text) in Page Builder blocks string and text inputs.

### Developer experience

#### Symfony 7.4

Symfony is upgraded from 7.3 to 7.4. It's the latest [LTS release](https://symfony.com/releases#long-term-support-release), maintained till November 2029. See [what's new in Symfony 7.4](https://symfony.com/blog/category/living-on-the-edge/8.0-7.4) and [how to update Symfony within Ibexa DXP](../../update_and_migration/from_5.0/update_from_5.0/index.md#update-symfony-from-73-to-74).

#### Taxonomy search

One [taxonomy search](../../content_management/taxonomy/taxonomy_api/index.md#search) criterion is added:

- [`TaxonomyNoEntries`](../../search/criteria_reference/taxonomy_no_entries/index.md) to find content items to which no taxonomy entries have been assigned.

#### Custom parameters in `ibexa_render()`

You can now pass custom parameters to templates when using the `ibexa_render()` Twig function with the new `params` option, similar to how you can with `render(controller())`.

This allows you to provide additional context or data to your view templates:

```html+twig
{{ ibexa_render(content, {
    'viewType': 'line',
    'method': 'inline',
    'params': {
        'custom_param': 'custom_value',
        'another_param': 'another_value'
    }
}) }}
```

The parameters are available in your template as regular variables.

For more information, see [`ibexa_render()` Twig function](../../templating/twig_function_reference/content_twig_functions/index.md#ibexa_render).

#### Try-catch support in data migrations

Data migrations now support try-catch error handling, allowing you to wrap migration steps with exception handling logic. You can use it for migrations that might fail under certain conditions but should not break the entire migration process.

For example, you can create languages without checking if they already exist:

```yaml
-
    type: try_catch
    mode: execute
    allowed_exceptions:
        - Ibexa\Contracts\Core\Repository\Exceptions\InvalidArgumentException
    stop_after_first_exception: true
    steps:
        -
            type: language
            mode: create
            metadata:
                languageCode: ger-DE
                name: German
                enabled: true
```

The `try_catch` step allows you to specify which exceptions to catch and whether to continue executing remaining steps after an exception occurs.

For more information, see [Error handling with try-catch](../../content_management/data_migration/importing_data/index.md#error-handling-with-try-catch).

#### Translation-related Twig Component groups

Four new [Twig component groups](../../templating/components/index.md) related to Admin UI translation are added:

- `admin-ui-product-translation-modal-footer`
- `admin-ui-product-translations-actions-modal`
- `admin-ui-product-translations-actions`
- `admin-ui-product-translations-row-actions`

For more information, see [available Admin UI Twig Component groups](../../administration/back_office/back_office_elements/custom_components/index.md#admin-ui).

#### REST API

You can now find examples for some REST request bodies in the [OpenAPI REST API](../../api/rest_api/rest_api_usage/rest_api_usage/index.md#openapi-support):

- in the right column of the [online reference](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html), and in the downloadable OpenAPI specification files
- on your dev instance at `/api/ibexa/v2/doc` in an “Example Value” tab of the "Request Body" section, alongside the "Schema" tab
- in the generated JSON or YAML OpenAPI specifications when running `ibexa:openapi` command

#### PHP API

The following additions were made to the PHP API:

- [`Ibexa\Contracts\Core\FieldType\ReferenceAwareExternalStorage`](../../../../../ibexa/core/src/contracts/FieldType/ReferenceAwareExternalStorage.php)

- [`Ibexa\Contracts\Core\Options\Context`](../../../../../ibexa/core/src/contracts/Options/Context.php)

- [`Ibexa\Contracts\CorporateAccount\Order\OrderStatusLabelProviderInterface`](../../../../../ibexa/corporate-account/src/contracts/Order/OrderStatusLabelProviderInterface.php)

- [`Ibexa\Contracts\ProductCatalog\Events\ProductAttributeRenderEvent`](../../../../../ibexa/product-catalog/src/contracts/Events/ProductAttributeRenderEvent.php)

- [`Ibexa\Contracts\Taxonomy\Search\Query\Criterion\TaxonomyNoEntries`](../../../../../ibexa/taxonomy/src/contracts/Search/Query/Criterion/TaxonomyNoEntries.php)

  For more information, see [search criteria reference entry](../../search/criteria_reference/taxonomy_no_entries/index.md).

- [`Ibexa\Contracts\ConnectorRaptor` namespace](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-connectorraptor.html) from the [Raptor connector add-on](../../recommendations/raptor_integration/raptor_connector/index.md)

- [`Ibexa\Contracts\IntegratedHelp` namespace](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-integratedhelp.html) from the [Integrated help LTS-Update](../../administration/back_office/integrated_help/index.md)

### Full changelog

To learn more about all the included changes, see the full release change logs:

- [Ibexa Headless v5.0.7](https://github.com/ibexa/headless/releases/tag/v5.0.7)
- [Ibexa Experience v5.0.7](https://github.com/ibexa/experience/releases/tag/v5.0.7)
- [Ibexa Commerce v5.0.7](https://github.com/ibexa/commerce/releases/tag/v5.0.7)

To update your application, see the [update instructions](../../update_and_migration/from_5.0/update_from_5.0/index.md#v507).

## Shopping Lists v5.0.6 (Commerce, LTS Update, New feature)

Release date: 2026-03-05

Shopping list is a new feature that allows users to save products into wishlists. An authenticated customer has a default "My wishlist", and can create custom shopping lists to organize their potential or recurrent purchases. Products can be moved from cart to shopping list, from a shopping list to another shopping list, and copied from a shopping list to the cart.

For more information, see [Shopping list feature guide](../../commerce/shopping_list/shopping_list_guide/index.md).

## Ibexa DXP v5.0.6 (Headless, Experience, Commerce, New feature)

Release date: 2026-03-05

### Security

This release includes security fixes. To learn more, see the [corresponding security advisory](https://developers.ibexa.co/security-advisories/ibexa-sa-2026-001-insufficient-main-landing-page-access-control).

### Improved product variant querying

Product variant querying now supports filtering by variant codes and product attribute criteria.

You can now use the [`ProductServiceInterface::findVariants()`](../../../../../ibexa/product-catalog/src/contracts/ProductServiceInterface.php) method to search for variants across all products, regardless of their base product.

For more information, see [Product API - Searching variants](../../product_catalog/product_api/index.md#searching-for-variants-across-all-products).

### Infrastructure

#### Ibexa Cloud package

A new `ibexa/cloud` package is now available for Ibexa Cloud deployments. This package replaces the previous `composer ibexa:setup --platformsh` command with a dedicated console command.

The package automatically generates environment variables based on the configuration of relationships and routes in Ibexa Cloud, making it easier to configure services like databases, cache, search engines, and session storage.

For more information, see [Install on Ibexa Cloud](../../ibexa_cloud/install_on_ibexa_cloud/index.md) and [Environment variables on Ibexa Cloud](../../ibexa_cloud/environment_variables/index.md).

#### PHP 8.4 support

PHP 8.4 is now [officially supported](../../getting_started/requirements/index.md#php).

### Query subtree limit configuration

A new `query_subtree.limit` configuration option improves performance when working with large content trees by limiting count operations. This prevents performance degradation from database queries when determining if locations have children or calculating subtree sizes.

For more information, see [Subtree operations configuration](../../administration/back_office/back_office_configuration/index.md#subtree-operations).

### Improved HTTP caching for Page Builder and dashboard blocks (Experience, Commerce)

You can now indicate which [query parameters](https://en.wikipedia.org/wiki/Query_string) must be used as keys when generating [HTTP cache](../../infrastructure_and_maintenance/cache/http_cache/http_cache/index.md) for block requests.

This allows you to improve performance for blocks by utilizing HTTP cache more effectively, for example, for paginated blocks in the [dashboard](../../administration/dashboard/customize_dashboard/index.md).

To set it up, use the new `cacheable_query_params` [block setting](../../content_management/pages/page_blocks/index.md#block-configuration).

Then, adjust your [layouts](../../templating/render_content/render_page/index.md#configure-layout) and pass the parameters to [Symfony's `controller function`](https://symfony.com/doc/7.4/reference/twig_reference.html#controller) by using the new `ibexa_append_cacheable_query_params` Twig function, as in the example below:

```html+twig
{{ render_esi(controller('Ibexa\\Bundle\\FieldTypePage\\Controller\\BlockController::renderAction',
    {
        'locationId': locationId,
        'contentId': contentInfo.id,
        'blockId': block.id,
        'versionNo': versionInfo.versionNo,
        'languageCode': field.languageCode
    },
    ibexa_append_cacheable_query_params(block)
)) }}
```

### Developer experience

#### PHP API

The following additions were made to the PHP API:

- [`Ibexa\Contracts\Cdp\Value\Webhook\PersonIdType`](../../../../../ibexa/cdp/src/contracts/Value/Webhook/PersonIdType.php)
- [`Ibexa\Contracts\Cdp\Webhook`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-cdp-webhook.html)
- [`Ibexa\Contracts\Core\Persistence\Filter\Query`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-persistence-filter-query.html)
- [`Ibexa\Contracts\ImageEditor\Event`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-imageeditor-event.html)
- [`Ibexa\Contracts\ProductCatalog\Config`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-productcatalog-config.html)
- [`Ibexa\Contracts\ShoppingList`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-shoppinglist.html)
- [`Ibexa\Contracts\Taxonomy\Embedding\Exception`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-taxonomy-embedding-exception.html)

### Full changelog

To learn more about all the included changes, see the full release change logs:

- [Ibexa Headless v5.0.6](https://github.com/ibexa/headless/releases/tag/v5.0.6)
- [Ibexa Experience v5.0.6](https://github.com/ibexa/experience/releases/tag/v5.0.6)
- [Ibexa Commerce v5.0.6](https://github.com/ibexa/commerce/releases/tag/v5.0.6)

To update your application, see the [update instructions](../../update_and_migration/from_5.0/update_from_5.0/index.md#v506).

## Ibexa DXP v5.0.5 (Headless, Experience, Commerce)

Release date: 2026-01-15

### Infrastructure

#### Added support for Elasticsearch 8

Elasticsearch 8 is now officially supported. If you're currently using Elasticsearch 7, which is [no longer maintained](https://www.elastic.co/support/eol), it's recommended to upgrade. See the [update instructions](../../update_and_migration/from_5.0/update_from_5.0/index.md#update-elasticsearch-server) for more information.

#### Added support for Valkey

Valkey is now [officially supported](../../getting_started/requirements/index.md) alongside Redis.

#### Added support for PostgreSQL 18

PostgreSQL 18 is now [officially supported](https://doc.ibexa.co/en/5.0/getting_started/requirements#dbms).

### Developer experience

#### Easier debugging of Page Builder blocks

In Symfony's `dev` environment, use the "Open profiler" action to quickly debug Page Builder's block rendering failures.

![Quickly debug failing Page Builder blocks with "Open profiler" action](https://doc.ibexa.co/en/5.0/release_notes/img/5.0_open_in_profiler.png "Quickly debug failing Page Builder blocks with 'Open profiler' action")

#### Improved logging for Ibexa CDP

You can configure the new `ibexa.cdp.webhook` Monolog channels to direct all CDP webhook logs to specific output for easier separation of logs.

Example configuration:

```yaml
when@prod:
    monolog:
        handlers:
            cdp_webhook:
                type: stream
                path: "%kernel.logs_dir%/cdp_webhook_%kernel.environment%.log"
                level: debug
                channels: [ 'ibexa.cdp.webhook' ]
```

#### Added OpenAPI support for Collaborative editing REST API

The [Collaborative editing](../../content_management/collaborative_editing/collaborative_editing/index.md) REST API endpoints are now included in the [OpenAPI-based REST API reference](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Collaboration-Sessions).

### Full changelog

To learn more about all the included changes, see the full release change logs:

- [Ibexa Headless v5.0.5](https://github.com/ibexa/headless/releases/tag/v5.0.5)
- [Ibexa Experience v5.0.5](https://github.com/ibexa/experience/releases/tag/v5.0.5)
- [Ibexa Commerce v5.0.5](https://github.com/ibexa/commerce/releases/tag/v5.0.5)

To update your application, see the [update instructions](../../update_and_migration/from_5.0/update_from_5.0/index.md#v505).

## Integrated help v5.0.4 (Headless, Experience, Commerce, LTS Update, New feature, First release)

Release date: 2025-12-10

Integrated help brings contextual documentation, guidance, and partner-specific resources right into the user interface of Ibexa DXP. It helps editors, store managers, and developers to quickly access relevant content, training and resources without leaving the UI, narrowing the gap between product and documentation.

The default help menu can be modified to include links to internal editorial guidelines, custom tutorials, or support pages.

![Integrated help menu](https://doc.ibexa.co/en/5.0/administration/back_office/img/5_0_integrated_help_menu.png)

For more information, see [Integrated help](../../administration/back_office/integrated_help/index.md).

## Anthropic connector v5.0.4 (Headless, Experience, Commerce, LTS Update, New feature, First release)

Release date: 2025-12-10

This release introduces a new AI connector that allows you to integrate [AI Actions](../../ai/ai_actions/ai_actions/index.md) with [Anthropic Claude](https://claude.com/product/overview).

For more information, see how to [install Anthropic connector](https://doc.ibexa.co/en/5.0/ai/ai_actions/configure_ai_actions#install-anthropic-connector).

## Ibexa DXP v5.0.4 (Headless, Experience, Commerce, New feature)

Release date: 2025-12-10

### Security

This release includes security fixes. To learn more, see the [corresponding security advisory](https://developers.ibexa.co/security-advisories/ibexa-sa-2025-005-password-change-and-xss-vulnerabilities-in-back-office).

### Real-time collaborative editing

Real-time editing is now part of the [Collaborative editing](../../content_management/collaborative_editing/collaborative_editing/index.md) feature.

By using it, users can edit and review content in real time, making teamwork faster, more efficient, and streamlining the content review process. The system automatically tracks changes, allowing seamless collaboration within a single content item.

This extends the already existing capabilities allowing editors to work on the same content created in Ibexa DXP simultaneously, streamlining the content creation and review process.

![Participants list](https://doc.ibexa.co/en/5.0/release_notes/img/participants_list.png)

For more information, see how to [configure Collaborative editing](../../content_management/collaborative_editing/configure_collaborative_editing/index.md).

### Taxonomy suggestions for faster content classification

You can now speed up taxonomy assignment with AI-powered taxonomy suggestions.

Instead of manually browsing through large taxonomy trees and selecting categories or tags one by one, editors can choose from automatically generated suggestions based on the product or content information, for example name and description.

This approach reduces manual effort, minimizes errors, and significantly improves the speed and consistency of content and product classification.

![Taxonomy entries suggested by the AI Assistant](https://doc.ibexa.co/en/5.0/release_notes/img/taxonomy_suggestions_content.png "Taxonomy entries suggested by the AI Assistant")

For more information, see [Taxonomy suggestions](../../content_management/taxonomy/taxonomy/index.md#taxonomy-suggestions).

### Infrastructure

- MariaDB 11.4 is now [officially supported](../../getting_started/requirements/index.md#dbms)

### Developer experience

#### PHP API

The following additions were made to the PHP API:

##### Real-time collaborative editing

- [`Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\ParticipantScope`](../../../../../ibexa/collaboration/src/contracts/Invitation/Query/Criterion/ParticipantScope.php)
- [`Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\ParticipantType`](../../../../../ibexa/collaboration/src/contracts/Invitation/Query/Criterion/ParticipantType.php)
- [`Ibexa\Contracts\Collaboration\Participant\ParticipantDiscriminator`](../../../../../ibexa/collaboration/src/contracts/Participant/ParticipantDiscriminator.php)
- [`Ibexa\Contracts\FieldTypeRichTextRTE\ChannelIdGeneratorInterface`](../../../../../ibexa/fieldtype-richtext-rte/src/contracts/ChannelIdGeneratorInterface.php)
- [`Ibexa\Contracts\FieldTypeRichTextRTE\Config\LicenseKeyProviderInterface`](../../../../../ibexa/fieldtype-richtext-rte/src/contracts/Config/LicenseKeyProviderInterface.php)
- [`Ibexa\Contracts\FieldTypeRichTextRTE\Config\LocalStorageInterface`](../../../../../ibexa/fieldtype-richtext-rte/src/contracts/Config/LocalStorageInterface.php)
- [`Ibexa\Contracts\FieldTypeRichTextRTE\TokenServiceInterface`](../../../../../ibexa/fieldtype-richtext-rte/src/contracts/TokenServiceInterface.php)
- [`Ibexa\Contracts\FieldTypeRichTextRTE\ToS\LicenseTermsStatusServiceInterface`](../../../../../ibexa/fieldtype-richtext-rte/src/contracts/ToS/LicenseTermsStatusServiceInterface.php)
- [`Ibexa\Contracts\FieldTypeRichTextRTE\ToS\NoResponseException`](../../../../../ibexa/fieldtype-richtext-rte/src/contracts/ToS/NoResponseException.php)
- [`Ibexa\Contracts\FieldTypeRichTextRTE\ToS\Status`](../../../../../ibexa/fieldtype-richtext-rte/src/contracts/ToS/Status.php)
- [`Ibexa\Contracts\FieldTypeRichTextRTE\ToS\ToSServiceInterface`](../../../../../ibexa/fieldtype-richtext-rte/src/contracts/ToS/ToSServiceInterface.php)
- [`Ibexa\Contracts\Share\Mapper\Action\ShareActionItemsMapperInterface`](../../../../../ibexa/share/src/contracts/Mapper/Action/ShareActionItemsMapperInterface.php)

##### AI Taxonomy suggestions

- [`Ibexa\Contracts\ConnectorAi\Action\DataType\Taxonomy`](../../../../../ibexa/connector-ai/src/contracts/Action/DataType/Taxonomy.php)
- [`Ibexa\Contracts\ConnectorAi\Action\DataType\TaxonomyEntry`](../../../../../ibexa/connector-ai/src/contracts/Action/DataType/TaxonomyEntry.php)
- [`Ibexa\Contracts\ConnectorAi\Action\DataType\TaxonomySuggestion`](../../../../../ibexa/connector-ai/src/contracts/Action/DataType/TaxonomySuggestion.php)
- [`Ibexa\Contracts\ConnectorAi\Action\DataType\TaxonomySuggestionInterface`](../../../../../ibexa/connector-ai/src/contracts/Action/DataType/TaxonomySuggestionInterface.php)
- [`Ibexa\Contracts\ConnectorAi\Action\DataType\TextToTaxonomyInput`](../../../../../ibexa/connector-ai/src/contracts/Action/DataType/TextToTaxonomyInput.php)
- [`Ibexa\Contracts\ConnectorAi\Action\Response\TaxonomyResponse`](../../../../../ibexa/connector-ai/src/contracts/Action/Response/TaxonomyResponse.php)
- [`Ibexa\Contracts\ConnectorAi\Action\SuggestTaxonomyAction`](../../../../../ibexa/connector-ai/src/contracts/Action/SuggestTaxonomyAction.php)
- [`Ibexa\Contracts\ConnectorAi\Action\TextToTaxonomy\Action`](../../../../../ibexa/connector-ai/src/contracts/Action/TextToTaxonomy/Action.php)
- [`Ibexa\Contracts\ConnectorAi\Action\TextToTaxonomy\ActionResponse`](../../../../../ibexa/connector-ai/src/contracts/Action/TextToTaxonomy/ActionResponse.php)
- [`Ibexa\Contracts\ConnectorAi\Action\TextToTaxonomy\ActionType`](../../../../../ibexa/connector-ai/src/contracts/Action/TextToTaxonomy/ActionType.php)
- [`Ibexa\Contracts\Core\Repository\Values\Content\EmbeddingQuery`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/EmbeddingQuery.php)
- [`Ibexa\Contracts\Core\Repository\Values\Content\EmbeddingQueryBuilder`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/EmbeddingQueryBuilder.php)
- [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Embedding`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Embedding.php)
- [`Ibexa\Contracts\Core\Repository\Values\Content\QueryValidatorInterface`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/QueryValidatorInterface.php)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\ContentTypeGroupName`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/ContentTypeGroupName.php)
- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingConfigurationInterface`](../../../../../ibexa/core/src/contracts/Search/Embedding/EmbeddingConfigurationInterface.php)
- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderInterface`](../../../../../ibexa/core/src/contracts/Search/Embedding/EmbeddingProviderInterface.php)
- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderRegistryInterface`](../../../../../ibexa/core/src/contracts/Search/Embedding/EmbeddingProviderRegistryInterface.php)
- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderResolverInterface`](../../../../../ibexa/core/src/contracts/Search/Embedding/EmbeddingProviderResolverInterface.php)
- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingResolverNotFoundException`](../../../../../ibexa/core/src/contracts/Search/Embedding/EmbeddingResolverNotFoundException.php)
- [`Ibexa\Contracts\Core\Search\FieldType\EmbeddingField`](../../../../../ibexa/core/src/contracts/Search/FieldType/EmbeddingField.php)
- [`Ibexa\Contracts\Core\Search\FieldType\EmbeddingFieldFactory`](../../../../../ibexa/core/src/contracts/Search/FieldType/EmbeddingFieldFactory.php)
- [`Ibexa\Contracts\Elasticsearch\Query\EmbeddingVisitor`](../../../../../ibexa/elasticsearch/src/contracts/Query/EmbeddingVisitor.php)
- [`Ibexa\Contracts\Solr\Query\EmbeddingVisitor`](../../../../../ibexa/solr/src/contracts/Query/EmbeddingVisitor.php)
- [`Ibexa\Contracts\Taxonomy\Embedding\TaxonomyEmbeddingConfigurationInterface`](../../../../../ibexa/taxonomy/src/contracts/Embedding/TaxonomyEmbeddingConfigurationInterface.php)
- [`Ibexa\Contracts\Taxonomy\Embedding\TaxonomyEmbeddingFieldProviderInterface`](../../../../../ibexa/taxonomy/src/contracts/Embedding/TaxonomyEmbeddingFieldProviderInterface.php)
- [`Ibexa\Contracts\Taxonomy\Search\Query\Value\TaxonomyEmbedding`](../../../../../ibexa/taxonomy/src/contracts/Search/Query/Value/TaxonomyEmbedding.php)

##### Search

- [`Ibexa\Contracts\AdminUi\ContentType\ContentTypeFieldsByExpressionServiceInterface`](../../../../../ibexa/admin-ui/src/contracts/ContentType/ContentTypeFieldsByExpressionServiceInterface.php)
- [`Ibexa\Contracts\CoreSearch\Values\Query\PaginationAwareInterface`](../../../../../ibexa/core-search/src/contracts/Values/Query/PaginationAwareInterface.php)
- [`Ibexa\Contracts\SiteFactory\Values\Query\Criterion\MatchTreeRootLocationIds`](../../../../../ibexa/site-factory/src/contracts/Values/Query/Criterion/MatchTreeRootLocationIds.php)

##### Other

- [`Ibexa\Contracts\ProductCatalog\CapabilitiesEnum`](../../../../../ibexa/product-catalog/src/contracts/CapabilitiesEnum.php)
- [`Ibexa\Contracts\ProductCatalog\CapabilitiesServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/CapabilitiesServiceInterface.php)
- [`Ibexa\Contracts\User\PasswordReset\NotifierInterface`](../../../../../ibexa/user/src/contracts/PasswordReset/NotifierInterface.php)

To learn more about all the included changes, see the full release change logs:

- [Ibexa Headless v5.0.4](https://github.com/ibexa/headless/releases/tag/v5.0.4)
- [Ibexa Experience v5.0.4](https://github.com/ibexa/experience/releases/tag/v5.0.4)
- [Ibexa Commerce v5.0.4](https://github.com/ibexa/commerce/releases/tag/v5.0.4)

To update your application, see the [update instructions](../../update_and_migration/from_5.0/update_from_5.0/index.md#v504).

## Ibexa DXP v5.0.3 (Headless, Experience, Commerce)

Release date: 2024-10-17

### Security

This release includes security fixes. To learn more, see the [corresponding security advisory](https://developers.ibexa.co/security-advisories/ibexa-sa-2025-004-xss-and-enumeration-vulnerabilities-in-back-office).

### Developer experience

#### PHP API

The PHP API has been expanded with the following:

PHP API classes and interfaces

- [`Ibexa\Contracts\ContentForms\Event`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-contentforms-event.html)
- [`Ibexa\Contracts\Core\Persistence\Content\Type\CriterionHandlerInterface`](../../../../../ibexa/core/src/contracts/Persistence/Content/Type/CriterionHandlerInterface.php)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-repository-values-contenttype-query.html)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\ContentTypeQuery`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/ContentTypeQuery.php)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-repository-values-contenttype-query-criterion.html)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\CriterionInterface`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/CriterionInterface.php)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\SortClause`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/SortClause.php)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\SortClause`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-repository-values-contenttype-query-sortclause.html)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\SearchResult`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/SearchResult.php)

Events

- [`Ibexa\Contracts\ContentForms\Event\AutosaveEnabled`](../../../../../ibexa/content-forms/src/contracts/Event/AutosaveEnabled.php)

Search criteria

- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\ContainsFieldDefinitionId`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/ContainsFieldDefinitionId.php)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\ContentTypeGroupId`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/ContentTypeGroupId.php)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\ContentTypeId`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/ContentTypeId.php)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\ContentTypeIdentifier`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/ContentTypeIdentifier.php)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\IsSystem`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/IsSystem.php)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\LogicalAnd`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/LogicalAnd.php)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\LogicalNot`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/LogicalNot.php)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\LogicalOperator`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/LogicalOperator.php)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\LogicalOr`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/LogicalOr.php)

Sort clauses

- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\SortClause\Id`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/SortClause/Id.php)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\SortClause\Identifier`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/SortClause/Identifier.php)
- [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\SortClause\Name`](../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/SortClause/Name.php)

To learn more about all the included changes, see the full release change logs:

- [Ibexa Headless v5.0.3](https://github.com/ibexa/headless/releases/tag/v5.0.3)
- [Ibexa Experience v5.0.3](https://github.com/ibexa/experience/releases/tag/v5.0.3)
- [Ibexa Commerce v5.0.3](https://github.com/ibexa/commerce/releases/tag/v5.0.3)

To update your application, see the [update instructions](../../update_and_migration/from_5.0/update_from_5.0/index.md#v503).

## Ibexa DXP v5.0.2 (Headless, Experience, Commerce, New feature)

Release date: 2025-09-09

### Collaboration

The new [Collaborative editing feature](../../content_management/collaborative_editing/collaborative_editing_guide/index.md) allows multiple users to preview, review, and edit the same content, improving teamwork and streamlining the review process. Internal and external users can be invited to a collaboration session, through different sharing options.

With Real-time editing, more advanced part of the feature, users can see each other’s changes in the real time, or work on the content asynchronously.

Additionally, shared drafts can be accessed and managed through new dashboard tabs: **My shared drafts** and **Drafts shared with me**, helping users stay organized.

### Discount indexing

Discounts now allow scheduling a re-indexing of discounted product catalog prices at the most convenient time by using the Ibexa Messenger package. Ibexa Messenger is a customization of the Symfony Messenger package, created to adjust it to Ibexa DXP's needs.

Once properly configured, it uses a background queue to trigger price re-indexing, ensuring efficient use of system resources without causing performance disruptions.

### Improvements to notifications

An improved notifications system is now more intuitive. Developers can now create and configure their own notification types, while users can now [browse through a list of notifications](../../../user/getting_started/notifications/index.md), where they can either act on them or dismiss them.

![A searchable notifications list](https://doc.ibexa.co/en/5.0/release_notes/img/502_notifications_screen.png "A searchable notifications list")

### Chat GPT 5.0 support

With improved reasoning and greater accuracy in mind, the AI Connector package has been enhanced by adding ChatGPT 5.0 to its list of supported LLMs.

![ChatGPT 5.0 on a list of supported LLMs](https://doc.ibexa.co/en/5.0/release_notes/img/502_ai_connector_gpt_50.png "ChatGPT 5.0 on a list of supported LLMs")

### Developer experience

#### New packages

The following packages have been introduced in Ibexa DXP v5.0.2:

- ibexa/collaboration
- ibexa/messenger

#### New version of PHP Storm Plugin

To further improve your experience with Ibexa DXP, a 1.14.0 version of [PHP Storm Plugin](../../resources/phpstorm_plugin/index.md) has been released, which brings the following changes:

- Added support for Ibexa DXP v5.0
- Added compatibility with PhpStorm 2024.3.6+
- Added file template for Twig Component class
- Added code completion for Twig Component Groups in YAML config files and AsTwigComponent attribute
- Added code completion for Twig Component Types in YAML config files

#### REST APIs

Ibexa DXP v5.0.2 adds REST API coverage for the following features:

- Collaboration:
  - Invitation
  - CollaborationSession
  - Participant
  - ParticipantList
- AI Actions
  - Action
  - ActionType
  - ActionTypeList
  - ActionConfiguration
  - ActionConfigurationList
- Discounts
  - Discount
  - DiscountList

#### PHP API

The PHP API has been expanded with the following:

PHP API classes and interfaces

- [`Ibexa\Contracts\AdminUi\Exception`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-adminui-exception.html)
- [`Ibexa\Contracts\AdminUi\Exception\UnresolvedPreviewUrlException`](../../../../../ibexa/admin-ui/src/contracts/Exception/UnresolvedPreviewUrlException.php)
- [`Ibexa\Contracts\AdminUi\PreviewUrlResolver`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-adminui-previewurlresolver.html)
- [`Ibexa\Contracts\AdminUi\PreviewUrlResolver\VersionPreviewUrlResolverInterface`](../../../../../ibexa/admin-ui/src/contracts/PreviewUrlResolver/VersionPreviewUrlResolverInterface.php)
- [`Ibexa\Contracts\AutomatedTranslation\Exception`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-automatedtranslation-exception.html)
- [`Ibexa\Contracts\AutomatedTranslation\Exception\ClientNotConfiguredException`](../../../../../ibexa/automated-translation/src/contracts/Exception/ClientNotConfiguredException.php)
- [`Ibexa\Contracts\Collaboration\Configuration\ShareableUserConfigurationInterface`](../../../../../ibexa/collaboration/src/contracts/Configuration/ShareableUserConfigurationInterface.php)
- [`Ibexa\Contracts\Collaboration\Security`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-collaboration-security.html)
- [`Ibexa\Contracts\Collaboration\Security\ShareableLinkMatcherStrategyInterface`](../../../../../ibexa/collaboration/src/contracts/Security/ShareableLinkMatcherStrategyInterface.php)
- [`Ibexa\Contracts\Collaboration\Session\JoinSessionRedirectResolverInterface`](../../../../../ibexa/collaboration/src/contracts/Session/JoinSessionRedirectResolverInterface.php)
- [`Ibexa\Contracts\Collaboration\Session\LeaveSessionRedirectResolverInterface`](../../../../../ibexa/collaboration/src/contracts/Session/LeaveSessionRedirectResolverInterface.php)
- [`Ibexa\Contracts\Core\Validation\Constraint`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-validation-constraint.html)
- [`Ibexa\Contracts\Core\Validation\Constraint\UniqueIdentifier`](../../../../../ibexa/core/src/contracts/Validation/Constraint/UniqueIdentifier.php)
- [`Ibexa\Contracts\Core\Validation\Constraint\UniqueIdentifierValidator`](../../../../../ibexa/core/src/contracts/Validation/Constraint/UniqueIdentifierValidator.php)
- [`Ibexa\Contracts\Messenger`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-messenger.html)
- [`Ibexa\Contracts\Messenger\Transport`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-messenger-transport.html)
- [`Ibexa\Contracts\Messenger\Transport\MessageProviderInterface`](../../../../../ibexa/messenger/src/contracts/Transport/MessageProviderInterface.php)
- [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilder`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-productcatalog-values-product-query-attributecriterionbuilder.html)
- [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilderRegistry`](../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/AttributeCriterionBuilderRegistry.php)
- [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilderRegistryInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/AttributeCriterionBuilderRegistryInterface.php)
- [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilder\AttributeCriterionBuilderInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/AttributeCriterionBuilder/AttributeCriterionBuilderInterface.php)
- [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilder\CheckboxBuilder`](../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/AttributeCriterionBuilder/CheckboxBuilder.php)
- [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilder\ColorBuilder`](../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/AttributeCriterionBuilder/ColorBuilder.php)
- [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilder\FloatBuilder`](../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/AttributeCriterionBuilder/FloatBuilder.php)
- [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilder\IntegerBuilder`](../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/AttributeCriterionBuilder/IntegerBuilder.php)
- [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilder\SelectionBuilder`](../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/AttributeCriterionBuilder/SelectionBuilder.php)
- [`Ibexa\Contracts\Share\Permission\Mapper`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-share-permission-mapper.html)

Events

- [`Ibexa\Contracts\AdminUi\Event\ResolveVersionPreviewUrlEvent`](../../../../../ibexa/admin-ui/src/contracts/Event/ResolveVersionPreviewUrlEvent.php)
- [`Ibexa\Contracts\Collaboration\Session\Event\JoinSessionEvent`](../../../../../ibexa/collaboration/src/contracts/Session/Event/JoinSessionEvent.php)
- [`Ibexa\Contracts\Collaboration\Session\Event\SessionPublicPreviewEvent`](../../../../../ibexa/collaboration/src/contracts/Session/Event/SessionPublicPreviewEvent.php)
- [`Ibexa\Contracts\Discounts\Event\EnableDiscountEvent`](../../../../../ibexa/discounts/src/contracts/Event/EnableDiscountEvent.php)
- [`Ibexa\Contracts\Discounts\Event\BeforeDisableDiscountEvent`](../../../../../ibexa/discounts/src/contracts/Event/BeforeDisableDiscountEvent.php)
- [`Ibexa\Contracts\Discounts\Event\BeforeEnableDiscountEvent`](../../../../../ibexa/discounts/src/contracts/Event/BeforeEnableDiscountEvent.php)
- [`Ibexa\Contracts\Discounts\Event\DisableDiscountEvent`](../../../../../ibexa/discounts/src/contracts/Event/DisableDiscountEvent.php)
- [`Ibexa\Contracts\Share\Event\UsersWithPermissionInfoMappedEvent`](../../../../../ibexa/share/src/contracts/Event/UsersWithPermissionInfoMappedEvent.php)

Search criteria

- [`Ibexa\Contracts\Collaboration\Session\Query\Criterion\ParticipantToken`](../../../../../ibexa/collaboration/src/contracts/Session/Query/Criterion/ParticipantToken.php)
- [`Ibexa\Contracts\Discounts\Value\Query\Criterion\IndexedAtCriterion`](../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/IndexedAtCriterion.php)
- [`Ibexa\Contracts\Discounts\Value\Query\Criterion\UpdatedAtCriterion`](../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/UpdatedAtCriterion.php)

Sort clauses

- [`Ibexa\Contracts\Collaboration\Invitation\Query\SortClause\CreatedAt`](../../../../../ibexa/collaboration/src/contracts/Invitation/Query/SortClause/CreatedAt.php)
- [`Ibexa\Contracts\Collaboration\Invitation\Query\SortClause\Id`](../../../../../ibexa/collaboration/src/contracts/Invitation/Query/SortClause/Id.php)
- [`Ibexa\Contracts\Collaboration\Invitation\Query\SortClause\Status`](../../../../../ibexa/collaboration/src/contracts/Invitation/Query/SortClause/Status.php)
- [`Ibexa\Contracts\Collaboration\Invitation\Query\SortClause\UpdatedAt`](../../../../../ibexa/collaboration/src/contracts/Invitation/Query/SortClause/UpdatedAt.php)
- [`Ibexa\Contracts\Collaboration\Session\Query\SortClause\CreatedAt`](../../../../../ibexa/collaboration/src/contracts/Session/Query/SortClause/CreatedAt.php)
- [`Ibexa\Contracts\Collaboration\Session\Query\SortClause\Id`](../../../../../ibexa/collaboration/src/contracts/Session/Query/SortClause/Id.php)
- [`Ibexa\Contracts\Collaboration\Session\Query\SortClause\UpdatedAt`](../../../../../ibexa/collaboration/src/contracts/Session/Query/SortClause/UpdatedAt.php)

### Full changelog

To learn more about all the included changes, see the full release change logs:

- [Ibexa Headless v5.0.2](https://github.com/ibexa/headless/releases/tag/v5.0.2)
- [Ibexa Experience v5.0.2](https://github.com/ibexa/experience/releases/tag/v5.0.2)
- [Ibexa Commerce v5.0.2](https://github.com/ibexa/commerce/releases/tag/v5.0.2)

To update your application, see the [update instructions](../../update_and_migration/from_5.0/update_from_5.0/index.md#v502).

## Ibexa DXP v5.0.1 (Headless, Experience, Commerce, New feature)

Release date: 2025-08-19

### Special characters in online editor

The [online editor](../../content_management/rich_text/online_editor_guide/index.md) now allows to easily enter special characters like currency symbols. It uses the [special characters plugin](https://ckeditor.com/docs/ckeditor5/latest/features/special-characters.html).

![Special characters in online editor](https://doc.ibexa.co/en/5.0/release_notes/img/4.6_special_characters.png "Special characters in online editor")

### Support for Solr 9

With this release, Ibexa DXP starts supporting [Solr 9](../../getting_started/requirements/index.md#search).

Solr 9 comes with support for [Dense Vector Search](https://solr.apache.org/guide/solr/latest/query-guide/dense-vector-search.html), paving the way for incoming improvements to the [AI Actions](../../ai/ai_actions/ai_actions/index.md) feature.

### Improved content creation interface

The editing interface of the back office is now improved to better highlight the language, creator, and the publication date when working with content items.

![Improved interface for content creation](https://doc.ibexa.co/en/5.0/release_notes/img/4.6_improved_editing.png "Improved interface for content creation")

### Taxonomy Subtree limitation

You can now manage access to [taxonomy items](../../content_management/taxonomy/taxonomy/index.md) more effectively by using the new [Taxonomy Subtree limitation](../../permissions/limitation_reference/index.md#taxonomy-subtree-limitation).

In addition, you can now use the [Taxonomy limitation](../../permissions/limitation_reference/index.md#taxonomy-limitation) together with the `taxonomy/assign` policy.

### Base price column added to a Product Picker view

The Product Picker tool that, for example, lets you [select products eligible for discounts](../../../user/commerce/discounts/work_with_discounts/index.md#create-new-discount), now displays a **Base price** column for products and product variants.

### PHP API

The PHP API has been enhanced with the following new classes:

[`Ibexa\Contracts\Cart\Exception\VatCalculationExceptionInterface`](../../../../../ibexa/cart/src/contracts/Exception/VatCalculationExceptionInterface.php) [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\AbstractPriceRange`](../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/Criterion/AbstractPriceRange.php) [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\CustomPriceRange`](../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/Criterion/CustomPriceRange.php)

This release brings additional minor improvements to the developer's experience that result from capabilities offered by PHP in version 8.3.

### Full changelog

To learn more about all the included changes, see the full release change logs:

- [Ibexa Headless v5.0.1](https://github.com/ibexa/headless/releases/tag/v5.0.1)
- [Ibexa Experience v5.0.1](https://github.com/ibexa/experience/releases/tag/v5.0.1)
- [Ibexa Commerce v5.0.1](https://github.com/ibexa/commerce/releases/tag/v5.0.1)

To update your application, see the [update instructions](../../update_and_migration/from_5.0/update_from_5.0/index.md#v501).

## Ibexa DXP v5.0.0 (Headless, Experience, Commerce, New feature, First release)

Release date: 2025-07-22

### Notable changes

This version incorporates into the product numerous features brought by LTS Updates from previous versions, brings upgrades to the tech stack and improvements to developer experience.

#### AI Actions

The AI Actions feature enhances the usability and flexibility of Ibexa DXP by harnessing the potential of artificial intelligence to automate time-consuming editorial tasks. By default, the AI Actions feature can help users with their work in following scenarios:

- Refining text: when editing a content item, users can request that a passage selected in online editor is modified, for example, by adjusting the length of the text, changing its tone, or correcting linguistic errors
- Generating alternative text: when working with images, users can ask AI to generate alternative text for them, which helps improve accessibility and SEO

![AI Assistant](https://doc.ibexa.co/en/5.0/ai/ai_actions/img/ai_assistant.png)

AI Actions integrate with [Ibexa Connect](https://doc.ibexa.co/projects/connect/en/latest/), giving you an opportunity to build complex data transformation workflows without having to rely on custom code.

For more information, see [AI Actions product guide](../../ai/ai_actions/ai_actions_guide/index.md).

#### Discounts (Commerce)

With Discounts, you can temporarily or permanently reduce prices on specific products or categories, making deals more attractive to potential buyers.

Use them to encourage first-time purchases, reward loyal customers, promote new or slow-moving items, or drive sales during seasonal events.

By displaying discounted prices clearly in the catalog or cart, businesses can create a sense of urgency, increase customer satisfaction, and ultimately boost revenue.

![Discounts for products in the cart](https://doc.ibexa.co/en/5.0/release_notes/img/4.6_discounts.png)

For more information, see [Discounts product guide](../../discounts/discounts_guide/index.md).

#### Date and time attribute

The Date and time attributes allow you to represent date and time values as part of the product specification in the [product catalog](https://doc.ibexa.co/en/5.0/product_catalog/product_catalog_guide).

For more information, see [Date and time attributes](../../product_catalog/attributes/date_and_time/index.md).

#### Symbol attribute

The Symbol attributes allow you to efficiently represent the string-based data as part of the product specification in the [product catalog](https://doc.ibexa.co/en/5.0/product_catalog/product_catalog_guide).

For more information, see [Symbol attributes](../../product_catalog/attributes/symbol_attribute_type/index.md).

#### Collaboration

With Collaboration, multiple users can invite each other to work on the same content. It is a starting point for future functionalities in the collaboration domain.

![Collaboration invite](https://doc.ibexa.co/en/5.0/release_notes/img/5.0_collaborative_invitation.jpg "Collaboration invite")

For more information, see [Collaboration PHP API](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-collaboration.html) and [Share PHP API](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-share.html).

### Software architecture upgrades

With improved compatibility, performance and increased security, as well as better developer experience in mind, Ibexa decided to introduce several significant tech stack upgrades.

For a full list of updated system requirements, see [Requirements](../../getting_started/requirements/index.md).

#### Symfony 7.3

With this release, Ibexa DXP moves to Symfony 7.3 from the previously used versions of Symfony.

For details, see [Symfony 7.3](https://symfony.com/blog/symfony-7-3-curated-new-features).

#### Doctrine DBAL 3.9

By moving to Doctrine DBAL 3.9, Ibexa DXP brings developers better performance, cleaner code, and stronger foundation for a more modern and maintainable application.

#### PHP 8.3

With performance, coding safety and security in mind, with this version, Ibexa DXP moves to [PHP 8.3](https://www.php.net/releases/8.3/en.php) and drops support for lower versions of the language.

#### OpenAPI support

Adding support for generating the [OpenAPI](https://www.openapis.org/) specification for our REST API makes future changes more manageable, and helps our partners automatically generate REST API clients.

For more information, see [REST API usage](../../api/rest_api/rest_api_usage/rest_api_usage/index.md#openapi-support).

Support for serialization and deserialization of REST payloads with the [Symfony Serializer](https://symfony.com/doc/current/serializer.html) component improves data reliability and simplifies debugging.

#### React 19

Ibexa DXP's Back Office now uses [React 19](https://react.dev/blog/2024/12/05/react-19). This upgrade enhances maintainability, unlocks new UI capabilities, and simplifies future feature development.

### Developer experience

#### New packages

The following packages have been introduced in Ibexa DXP v5.0.0:

- ibexa/collaboration
- ibexa/connector-ai
- ibexa/connector-openai
- ibexa/discounts
- ibexa/discounts-codes
- ibexa/product-catalog-date-time-attribute
- ibexa/product-catalog-symbol-attribute
- ibexa/share

#### REST APIs

Ibexa DXP v5.0.0 adds REST API coverage for the following features:

- AI Actions:
  - Action Configurations
  - Action Types
- Discounts
- Collaboration

#### PHP API

The PHP API has been expanded with the following classes and interfaces:

AI Actions

- [`Ibexa\Contracts\ConnectorAi\Action\Action`](../../../../../ibexa/connector-ai/src/contracts/Action/Action.php)
- [`Ibexa\Contracts\ConnectorAi\Action\ActionContext`](../../../../../ibexa/connector-ai/src/contracts/Action/ActionContext.php)
- [`Ibexa\Contracts\ConnectorAi\Action\ActionFactoryInterface`](../../../../../ibexa/connector-ai/src/contracts/Action/ActionFactoryInterface.php)
- [`Ibexa\Contracts\ConnectorAi\Action\ActionHandlerInterface`](../../../../../ibexa/connector-ai/src/contracts/Action/ActionHandlerInterface.php)
- [`Ibexa\Contracts\ConnectorAi\Action\ActionHandlerResolverInterface`](../../../../../ibexa/connector-ai/src/contracts/Action/ActionHandlerResolverInterface.php)
- [`Ibexa\Contracts\ConnectorAi\Action\GenerateAltTextAction`](../../../../../ibexa/connector-ai/src/contracts/Action/GenerateAltTextAction.php)
- [`Ibexa\Contracts\ConnectorAi\Action\LLMBaseActionTypeInterface`](../../../../../ibexa/connector-ai/src/contracts/Action/LLMBaseActionTypeInterface.php)
- [`Ibexa\Contracts\ConnectorAi\Action\RefineTextAction`](../../../../../ibexa/connector-ai/src/contracts/Action/RefineTextAction.php)
- [`Ibexa\Contracts\ConnectorAi\Action\RuntimeContext`](../../../../../ibexa/connector-ai/src/contracts/Action/RuntimeContext.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationCreateStruct`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/ActionConfigurationCreateStruct.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationCopyStruct`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/ActionConfigurationCopyStruct.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationListInterface`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/ActionConfigurationListInterface.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationOptions`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/ActionConfigurationOptions.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationQuery`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/ActionConfigurationQuery.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationUpdateStruct`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/ActionConfigurationUpdateStruct.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionHandlerOptionsFormMapperInterface`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/ActionHandlerOptionsFormMapperInterface.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionTypeOptionsFormMapperInterface`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/ActionTypeOptionsFormMapperInterface.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\OptionsFormatterInterface`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/OptionsFormatterInterface.php)
- [`Ibexa\Contracts\ConnectorAi\ActionType\ActionTypeFactoryInterface`](../../../../../ibexa/connector-ai/src/contracts/ActionType/ActionTypeFactoryInterface.php)
- [`Ibexa\Contracts\ConnectorAi\ActionType\ActionTypeInterface`](../../../../../ibexa/connector-ai/src/contracts/ActionType/ActionTypeInterface.php)
- [`Ibexa\Contracts\ConnectorAi\ActionType\ActionTypeRegistryInterface`](../../../../../ibexa/connector-ai/src/contracts/ActionType/ActionTypeRegistryInterface.php)
- [`Ibexa\Contracts\ConnectorAi\ActionType\OptionsValidatorError`](../../../../../ibexa/connector-ai/src/contracts/ActionType/OptionsValidatorError.php)
- [`Ibexa\Contracts\ConnectorAi\ActionType\OptionsValidatorInterface`](../../../../../ibexa/connector-ai/src/contracts/ActionType/OptionsValidatorInterface.php)
- [`Ibexa\Contracts\ConnectorAi\ActionType\OptionsValidatorRegistryInterface`](../../../../../ibexa/connector-ai/src/contracts/ActionType/OptionsValidatorRegistryInterface.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfigurationInterface`](../../../../../ibexa/connector-ai/src/contracts/ActionConfigurationInterface.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfigurationServiceDecorator`](../../../../../ibexa/connector-ai/src/contracts/ActionConfigurationServiceDecorator.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfigurationServiceInterface`](../../../../../ibexa/connector-ai/src/contracts/ActionConfigurationServiceInterface.php)
- [`Ibexa\Contracts\ConnectorAi\ActionHandlerRegistryInterface`](../../../../../ibexa/connector-ai/src/contracts/ActionHandlerRegistryInterface.php)
- [`Ibexa\Contracts\ConnectorAi\ActionInterface`](../../../../../ibexa/connector-ai/src/contracts/ActionInterface.php)
- [`Ibexa\Contracts\ConnectorAi\ActionResponseInterface`](../../../../../ibexa/connector-ai/src/contracts/ActionResponseInterface.php)
- [`Ibexa\Contracts\ConnectorAi\ActionServiceDecorator`](../../../../../ibexa/connector-ai/src/contracts/ActionServiceDecorator.php)
- [`Ibexa\Contracts\ConnectorAi\ActionServiceInterface`](../../../../../ibexa/connector-ai/src/contracts/ActionServiceInterface.php)
- [`Ibexa\Contracts\ConnectorAi\AdapterAwareActionInterface`](../../../../../ibexa/connector-ai/src/contracts/AdapterAwareActionInterface.php)
- [`Ibexa\Contracts\ConnectorAi\DataType`](../../../../../ibexa/connector-ai/src/contracts/DataType.php)
- [`Ibexa\Contracts\ConnectorAi\PromptResolverInterface`](../../../../../ibexa/connector-ai/src/contracts/PromptResolverInterface.php)
- [`Ibexa\Contracts\ConnectorAi\Prompt\PromptFactory`](../../../../../ibexa/connector-ai/src/contracts/Prompt/PromptFactory.php)
- [`Ibexa\Contracts\ConnectorAi\Prompt\PromptInterface`](../../../../../ibexa/connector-ai/src/contracts/Prompt/PromptInterface.php)
- [`Ibexa\Contracts\ConnectorAi\PromptResolverInterface`](../../../../../ibexa/connector-ai/src/contracts/PromptResolverInterface.php)
- [`Ibexa\Contracts\ConnectorOpenAi\ClientProviderInterface`](../../../../../ibexa/connector-openai/src/contracts/ClientProviderInterface.php)

Discounts

- [`Ibexa\Contracts\Discounts\DiscountConditionCriterionMapperInterface`](../../../../../ibexa/discounts/src/contracts/DiscountConditionCriterionMapperInterface.php)
- [`Ibexa\Contracts\Discounts\DiscountFormMapperInterface`](../../../../../ibexa/discounts/src/contracts/DiscountFormMapperInterface.php)
- [`Ibexa\Contracts\Discounts\DiscountPrioritizationStrategyInterface`](../../../../../ibexa/discounts/src/contracts/DiscountPrioritizationStrategyInterface.php)
- [`Ibexa\Contracts\Discounts\DiscountServiceDecorator`](../../../../../ibexa/discounts/src/contracts/DiscountServiceDecorator.php)
- [`Ibexa\Contracts\Discounts\DiscountServiceInterface`](../../../../../ibexa/discounts/src/contracts/DiscountServiceInterface.php)
- [`Ibexa\Contracts\Discounts\DiscountValueFormatterInterface`](../../../../../ibexa/discounts/src/contracts/DiscountValueFormatterInterface.php)
- [`Ibexa\Contracts\Discounts\DiscountVariablesResolverInterface`](../../../../../ibexa/discounts/src/contracts/DiscountVariablesResolverInterface.php)
- [`Ibexa\Contracts\Discounts\Admin\Form\DiscountValueFormTypeMapperInterface`](../../../../../ibexa/discounts/src/contracts/Admin/Form/DiscountValueFormTypeMapperInterface.php)
- [`Ibexa\Contracts\Discounts\Admin\Form\FormThemeProviderInterface`](../../../../../ibexa/discounts/src/contracts/Admin/Form/FormThemeProviderInterface.php)
- [`Ibexa\Contracts\Discounts\Admin\FormMapper\ConditionsMapperInterface`](../../../../../ibexa/discounts/src/contracts/Admin/FormMapper/ConditionsMapperInterface.php)
- [`Ibexa\Contracts\Discounts\Admin\FormMapper\DiscountValueMapperInterface`](../../../../../ibexa/discounts/src/contracts/Admin/FormMapper/DiscountValueMapperInterface.php)
- [`Ibexa\Contracts\Discounts\Admin\FormMapper\GeneralPropertiesMapperInterface`](../../../../../ibexa/discounts/src/contracts/Admin/FormMapper/GeneralPropertiesMapperInterface.php)
- [`Ibexa\Contracts\Discounts\Admin\FormMapper\ProductConditionsMapperInterface`](../../../../../ibexa/discounts/src/contracts/Admin/FormMapper/ProductConditionsMapperInterface.php)
- [`Ibexa\Contracts\Discounts\Admin\FormMapper\StepDataObjectMapperInterface`](../../../../../ibexa/discounts/src/contracts/Admin/FormMapper/StepDataObjectMapperInterface.php)
- [`Ibexa\Contracts\Discounts\Admin\FormMapper\UserConditionsMapperInterface`](../../../../../ibexa/discounts/src/contracts/Admin/FormMapper/UserConditionsMapperInterface.php)
- [`Ibexa\Contracts\Discounts\Exception\DiscountConditionNotFoundException`](../../../../../ibexa/discounts/src/contracts/Exception/DiscountConditionNotFoundException.php)
- [`Ibexa\Contracts\Discounts\Exception\DiscountExpressionInvalidArgumentException`](../../../../../ibexa/discounts/src/contracts/Exception/DiscountExpressionInvalidArgumentException.php)
- [`Ibexa\Contracts\Discounts\Exception\DiscountExpressionRuntimeException`](../../../../../ibexa/discounts/src/contracts/Exception/DiscountExpressionRuntimeException.php)
- [`Ibexa\Contracts\Discounts\Exception\DiscountNotFoundException`](../../../../../ibexa/discounts/src/contracts/Exception/DiscountNotFoundException.php)
- [`Ibexa\Contracts\Discounts\Exception\DiscountRuleNotFoundException`](../../../../../ibexa/discounts/src/contracts/Exception/DiscountRuleNotFoundException.php)
- [`Ibexa\Contracts\Discounts\Exception\DiscountValueResolutionException`](../../../../../ibexa/discounts/src/contracts/Exception/DiscountValueResolutionException.php)
- [`Ibexa\Contracts\Discounts\Policy\AbstractDiscountPolicy`](../../../../../ibexa/discounts/src/contracts/Policy/AbstractDiscountPolicy.php)
- [`Ibexa\Contracts\Discounts\Policy\Create`](../../../../../ibexa/discounts/src/contracts/Policy/Create.php)
- [`Ibexa\Contracts\Discounts\Policy\Delete`](../../../../../ibexa/discounts/src/contracts/Policy/Delete.php)
- [`Ibexa\Contracts\Discounts\Policy\Disable`](../../../../../ibexa/discounts/src/contracts/Policy/Disable.php)
- [`Ibexa\Contracts\Discounts\Policy\Enable`](../../../../../ibexa/discounts/src/contracts/Policy/Enable.php)
- [`Ibexa\Contracts\Discounts\Policy\Update`](../../../../../ibexa/discounts/src/contracts/Policy/Update.php)
- [`Ibexa\Contracts\Discounts\Policy\View`](../../../../../ibexa/discounts/src/contracts/Policy/View.php)
- [`Ibexa\Contracts\Discounts\Value\CartDiscountConditionInterface`](../../../../../ibexa/discounts/src/contracts/Value/CartDiscountConditionInterface.php)
- [`Ibexa\Contracts\Discounts\Value\DiscountConditionInterface`](../../../../../ibexa/discounts/src/contracts/Value/DiscountConditionInterface.php)
- [`Ibexa\Contracts\Discounts\Value\DiscountExpressionAwareInterface`](../../../../../ibexa/discounts/src/contracts/Value/DiscountExpressionAwareInterface.php)
- [`Ibexa\Contracts\Discounts\Value\DiscountInterface`](../../../../../ibexa/discounts/src/contracts/Value/DiscountInterface.php)
- [`Ibexa\Contracts\Discounts\Value\DiscountListInterface`](../../../../../ibexa/discounts/src/contracts/Value/DiscountListInterface.php)
- [`Ibexa\Contracts\Discounts\Value\DiscountRuleInterface`](../../../../../ibexa/discounts/src/contracts/Value/DiscountRuleInterface.php)
- [`Ibexa\Contracts\Discounts\Value\DiscountTranslationInterface`](../../../../../ibexa/discounts/src/contracts/Value/DiscountTranslationInterface.php)
- [`Ibexa\Contracts\Discounts\Value\DiscountType`](../../../../../ibexa/discounts/src/contracts/Value/DiscountType.php)
- [`Ibexa\Contracts\Discounts\Value\DiscountValueInterface`](../../../../../ibexa/discounts/src/contracts/Value/DiscountValueInterface.php)
- [`Ibexa\Contracts\Discounts\Value\Struct\DiscountCreateStruct`](../../../../../ibexa/discounts/src/contracts/Value/Struct/DiscountCreateStruct.php)
- [`Ibexa\Contracts\Discounts\Value\Struct\DiscountStructInterface`](../../../../../ibexa/discounts/src/contracts/Value/Struct/DiscountStructInterface.php)
- [`Ibexa\Contracts\Discounts\Value\DiscountTranslationStruct`](../../../../../ibexa/discounts/src/contracts/Value/Struct/DiscountTranslationStruct.php)
- [`Ibexa\Contracts\Discounts\Value\DiscountUpdateStruct`](../../../../../ibexa/discounts/src/contracts/Value/Struct/DiscountUpdateStruct.php)
- [`Ibexa\Contracts\Discounts\Value\TranslationAwareDiscountStructInterface`](../../../../../ibexa/discounts/src/contracts/Value/Struct/TranslationAwareDiscountStructInterface.php)
- [`Ibexa\Contracts\Discounts\Value\TranslationAwareDiscountStructTrait`](../../../../../ibexa/discounts/src/contracts/Value/Struct/TranslationAwareDiscountStructTrait.php)
- [`Ibexa\Contracts\DiscountsCodes\Exception\DiscountCodeNotFoundException`](../../../../../ibexa/discounts-codes/src/contracts/Exception/DiscountCodeNotFoundException.php)
- [`Ibexa\Contracts\DiscountsCodes\Exception\DiscountCodeRateLimitExceededException`](../../../../../ibexa/discounts-codes/src/contracts/Exception/DiscountCodeRateLimitExceededException.php)
- [`Ibexa\Contracts\DiscountsCodes\Exception\DiscountCodeUnusableException`](../../../../../ibexa/discounts-codes/src/contracts/Exception/DiscountCodeUnusableException.php)
- [`Ibexa\Contracts\DiscountsCodes\Exception\DiscountCodeUserInvalidArgumentException`](../../../../../ibexa/discounts-codes/src/contracts/Exception/DiscountCodeUserInvalidArgumentException.php)
- [`Ibexa\Contracts\DiscountsCodes\Value\DiscountCodeUsageInterface`](../../../../../ibexa/discounts-codes/src/contracts/Value/DiscountCodeUsageInterface.php)
- [`Ibexa\Contracts\DiscountsCodes\Value\DiscountCodeUser`](../../../../../ibexa/discounts-codes/src/contracts/Value/DiscountCodeUser.php)
- [`Ibexa\Contracts\DiscountsCodes\Value\Query\DiscountCodeUsageQuery`](../../../../../ibexa/discounts-codes/src/contracts/Value/Query/DiscountCodeUsageQuery.php)
- [`Ibexa\Contracts\DiscountsCodes\Value\Struct\DiscountCodeCreateStruct`](../../../../../ibexa/discounts-codes/src/contracts/Value/Struct/DiscountCodeCreateStruct.php)
- [`Ibexa\Contracts\DiscountsCodes\Value\StructDiscountCodeUpdateStruct`](../../../../../ibexa/discounts-codes/src/contracts/Value/Struct/DiscountCodeUpdateStruct.php)

Product catalog attributes

- [`Ibexa\Contracts\ProductCatalogDateTimeAttribute`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-productcatalogdatetimeattribute.html)
- [`Ibexa\Contracts\ProductCatalogSymbolAttribute`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-productcatalogsymbolattribute.html)

#### Search Criteria

The following search criteria have been added in the v5.0 release:

AI Actions

- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Enabled`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/Criterion/Enabled.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Identifier`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/Criterion/Identifier.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\LogicalAnd`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/Criterion/LogicalAnd.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\LogicalOr`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/Criterion/LogicalOr.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Name`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/Criterion/Name.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Type`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/Criterion/Type.php)

Discounts

- [`Ibexa\Contracts\Discounts\Value\Query\Criterion\CreatedAtCriterion`](../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/CreatedAtCriterion.php)
- [`Ibexa\Contracts\Discounts\Value\Query\Criterion\CreatorCriterion`](../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/CreatorCriterion.php)
- [`Ibexa\Contracts\Discounts\Value\Query\Criterion\EndDateCriterion`](../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/EndDateCriterion.php)
- [`Ibexa\Contracts\Discounts\Value\Query\Criterion\IdentifierCriterion`](../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/IdentifierCriterion.php)
- [`Ibexa\Contracts\Discounts\Value\Query\Criterion\IsEnabledCriterion`](../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/IsEnabledCriterion.php)
- [`Ibexa\Contracts\Discounts\Value\Query\Criterion\LogicalAnd`](../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/LogicalAnd.php)
- [`Ibexa\Contracts\Discounts\Value\Query\Criterion\LogicalOr`](../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/LogicalOr.php)
- [`Ibexa\Contracts\Discounts\Value\Query\Criterion\NameCriterion`](../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/NameCriterion.php)
- [`Ibexa\Contracts\Discounts\Value\Query\Criterion\PriorityCriterion`](../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/PriorityCriterion.php)
- [`Ibexa\Contracts\Discounts\Value\Query\Criterion\StartDateCriterion`](../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/StartDateCriterion.php)
- [`Ibexa\Contracts\Discounts\Value\Query\Criterion\TypeCriterion`](../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/TypeCriterion.php)

Product catalog attributes

- [`Ibexa\Contracts\ProductCatalogDateTimeAttribute\Search\Criterion\DateTimeAttribute`](../../../../../ibexa/product-catalog-date-time-attribute/src/contracts/Search/Criterion/DateTimeAttribute.php)
- [`Ibexa\Contracts\ProductCatalogDateTimeAttribute\Search\Criterion\DateTimeAttributeRange`](../../../../../ibexa/product-catalog-date-time-attribute/src/contracts/Search/Criterion/DateTimeAttributeRange.php)
- [`Ibexa\Contracts\ProductCatalogSymbolAttribute\Search\Criterion\SymbolAttribute`](../../../../../ibexa/product-catalog-symbol-attribute/src/contracts/Search/Criterion/SymbolAttribute.php)

#### Sort Clauses

The following sort clauses have been added in the v5.0 release:

AI Actions

- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause\Enabled`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/SortClause/Enabled.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause\Id`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/SortClause/Id.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause\Identifier`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/SortClause/Identifier.php)

Discounts

- [`Ibexa\Contracts\Discounts\Value\Query\SortClause\CreatedAt`](../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/CreatedAt.php)
- [`Ibexa\Contracts\Discounts\Value\Query\SortClause\EndDate`](../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/EndDate.php)
- [`Ibexa\Contracts\Discounts\Value\Query\SortClause\Id`](../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/Id.php)
- [`Ibexa\Contracts\Discounts\Value\Query\SortClause\Identifier`](../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/Identifier.php)
- [`Ibexa\Contracts\Discounts\Value\Query\SortClause\Priority`](../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/Priority.php)
- [`Ibexa\Contracts\Discounts\Value\Query\SortClause\StartDate`](../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/StartDate.php)
- [`Ibexa\Contracts\Discounts\Value\Query\SortClause\Type`](../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/Type.php)
- [`Ibexa\Contracts\Discounts\Value\Query\SortClause\UpdatedAt`](../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/UpdatedAt.php)

#### Events

The following events have been added in the v5.0 release:

AI Actions

- [`\Ibexa\Contracts\ConnectorAi\Action\Event\BeforeExecuteEvent`](../../../../../ibexa/connector-ai/src/contracts/Action/Event/BeforeExecuteEvent.php)
- [`\Ibexa\Contracts\ConnectorAi\Action\Event\ExecuteEvent`](../../../../../ibexa/connector-ai/src/contracts/Action/Event/ExecuteEvent.php)
- [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\BeforeCreateActionConfigurationEvent`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Event/BeforeCreateActionConfigurationEvent.php)
- [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\CreateActionConfigurationEvent`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Event/CreateActionConfigurationEvent.php)
- [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\BeforeUpdateActionConfigurationEvent`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Event/BeforeUpdateActionConfigurationEvent.php)
- [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\UpdateActionConfigurationEvent`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Event/UpdateActionConfigurationEvent.php)
- [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\BeforeDeleteActionConfigurationEvent`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Event/BeforeDeleteActionConfigurationEvent.php)
- [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\DeleteActionConfigurationEvent`](../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Event/DeleteActionConfigurationEvent.php)
- [`Ibexa\Contracts\ConnectorAi\Events\ContextEvent`](../../../../../ibexa/connector-ai/src/contracts/Events/ContextEvent.php)
- [`Ibexa\Contracts\ConnectorAi\Events\ResolveActionConfigurationWidgetConfigEvent`](../../../../../ibexa/connector-ai/src/contracts/Events/ResolveActionConfigurationWidgetConfigEvent.php)
- [`Ibexa\Contracts\ConnectorAi\Events\ResolveActionHandlerEvent`](../../../../../ibexa/connector-ai/src/contracts/Events/ResolveActionHandlerEvent.php)

Discounts

- [`\Ibexa\Contracts\Discounts\Event\BeforeCreateDiscountEvent`](../../../../../ibexa/discounts/src/contracts/Event/BeforeCreateDiscountEvent.php)
- [`\Ibexa\Contracts\Discounts\Event\CreateDiscountEvent`](../../../../../ibexa/discounts/src/contracts/Event/CreateDiscountEvent.php)
- [`\Ibexa\Contracts\Discounts\Event\BeforeDeleteDiscountEvent`](../../../../../ibexa/discounts/src/contracts/Event/BeforeDeleteDiscountEvent.php)
- [`\Ibexa\Contracts\Discounts\Event\DeleteDiscountEvent`](../../../../../ibexa/discounts/src/contracts/Event/DeleteDiscountEvent.php)
- [`\Ibexa\Contracts\Discounts\Event\BeforeUpdateDiscountEvent`](../../../../../ibexa/discounts/src/contracts/Event/BeforeUpdateDiscountEvent.php)
- [`\Ibexa\Contracts\Discounts\Event\UpdateDiscountEvent`](../../../../../ibexa/discounts/src/contracts/Event/UpdateDiscountEvent.php)
- [`\Ibexa\Contracts\Discounts\Event\CreateDiscountCreateStructEvent`](../../../../../ibexa/discounts/src/contracts/Event/CreateDiscountCreateStructEvent.php)
- [`\Ibexa\Contracts\Discounts\Event\CreateDiscountUpdateStructEvent`](../../../../../ibexa/discounts/src/contracts/Event/CreateDiscountUpdateStructEvent.php)
- [`\Ibexa\Contracts\Discounts\Event\CreateFormDataEvent`](../../../../../ibexa/discounts/src/contracts/Event/CreateFormDataEvent.php)
- [`\Ibexa\Contracts\Discounts\Event\MapDiscountToFormDataEvent`](../../../../../ibexa/discounts/src/contracts/Event/MapDiscountToFormDataEvent.php)
- [`\Ibexa\Contracts\Discounts\Event\Step\CreateFormDataEvent`](../../../../../ibexa/discounts/src/contracts/Event/CreateFormDataEvent.php)
- [`\Ibexa\Contracts\Discounts\Event\Step\MapCreateDataToStructEvent`](../../../../../ibexa/discounts/src/contracts/Event/Step/MapCreateDataToStructEvent.php)
- [`\Ibexa\Contracts\Discounts\Event\Step\MapDiscountToFormDataEvent`](../../../../../ibexa/discounts/src/contracts/Event/MapDiscountToFormDataEvent.php)
- [`\Ibexa\Contracts\Discounts\Event\Step\MapUpdateDataToStructEvent`](../../../../../ibexa/discounts/src/contracts/Event/Step/MapUpdateDataToStructEvent.php)
- [`\Ibexa\Contracts\Discounts\Admin\Form\Event\PreDiscountCreateEvent`](../../../../../ibexa/discounts/src/contracts/Admin/Form/Event/PreDiscountCreateEvent.php)
- [`\Ibexa\Contracts\DiscountsCodes\Event\BeforeDiscountCodeApplyEvent`](../../../../../ibexa/discounts-codes/src/contracts/Event/BeforeDiscountCodeApplyEvent.php)

#### Twig functions

The following Twig functions have been added in the v5.0 release:

- [`ibexa_ai_config`](https://doc.ibexa.co/en/5.0/templating/twig_function_reference/ai_actions_twig_functions#ibexa_ai_config)
- [`ibexa_render_discount_rule_type`](https://doc.ibexa.co/en/5.0/templating/twig_function_reference/discounts_twig_functions#ibexa_render_discount_rule_type)
- [`ibexa_discounts_render_discount_badge`](https://doc.ibexa.co/en/5.0/templating/twig_function_reference/discounts_twig_functions#ibexa_discounts_render_discount_badge)
- [`ibexa_get_original_price`](https://doc.ibexa.co/en/5.0/templating/twig_function_reference/discounts_twig_functions#ibexa_get_original_price)
- [`ibexa_format_discount_value`](https://doc.ibexa.co/en/5.0/templating/twig_function_reference/discounts_twig_functions#ibexa_format_discount_value)
- [`ibexa_discounts_is_active`](https://doc.ibexa.co/en/5.0/templating/twig_function_reference/discounts_twig_functions#ibexa_discounts_is_active)
- [`ibexa_discounts_form_themes`](https://doc.ibexa.co/en/5.0/templating/twig_function_reference/discounts_twig_functions#ibexa_discounts_form_themes)
- [`ibexa_discounts_can_edit`](https://doc.ibexa.co/en/5.0/templating/twig_function_reference/discounts_twig_functions#ibexa_discounts_can_edit)
- [`ibexa_discounts_can_enable`](https://doc.ibexa.co/en/5.0/templating/twig_function_reference/discounts_twig_functions#ibexa_discounts_can_enable)
- [`ibexa_discounts_can_disable`](https://doc.ibexa.co/en/5.0/templating/twig_function_reference/discounts_twig_functions#ibexa_discounts_can_disable)
- [`ibexa_discounts_can_delete`](https://doc.ibexa.co/en/5.0/templating/twig_function_reference/discounts_twig_functions#ibexa_discounts_can_delete)

#### Other upgrades

This release brings other minor upgrades intended to improve the developer's experience:

- To improve code clarity, reliability, and error detection, type hint declarations that specify the expected data type have been added in multiple places throughout the product
- In anticipation of [changes coming with PHP 8.4](https://php.watch/versions/8.4/implicitly-marking-parameter-type-nullable-deprecated), implicit nullable type declarations have been replaced with nullable type declarations throughout the product code. It is recommended that you update your custom code in the same way
- Developer experience has improved with capabilities offered by PHP in version 8.3. For example, the `AsTwigComponent` attribute [facilitates autoconfiguration](../../templating/components/index.md#php-code) of Twig components
- With protection against breaking changes and easier refactoring in mind, [TypeScript](https://www.typescriptlang.org/) can now be used to extend the Back Office
- [Ibexa Rector package](https://github.com/ibexa/rector) has been introduced that is based on [Rector](https://github.com/rectorphp) and comes with additional rules for working with Ibexa code. You can use it to get rid of PHP code deprecations
- [New icons](https://doc.ibexa.co/en/5.0/templating/twig_function_reference/icon_twig_functions#icons-reference) replace the ones found in previous versions and serve as a highlight of a future system design

### Deprecations

Refer to [Ibexa DXP v5.0 renames, deprecations and removals](../ibexa_dxp_v5.0_deprecations/index.md) for a full list of changes and how they influence your project.

### Full changelog

To learn more about all the included changes, see the full release change logs:

- [Ibexa Headless v5.0.0](https://github.com/ibexa/headless/releases/tag/v5.0.0)
- [Ibexa Experience v5.0.0](https://github.com/ibexa/experience/releases/tag/v5.0.0)
- [Ibexa Commerce v5.0.0](https://github.com/ibexa/commerce/releases/tag/v5.0.0)

To update your application, see the [update instructions](../../update_and_migration/from_4.6/update_to_5.0/index.md).
