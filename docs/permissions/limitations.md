---
description: Control access to parts of the system by fine-tuning permissions with the use of Limitations.
---

# Limitations

Limitations are part of the permissions system.
They limit the access granted to users by [Policies](permissions.md#permission-overview).
While a Policy grants the user access to a function, Limitations narrow it down by different criteria.

Limitations consist of two parts:

- `Limitation` (Value)
- `LimitationType`

Certain Limitations also serve as Role Limitations, which means they can be used to limit the rights of a Role assignment.
Currently this covers [Subtree of Location](limitation_reference.md#subtree-of-location-limitation), [Section](limitation_reference.md#section-limitation) and [Personalization access](limitation_reference.md#personalization-access-limitation) Limitations.

`Limitation` represents the value, while `LimitationType` deals with the business logic surrounding how it actually works and is enforced.
`LimitationTypes` have two modes of operation in regards to permission logic (see [`Ibexa\Contracts\Core\Limitation`](https://github.com/ibexa/core/blob/main/src/contracts/Limitation/Type.php) interface for more info):

| Method | Use |
|--------|-----|
| `evaluate` | Evaluates if the User has access to a given object in a certain context (for instance the context can be Locations when the object is `Content`), under the condition of the `Limitation` value(s). |
| `getCriterion` | Generates a `Criterion` using `Limitation` value and current User which `SearchService` by default applies to search criteria for filtering search based on permissions. |

## Available Limitations

!!! tip

    Core Policies with Limitations are defined in [`IbexaCoreBundle/settings/policies.yaml`](https://github.com/ibexa/core/blob/main/src/lib/Resources/settings/policies.yml).

Each function in one of the five modules (content, section, state, user, workflow) can be assigned different Limitations.

!!! tip "Functions without Limitations"

    If a function is not mentioned below, it can have no Limitations.

#### Cart

`cart/create`:

- [CartOwner](limitation_reference.md#cartowner-limitation)

`cart/view`:

- [CartOwner](limitation_reference.md#cartowner-limitation)

`cart/edit`:

- [CartOwner](limitation_reference.md#cartowner-limitation)

`cart/delete`:

- [CartOwner](limitation_reference.md#cartowner-limitation)

#### Content

All Content Policies can be assigned the [Content Type](limitation_reference.md#content-type-limitation) and [Section](limitation_reference.md#section-limitation) Limitation.
Beyond that the following Limitations are available:

`content/read`:

- [Owner](limitation_reference.md#owner-limitation)
- [Content Type Group](limitation_reference.md#content-type-group-limitation)
- [Location](limitation_reference.md#location-limitation)
- [Subtree of Location](limitation_reference.md#subtree-of-location-limitation)
- [State](limitation_reference.md#state-limitation)

`content/diff`:

- [Owner](limitation_reference.md#owner-limitation)
- [Location](limitation_reference.md#location-limitation)
- [Subtree of Location](limitation_reference.md#subtree-of-location-limitation)

`content/view_embed`:

- [Owner](limitation_reference.md#owner-limitation)
- [Location](limitation_reference.md#location-limitation)
- [Subtree of Location](limitation_reference.md#subtree-of-location-limitation)

`content/create`:

- [Location](limitation_reference.md#location-limitation)
- [Subtree of Location](limitation_reference.md#subtree-of-location-limitation)
- [Language](limitation_reference.md#language-limitation)
- [Owner of Parent](limitation_reference.md#owner-of-parent-limitation)
- [Content Type Group of Parent](limitation_reference.md#content-type-group-of-parent-limitation)
- [Content Type of Parent](limitation_reference.md#content-type-of-parent-limitation)
- [Parent Depth](limitation_reference.md#parent-depth-limitation)
- [Field Group](limitation_reference.md#field-group-limitation)
- [Change Owner](limitation_reference.md#change-owner-limitation)

`content/edit`:

- [Owner](limitation_reference.md#owner-limitation)
- [Content Type Group](limitation_reference.md#content-type-group-limitation)
- [Location](limitation_reference.md#location-limitation)
- [Subtree of Location](limitation_reference.md#subtree-of-location-limitation)
- [Language](limitation_reference.md#language-limitation)
- [State](limitation_reference.md#state-limitation)
- [Workflow Stage](limitation_reference.md#workflow-stage-limitation)
- [Field Group](limitation_reference.md#field-group-limitation)
- [Version Lock](limitation_reference.md#version-lock-limitation)
- [Change Owner](limitation_reference.md#change-owner-limitation)

`content/publish`:

- [Owner](limitation_reference.md#owner-limitation)
- [Content Type Group](limitation_reference.md#content-type-group-limitation)
- [Location](limitation_reference.md#location-limitation)
- [Subtree of Location](limitation_reference.md#subtree-of-location-limitation)
- [Language](limitation_reference.md#language-limitation)
- [State](limitation_reference.md#state-limitation)
- [Workflow Stage](limitation_reference.md#workflow-stage-limitation)

`content/manage_locations`:

- [Owner](limitation_reference.md#owner-limitation)
- [Subtree of Location](limitation_reference.md#subtree-of-location-limitation)
- [State](limitation_reference.md#state-limitation)

`content/hide`:

- [Owner](limitation_reference.md#owner-limitation)
- [Content Type Group](limitation_reference.md#content-type-group-limitation)
- [Location](limitation_reference.md#location-limitation)
- [Subtree of Location](limitation_reference.md#subtree-of-location-limitation)
- [Language](limitation_reference.md#language-limitation)

`content/translate`:

- [Owner](limitation_reference.md#owner-limitation)
- [Location](limitation_reference.md#location-limitation)
- [Subtree of Location](limitation_reference.md#subtree-of-location-limitation)
- [Language](limitation_reference.md#language-limitation)

`content/remove`:

- [Owner](limitation_reference.md#owner-limitation)
- [Location](limitation_reference.md#location-limitation)
- [Subtree of Location](limitation_reference.md#subtree-of-location-limitation)
- [State](limitation_reference.md#state-limitation)
- [Language](limitation_reference.md#language-limitation)

`content/versionread`:

- [Owner](limitation_reference.md#owner-limitation)
- [Status](limitation_reference.md#status-limitation)
- [Location](limitation_reference.md#location-limitation)
- [Subtree of Location](limitation_reference.md#subtree-of-location-limitation)
- [State](limitation_reference.md#state-limitation)

`content/versionremove`:

- [Owner](limitation_reference.md#owner-limitation)
- [Status](limitation_reference.md#status-limitation)
- [Location](limitation_reference.md#location-limitation)
- [Subtree of Location](limitation_reference.md#subtree-of-location-limitation)
- [State](limitation_reference.md#state-limitation)

`content/unlock`:

- [Owner](limitation_reference.md#owner-limitation)
- [Content Type Group](limitation_reference.md#content-type-group-limitation)
- [Subtree of Location](limitation_reference.md#subtree-of-location-limitation)
- [Language](limitation_reference.md#language-limitation)
- [Version Lock](limitation_reference.md#version-lock-limitation)

#### Order

`order/create`:

- [OrderOwner](limitation_reference.md#orderowner-limitation)

`order/view`:

- [OrderOwner](limitation_reference.md#orderowner-limitation)

`order/update`:

- [OrderOwner](limitation_reference.md#orderowner-limitation)

`order/cancel`:

- [OrderOwner](limitation_reference.md#orderowner-limitation)

#### Payment

`payment/create`:

- [PaymentOwner](limitation_reference.md#paymentowner-limitation)

`payment/view`:

- [PaymentOwner](limitation_reference.md#paymentowner-limitation)

`payment/edit`:

- [PaymentOwner](limitation_reference.md#paymentowner-limitation)

`payment/delete`:

- [PaymentOwner](limitation_reference.md#paymentowner-limitation)

#### Personalization

`personalization/view`:

- [Personalization access](limitation_reference.md#personalization-access-limitation)

`personalization/edit`:

- [Personalization access](limitation_reference.md#personalization-access-limitation)

#### Product

`product/create`:

- [Product Type](limitation_reference.md#product-type-limitation)
- [Language](limitation_reference.md#language-limitation)

`product/view`:

- [Product Type](limitation_reference.md#product-type-limitation)

`product/edit`:

- [Product Type](limitation_reference.md#product-type-limitation)
- [Language](limitation_reference.md#language-limitation)

`product/delete`:

- [Product Type](limitation_reference.md#product-type-limitation)

#### Segment [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

- [Segment Group](limitation_reference.md#segment-group-limitation)

#### Section

`section/assign`:

- [Content Type](limitation_reference.md#content-type-limitation)
- [Section](limitation_reference.md#section-limitation)
- [Owner](limitation_reference.md#owner-limitation)
- [New Section](limitation_reference.md#new-section-limitation)

#### Shipment

`shipment/create`:

- [ShipmentOwner](limitation_reference.md#shipmentowner-limitation)

`shipment/view`:

- [ShipmentOwner](limitation_reference.md#shipmentowner-limitation)

`shipment/update`:

- [ShipmentOwner](limitation_reference.md#shipmentowner-limitation)

`shipment/delete`:

- [ShipmentOwner](limitation_reference.md#shipmentowner-limitation)

#### State

`state/assign`:

- [Content Type](limitation_reference.md#content-type-limitation)
- [Section](limitation_reference.md#section-limitation)
- [Owner](limitation_reference.md#owner-limitation)
- [Content Type Group](limitation_reference.md#content-type-group-limitation)
- [Location](limitation_reference.md#location-limitation)
- [Subtree of Location](limitation_reference.md#subtree-of-location-limitation)
- [State](limitation_reference.md#state-limitation)
- [New State](limitation_reference.md#new-state-limitation)

#### User

`user/assign`:

- [SiteAccess](limitation_reference.md#siteaccess-limitation)

#### Workflow

`workflow/change_stage`:

- [Workflow Transition](limitation_reference.md#workflow-transition-limitation)

## Limitation reference

See [Limitation reference](limitation_reference.md) for detailed information about individual Limitations.
