---
description: Shipment Status Criterion
edition: commerce
---

# Shipment Status Criterion

The `StatusCriterion` Search Criterion searches for shipments based on shipment status.

## Arguments

- `status` - string that represents the status of the shipment, takes values defined in shipment processing workflow

## Example

``` php
$query->query = new \Ibexa\Contracts\Checkout\Shipment\Query\Criterion\Status('pending');
```
