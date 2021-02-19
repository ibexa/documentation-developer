# ERP [[% include 'snippets/commerce_badge.md' %]]

[[= product_name =]] can be connected to ERP systems. 
Out of the box, it offers connection for the Microsoft Dynamics ERP.

Existing ERP customers can automatically create an account in the shop without waiting for a confirmation from the administrator.
The shop updates customer data from the ERP in real time.

## Stock information

[[= product_name =]] requests real-time stock information from the ERP system
and notifies the customer if the stock is lower than the required quantity.
It is possible to display the real stock as a numeric value as well.

![](img/stock_info_in_basket.png)

## Configuration of price providers

The shop owner can select systems used for calculating prices.

A fallback price provider can be configured (for example, one that uses imported prices). 
It is used if ERP is not available.

![](img/price_providers.png)

## ERP fallback

[[= product_name =]] supports fallback scenarios for the most important processes in case the connection to the ERP is not available:

- Caching latest customer data after login.
- Fallback price engine. The customer is informed if the prices and stock are not up to date.
- Storing an order in the shop. It is transmitted to the ERP when the system is available again.
