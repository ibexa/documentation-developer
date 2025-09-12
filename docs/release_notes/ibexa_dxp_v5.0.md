---
description: Ibexa DXP v5.0 incorporates features brought by LTS Updates from previous versions, brings upgrades to the tech stack and improvements to developer experience.
title: Ibexa DXP v5.0 LTS
month_change: true
---

<!-- vale VariablesVersion = NO -->

[[= release_notes_filters('Ibexa DXP v5.0 LTS', ['Headless', 'Experience', 'Commerce', 'LTS Update', 'New feature']) =]]

<div class="release-notes" markdown="1">

[[% set version = 'v5.0.2' %]]

[[= release_note_entry_begin("Ibexa DXP " + version, '2025-09-09', ['Headless', 'Experience', 'Commerce', 'New feature']) =]]

#### Collaboration

The new [Collaborative editing feature](collaborative_editing_guide.md) allows multiple users to preview, review, and edit the same content, improving teamwork and streamlining the review process.
Internal and external users can be invited to a collaboration session, through different sharing options.

With Real-time editing, more advanced part of the feature, users can see each other’s changes in the real time, or work on the content asynchronously.

Additionally, shared drafts can be accessed and managed through new dashboard tabs: **My shared drafts** and **Drafts shared with me**, helping users stay organized. 

#### Discount indexing

Discounts now allow scheduling a re-indexing of discounted product catalog prices at the most convenient time by using the Ibexa Messenger package.
Ibexa Messenger is a customization of the Symfony Messenger package, created to adjust it to [[= product_name =]]'s needs.

Once properly configured, it uses a background queue to trigger price re-indexing, ensuring efficient use of system resources without causing performance disruptions.

#### Improvements to notifications

