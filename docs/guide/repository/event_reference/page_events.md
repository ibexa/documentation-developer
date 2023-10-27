---
description: Events that are triggered when working with Pages and Page blocks.
edition: experience
---

# Page events

| Event | Dispatched by | Properties |
|---|---|---|
|`AttributeSerializationEvent`|`AttributeSerializationDispatcher::serialize`|`LandingPage\Model\BlockValue $blockValue`</br>`string $attributeIdentifier`</br>`mixed|null $serializedValue`</br>`mixed $deserializedValue`|
|`BlockContextEvent`|`BlockService::createBlockContextFromRequest`|`Request $request`</br>`BlockContextInterface|null $blockContext`|
|`BlockFragmentRenderEvent`|`BlockRenderOptionsFragmentRenderer::dispatchFragmentRenderEvent`|`Content $content`</br>`Location|null $location`</br>`LandingPage\Model\Page $page`</br>`LandingPage\Model\BlockValue $blockValue`</br>`ControllerReference $uri`</br>`Request $request`</br>`array $options`|
|`BlockResponseEvent`|`BlockResponseSubscriber::getSubscribedEvents`|`BlockContextInterface $blockContext`</br>`LandingPage\Model\BlockValue $blockValue`</br>`Request $request`</br>`Response $response`|
|`CollectBlockRelationsEvent`|`CollectRelationsSubscriber::onCollectBlockRelations`|`LandingPage\Value $fieldValue`</br>`LandingPage\Model\BlockValue $blockValue`</br>`int[] $relations`|
|`PageRenderEvent`|`PageService::dispatchRenderPageEvent`|`Content $content`</br>`Location|null $location`</br>`LandingPage\Model\Page $page`</br>`Request $request`|

## Page Builder

The following events are dispatched when editing a Page in the Page Builder.

| Event | Dispatched by | Properties |
|---|---|---|
|`BlockConfigurationViewEvent`|`BlockController::dispatchBlockConfigurationViewEvent`|`BlockConfigurationView $blockConfigurationView`</br>`BlockDefinition $blockDefinition`</br>`BlockConfiguration $blockConfiguration`</br>`FormInterface $blockConfigurationForm`|
|`BlockPreviewPageContextEvent`|`PreviewController::dispatchPageContextEvent`|`BlockContextInterface $blockContext`</br>`LandingPage\Model\Page $page`</br>`array $pagePreviewParameters`|
|`BlockPreviewResponseEvent`|`PreviewController::dispatchBlockPreviewResponseEvent`|`BlockContextInterface $blockContext`</br>`array $pagePreviewParameters`</br>`LandingPage\Model\Page $page`</br>`BlockValue $blockValue`</br>`array  $responseData`|

## Page blocks

The following events are dispatched when editing a Page block.

| Event | Dispatched by | Properties |
|---|---|---|
|`BlockDefinitionEvent`|`BlockDefinitionFactory::getBlockDefinition`|`BlockDefinition $definition`</br>`array $configuration`|
|`BlockAttributeDefinitionEvent`|`BlockDefinitionFactory::getBlockDefinition`|`BlockAttributeDefinition $definition`</br>`array $configuration`|
|`PreRenderEvent`|`BlockService::render`|`BlockContextInterface $blockContext`</br>`BlockValue $blockValue`</br>`RenderRequestInterface $renderRequest`|
|`PostRenderEvent`|`BlockService::render`|`BlockContextInterface $blockContext`</br>`BlockValue $blockValue`</br>`string $renderedBlock`|
