---
description: Events that are triggered when working with AI actions.
page_type: reference
month_change: false
---

# AI Actions events

## AI Action execution

| Event | Dispatched by |
|---|---|
|[BeforeExecuteEvent](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-Event-BeforeExecuteEvent.html)|[ActionServiceInterface](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionServiceInterface.html)|
|[ExecuteEvent](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-Event-ExecuteEvent.html)|[ActionServiceInterface](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionServiceInterface.html)|

## Action Configurations management

| Event | Dispatched by |
|---|---|
|[BeforeCreateActionConfigurationEvent](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-BeforeCreateActionConfigurationEvent.html)|[ActionConfigurationServiceInterface](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationServiceInterface.html)|
|[CreateActionConfigurationEvent](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-CreateActionConfigurationEvent.html)|[ActionConfigurationServiceInterface](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationServiceInterface.html)|
|[BeforeUpdateActionConfigurationEvent](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-BeforeUpdateActionConfigurationEvent.html)|[ActionConfigurationServiceInterface](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationServiceInterface.html)|
|[UpdateActionConfigurationEvent](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-UpdateActionConfigurationEvent.html)|[ActionConfigurationServiceInterface](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationServiceInterface.html)|
|[BeforeDeleteActionConfigurationEvent](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-BeforeDeleteActionConfigurationEvent.html)|[ActionConfigurationServiceInterface](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationServiceInterface.html)|
|[DeleteActionConfigurationEvent](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-DeleteActionConfigurationEvent.html)|[ActionConfigurationServiceInterface](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationServiceInterface.html)|

## Others

| Event | Dispatched by | Description |
|---|---|---|
| [ContextEvent](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Events-ContextEvent.html)| [ActionServiceInterface](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionServiceInterface.html) | Pass additional options to the System Context before an AI Action is executed |
| [ResolveActionConfigurationWidgetConfigEvent](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Events-ResolveActionConfigurationWidgetConfigEvent.html)| `\Ibexa\ConnectorAi\Twig\ActionConfigurationWidgetConfigExtension::renderActionConfigurationWidgetConfig()` | Modify the Action Type configuration returned from the [ibexa_ai_config Twig function](ai_actions_twig_functions.md) |
| [ResolveActionHandlerEvent](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Events-ResolveActionHandlerEvent.html)| [ActionHandlerResolverInterface](../php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-ActionHandlerResolverInterface.html) | Hook into the process of choosing a Handler to execute an AI Action |

