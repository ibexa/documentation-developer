# Data processor events [[% include 'snippets/commerce_badge.md' %]]

You can listen to two events for each data processor to extend its logic.
An event is triggered before and after the execution of the data processor.

## Event names

The name of the event is put together dynamically by a prefix and a suffix.

- `ses_pre_execute_` - the event before the execution 
- `ses_post_execute_` - the event after the execution

The suffix is the ID of the `DataProcessor` service. An example for the service `ses_forms.create_ez_user` is:

- `ses_pre_execute_ses_forms.create_ez_user`
- `ses_post_execute_ses_forms.create_ez_user`

To listen to one of these events, define a service and tag it in configuration:

``` xml
<service id="ses_data_processor.pre_execute.create_ez_user_handler" class="%ses_data_processor.pre_execute.create_ez_user_handler.class%">
      <tag name="kernel.event_listener" event="ses_pre_execute_ses_forms.create_ez_user" method="preExecute" />
      <tag name="kernel.event_listener" event="ses_post_execute_ses_forms.create_ez_user" method="postExecute" />
</service>
```

In the implemented class you can access and manipulate the normalized `FormEntity`:

``` php
use Silversolutions\Bundle\EshopBundle\Entities\Forms\Normalize\Entity;
use Silversolutions\Bundle\EshopBundle\Event\DataProcessor\PreDataProcessorExecuteEvent;
use Silversolutions\Bundle\EshopBundle\Event\DataProcessor\PostDataProcessorExecuteEvent;

class EzCreateUserEventHandler
{
    public function preExecute(PreDataProcessorExecuteEvent $event)
    {        
        /** @var Entity $entity */
        $entity = $event->getNormalizedEntity();   
        ...   
    }
 
    public function postExecute(PostDataProcessorExecuteEvent $event)
    {        
        /** @var Entity $entity */
        $entity = $event->getNormalizedEntity();      
        ...
    }
}
```

If you manipulate the normalized entity, remember that it affects the next `DataProcessors`.