An improved notifications system is now more intuitive.
Developers can now create and configure their own notification types, while users can now [browse through a list of notifications](https://doc.ibexa.co/projects/userguide/en/latest/getting_started/notifications/), where they can either act on them or dismiss them.

![A searchable notifications list](502_notifications_screen.png "A searchable notifications list")

#### Chat GPT 5.0 support

With improved reasoning and greater accuracy in mind, the AI Connector package has been enhanced by adding ChatGPT 5.0 to its list of supported LLMs.

![ChatGPT 5.0 on a list of supported LLMs](502_ai_connector_gpt_50.png "ChatGPT 5.0 on a list of supported LLMs")

#### Developer experience

##### New packages

The following packages have been introduced in Ibexa DXP v5.0.2:

- ibexa/collaboration
- ibexa/messenger

##### New version of PHP Storm Plugin

To further improve your experience with Ibexa DXP, a 1.14.0 version of [PHP Storm Plugin](phpstorm_plugin.md) has been released, which brings the following changes:

- Added support for Ibexa DXP v5.0
- Added compatibility with PhpStorm 2024.3.6+
- Added file template for Twig Component class
- Added code completion for Twig Component Groups in YAML config files and AsTwigComponent attribute
- Added code completion for Twig Component Types in YAML config files

##### REST APIs

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

##### PHP API

The PHP API has been expanded with the following:

??? note "PHP API classes and interfaces"
    - [`Ibexa\Contracts\AdminUi\Exception`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-adminui-exception.html)
    - [`Ibexa\Contracts\AdminUi\Exception\UnresolvedPreviewUrlException`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-AdminUi-Exception-UnresolvedPreviewUrlException.html)
    - [`Ibexa\Contracts\AdminUi\PreviewUrlResolver`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-adminui-previewurlresolver.html)
    - [`Ibexa\Contracts\AdminUi\PreviewUrlResolver\VersionPreviewUrlResolverInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-AdminUi-PreviewUrlResolver-VersionPreviewUrlResolverInterface.html)
    - [`Ibexa\Contracts\AutomatedTranslation\Exception`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-automatedtranslation-exception.html)
    - [`Ibexa\Contracts\AutomatedTranslation\Exception\ClientNotConfiguredException`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-AutomatedTranslation-Exception-ClientNotConfiguredException.html)
    - [`Ibexa\Contracts\Collaboration\Configuration\ShareableUserConfigurationInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Configuration-ShareableUserConfigurationInterface.html)
    - [`Ibexa\Contracts\Collaboration\Security`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-collaboration-security.html)
    - [`Ibexa\Contracts\Collaboration\Security\ShareableLinkMatcherStrategyInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Security-ShareableLinkMatcherStrategyInterface.html)
    - [`Ibexa\Contracts\Collaboration\Session\JoinSessionRedirectResolverInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-JoinSessionRedirectResolverInterface.html)
    - [`Ibexa\Contracts\Collaboration\Session\LeaveSessionRedirectResolverInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-LeaveSessionRedirectResolverInterface.html)
    - [`Ibexa\Contracts\Core\Validation\Constraint`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-validation-constraint.html)
    - [`Ibexa\Contracts\Core\Validation\Constraint\UniqueIdentifier`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Validation-Constraint-UniqueIdentifier.html)
    - [`Ibexa\Contracts\Core\Validation\Constraint\UniqueIdentifierValidator`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Validation-Constraint-UniqueIdentifierValidator.html)
    - [`Ibexa\Contracts\Messenger`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-messenger.html)
    - [`Ibexa\Contracts\Messenger\Transport`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-messenger-transport.html)
    - [`Ibexa\Contracts\Messenger\Transport\MessageProviderInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Messenger-Transport-MessageProviderInterface.html)
    - [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilder`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-productcatalog-values-product-query-attributecriterionbuilder.html)
    - [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilderRegistry`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-AttributeCriterionBuilderRegistry.html)
    - [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilderRegistryInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-AttributeCriterionBuilderRegistryInterface.html)
    - [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilder\AttributeCriterionBuilderInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-AttributeCriterionBuilder-AttributeCriterionBuilderInterface.html)
    - [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilder\CheckboxBuilder`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-AttributeCriterionBuilder-CheckboxBuilder.html)
    - [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilder\ColorBuilder`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-AttributeCriterionBuilder-ColorBuilder.html)
    - [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilder\FloatBuilder`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-AttributeCriterionBuilder-FloatBuilder.html)
    - [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilder\IntegerBuilder`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-AttributeCriterionBuilder-IntegerBuilder.html)
    - [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\AttributeCriterionBuilder\SelectionBuilder`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-AttributeCriterionBuilder-SelectionBuilder.html)
    - [`Ibexa\Contracts\Share\Permission\Mapper`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-share-permission-mapper.html)

??? note "Events"
    - [`Ibexa\Contracts\AdminUi\Event\ResolveVersionPreviewUrlEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-AdminUi-Event-ResolveVersionPreviewUrlEvent.html)
    - [`Ibexa\Contracts\Collaboration\Session\Event\JoinSessionEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-JoinSessionEvent.html)
    - [`Ibexa\Contracts\Collaboration\Session\Event\SessionPublicPreviewEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Event-SessionPublicPreviewEvent.html)
    - [`Ibexa\Contracts\Discounts\Event\EnableDiscountEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-EnableDiscountEvent.html)
    - [`Ibexa\Contracts\Discounts\Event\BeforeDisableDiscountEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-BeforeDisableDiscountEvent.html)
    - [`Ibexa\Contracts\Discounts\Event\BeforeEnableDiscountEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-BeforeEnableDiscountEvent.html)
    - [`Ibexa\Contracts\Discounts\Event\DisableDiscountEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-DisableDiscountEvent.html)
    - [`Ibexa\Contracts\Share\Event\UsersWithPermissionInfoMappedEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Share-Event-UsersWithPermissionInfoMappedEvent.html)

??? note "Search criteria"
    - [`Ibexa\Contracts\Collaboration\Session\Query\Criterion\ParticipantToken`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-Criterion-ParticipantToken.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\IndexedAtCriterion`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-IndexedAtCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\UpdatedAtCriterion`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-UpdatedAtCriterion.html)


??? note "Sort clauses"
    - [`Ibexa\Contracts\Collaboration\Invitation\Query\SortClause\CreatedAt`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-SortClause-CreatedAt.html)
    - [`Ibexa\Contracts\Collaboration\Invitation\Query\SortClause\Id`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-SortClause-Id.html)
    - [`Ibexa\Contracts\Collaboration\Invitation\Query\SortClause\Status`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-SortClause-Status.html)
    - [`Ibexa\Contracts\Collaboration\Invitation\Query\SortClause\UpdatedAt`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-SortClause-UpdatedAt.html)
    - [`Ibexa\Contracts\Collaboration\Session\Query\SortClause\CreatedAt`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-SortClause-CreatedAt.html)
    - [`Ibexa\Contracts\Collaboration\Session\Query\SortClause\Id`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-SortClause-Id.html)
    - [`Ibexa\Contracts\Collaboration\Session\Query\SortClause\UpdatedAt`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-SortClause-UpdatedAt.html)

##### New version of PHP Storm Plugin

To further improve your experience with Ibexa DXP, a 1.14.0 version of PHP Storm Plugin has been released, which brings the following changes:

- Added support for Ibexa DXP v5.0
- Added compatibility with PhpStorm 2024.3.6+
- Added file template for Twig Component class
- Added code completion for Twig Component Groups in YAML config files and AsTwigComponent attribute
- Added code completion for Twig Component Types in YAML config files

#### Full changelog

[[% include 'snippets/release_50.md' %]]

[[= release_note_entry_end() =]]

[[% set version = 'v5.0.1' %]]

[[= release_note_entry_begin("Ibexa DXP " + version, '2025-08-19', ['Headless', 'Experience', 'Commerce', 'New feature']) =]]

#### Special characters in online editor

The [online editor](online_editor_guide.md) now allows to easily enter special characters like currency symbols.
It uses the [special characters plugin](https://ckeditor.com/docs/ckeditor5/latest/features/special-characters.html).

![Special characters in online editor](4.6_special_characters.png "Special characters in online editor")

#### Support for Solr 9

With this release, [[= product_name =]] starts supporting [Solr 9](requirements.md#search).

Solr 9 comes with support for [Dense Vector Search](https://solr.apache.org/guide/solr/latest/query-guide/dense-vector-search.html), paving the way for incoming improvements to the [AI Actions](ai_actions.md) feature.

#### Improved content creation interface

The editing interface of the back office is now improved to better highlight the language, creator, and the publication date when working with content items.

![Improved interface for content creation](4.6_improved_editing.png "Improved interface for content creation")

#### Taxonomy Subtree limitation

You can now manage access to [taxonomy items](taxonomy.md) more effectively by using the new [Taxonomy Subtree limitation](limitation_reference.md#taxonomy-subtree-limitation).

In addition, you can now use the [Taxonomy limitation](limitation_reference.md#taxonomy-limitation) together with the `taxonomy/assign` policy.

#### Base price column added to a Product Picker view

The Product Picker tool that, for example, lets you [select products eligible for discounts]([[= user_doc =]]/commerce/discounts/work_with_discounts/#create-new-discount), now displays a **Base price** column for products and product variants.

#### PHP API

The PHP API has been enhanced with the following new classes:

[`Ibexa\Contracts\Cart\Exception\VatCalculationExceptionInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Cart-Exception-VatCalculationExceptionInterface.html)
[`Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\AbstractPriceRange`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-Criterion-AbstractPriceRange.html)
[`Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\CustomPriceRange`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-Criterion-CustomPriceRange.html)

This release brings additional minor improvements to the developer's experience that result from capabilities offered by PHP in version 8.3.

#### Full changelog

[[% include 'snippets/release_50.md' %]]

[[= release_note_entry_end() =]]

[[% set version = 'v5.0.0' %]]
[[= release_note_entry_begin("Ibexa DXP " + version, '2025-07-22', ['Headless', 'Experience', 'Commerce', 'New feature']) =]]

### Notable changes

This version incorporates into the product numerous features brought by LTS Updates from previous versions, brings upgrades to the tech stack and improvements to developer experience.

#### AI Actions

The AI Actions feature enhances the usability and flexibility of [[= product_name =]] by harnessing the potential of artificial intelligence to automate time-consuming editorial tasks.
By default, the AI Actions feature can help users with their work in following scenarios:

- Refining text: when editing a content item, users can request that a passage selected in online editor is modified, for example, by adjusting the length of the text, changing its tone, or correcting linguistic errors
- Generating alternative text: when working with images, users can ask AI to generate alternative text for them, which helps improve accessibility and SEO

![AI Assistant](ai_assistant.png)

AI Actions integrate with [Ibexa Connect]([[= connect_doc =]]), giving you an opportunity to build complex data transformation workflows without having to rely on custom code.

For more information, see [AI Actions product guide](ai_actions_guide.md).

#### Discounts [[% include 'snippets/commerce_badge.md' %]]

With Discounts, you can temporarily or permanently reduce prices on specific products or categories, making deals more attractive to potential buyers.

Use them to encourage first-time purchases, reward loyal customers, promote new or slow-moving items, or drive sales during seasonal events.

By displaying discounted prices clearly in the catalog or cart, businesses can create a sense of urgency, increase customer satisfaction, and ultimately boost revenue.

![Discounts for products in the cart](4.6_discounts.png)

For more information, see [Discounts product guide](discounts_guide.md).

#### Date and time attribute

The Date and time attributes allow you to represent date and time values as part of the product specification in the [Product Information Management](pim_guide.md) system.

For more information, see [Date and time attributes](date_and_time.md).

#### Symbol attribute

The Symbol attributes allow you to efficiently represent the string-based data as part of the product specification in the [Product Information Management](pim_guide.md) system.

For more information, see [Symbol attributes](symbol_attribute_type.md).

#### Collaboration

With Collaboration, multiple users can invite each other to work on the same content.
It is a starting point for future functionalities in the collaboration domain.

![Collaboration invite](img/5.0_collaborative_invitation.jpg "Collaboration invite")

For more information, see [Collaboration PHP API](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-collaboration.html) and [Share PHP API](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-share.html).

### Software architecture upgrades

With improved compatibility, performance and increased security, as well as better developer experience in mind, [[= product_name_base =]] decided to introduce several significant tech stack upgrades.

For a full list of updated system requirements, see [Requirements](../getting_started/requirements.md).

#### Symfony 7.3

With this release, [[= product_name =]] moves to Symfony 7.3 from the previously used versions of Symfony.

For details, see [Symfony 7.3](https://symfony.com/blog/symfony-7-3-curated-new-features).

#### Doctrine DBAL 3.9

By moving to Doctrine DBAL 3.9, [[= product_name =]] brings developers better performance, cleaner code, and stronger foundation for a more modern and maintainable application.

#### PHP 8.3

With performance, coding safety and security in mind, with this version, [[= product_name =]] moves to [PHP 8.3](https://www.php.net/releases/8.3/en.php) and drops support for lower versions of the language.

#### OpenAPI support

Adding support for generating the [OpenAPI](https://www.openapis.org/) specification for our REST API makes future changes more manageable, and helps our partners automatically generate REST API clients.

For more information, see [REST API usage](https://doc.ibexa.co/en/latest/api/rest_api/rest_api_usage/rest_api_usage/#openapi-support).

Support for serialization and deserialization of REST payloads with the [Symfony Serializer](https://symfony.com/doc/current/serializer.html) component improves data reliability and simplifies debugging.

#### React 19

[[= product_name =]]'s Back Office now uses [React 19](https://react.dev/blog/2024/12/05/react-19).
This upgrade enhances maintainability, unlocks new UI capabilities, and simplifies future feature development.

### Developer experience

#### New packages 

The following packages have been introduced in [[= product_name =]] v5.0.0:

- ibexa/collaboration
- ibexa/connector-ai
- ibexa/connector-openai
- ibexa/discounts
- ibexa/discounts-codes
- ibexa/product-catalog-date-time-attribute
- ibexa/product-catalog-symbol-attribute
- ibexa/share

#### REST APIs

[[= product_name =]] v5.0.0 adds REST API coverage for the following features:

- AI Actions:
    - Action Configurations
    - Action Types
- Discounts
- Collaboration

#### PHP API

The PHP API has been expanded with the following classes and interfaces:

??? note "AI Actions"

    - [`Ibexa\Contracts\ConnectorAi\Action\Action`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-Action.html)
    - [`Ibexa\Contracts\ConnectorAi\Action\ActionContext`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-ActionContext.html)
    - [`Ibexa\Contracts\ConnectorAi\Action\ActionFactoryInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-ActionFactoryInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\Action\ActionHandlerInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-ActionHandlerInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\Action\ActionHandlerResolverInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-ActionHandlerResolverInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\Action\GenerateAltTextAction`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-GenerateAltTextAction.html)
    - [`Ibexa\Contracts\ConnectorAi\Action\LLMBaseActionTypeInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-LLMBaseActionTypeInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\Action\RefineTextAction`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-RefineTextAction.html)
    - [`Ibexa\Contracts\ConnectorAi\Action\RuntimeContext`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-RuntimeContext.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationCreateStruct`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-ActionConfigurationCreateStruct.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationCopyStruct`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-ActionConfigurationCopyStruct.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationListInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-ActionConfigurationListInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationOptions`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-ActionConfigurationOptions.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationQuery`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-ActionConfigurationQuery.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationUpdateStruct`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-ActionConfigurationUpdateStruct.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionHandlerOptionsFormMapperInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-ActionHandlerOptionsFormMapperInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionTypeOptionsFormMapperInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-ActionTypeOptionsFormMapperInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\OptionsFormatterInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-OptionsFormatterInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionType\ActionTypeFactoryInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionType-ActionTypeFactoryInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionType\ActionTypeInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionType-ActionTypeInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionType\ActionTypeRegistryInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionType-ActionTypeRegistryInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionType\OptionsValidatorError`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionType-OptionsValidatorError.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionType\OptionsValidatorInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionType-OptionsValidatorInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionType\OptionsValidatorRegistryInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionType-OptionsValidatorRegistryInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfigurationInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfigurationServiceDecorator`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationServiceDecorator.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfigurationServiceInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationServiceInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionHandlerRegistryInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionHandlerRegistryInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionResponseInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionResponseInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionServiceDecorator`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionServiceDecorator.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionServiceInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionServiceInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\AdapterAwareActionInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-AdapterAwareActionInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\DataType`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-DataType.html)
    - [`Ibexa\Contracts\ConnectorAi\PromptResolverInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-PromptResolverInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\Prompt\PromptFactory`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Prompt-PromptFactory.html)
    - [`Ibexa\Contracts\ConnectorAi\Prompt\PromptInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Prompt-PromptInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\PromptResolverInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-PromptResolverInterface.html)
    - [`Ibexa\Contracts\ConnectorOpenAi\ClientProviderInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorOpenAi-ClientProviderInterface.html)

??? note "Discounts"

    - [`Ibexa\Contracts\Discounts\DiscountConditionCriterionMapperInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountConditionCriterionMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\DiscountFormMapperInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\DiscountPrioritizationStrategyInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountPrioritizationStrategyInterface.html)
    - [`Ibexa\Contracts\Discounts\DiscountServiceDecorator`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountServiceDecorator.html)
    - [`Ibexa\Contracts\Discounts\DiscountServiceInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountServiceInterface.html)
    - [`Ibexa\Contracts\Discounts\DiscountValueFormatterInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountValueFormatterInterface.html)
    - [`Ibexa\Contracts\Discounts\DiscountVariablesResolverInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountVariablesResolverInterface.html)
    - [`Ibexa\Contracts\Discounts\Admin\Form\DiscountValueFormTypeMapperInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-DiscountValueFormTypeMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\Admin\Form\FormThemeProviderInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-FormThemeProviderInterface.html)
    - [`Ibexa\Contracts\Discounts\Admin\FormMapper\ConditionsMapperInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-FormMapper-ConditionsMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\Admin\FormMapper\DiscountValueMapperInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-FormMapper-DiscountValueMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\Admin\FormMapper\GeneralPropertiesMapperInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-FormMapper-GeneralPropertiesMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\Admin\FormMapper\ProductConditionsMapperInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-FormMapper-ProductConditionsMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\Admin\FormMapper\StepDataObjectMapperInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-FormMapper-StepDataObjectMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\Admin\FormMapper\UserConditionsMapperInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-FormMapper-UserConditionsMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\Exception\DiscountConditionNotFoundException`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Exception-DiscountConditionNotFoundException.html)
    - [`Ibexa\Contracts\Discounts\Exception\DiscountExpressionInvalidArgumentException`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Exception-DiscountExpressionInvalidArgumentException.html)
    - [`Ibexa\Contracts\Discounts\Exception\DiscountExpressionRuntimeException`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Exception-DiscountExpressionRuntimeException.html)
    - [`Ibexa\Contracts\Discounts\Exception\DiscountNotFoundException`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Exception-DiscountNotFoundException.html)
    - [`Ibexa\Contracts\Discounts\Exception\DiscountRuleNotFoundException`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Exception-DiscountRuleNotFoundException.html)
    - [`Ibexa\Contracts\Discounts\Exception\DiscountValueResolutionException`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Exception-DiscountValueResolutionException.html)
    - [`Ibexa\Contracts\Discounts\Policy\AbstractDiscountPolicy`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Policy-AbstractDiscountPolicy.html)
    - [`Ibexa\Contracts\Discounts\Policy\Create`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Policy-Create.html)
    - [`Ibexa\Contracts\Discounts\Policy\Delete`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Policy-Delete.html)
    - [`Ibexa\Contracts\Discounts\Policy\Disable`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Policy-Disable.html)
    - [`Ibexa\Contracts\Discounts\Policy\Enable`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Policy-Enable.html)
    - [`Ibexa\Contracts\Discounts\Policy\Update`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Policy-Update.html)
    - [`Ibexa\Contracts\Discounts\Policy\View`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Policy-View.html)
    - [`Ibexa\Contracts\Discounts\Value\CartDiscountConditionInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-CartDiscountConditionInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountConditionInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountConditionInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountExpressionAwareInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountExpressionAwareInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountListInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountListInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountRuleInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountRuleInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountTranslationInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountTranslationInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountType`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountType.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountValueInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountValueInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\Struct\DiscountCreateStruct`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Struct-DiscountCreateStruct.html)
    - [`Ibexa\Contracts\Discounts\Value\Struct\DiscountStructInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Struct-DiscountStructInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountTranslationStruct`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Struct-DiscountTranslationStruct.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountUpdateStruct`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Struct-DiscountUpdateStruct.html)
    - [`Ibexa\Contracts\Discounts\Value\TranslationAwareDiscountStructInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Struct-TranslationAwareDiscountStructInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\TranslationAwareDiscountStructTrait`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Struct-TranslationAwareDiscountStructTrait.html)
    - [`Ibexa\Contracts\DiscountsCodes\Exception\DiscountCodeNotFoundException`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Exception-DiscountCodeNotFoundException.html)
    - [`Ibexa\Contracts\DiscountsCodes\Exception\DiscountCodeRateLimitExceededException`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Exception-DiscountCodeRateLimitExceededException.html)
    - [`Ibexa\Contracts\DiscountsCodes\Exception\DiscountCodeUnusableException`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Exception-DiscountCodeUnusableException.html)
    - [`Ibexa\Contracts\DiscountsCodes\Exception\DiscountCodeUserInvalidArgumentException`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Exception-DiscountCodeUserInvalidArgumentException.html)
    - [`Ibexa\Contracts\DiscountsCodes\Value\DiscountCodeUsageInterface`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-DiscountCodeUsageInterface.html)
    - [`Ibexa\Contracts\DiscountsCodes\Value\DiscountCodeUser`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-DiscountCodeUser.html)
    - [`Ibexa\Contracts\DiscountsCodes\Value\Query\DiscountCodeUsageQuery`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-Query-DiscountCodeUsageQuery.html)
    - [`Ibexa\Contracts\DiscountsCodes\Value\Struct\DiscountCodeCreateStruct `](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-Struct-DiscountCodeCreateStruct.html)
    - [`Ibexa\Contracts\DiscountsCodes\Value\StructDiscountCodeUpdateStruct `](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-Struct-DiscountCodeUpdateStruct.html)

??? note "PIM Attributes"

    - [`Ibexa\Contracts\ProductCatalogDateTimeAttribute`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-productcatalogdatetimeattribute.html)
    - [`Ibexa\Contracts\ProductCatalogSymbolAttribute`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-productcatalogsymbolattribute.html)

#### Search Criteria

The following search criteria have been added in the v5.0 release:

??? note "AI Actions"

    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Enabled`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-Enabled.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Identifier`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-Identifier.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\LogicalAnd`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-LogicalAnd.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\LogicalOr`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-LogicalOr.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Name`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-Name.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Type`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-Type.html)

??? note "Discounts"

    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\CreatedAtCriterion`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-CreatedAtCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\CreatorCriterion`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-CreatorCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\EndDateCriterion`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-EndDateCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\IdentifierCriterion`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-IdentifierCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\IsEnabledCriterion`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-IsEnabledCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\LogicalAnd`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-LogicalAnd.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\LogicalOr`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-LogicalOr.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\NameCriterion`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-NameCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\PriorityCriterion`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-PriorityCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\StartDateCriterion`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-StartDateCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\TypeCriterion`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-TypeCriterion.html)

??? note "PIM Attributes"

    - [`Ibexa\Contracts\ProductCatalogDateTimeAttribute\Search\Criterion\DateTimeAttribute`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalogDateTimeAttribute-Search-Criterion-DateTimeAttribute.html)
    - [`Ibexa\Contracts\ProductCatalogDateTimeAttribute\Search\Criterion\DateTimeAttributeRange`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalogDateTimeAttribute-Search-Criterion-DateTimeAttributeRange.html)
    - [`Ibexa\Contracts\ProductCatalogSymbolAttribute\Search\Criterion\SymbolAttribute`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalogSymbolAttribute-Search-Criterion-SymbolAttribute.html)

#### Sort Clauses

The following sort clauses have been added in the v5.0 release:

??? note "AI Actions"

    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause\Enabled`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-SortClause-Enabled.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause\Id`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-SortClause-Id.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause\Identifier`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-SortClause-Identifier.html)

??? note "Discounts"

    - [`Ibexa\Contracts\Discounts\Value\Query\SortClause\CreatedAt`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-CreatedAt.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\SortClause\EndDate`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-EndDate.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\SortClause\Id`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-Id.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\SortClause\Identifier`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-Identifier.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\SortClause\Priority`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-Priority.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\SortClause\StartDate`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-StartDate.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\SortClause\Type`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-Type.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\SortClause\UpdatedAt`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-UpdatedAt.html)

#### Events

The following events have been added in the v5.0 release:

??? note "AI Actions"

    - [`\Ibexa\Contracts\ConnectorAi\Action\Event\BeforeExecuteEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-Event-BeforeExecuteEvent.html)
    - [`\Ibexa\Contracts\ConnectorAi\Action\Event\ExecuteEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-Event-ExecuteEvent.html)
    - [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\BeforeCreateActionConfigurationEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-BeforeCreateActionConfigurationEvent.html)
    - [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\CreateActionConfigurationEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-CreateActionConfigurationEvent.html)
    - [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\BeforeUpdateActionConfigurationEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-BeforeUpdateActionConfigurationEvent.html)
    - [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\UpdateActionConfigurationEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-UpdateActionConfigurationEvent.html)
    - [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\BeforeDeleteActionConfigurationEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-BeforeDeleteActionConfigurationEvent.html)
    - [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\DeleteActionConfigurationEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-DeleteActionConfigurationEvent.html)
    - [`Ibexa\Contracts\ConnectorAi\Events\ContextEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Events-ContextEvent.html)
    - [`Ibexa\Contracts\ConnectorAi\Events\ResolveActionConfigurationWidgetConfigEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Events-ResolveActionConfigurationWidgetConfigEvent.html)
    - [`Ibexa\Contracts\ConnectorAi\Events\ResolveActionHandlerEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Events-ResolveActionHandlerEvent.html)

??? note "Discounts"

    - [`\Ibexa\Contracts\Discounts\Event\BeforeCreateDiscountEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-BeforeCreateDiscountEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\CreateDiscountEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-CreateDiscountEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\BeforeDeleteDiscountEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-BeforeDeleteDiscountEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\DeleteDiscountEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-DeleteDiscountEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\BeforeUpdateDiscountEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-BeforeUpdateDiscountEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\UpdateDiscountEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-UpdateDiscountEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\CreateDiscountCreateStructEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-CreateDiscountCreateStructEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\CreateDiscountUpdateStructEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-CreateDiscountUpdateStructEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\CreateFormDataEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-CreateFormDataEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\MapDiscountToFormDataEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-MapDiscountToFormDataEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\Step\CreateFormDataEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-CreateFormDataEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\Step\MapCreateDataToStructEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-Step-MapCreateDataToStructEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\Step\MapDiscountToFormDataEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-MapDiscountToFormDataEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\Step\MapUpdateDataToStructEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-Step-MapUpdateDataToStructEvent.html)
    - [`\Ibexa\Contracts\Discounts\Admin\Form\Event\PreDiscountCreateEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-Event-PreDiscountCreateEvent.html)
    - [`\Ibexa\Contracts\DiscountsCodes\Event\BeforeDiscountCodeApplyEvent`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Event-BeforeDiscountCodeApplyEvent.html)

#### Twig functions

The following Twig functions have been added in the v5.0 release:

- [`ibexa_ai_config`](../templating/twig_function_reference/ai_actions_twig_functions.md#ibexa_ai_config)
- [`ibexa_render_discount_rule_type`](../templating/twig_function_reference/discounts_twig_functions.md#ibexa_render_discount_rule_type)
- [`ibexa_discounts_render_discount_badge`](../templating/twig_function_reference/discounts_twig_functions.md#ibexa_discounts_render_discount_badge)
- [`ibexa_get_original_price`](../templating/twig_function_reference/discounts_twig_functions.md#ibexa_get_original_price)
- [`ibexa_format_discount_value`](../templating/twig_function_reference/discounts_twig_functions.md#ibexa_format_discount_value)
- [`ibexa_discounts_is_active`](../templating/twig_function_reference/discounts_twig_functions.md#ibexa_discounts_is_active)
- [`ibexa_discounts_form_themes`](../templating/twig_function_reference/discounts_twig_functions.md#ibexa_discounts_form_themes)
- [`ibexa_discounts_can_edit`](../templating/twig_function_reference/discounts_twig_functions.md#ibexa_discounts_can_edit)
- [`ibexa_discounts_can_enable`](../templating/twig_function_reference/discounts_twig_functions.md#ibexa_discounts_can_enable)
- [`ibexa_discounts_can_disable`](../templating/twig_function_reference/discounts_twig_functions.md#ibexa_discounts_can_disable)
- [`ibexa_discounts_can_delete`](../templating/twig_function_reference/discounts_twig_functions.md#ibexa_discounts_can_delete)

#### Other upgrades

This release brings other minor upgrades intended to improve the developer's experience:

- To improve code clarity, reliability, and error detection, type hint declarations that specify the expected data type have been added in multiple places throughout the product
- In anticipation of [changes coming with PHP 8.4](https://php.watch/versions/8.4/implicitly-marking-parameter-type-nullable-deprecated), implicit nullable type declarations have been replaced with nullable type declarations throughout the product code. It is recommended that you update your custom code in the same way
- Developer experience has improved with capabilities offered by PHP in version 8.3. For example, the `AsTwigComponent` attribute [facilitates autoconfiguration](components.md#php-code) of Twig components
- With protection against breaking changes and easier refactoring in mind, [TypeScript](https://www.typescriptlang.org/) can now be used to extend the Back Office
- [[[= product_name_base =]] Rector package](https://github.com/ibexa/rector) has been introduced that is based on [Rector](https://github.com/rectorphp) and comes with additional rules for working with Ibexa code. You can use it to get rid of PHP code deprecations
- [New icons](../templating/twig_function_reference/icon_twig_functions.md#icons-reference) replace the ones found in previous versions and serve as a highlight of a future system design

### Deprecations

Refer to [Ibexa DXP v5.0 renames, deprecations and removals](ibexa_dxp_v5.0_deprecations.md) for a full list of changes and how they influence your project.

### Full changelog

[[% include 'snippets/release_50.md' %]]

To update your application, see the [update instructions](../update_and_migration/from_4.6/update_to_5.0.md).

[[= release_note_entry_end() =]]

</div>
