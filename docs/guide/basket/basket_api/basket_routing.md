---
edition: commerce
---

# Basket routing

The basket provides the following routes:

| Route          | Controller     | Description |
| -------------- | -------------- | ----------- |
| `/basket/show`   | `showAction()`   | Shows a basket with all basket lines |
| `/basket/add`    | `addAction()`    | Adds a product (product list) to the basket |
| `/basket/update` | `updateAction()` | Changes attributes (for example, quantity) of a basket line in the basket |
| `/basket/delete` | `deleteAction()` | Removes a basket line from the basket by the given basket line ID |

## `/basket/show`

Shows a basket with all basket lines. The controller loads the template `/basket/page.html.twig`.

| Parameter | Type   | Description                                   |
| --------- | ------ | ------------------------------------------------------------------------------------- |
| `basket`    | Basket | Optional. This parameter cannot be provided as a POST parameter. It's used internally |

Parameters provided in the basket template `page.html.twig`:

| Parameter | Type | Description |
| --------- | -------------------------------------------- | --------------------------------------------------- |
| `basket`    | Basket                                       | The current basket of the user                      |
| `error`     | array                                        | A list of error messages                           |
| `success`   | array                                        | A list of success messages                         |
| `notice`    | array                                        | A list of notice messages                           |

## `/basket/add`

Adds one or more products to the basket. After adding the product, the basket is displayed.
If the given quantity is 0, it is changed to 1.

| Parameter                            | Type   | Description |
| ------------------------------------ | ------ | ----------- |
| `ses_basket[0][quantity]` | float  | Quantity to be set  |
| `ses_basket[0][sku]` | string | SKU of the basket line |

## `/basket/update`

Updates the current basket. After updating, the basket is displayed.
If the given quantity is 0, `deleteAction()` is called and the product is removed.

| Parameter                            | Type   | Description |
| ------------------------------------ | ------ | ----------- |
| `ses_basket[0][quantity]` | float  | Quantity to be set |
| `ses_basket[0][sku]` | string | SKU of the basket line |

## `/basket/delete`

Removes one line from the basket. After deleting the line, the basket is displayed. 

| Parameter | Type | Description |
| --------- | ---- | ----------- |
| `id` | int  | ID of the basket line that should be deleted |
