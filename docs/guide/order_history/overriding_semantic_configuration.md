# Overriding semantic configuration per SiteAccess [[% include 'snippets/commerce_badge.md' %]]

The semantic configuration (`orderhistory.yml`) is read and prepared in the `ConfigurationReaderService`.
When an event is dispatched, the service enables you to modify the configuration, for example if you need to change it per SiteAccess.

``` php
$list = %siso_order_history.list%;
$document_types = %siso_order_history.document_types%;
$default_document_type = %siso_order_history.default_document_type%;
$date = %siso_order_history.date%;
$default_list_fields = %siso_order_history.default_list_fields%;
$default_list_sort = %siso_order_history.default_list_sort%;
$default_list_sort_column = %siso_order_history.default_list_sort_column%;
$default_detail_fields = %siso_order_history.default_detail_fields%;

$data = array(
    'list' => $list,
    'document_types' => $document_types,
    'default_document_type' => $default_document_type,
    'date' => $this->dateTimeService->formatDateAmountToDate($date),
    'default_list_fields' => $default_list_fields,
    'default_list_sort' => $default_list_sort,
    'default_list_sort_column' => $default_list_sort_column,
    'default_detail_fields' => $default_detail_fields
);

// ...

/**
 * Dispatch the event ConfigurationEvents::READ_CONFIGURATION
 * The purpose of this event is to have a possibility to change the existing configuration depending on the siteAccess.
 *
 * @return void
 */
protected function getConfigurationData()
{
    /** @var  ReadConfigurationEvent $event */
    $event = new ReadConfigurationEvent();
    $event->setData($this->data);

    $this->eventDispatcher->dispatch(
        ConfigurationEvents::READ_CONFIGURATION,
        $event
    );

    $this->data = $event->getData();
}
```

You need to implement a `siso_order_history.read_configuration` listener.

Add a configuration per SiteAccess:

``` yaml
parameters:
    siso_order_history.default.document_types:
       - order
    siso_order_history.default.default_document_type: order
```

Implement an event listener:

``` php
public function onReadConfiguration(ReadConfigurationEvent $readConfigurationEvent)
{
    $data = $readConfigurationEvent->getData();

    $data['document_types'] = $this->configResolver->getParameter('document_types', 'siso_order_history');
    $data['default_document_type'] = $this->configResolver->getParameter(
                'default_document_type', 
                'siso_order_history'
   );

   $readConfigurationEvent->setData($data);
}
```

``` xml
<service id="project.read_configuration_listener" class="%project.read_configuration_listener.class%">
    <argument type="service" id="ezpublish.config.resolver"/>
    <tag name="kernel.event_listener"  event="siso_order_history.read_configuration" method="onReadConfiguration" />
</service>
```
