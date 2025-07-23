---
description: Ibexa DXP v5.0 incorporates features brought by LTS Updates from previous versions, brings upgrades to the tech stack and improvements to developer experience.
title: Ibexa DXP v5.0 LTS
month_change: true
---

<!-- vale VariablesVersion = NO -->

[[= release_notes_filters('Ibexa DXP v5.0 LTS', ['Headless', 'Experience', 'Commerce', 'LTS Update', 'New feature']) =]]

<div class="release-notes" markdown="1">

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

For more information, see [Collaboration PHP API](../api/php_api/php_api_reference/namespaces/ibexa-contracts-collaboration.html) and [Share PHP API](../api/php_api/php_api_reference/namespaces/ibexa-contracts-share.html).

### Software architecture upgrades

With improved compatibility, performance and increased security, as well as better developer experience in mind, [[= product_name_base =]] decided to introduce several significant tech stack upgrades.

For a full list of updated system requirements, see [Requirements](../getting_started/requirements.md).

#### Symfony 7.3

With this release, [[= product_name =]] moves to Symfony 7.3 from the previously used versions of Symfony.

For details, see [Symfony 7.3](https://symfony.com/blog/symfony-7-3-curated-new-features).

#### Doctrine 3.9

By moving to Doctrine 3.9, [[= product_name =]] brings developers better performance, cleaner code, and stronger foundation for a more modern and maintainable application.

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

    - [`Ibexa\Contracts\ConnectorAi\Action\Action`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-Action.html)
    - [`Ibexa\Contracts\ConnectorAi\Action\ActionContext`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-ActionContext.html)
    - [`Ibexa\Contracts\ConnectorAi\Action\ActionFactoryInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-ActionFactoryInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\Action\ActionHandlerInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-ActionHandlerInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\Action\ActionHandlerResolverInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-ActionHandlerResolverInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\Action\GenerateAltTextAction`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-GenerateAltTextAction.html)
    - [`Ibexa\Contracts\ConnectorAi\Action\LLMBaseActionTypeInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-LLMBaseActionTypeInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\Action\RefineTextAction`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-RefineTextAction.html)
    - [`Ibexa\Contracts\ConnectorAi\Action\RuntimeContext`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-RuntimeContext.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationCreateStruct`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-ActionConfigurationCreateStruct.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationCopyStruct`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-ActionConfigurationCopyStruct.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationListInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-ActionConfigurationListInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationOptions`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-ActionConfigurationOptions.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationQuery`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-ActionConfigurationQuery.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationUpdateStruct`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-ActionConfigurationUpdateStruct.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionHandlerOptionsFormMapperInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-ActionHandlerOptionsFormMapperInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionTypeOptionsFormMapperInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-ActionTypeOptionsFormMapperInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\OptionsFormatterInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-OptionsFormatterInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionType\ActionTypeFactoryInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionType-ActionTypeFactoryInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionType\ActionTypeInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionType-ActionTypeInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionType\ActionTypeRegistryInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionType-ActionTypeRegistryInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionType\OptionsValidatorError`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionType-OptionsValidatorError.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionType\OptionsValidatorInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionType-OptionsValidatorInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionType\OptionsValidatorRegistryInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionType-OptionsValidatorRegistryInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfigurationInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfigurationServiceDecorator`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationServiceDecorator.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfigurationServiceInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationServiceInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionHandlerRegistryInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionHandlerRegistryInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionResponseInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionResponseInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionServiceDecorator`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionServiceDecorator.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionServiceInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionServiceInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\AdapterAwareActionInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-AdapterAwareActionInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\DataType`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-DataType.html)
    - [`Ibexa\Contracts\ConnectorAi\PromptResolverInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-PromptResolverInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\Prompt\PromptFactory`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Prompt-PromptFactory.html)
    - [`Ibexa\Contracts\ConnectorAi\Prompt\PromptInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Prompt-PromptInterface.html)
    - [`Ibexa\Contracts\ConnectorAi\PromptResolverInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-PromptResolverInterface.html)
    - [`Ibexa\Contracts\ConnectorOpenAi\ClientProviderInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorOpenAi-ClientProviderInterface.html)

??? note "Discounts"

    - [`Ibexa\Contracts\Discounts\DiscountConditionCriterionMapperInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountConditionCriterionMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\DiscountFormMapperInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\DiscountPrioritizationStrategyInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountPrioritizationStrategyInterface.html)
    - [`Ibexa\Contracts\Discounts\DiscountServiceDecorator`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountServiceDecorator.html)
    - [`Ibexa\Contracts\Discounts\DiscountServiceInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountServiceInterface.html)
    - [`Ibexa\Contracts\Discounts\DiscountValueFormatterInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountValueFormatterInterface.html)
    - [`Ibexa\Contracts\Discounts\DiscountVariablesResolverInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountVariablesResolverInterface.html)
    - [`Ibexa\Contracts\Discounts\Admin\Form\DiscountValueFormTypeMapperInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-DiscountValueFormTypeMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\Admin\Form\FormThemeProviderInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-FormThemeProviderInterface.html)
    - [`Ibexa\Contracts\Discounts\Admin\FormMapper\ConditionsMapperInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-FormMapper-ConditionsMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\Admin\FormMapper\DiscountValueMapperInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-FormMapper-DiscountValueMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\Admin\FormMapper\GeneralPropertiesMapperInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-FormMapper-GeneralPropertiesMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\Admin\FormMapper\ProductConditionsMapperInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-FormMapper-ProductConditionsMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\Admin\FormMapper\StepDataObjectMapperInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-FormMapper-StepDataObjectMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\Admin\FormMapper\UserConditionsMapperInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-FormMapper-UserConditionsMapperInterface.html)
    - [`Ibexa\Contracts\Discounts\Exception\DiscountConditionNotFoundException`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Exception-DiscountConditionNotFoundException.html)
    - [`Ibexa\Contracts\Discounts\Exception\DiscountExpressionInvalidArgumentException`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Exception-DiscountExpressionInvalidArgumentException.html)
    - [`Ibexa\Contracts\Discounts\Exception\DiscountExpressionRuntimeException`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Exception-DiscountExpressionRuntimeException.html)
    - [`Ibexa\Contracts\Discounts\Exception\DiscountNotFoundException`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Exception-DiscountNotFoundException.html)
    - [`Ibexa\Contracts\Discounts\Exception\DiscountRuleNotFoundException`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Exception-DiscountRuleNotFoundException.html)
    - [`Ibexa\Contracts\Discounts\Exception\DiscountValueResolutionException`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Exception-DiscountValueResolutionException.html)
    - [`Ibexa\Contracts\Discounts\Policy\AbstractDiscountPolicy`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Policy-AbstractDiscountPolicy.html)
    - [`Ibexa\Contracts\Discounts\Policy\Create`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Policy-Create.html)
    - [`Ibexa\Contracts\Discounts\Policy\Delete`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Policy-Delete.html)
    - [`Ibexa\Contracts\Discounts\Policy\Disable`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Policy-Disable.html)
    - [`Ibexa\Contracts\Discounts\Policy\Enable`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Policy-Enable.html)
    - [`Ibexa\Contracts\Discounts\Policy\Update`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Policy-Update.html)
    - [`Ibexa\Contracts\Discounts\Policy\View`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Policy-View.html)
    - [`Ibexa\Contracts\Discounts\Value\CartDiscountConditionInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-CartDiscountConditionInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountConditionInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountConditionInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountExpressionAwareInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountExpressionAwareInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountListInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountListInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountRuleInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountRuleInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountTranslationInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountTranslationInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountType`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountType.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountValueInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountValueInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\Struct\DiscountCreateStruct`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Struct-DiscountCreateStruct.html)
    - [`Ibexa\Contracts\Discounts\Value\Struct\DiscountStructInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Struct-DiscountStructInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountTranslationStruct`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Struct-DiscountTranslationStruct.html)
    - [`Ibexa\Contracts\Discounts\Value\DiscountUpdateStruct`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Struct-DiscountUpdateStruct.html)
    - [`Ibexa\Contracts\Discounts\Value\TranslationAwareDiscountStructInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Struct-TranslationAwareDiscountStructInterface.html)
    - [`Ibexa\Contracts\Discounts\Value\TranslationAwareDiscountStructTrait`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Struct-TranslationAwareDiscountStructTrait.html)
    - [`Ibexa\Contracts\DiscountsCodes\Exception\DiscountCodeNotFoundException`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Exception-DiscountCodeNotFoundException.html)
    - [`Ibexa\Contracts\DiscountsCodes\Exception\DiscountCodeRateLimitExceededException`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Exception-DiscountCodeRateLimitExceededException.html)
    - [`Ibexa\Contracts\DiscountsCodes\Exception\DiscountCodeUnusableException`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Exception-DiscountCodeUnusableException.html)
    - [`Ibexa\Contracts\DiscountsCodes\Exception\DiscountCodeUserInvalidArgumentException`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Exception-DiscountCodeUserInvalidArgumentException.html)
    - [`Ibexa\Contracts\DiscountsCodes\Value\DiscountCodeUsageInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-DiscountCodeUsageInterface.html)
    - [`Ibexa\Contracts\DiscountsCodes\Value\DiscountCodeUser`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-DiscountCodeUser.html)
    - [`Ibexa\Contracts\DiscountsCodes\Value\Query\DiscountCodeUsageQuery`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-Query-DiscountCodeUsageQuery.html)
    - [`Ibexa\Contracts\DiscountsCodes\Value\Struct\DiscountCodeCreateStruct `](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-Struct-DiscountCodeCreateStruct.html)
    - [`Ibexa\Contracts\DiscountsCodes\Value\StructDiscountCodeUpdateStruct `](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-Struct-DiscountCodeUpdateStruct.html)

??? note "PIM Attributes"

    - [`Ibexa\Contracts\ProductCatalogDateTimeAttribute`](../api/php_api/php_api_reference/namespaces/ibexa-contracts-productcatalogdatetimeattribute.html)
    - [Ibexa\Contracts\ProductCatalogSymbolAttribute](../api/php_api/php_api_reference/namespaces/ibexa-contracts-productcatalogsymbolattribute.html)

#### Search Criteria

The following search criteria have been added in the v5.0 release:

??? note "AI Actions"

    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Enabled`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-Enabled.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Identifier`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-Identifier.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\LogicalAnd`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-LogicalAnd.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\LogicalOr`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-LogicalOr.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Name`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-Name.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Type`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-Type.html)

??? note "Discounts"

    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\CreatedAtCriterion`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-CreatedAtCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\CreatorCriterion`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-CreatorCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\EndDateCriterion`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-EndDateCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\IdentifierCriterion`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-IdentifierCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\IsEnabledCriterion`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-IsEnabledCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\LogicalAnd`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-LogicalAnd.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\LogicalOr`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-LogicalOr.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\NameCriterion`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-NameCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\PriorityCriterion`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-PriorityCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\StartDateCriterion`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-StartDateCriterion.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\Criterion\TypeCriterion`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-TypeCriterion.html)

??? note "PIM Attributes"

    - [`Ibexa\Contracts\ProductCatalogDateTimeAttribute\Search\Criterion\DateTimeAttribute`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalogDateTimeAttribute-Search-Criterion-DateTimeAttribute.html)
    - [`Ibexa\Contracts\ProductCatalogDateTimeAttribute\Search\Criterion\DateTimeAttributeRange`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalogDateTimeAttribute-Search-Criterion-DateTimeAttributeRange.html)
    - [`Ibexa\Contracts\ProductCatalogSymbolAttribute\Search\Criterion\SymbolAttribute`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalogSymbolAttribute-Search-Criterion-SymbolAttribute.html)

#### Sort Clauses

The following sort clauses have been added in the v5.0 release:

??? note "AI Actions"

    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause\Enabled`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-SortClause-Enabled.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause\Id`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-SortClause-Id.html)
    - [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause\Identifier`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-SortClause-Identifier.html)

??? note "Discounts"

    - [`Ibexa\Contracts\Discounts\Value\Query\SortClause\CreatedAt`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-CreatedAt.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\SortClause\EndDate`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-EndDate.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\SortClause\Id`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-Id.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\SortClause\Identifier`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-Identifier.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\SortClause\Priority`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-Priority.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\SortClause\StartDate`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-StartDate.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\SortClause\Type`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-Type.html)
    - [`Ibexa\Contracts\Discounts\Value\Query\SortClause\UpdatedAt`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-SortClause-UpdatedAt.html)

#### Events

The following events have been added in the v5.0 release:

??? note "AI Actions"

    - [`\Ibexa\Contracts\ConnectorAi\Action\Event\BeforeExecuteEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-Event-BeforeExecuteEvent.html)
    - [`\Ibexa\Contracts\ConnectorAi\Action\Event\ExecuteEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-Event-ExecuteEvent.html)
    - [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\BeforeCreateActionConfigurationEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-BeforeCreateActionConfigurationEvent.html)
    - [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\CreateActionConfigurationEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-CreateActionConfigurationEvent.html)
    - [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\BeforeUpdateActionConfigurationEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-BeforeUpdateActionConfigurationEvent.html)
    - [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\UpdateActionConfigurationEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-UpdateActionConfigurationEvent.html)
    - [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\BeforeDeleteActionConfigurationEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-BeforeDeleteActionConfigurationEvent.html)
    - [`\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\DeleteActionConfigurationEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-DeleteActionConfigurationEvent.html)
    - [`Ibexa\Contracts\ConnectorAi\Events\ContextEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Events-ContextEvent.html)
    - [`Ibexa\Contracts\ConnectorAi\Events\ResolveActionConfigurationWidgetConfigEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Events-ResolveActionConfigurationWidgetConfigEvent.html)
    - [`Ibexa\Contracts\ConnectorAi\Events\ResolveActionHandlerEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Events-ResolveActionHandlerEvent.html)

??? note "Discounts"

    - [`\Ibexa\Contracts\Discounts\Event\BeforeCreateDiscountEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-BeforeCreateDiscountEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\CreateDiscountEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-CreateDiscountEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\BeforeDeleteDiscountEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-BeforeDeleteDiscountEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\DeleteDiscountEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-DeleteDiscountEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\BeforeUpdateDiscountEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-BeforeUpdateDiscountEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\UpdateDiscountEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-UpdateDiscountEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\CreateDiscountCreateStructEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-CreateDiscountCreateStructEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\CreateDiscountUpdateStructEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-CreateDiscountUpdateStructEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\CreateFormDataEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-CreateFormDataEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\MapDiscountToFormDataEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-MapDiscountToFormDataEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\Step\CreateFormDataEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-CreateFormDataEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\Step\MapCreateDataToStructEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-Step-MapCreateDataToStructEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\Step\MapDiscountToFormDataEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-MapDiscountToFormDataEvent.html)
    - [`\Ibexa\Contracts\Discounts\Event\Step\MapUpdateDataToStructEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-Step-MapUpdateDataToStructEvent.html)
    - [`\Ibexa\Contracts\Discounts\Admin\Form\Event\PreDiscountCreateEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-Event-PreDiscountCreateEvent.html)
    - [`\Ibexa\Contracts\DiscountsCodes\Event\BeforeDiscountCodeApplyEvent`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Event-BeforeDiscountCodeApplyEvent.html)

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
