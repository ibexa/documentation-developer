---
description: Ibexa DXP v5.0 incorporates features brought by LTS Updates from previous versions, brings upgrades to the tech stack and improvements to developer experience.
title: Ibexa DXP v5.0 LTS
month_change: true
---

<!-- vale VariablesVersion = NO -->

[[= release_notes_filters('Ibexa DXP v5.0 LTS', ['Headless', 'Experience', 'Commerce', 'LTS Update', 'New feature']) =]]

<div class="release-notes" markdown="1">

[[% set version = 'v5.0.0' %]]
[[= release_note_entry_begin("Ibexa DXP " + version, '2024-07-11', ['Headless', 'Experience', 'Commerce', 'New feature']) =]]

### Notable changes

This version incorporates into the product numerous features brought by [LTS Updates] from previous versions, brings upgrades to the tech stack and improvements to developer experience.

#### AI Actions

The AI Actions feature enhances the usability and flexibility of [[= product_name =]] by harnessing the potential of artificial intelligence to automate time-consuming editorial tasks.
By default, the AI Actions feature can help users with their work in following scenarios:

- Refining text: when editing a content item, users can request that a passage selected in online editor is modified, for example, by adjusting the length of the text, changing its tone, or correcting linguistic errors.
- Generating alternative text: when working with images, users can ask AI to generate alternative text for them, which helps improve accessibility and SEO.

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

For more information, see [Collaboration PHP API](../api/php_api/php_api_reference/php_api_reference/namespaces/ibexa-contracts-collaboration.html) and [Share PHP API](../api/php_api/php_api_reference/php_api_reference/namespaces/ibexa-contracts-share.html).

### Software architecture upgrades

With improved compatibility, performance and increased security, as well as better developer experience in mind, [[= product_name_base =]] decided to introduce several significant tech stack upgrades.

For a full list of updated system requirements, see [Requirements](../getting_started/requirements.md).

#### Symfony 7.3

With this release, [[= product_name =]] moves to Symfony 7.3 from the previously used versions of Symfony.

