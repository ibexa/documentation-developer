# Basket routing

The basket provides the following routes:

| Route          | Controller     | Controller name                  | Description                                                                  |
| -------------- | -------------- | -------------------------------- | ---------------------------------------------------------------------------- |
| /basket/show   | showAction()   | silversolutions_basket_show    | shows a basket with all basket lines                                            |
| /basket/add    | addAction()    | silversolutions_add_to_basket | adds a product (product list) to the basket with given SKU                   |
| /basket/update | updateAction() | silversolutions_basket_update  | changes attributes (e.g. quantity) of a basket line in the basket for given SKU |
| /basket/delete | deleteAction() | silversolutions_basket_delete  | removes a basket line from the basket by the given basket line ID              |

## Used messages

| Message text                                                      | Description                                                              |
| ----------------------------------------------------------------- | ------------------------------------------------------------------------ |
| Product added: %sku%                                              | Success message when a product has been added                            |
| Product removed: %sku%                                            | Success message when a product has been removed             |
| The given quantity %quantity% is not valid for product SKU: %sku% | Error message if the product quantity is not valid                       |
| The %value% quantity is %quantity% for product SKU: %sku%         | Notice message if the product quantity is more than MAX or less than MIN |

## Route /basket/show

Shows a basket with all basket lines. The controller loads the template `SilversolutionsEshopBundle:Basket:show.html.twig`.  

| Parameter | Type   | Description                                   |
| --------- | ------ | ------------------------------------------------------------------------------------- |
| basket    | Basket | Optional. This parameter cannot be provided as a POST parameter. It's used internally |

Parameters provided in the basket template `show.html.twig`:

| Parameter | Type | Description |
| --------- | -------------------------------------------- | --------------------------------------------------- |
| basket    | Basket                                       | The current basket of the user                      |
| error     | array                                        | A list of error messages.                           |
| success   | array                                        | A list of success messages.                         |
| notice    | array                                        | A list of notice messages                           |

The messages were already translated in the basket service using the translation service.

### Events in show basket

This controller offers an event that is thrown, before the basket is rendered. So it is possible to fetch some additional data before, for example. The event listeners can return a list of subtemplates, that will be displayed on the basket page, either on top or bottom - depending on given parameters.

See [Basket Events](basket_events/basket_events.md)

## Route /basket/add

Adds one or more products to the basket. After adding the product the basket will be displayed. If the given quantity is 0 it is changed to 1.

| Parameter                            | Type   | Description |
| ------------------------------------ | ------ | --------------------------------------------------- |
| ses_basket[0][quantity]         | float  | Quantity to be set                                  |
| ses_basket[0][sku] | string | SKU of the basket line                               |

## Route /basket/update

Updates the current basket. After updating the basket the basket will be displayed. If the given quantity is 0, `deleteAction()` is called and the product is removed.

| Parameter                            | Type   | Description |
| ------------------------------------ | ------ | --------------------------------------------------- |
| ses_basket[0][quantity]         | float  | Quantity to be set                                  |
| ses_basket[0][sku] | string | Sku of the BasketLine                               |

## Route /basket/delete

Removes one line from the basket. After deleting the line the basket will be displayed. 

| Parameter | Type | Description |
| --------- | ---- | --------------------------------------------------- |
| id        | int  | ID of BasketLine that should be deleted             |
