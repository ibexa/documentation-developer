# Page events [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

| Event | Dispatched by | Properties |
|---|---|---|
|`AttributeSerializationEvent`|`AttributeSerializationDispatcher::serialize`|`LandingPage\Model\BlockValue $blockValue`</br>`string $attributeIdentifier`</br>`mixed|null $serializedValue`</br>`mixed $deserializedValue`|
|`BlockContextEvent`|`BlockService::createBlockContextFromRequest`|`Request $request`</br>`BlockContextInterface|null $blockContext`|
|`BlockFragmentRenderEvent`|`BlockRenderOptionsFragmentRenderer::dispatchFragmentRenderEvent`|`Content $content`</br>`Location|null $location`</br>`LandingPage\Model\Page $page`</br>`LandingPage\Model\BlockValue $blockValue`</br>`ControllerReference $uri`</br>`Request $request`</br>`array $options`|
|`BlockResponseEvent`|`BlockResponseSubscriber::getSubscribedEvents`|`BlockContextInterface $blockContext`</br>`LandingPage\Model\BlockValue $blockValue`</br>`Request $request`</br>`Response $response`|
|`CollectBlockRelationsEvent`|`CollectRelationsSubscriber::onCollectBlockRelations`|`LandingPage\Value $fieldValue`</br>`LandingPage\Model\BlockValue $blockValue`</br>`int[] $relations`|
|`PageRenderEvent`|`PageService::dispatchRenderPageEvent`|`Content $content`</br>`Location|null $location`</br>`LandingPage\Model\Page $page`</br>`Request $request`|

## Page builder

The following events are dispatched when editing a Page in the Page builder.

| Event | Dispatched by | Properties |
|---|---|---|
|`BlockConfigurationViewEvent`|`BlockController::dispatchBlockConfigurationViewEvent`|`BlockConfigurationView $blockConfigurationView`</br>`BlockDefinition $blockDefinition`</br>`BlockConfiguration $blockConfiguration`</br>`FormInterface $blockConfigurationForm`|
|`BlockPreviewPageContextEvent`|`PreviewController::dispatchPageContextEvent`|`BlockContextInterface $blockContext`</br>`LandingPage\Model\Page $page`</br>`array $pagePreviewParameters`|
|`BlockPreviewResponseEvent`|`PreviewController::dispatchBlockPreviewResponseEvent`|`BlockContextInterface $blockContext`</br>`array $pagePreviewParameters`</br>`LandingPage\Model\Page $page`</br>`BlockValue $blockValue`</br>`array  $responseData`|
