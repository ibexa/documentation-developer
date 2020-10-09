# Basket FAQ

## What data can be stored in a basket?

The basket offers a flexible way to store information on header or product level.

A `dataMap` can be used to store all kinds of information. It can be addressed by the PHP API or filled directly using a form:

``` 
<input type="hidden" name="ses_basket[0][remark]" value="" />
```

## How are orders stored?

An order is stored in the basket table as well. The state "confirmed" states that this is an order and has been accepted and forwarded to a legacy system such as an ERP.
