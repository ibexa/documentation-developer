---
description: Ibexa DXP v4.6 brings improvements to Commerce, PIM and Personalization offerings, and a number of changes in CDP and Ibexa Connect.
---

# Ibexa DXP v4.6

**Version number**: v4.6

**Release date**: July 20, 2023

**Release type**: [LTS](https://support.ibexa.co/Public/service-life)

**Update**: [v4.5.x to v4.6](https://doc.ibexa.co/en/latest/update_and_migration/from_4.5/update_from_4.5/)

## Notable changes

### Ibexa Headless

Ibexa Content changes name to Ibexa Headless to emphasize Ibexa's capacity for headless architecture.

The feature set and capabilities of the product remain the same.

### New features and improvements in Personalization

#### Email triggers

You can increase the engagement of your visitors and customers by delivering recommendations straight to their mailboxes. 
The feature requires that you expose an endpoint that passes data to an internal mailing system and supports the following two use cases:

- Inducing a purchase by pushing a message with cart contents or equivalents, when the customer's cart status remains unchanged for a set time.

- Inviting a visitor to come back to the site by pushing a message with recommendations, when the customer hasn't returned to the site for a set time.

For more information, see [Email triggers](https://doc.ibexa.co/projects/userguide/en/4.5/personalization/triggers.md).

#### Multiple attributes in recommendation computation

With this feature, you get an option to combine several attribute types when computing recommendations. 
As a result, users can be presented with recommendations from an intersection of submodel results.

For more information, see [Submodel parameters](recommendation_api.md#submodel-parameters) and [Submodels]https://doc.ibexa.co/projects/userguide/en/latest/personalization/recommendation_models/#submodels).


#### New scenario filter

Depending on a setting that you make when defining a scenario, the recommendation response can now include either product variants or base products only. 
This way you can deliver more accurate recommendations and avoid showing multiple variants of the same product to the client.

For more information, see [Commerce-specific filters](https://doc.ibexa.co/projects/userguide/en/latest/personalization/filters/#commerce-specific-filters).

### 

## Other changes

### 

### API improvements

#### REST API 

#### PHP API 

### 

### 

### 

### Deprecations

#### 

## Full changelog

| Ibexa Headless | Ibexa Experience | Ibexa Commerce|
|---------------|------------------|---------------|
| [Ibexa Headless v4.6](https://github.com/ibexa/headless/releases/tag/v4.6.0) | [Ibexa Experience v4.6](https://github.com/ibexa/experience/releases/tag/v4.6.0) | [Ibexa Commerce v4.6](https://github.com/ibexa/commerce/releases/tag/v4.6.0) |
