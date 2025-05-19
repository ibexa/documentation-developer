---
description: Discount Search Criteria
edition: commerce
---

# Discount Search Criteria reference

Discount Search Criteria are only supported by [Discount Search (`DiscountService::findDiscounts`)](discounts_api.md#get-multiple-discounts).

With these Criteria you can filter discounts, for example, by their discount identifier, name, creation date, discount status, priority, or type.

## Discount Search Criteria

|Search Criterion|Search based on|
|-----|-----|
|[CreatedAtCriterion](discount_created_criterion.md)|Date and time when the discount was created|
|[CreatorCriterion](discount_creator_criterion.md)|User who created the discount|
|[EndDateCriterion](discount_end_date_criterion.md)|Date and time when the discount expires|
|[IdentifierCriterion](discount_identifier_criterion.md)|Discount identifier|
|[IsEnabledCriterion](discount_is_enabled_criterion.md)|Whether the discount is enabled or not|
|[LogicalAndCriterion](discount_logicaland_criterion.md)|Owner based on the user reference|
|[LogicalOrCriterion](discount_logicalor_criterion.md)|Owner based on the user reference|
|[NameCriterion](discount_name_criterion.md)|The name of the discount|
|[PriorityCriterion](discount_priority_criterion.md)|Priority value of the discount|
|[StartDateCriterion](discount_start_date_criterion.md)|Date and time when the discount begins|
|[TypeCriterion](discount_type_criterion.md)|Type value of the criterion|
