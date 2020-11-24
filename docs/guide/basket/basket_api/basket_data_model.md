# Basket data model [[% include 'snippets/commerce_badge.md' %]]

The basket consists of two elements:

- a basket header that contains information such as IDs, the invoice party and delivery
- one or more basket lines with information about the products 

## Basket

The following attributes are provided by the basket header.

|Attribute|Meaning|Type|Mandatory|
|--- |--- |--- |--- |
|`basketId`|Basket ID number. Ensures that one order is placed only once. It must be an integer, because it is passed to the ERP, and some ERP systems accept only integer IDs.|int|Yes|
|`originId`|ID of the original basket if the current basket is a copy|int||
|`erpOrderId`|ID assigned by the ERP to the order document|string||
|`guid`|Unique ID that identifies the order across all systems (for example, ERP, shop and payment system)|string||
|`state`|`new`, `offered`, `payed`, `confirmed`|string|Yes|
|`type`|`basket`, `quickOrder`, `storedBasket`, `wishlist`, `comparison`|string|Yes|
|`erpFailCounter`|Used in the `processFailedOrder()` method of the `BasketService` to count the number of attempts (of submitting the order to the ERP)|int||
|`erpFailErrorLog`|List of messages related to failed ERP transmissions|array||
|`sessionId`|`sessionId` of the anonymous user|string||
|`userId`|`userId` if the user is logged in|int||
|`basketName`|The basket name given by a user to function `storedBasket`. In this case the attribute `type` is `storedBasket` (see [Wishlist and stored baskets](../wishlist_and_stored_baskets.md))|string||
|`invoiceParty`|Invoice address. In order to process the basket, the address may have to be updated if the customer changes the invoice address|Party||
|`deliveryParty`|Delivery address chosen for the order|Party||
|`buyerParty`|Customer address. In order to process the basket, the address may have to be updated if the customer changes the invoice address|Party||
|`remark`|Additional customer remark|string||
|`dateCreated`|Date and time when the basket was created|Datetime|Yes|
|`dateLastModified`|Date and time when the basket was last modified|Datetime|Yes|
|`shop`|Code of the shop where the order was placed. The code is defined in `silver.e-shop.yml`|string||
|`requirePriceUpdate`|If true, price engine must be initiated|boolean|Yes|
|`totals`|Stores `BasketTotals` object, used for all lines|array of BasketTotals||
|`totalsSum`|Stores an array of `BasketTotals` objects, used for order splitting|BasketTotals||
|`currency`|Basket currency|string||
|`totalsSumNet`|Basket total net sum as simple float value|float||
|`totalsSumGross`|Basket total gross sum as simple float value|float||
|`additionalLines`|Array of `AdditionalLine` objects that can contain more information about products (for example, additional shipping costs, vouchers, discounts, etc.)|array of AdditionalLine||
|`lines`|Array of BasketLine objects|array of BasketLine||
|`dateLastPriceCalculation`|Date of last price calculation made by the basket service when storing the basket|DateTime||
|`shippingMethod`|The selected shipping method|string||
|`paymentMethod`|The selected payment method|string||
|`paymentTransactionId`|Transaction ID given by the payment provider|string||
|`confirmationEmail`|Email address, to which the order confirmation email will be sent|string||
|`salesConfirmationEmail`|Email address of the sales contact, to whom order confirmation will be sent|string||
|`allProductsAvailable`|True if all products in basket are available. This value can be checked only if a service such as the ERP provides `Stockinfo`|boolean||
|`dataMap`|Additional information (for example, project-specific attributes)|array||
|`messages`|The error, notice and success messages. The messages are not stored in the database|array||

## BasketLine

|Attribute|Meaning|Type|Mandatory|
|--- |--- |--- |--- |
|`basketLineId`|Basket line ID|int|Yes|
|`lineNumber`|Line number. The number is set when the user adds an article to the basket|int|Yes|
|`sku`|Unique article number|string|Yes|
|`variantCode`|If variant is used|string||
|`productType`|Type of product, such as product, event, subscription, ebook, download.</br>This field is used, for example, to choose a template for displaying the product info for price engine (which request should be sent to the ERP)</br>Example: `OrderableProductNode`|string|Yes|
|`quantity`|Quantity of the product|float|Yes|
|`unit`|Type of packaging unit|string||
|`price`|Price for one item of the line|float||
|`priceNet`|Net price for one item of the line|float||
|`priceGross`|Gross price for one item of the line|float||
|`linePriceAmountNet`|Net price of all items of the line|float||
|`linePriceAmountGross`|Gross price of all items of the line|float||
|`vat`|VAT in %|float||
|`isIncVat`|Does the price include VAT|boolean||
|`currency`|Line currency|string|Yes|
|`catalogElement`|Complete (orderable) catalog element|CatalogElement||
|`groupCalc`|Not used|string||
|`groupOrder`|Not used|string||
|`remark`|Additional remark from the user|string||
|`basket`|Relation to the Basket object|Basket||
|`remoteDataMap`|Additional information for the given basket line. This field may contain extra data provided by the user for this basket line (for example, a special field such as length or a reference to an internal order number).</br>The price engine sets the following attributes in the `remoteDataMap` when provided by the price service (for example, by an ERP system):</br>`stockNumeric` - number of items in stock</br>`onStock` - boolean|array||
|`variantCharacteristics`|Contains all characteristics for the given `variantCode`|array||
|`assignedLines`|Array of `AdditionalLine` objects that can contain more information about products (for example, additional shipping costs, vouchers, discounts)|array of AdditionalLine||

### BasketTotals

`BasketTotals` is not an entity, therefore it has no table in the database. `BasketTotals` is stored in the basket as:

-  serialized object - `totalsSum`
-  serialized array of objects - `totals`

| Attribute  | Type (PHP) |
| ---------- | ---------- |
| `totalNet`   | float      |
| `totalGross` | float      |
| `vatList`    | array      |
| `currency`   | string     |

### Important Basket Repository methods

|Method|Usage|Parameters|
|--- |--- |--- |
|`getBasketBySessionId`|Gets basket by `SessionId`|`sessionId`, `state`, `type`, `name` (optional), `splittingcode` (optional)|
|`getBasketByUserId`|Gets basket by `userId`|`userId`, `state`, `type`, `name` (optional), `splittingcode` (optional)|
|`removeAllAssignedBaskets`|Removes all baskets from the database that are based on the original basket|`originBasketId`|
|`removeBasketsOlderThan`|Removes all old anonymous baskets from the storage|`validationDatetime`|

## Basket messages

Basket messages are stored in the Basket object, but they are not stored in the database.
It is possible to store several success, error or notice messages for products.

|Method|Meaning|Parameters|
|--- |--- |--- |
|`setSuccessMessage()`|Adds one success message to the basket|`success`|
|`getSuccessMessages()`|Gets all success messages from the basket. If it is not set, an empty string is returned.||
|`setErrorMessage()`|Adds one error message to the basket|`error`|
|`getErrorMessages()`|Gets all error messages from the basket. If it is not set, an empty string is returned.||
|`setNoticeMessage()`|Adds one notice message to the basket|`notice`|
|`getNoticeMessages()`|Gets all notice messages from the basket. If it is not set, an empty string is returned.||
|`clearAllMessages()`|Deletes all messages from the basket||
|`removeSuccessMessageForSku()`|Deletes all success messages for the given SKU from the success messages|`sku`|

The messages are rendered using the `EshopBundle/Resources/views/Basket/messages.html.twig` template.
