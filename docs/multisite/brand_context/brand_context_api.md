---
description: Use PHP API to manage brand contexts, assign websites to them, and get the AI guidelines of a brand.
month_change: true
---

# Brand context API

You can manage [brand contexts](brand_context_guide.md) with the following PHP API services:

- [`BrandContextServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-BrandContextServiceInterface.html) - create, find, update, and delete brand contexts
- [`BrandContextAssignmentServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-BrandContextAssignmentServiceInterface.html) - assign websites to brand contexts
- [`AttributeGroupServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-AttributeGroupServiceInterface.html) and [`AttributeDefinitionServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-AttributeDefinitionServiceInterface.html) - manage attribute groups and attribute definitions
- [`BrandContextAiContextResolverInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-BrandContextAiContextResolverInterface.html) - get the AI guidelines of a brand context
- [`SiteContextServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-SiteContextServiceInterface.html) - get the website selected in the back office, or run code as if a specific website was selected

The services check the [brand context policies](policies.md#brand-context) of the current user.

## Create brand context

To create a brand context, get a [`BrandContextCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-BrandContext-BrandContextCreateStruct.html) from `BrandContextServiceInterface::newBrandContextCreateStruct()`, and pass it to `BrandContextServiceInterface::createBrandContext()`:

``` php hl_lines="11"
[[= include_code('code_samples/brand_context/src/Command/ManageBrandContextCommand.php', 37, 47, remove_indent=True) =]]
```

The struct accepts the following values:

- name and description - in one or more languages. You must provide a name in at least one language.
- logo - a reference to an image content item, in the `ezcontent://<content ID>` format
- color - a hexadecimal color value, for example, `#E8730C`
- region - the market or region in which the brand operates
- attribute values - the identifier of the attribute definition, the value, and the language code for translatable attributes

## Assign websites to brand context

To assign websites to a brand context, pass the brand context ID and a list of [`AssignmentCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-BrandContext-Assignment-AssignmentCreateStruct.html) objects with SiteAccess names to `BrandContextAssignmentServiceInterface::setAssignments()`:

``` php
[[= include_code('code_samples/brand_context/src/Command/ManageBrandContextCommand.php', 49, 53, remove_indent=True) =]]
```

`setAssignments()` replaces all existing assignments of the brand context.
To remove a single website from a brand context, use `BrandContextAssignmentServiceInterface::removeAssignment()`.

To check which brand context a website belongs to, use `BrandContextAssignmentServiceInterface::resolveContextForSiteAccess()`:

``` php
[[= include_code('code_samples/brand_context/src/Command/ManageBrandContextCommand.php', 75, 79, remove_indent=True) =]]
```

## Update brand context

To update a brand context, get a [`BrandContextUpdateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-BrandContext-BrandContextUpdateStruct.html) from `BrandContextServiceInterface::newBrandContextUpdateStruct()`, set the values that you want to change, and pass it to `BrandContextServiceInterface::updateBrandContext()`:

``` php
[[= include_code('code_samples/brand_context/src/Command/ManageBrandContextCommand.php', 55, 59, remove_indent=True) =]]
```

To delete a brand context, use `BrandContextServiceInterface::deleteBrandContext()`.
To delete one of its translations, use `BrandContextServiceInterface::deleteBrandContextTranslation()`.

## Get brand contexts

To get a single brand context by its identifier, use `BrandContextServiceInterface::getBrandContext()`.
You can pass a list of prioritized languages to get the names, descriptions, and attribute values in a specific language:

``` php
[[= include_code('code_samples/brand_context/src/Command/ManageBrandContextCommand.php', 70, 73, remove_indent=True) =]]
```

To find brand contexts, pass a [`BrandContextQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-BrandContext-BrandContextQuery.html) to `BrandContextServiceInterface::findBrandContexts()`:

``` php
[[= include_code('code_samples/brand_context/src/Command/ManageBrandContextCommand.php', 61, 68, remove_indent=True) =]]
```

The query takes a criterion, an offset, and a limit.
The default limit is 25.

### Query criteria

Brand context, attribute group, and attribute definition queries use their own criteria.
You can't use them in [content search](search_api.md).

| Query | Criterion | Matches |
|---|---|---|
| `BrandContextQuery` | [`IdCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-BrandContext-Query-Criterion-IdCriterion.html) | brand contexts with one of the given IDs |
| | [`IdentifierCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-BrandContext-Query-Criterion-IdentifierCriterion.html) | the brand context with the given identifier |
| | [`NameCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-BrandContext-Query-Criterion-NameCriterion.html) | brand contexts with names that start with the given text |
| | [`LogicalAnd`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-BrandContext-Query-Criterion-LogicalAnd.html) | brand contexts that match all the given criteria |
| `AttributeGroupQuery` | [`IdentifierCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-AttributeGroup-Query-Criterion-IdentifierCriterion.html) | the attribute group with the given identifier |
| | [`LabelCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-AttributeGroup-Query-Criterion-LabelCriterion.html) | attribute groups with labels that start with the given text |
| | [`LogicalAnd`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-AttributeGroup-Query-Criterion-LogicalAnd.html) | attribute groups that match all the given criteria |
| `AttributeDefinitionQuery` | [`AttributeGroupIdentifierCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-AttributeDefinition-Query-Criterion-AttributeGroupIdentifierCriterion.html) | attribute definitions from the given attribute group |
| | [`IdentifierCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-AttributeDefinition-Query-Criterion-IdentifierCriterion.html) | the attribute definition with the given identifier |
| | [`TypeIdentifierCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-AttributeDefinition-Query-Criterion-TypeIdentifierCriterion.html) | attribute definitions of the given type, for example, `text` |
| | [`LogicalAnd`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-AttributeDefinition-Query-Criterion-LogicalAnd.html) | attribute definitions that match all the given criteria |

## Get AI guidelines

[[= product_name =]] adds the AI guidelines of a brand context to the prompts of [AI actions](ai_actions.md) automatically.
It does this by listening to the `Ibexa\Contracts\ConnectorAi\Events\ResolveGuidelinesEvent` event, and adding the brand context's AI Context attributes as guidelines.

To use the same guidelines in your own AI integration, use `BrandContextAiContextResolverInterface`:

- `resolveForSiteAccess()` returns the guidelines of the brand context that a given website belongs to
- `resolveForCurrentSiteContext()` returns the guidelines of the brand context of the website selected in the back office

Both methods take an optional language code, and return a `BrandContextAiContext` object, or `null` if the website doesn't belong to any brand context or the brand context has no AI guidelines.
Each entry of the AI context contains the attribute identifier, the attribute description, and the attribute value converted to text:

``` php
[[= include_code('code_samples/brand_context/src/Command/BrandContextAiGuidelinesCommand.php', 27, 32, remove_indent=True) =]]
```

## Run code in website context

Some features, for example, AI guidelines, depend on the website that the user selected in the back office top bar.
To run code as if a specific website was selected, for example, in a CLI command or a background task, use `SiteContextServiceInterface::runInContext()`:

``` php
[[= include_code('code_samples/brand_context/src/Command/BrandContextAiGuidelinesCommand.php', 34, 38, remove_indent=True) =]]
```

The method passes the return value of the callback, and restores the previous context when the callback finishes.

To get the website selected by the current user, use `SiteContextServiceInterface::getCurrentContext()`.
