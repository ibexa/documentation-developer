# Page events

Events that are triggered when working with pages and page blocks.

Editions: Experience

| Event                         | Dispatched by                                                     | Properties                                                                                                                                                                        |
| ----------------------------- | ----------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `AttributeSerializationEvent` | `AttributeSerializationDispatcher::serialize`                     | `LandingPage\Model\BlockValue $blockValue` `string $attributeIdentifier` `mixed $serializedValue` `mixed $deserializedValue`                                                      |
| `BlockContextEvent`           | `BlockService::createBlockContextFromRequest`                     | `Request $request` `?BlockContextInterface $blockContext`                                                                                                                         |
| `BlockFragmentRenderEvent`    | `BlockRenderOptionsFragmentRenderer::dispatchFragmentRenderEvent` | `Content $content` `?Location $location` `LandingPage\Model\Page $page` `LandingPage\Model\BlockValue $blockValue` `ControllerReference $uri` `Request $request` `array $options` |
| `BlockResponseEvent`          | `BlockResponseSubscriber::getSubscribedEvents`                    | `BlockContextInterface $blockContext` `LandingPage\Model\BlockValue $blockValue` `Request $request` `Response $response`                                                          |
| `CollectBlockRelationsEvent`  | `CollectRelationsSubscriber::onCollectBlockRelations`             | `LandingPage\Value $fieldValue` `LandingPage\Model\BlockValue $blockValue` `int[] $relations`                                                                                     |
| `PageRenderEvent`             | `PageService::dispatchRenderPageEvent`                            | `Content $content` `?Location $location` `LandingPage\Model\Page $page` `Request $request`                                                                                        |

## Page Builder

The following events are dispatched when editing a page in the Page Builder.

| Event                          | Dispatched by                                          | Properties                                                                                                                                                           |
| ------------------------------ | ------------------------------------------------------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `BlockConfigurationViewEvent`  | `BlockController::dispatchBlockConfigurationViewEvent` | `BlockConfigurationView $blockConfigurationView` `BlockDefinition $blockDefinition` `BlockConfiguration $blockConfiguration` `FormInterface $blockConfigurationForm` |
| `BlockPreviewPageContextEvent` | `PreviewController::dispatchPageContextEvent`          | `BlockContextInterface $blockContext` `LandingPage\Model\Page $page` `array $pagePreviewParameters`                                                                  |
| `BlockPreviewResponseEvent`    | `PreviewController::dispatchBlockPreviewResponseEvent` | `BlockContextInterface $blockContext` `array $pagePreviewParameters` `LandingPage\Model\Page $page` `BlockValue $blockValue` `array $responseData`                   |

## Page blocks

The following events are dispatched when editing a page block.

| Event                           | Dispatched by                                | Properties                                                                                             |
| ------------------------------- | -------------------------------------------- | ------------------------------------------------------------------------------------------------------ |
| `BlockDefinitionEvent`          | `BlockDefinitionFactory::getBlockDefinition` | `BlockDefinition $definition` `array $configuration`                                                   |
| `BlockAttributeDefinitionEvent` | `BlockDefinitionFactory::getBlockDefinition` | `BlockAttributeDefinition $definition` `array $configuration`                                          |
| `PreRenderEvent`                | `BlockService::render`                       | `BlockContextInterface $blockContext` `BlockValue $blockValue` `RenderRequestInterface $renderRequest` |
| `PostRenderEvent`               | `BlockService::render`                       | `BlockContextInterface $blockContext` `BlockValue $blockValue` `string $renderedBlock`                 |
