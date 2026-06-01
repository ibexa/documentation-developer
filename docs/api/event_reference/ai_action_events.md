---
description: Events that are triggered when working with AI actions.
page_type: reference
edition: lts-update
month_change: false
---

# AI Actions events

## AI Action execution

| Event | Dispatched by |
|---|---|
|[BeforeExecuteEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-Event-BeforeExecuteEvent.html)|[ActionServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionServiceInterface.html)|
|[ExecuteEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-Event-ExecuteEvent.html)|[ActionServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionServiceInterface.html)|

## Action Configurations management

| Event | Dispatched by |
|---|---|
|[BeforeCreateActionConfigurationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-BeforeCreateActionConfigurationEvent.html)|[ActionConfigurationServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationServiceInterface.html)|
|[CreateActionConfigurationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-CreateActionConfigurationEvent.html)|[ActionConfigurationServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationServiceInterface.html)|
|[BeforeUpdateActionConfigurationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-BeforeUpdateActionConfigurationEvent.html)|[ActionConfigurationServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationServiceInterface.html)|
|[UpdateActionConfigurationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-UpdateActionConfigurationEvent.html)|[ActionConfigurationServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationServiceInterface.html)|
|[BeforeDeleteActionConfigurationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-BeforeDeleteActionConfigurationEvent.html)|[ActionConfigurationServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationServiceInterface.html)|
|[DeleteActionConfigurationEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Event-DeleteActionConfigurationEvent.html)|[ActionConfigurationServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfigurationServiceInterface.html)|

## Others

| Event | Dispatched by | Description |
|---|---|---|
| [ContextEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Events-ContextEvent.html)| [ActionServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionServiceInterface.html) | Pass additional options to the System Context before an AI Action is executed |
| [ResolveActionConfigurationWidgetConfigEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Events-ResolveActionConfigurationWidgetConfigEvent.html)| `\Ibexa\ConnectorAi\Twig\ActionConfigurationWidgetConfigExtension::renderActionConfigurationWidgetConfig()` | Modify the Action Type configuration returned from the [ibexa_ai_config Twig function](ai_actions_twig_functions.md) |
| [ResolveActionHandlerEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Events-ResolveActionHandlerEvent.html)| [ActionHandlerResolverInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-Action-ActionHandlerResolverInterface.html) | Hook into the process of choosing a Handler to execute an AI Action |
