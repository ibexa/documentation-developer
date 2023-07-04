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

With email triggers, you can increase the engagement of your visitors and customers by delivering recommendations straight to their mailboxes. 
The feature requires exposing an endpoint that passed data to an internal mailing system and supports the following two use cases:

- Pushing a message when the store customer's cart status remains unchanged for a set time to induce a purchase.

- Pushing a message that invites a visitor to come back to the site after they haven't returned to the site for a set time.

For more information, see [Email triggers](https://doc.ibexa.co/projects/userguide/en/4.5/personalization/triggers.md).

#### Multiple attributes in submodel computation

With this feature you get an option to combine different attribute types when computing submodels. 
This way they can now prepare a submodel based on one attribute and then group the resulting recommendations by the other one.

For more information, see [Advanced model configuration](https://doc.ibexa.co/projects/userguide/en/latest/personalization/configure_models/#advanced-model-configuration).

#### PIM integration

Improvements in this area result possibility to track events in relation to products and product variants alike.
Depending on a setting that you make when editing a model configuration, the recommendation response includes product variants or base products only. 
As a result, you can deliver more accurate recommendations and avoid showing multiple variants of the same product to the client.

For more information, see [Configure models](https://doc.ibexa.co/projects/userguide/en/latest/personalization/configure_models/).

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
