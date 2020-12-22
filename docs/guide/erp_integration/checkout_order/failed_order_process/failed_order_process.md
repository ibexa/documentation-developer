# Failed order process [[% include 'snippets/experience_badge.md' %]]

For usability reasons, it is not advisable to let the whole checkout fail if the communication to the ERP system is not working correctly.
When the submission of an order to the ERP system fails, the order must be stored for a later retry.

## The OrderFailedEvent

The `Silversolutions\Bundle\EshopBundle\Event\Erp\OrderFailedEvent` event (event ID `siso_erp.order_failed`) is dispatched by `WebConnectorErpService` if an error occurs during the communication with the remote ERP system.
It should also be dispatched by other implementations of `AbstractErpService` under similar circumstances.

!!! note

    If the class attribute `$maxCount` is not set or null, listeners for this event ignore the maximum number of retries for failed / lost orders.

    The order is submitted again (for back-end manipulation of orders).

## ErpErrorServiceInterface

The `Silversolutions\Bundle\EshopBundle\Services\ErpErrorServiceInterface` interface declares the `processFailedOrder()` method which is intended to process failed orders.

### Standard implementation

The `Silversolutions\Bundle\EshopBundle\Services\StandardErpErrorService` interface (service ID `siso_erp.erp_error_service`) is only implemented in an event listener.
This listener is subscribed to `OrderFailedEvent` and set up with the highest priority.

!!! note

    As this service provides some crucial information to the basket object (as ERP error message and fail counter) it should have the highest priority in all setups.

The standard implementation uses the basket states in order to realize the queue of failed orders.
Orders with the state `ordered_failed` are considered to be queued.

The number of failed tries is stored in the basket's `$erpFailCounter` attribute.
The maximum allowed number of tries is configured using `siso_checkout.default.max_failed_order`.

Only basket objects with the states `payed` and `ordered_failed` are expected to be transmitted as order and can be processed as a failed order.
If the given basket object has a different state, a `RuntimeException` is thrown.

## OrderFailedNotifyListener

If an order failed, an administrator is informed about it by sending an e-mail. For that purpose the `Silversolutions\Bundle\EshopBundle\EventListener\Erp\OrderFailedNotifyListener` (service ID `siso_eshop.order_failed_listener`) listener exists for the `siso_erp.order_failed` event.
This listener has a lower priority than `StandardErpErrorService`, which ensures that the ERP error message is already set in the basket (given by the event object).

The following container parameters are passed to the service:

- `ses_swiftmailer`
- `siso_eshop.order_failed.subject`

The `mailReceiver` subelement under `ses_swiftmailer` is used as the recipient for the notification.