For details, see [Symfony 7.3](https://symfony.com/doc/current/setup/upgrade_major.html).

#### Doctrine 3.9

By moving to Doctrine 3.9, [[= product_name =]] brings developers better performance, cleaner code, and stronger foundation for a more modern and maintainable application.

#### PHP 8.3

With performance, coding safety and security in mind, with this version, [[= product_name =]] moves to [PHP 8.3](https://www.php.net/releases/8.3/en.php) and drops support for lower versions of the language.

#### OpenAPI support

Adding support for generating the OpenAPI specification for our REST API makes future changes more manageable, and helps our partners automatically generate REST API clients.

Support for serialization and deserialization of REST payloads with the Symfony Serializer component improves data reliability and simplifies debugging.

### Developer experience

#### New packages 

The following packages have been introduced in [[= product_name =]] v5.0.0:

- ibexa/collaboration
- ibexa/connector-ai
- ibexa/discounts
- ibexa/discounts-codes
- ibexa/product-catalog-date-time-attribute
- ibexa/product-catalog-symbol-attribute
- ibexa/share

#### REST APIs

[[= product_name =]] v5.0.0 adds REST API coverage for the following features:

- AI Actions:
    - [Action Configurations](../api/rest_api/rest_api_reference/rest_api_reference.html#ai-actions-list-action-configurations)
    - [Action Types](../api/rest_api/rest_api_reference/rest_api_reference.html#ai-actions-list-action-types)
- [Discounts](/api/rest_api/rest_api_reference/rest_api_reference.html#discounts)
- [Collaboration](/api/rest_api/rest_api_reference/rest_api_reference.html#collaboration)

#### PHP API

The PHP API has been expanded with the following classes and interfaces:

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
- [`Ibexa\Contracts\Discounts\DiscountConditionCriterionMapperInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountConditionCriterionMapperInterface.html)
- [`Ibexa\Contracts\Discounts\DiscountFormMapperInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html)
- [`Ibexa\Contracts\Discounts\DiscountPrioritizationStrategyInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountPrioritizationStrategyInterface.html)
- [`Ibexa\Contracts\Discounts\DiscountServiceDecorator`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountServiceDecorator.html)
- [`Ibexa\Contracts\Discounts\DiscountServiceInterface `](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountServiceInterface .html)
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
- [`Ibexa\Contracts\Discounts\Value\Struct\DiscountCreateStruct`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountCreateStruct.html)
- [`Ibexa\Contracts\Discounts\Value\Struct\DiscountStructInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountStructInterface.html)
- [`Ibexa\Contracts\Discounts\Value\DiscountTranslationStruct`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountTranslationStruct.html)
- [`Ibexa\Contracts\Discounts\Value\DiscountUpdateStruct`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountUpdateStruct.html)
- [`Ibexa\Contracts\Discounts\Value\TranslationAwareDiscountStructInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-TranslationAwareDiscountStructInterface.html)
- [`Ibexa\Contracts\Discounts\Value\TranslationAwareDiscountStructTrait`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-TranslationAwareDiscountStructTrait.html)
- [`Ibexa\Contracts\DiscountsCodes\Exception\DiscountCodeNotFoundException`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Exception-DiscountCodeNotFoundException.html)
- [`Ibexa\Contracts\DiscountsCodes\Exception\DiscountCodeRateLimitExceededException`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Exception-DiscountCodeRateLimitExceededException.html)
- [`Ibexa\Contracts\DiscountsCodes\Exception\DiscountCodeUnusableException`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Exception-DiscountCodeUnusableException.html)
- [`Ibexa\Contracts\DiscountsCodes\Exception\DiscountCodeUserInvalidArgumentException`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Exception-DiscountCodeUserInvalidArgumentException.html)
- [`Ibexa\Contracts\DiscountsCodes\Value\DiscountCodeUsageInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-DiscountCodeUsageInterface.html)
- [`Ibexa\Contracts\DiscountsCodes\Value\DiscountCodeUser`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-DiscountCodeUser.html)
- [`Ibexa\Contracts\DiscountsCodes\Value\Query\DiscountCodeUsageQuery`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-Query-DiscountCodeUsageQuery.html)
- [`Ibexa\Contracts\DiscountsCodes\Value\Struct\DiscountCodeCreateStruct `](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-Struct-DiscountCodeCreateStruct.html)
- [`Ibexa\Contracts\DiscountsCodes\Value\StructDiscountCodeUpdateStruct `](../api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-Struct-DiscountCodeUpdateStruct.html)

#### Search Criteria

The following search criteria have been added in the v5.0 release:

AI Actions

- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Enabled`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-Enabled.html)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Identifier`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-Identifier.htmll)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\LogicalAnd`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-LogicalAnd.html)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\LogicalOr`](h../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-LogicalOr.html)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Name`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-Name.html)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Type`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-Type.html)

Discounts

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

#### Sort Clauses

The following sort clauses have been added in the v5.0 release:

AI Actions

- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause\Enabled`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-SortClause-Enabled.html)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause\Id`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-SortClause-Id.html)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause\Identifier`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-SortClause-Identifier.html)

Discounts

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

- ibexa/connector-ai

    - `\Ibexa\Contracts\ConnectorAi\Action\Event\BeforeExecuteEvent`
    - `\Ibexa\Contracts\ConnectorAi\Action\Event\ExecuteEvent`
    - `\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\BeforeCreateActionConfigurationEvent`
    - `\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\CreateActionConfigurationEvent`
    - `\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\BeforeUpdateActionConfigurationEvent`
    - `\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\UpdateActionConfigurationEvent`
    - `\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\BeforeDeleteActionConfigurationEvent`
    - `\Ibexa\Contracts\ConnectorAi\ActionConfiguration\Event\DeleteActionConfigurationEvent`
    - `Ibexa\Contracts\ConnectorAi\Events\ContextEvent`
    - `Ibexa\Contracts\ConnectorAi\Events\ResolveActionConfigurationWidgetConfigEvent`
    - `Ibexa\Contracts\ConnectorAi\Events\ResolveActionHandlerEvent`

- ibexa/discounts

    - `\Ibexa\Contracts\Discounts\Event\BeforeCreateDiscountEvent`
    - `\Ibexa\Contracts\Discounts\Event\CreateDiscountEvent`
    - `\Ibexa\Contracts\Discounts\Event\BeforeDeleteDiscountEvent`
    - `\Ibexa\Contracts\Discounts\Event\DeleteDiscountEvent`
    - `\Ibexa\Contracts\Discounts\Event\BeforeUpdateDiscountEvent`
    - `\Ibexa\Contracts\Discounts\Event\UpdateDiscountEvent`
    - `\Ibexa\Contracts\Discounts\Event\CreateDiscountCreateStructEvent`
    - `\Ibexa\Contracts\Discounts\Event\CreateDiscountUpdateStructEvent`
    - `\Ibexa\Contracts\Discounts\Event\CreateFormDataEvent`
    - `\Ibexa\Contracts\Discounts\Event\MapDiscountToFormDataEvent`
    - `\Ibexa\Contracts\Discounts\Event\Step\CreateFormDataEvent`
    - `\Ibexa\Contracts\Discounts\Event\Step\MapCreateDataToStructEvent`
    - `\Ibexa\Contracts\Discounts\Event\Step\MapDiscountToFormDataEvent`
    - `\Ibexa\Contracts\Discounts\Event\Step\MapUpdateDataToStructEvent`
    - `\Ibexa\Contracts\Discounts\Admin\Form\Event\PreDiscountCreateEvent`
    - `\Ibexa\Contracts\Discounts\Admin\Form\Event`
    - `\Ibexa\Contracts\DiscountsCodes\Event\BeforeDiscountCodeApplyEvent`

#### Twig functions

The following Twig functions have been added in the v5.0 release:

- `ibexa_ai_config`
- `ibexa_render_discount_rule_type`
- `ibexa_discounts_render_discount_badge`
- `ibexa_get_original_price`
- `ibexa_format_discount_value`
- `ibexa_discounts_is_active`
- `ibexa_discounts_form_themes`
- `ibexa_discounts_can_edit`
- `ibexa_discounts_can_enable`
- `ibexa_discounts_can_disable`
- `ibexa_discounts_can_delete`

#### Other upgrades

This release brings other minor upgrades intended to improve the developer's experience:

- New icons that serve as a highlight of a future system design
- Improved DX with capabilities offered by PHP in version 8.3. For example, the `AsTwigComponent` attribute [facilitates autoconfiguration](https://github.com/ibexa/twig-components/pull/15) of Twig components
- The introduction of [[= product_name_base =]] Rector package that is based on [Rector](https://github.com/rectorphp) and comes with additional rules for working with Ibexa code. You can use it to get rid of PHP code deprecations.

### Deprecations

Refer to [Ibexa DXP v5.0 renames, deprecations and removals](ibexa_dxp_v5.0_deprecations.md) for a full list of changes and how they influence your project.

### Full changelog

[[% include 'snippets/release_50.md' %]]

To update your application, see the [update instructions](update_from_4.6.md).

[[= release_note_entry_end() =]]

</div>
