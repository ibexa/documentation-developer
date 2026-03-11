---
description: Quable PIM integration - Architecture, features, limitations, and developer reference
---

# Additional technical information

This page contains additional technical information about the Quable PIM integration with [[= product_name =]], including architecture details, supported features, technical limitations, and developer reference materials.

!!! note

    This page is a collection of technical materials for review. Content may be reorganized into separate pages in the future.

## Architecture

### Integration overview

The Quable integration is built on [[= product_name =]]'s [Remote PIM framework](../add_remote_pim_support.md), which provides a foundation for connecting external Product Information Management systems.

**Key architectural principles:**

- **Single source of truth**: Quable PIM owns all product data
- **Read-only in DXP**: Products are displayed and used in [[= product_name =]] but edited in Quable
- **Service-oriented**: Integration uses service interfaces for data access
- **Event-driven sync**: Real-time updates via webhooks keep data synchronized
- **Cached data access**: API responses are cached for performance

### Data flow

```
Quable PIM → Quable API → Quable Connector → Product Catalog Services → DXP Features
                                     ↓
                                Cache Layer
                                     ↓
                            Storefront Display
```

**Data flow steps:**

1. **Product data originates** in Quable PIM
2. **Quable API** exposes product data via REST endpoints
3. **Quable Connector** fetches and transforms data using object mappers
4. **Product Catalog Services** provide standardized access to product data
5. **DXP Features** (Product Picker, Page Builder blocks, etc.) consume product data
6. **Storefront** displays products to end users

**Synchronization triggers:**

- **Manual**: Command-line sync for taxonomy/classifications
- **Automatic**: Webhooks notify DXP of product changes in real-time
- **On-demand**: API calls when specific product data is requested

### Service layer architecture

The Quable connector implements the following service interfaces:

| Service | Purpose | Key Methods |
|---------|---------|-------------|
| `ProductService` | Retrieve product data | `getProduct()`, `findProducts()`, `findProductsByCode()` |
| `ProductTypeService` | Get product type information | `getProductType()`, `findProductTypes()` |
| `AttributeDefinitionService` | Access attribute definitions | `getAttributeDefinition()`, `findAttributeDefinitions()` |
| `AttributeGroupService` | Manage attribute groups | `getAttributeGroup()`, `findAttributeGroups()` |
| `AssetService` | Retrieve product assets | `findAssets()` |

**Service characteristics:**

- Services implement standard [[= product_name =]] Product Catalog interfaces
- Responses are cached by default to minimize API calls
- Services transform Quable data structures into [[= product_name =]] value objects

### Object mapping and transformers

The connector uses object mappers and transformers to convert Quable API responses into [[= product_name =]] value objects:

**Value objects:**

- `Product` - Complete product data including attributes, variants, assets
- `ProductType` - Product type definitions and attribute schemas
- `AttributeDefinition` - Individual attribute definitions
- `AttributeGroup` - Groups of related attributes
- `Attribute` - Attribute values with type information

**Transformers:**

- `ProductTypeTransformer` - Maps product types from Quable to DXP format
- `AttributesListTransformer` - Builds attribute lists from raw data
- `Product/NameTransformer` - Derives product names from attributes
- `AttributeDefinition/NameTransformer` - Extracts attribute definition names

### Permission handling

Products from Quable are treated as remote objects for permission purposes:

- Permission context is provided by `Quable\Permissions\ContextProvider`
- Standard [[= product_name =]] permission system applies to product operations
- Create/Edit/Delete operations are disabled for remote products (handled in Quable)
- View permissions can be controlled via [[= product_name =]] roles and policies

!!! note "Permission limitations"

    Some permission limitations exist for remote products. Product Type limitations for policies require special handling. See [Known Limitations](#technical-limitations) below.

### Caching strategy

The Quable connector implements multi-level caching:

**Service-level caching:**

- In-memory cache within service instances
- Reduces duplicate API calls within the same request
- Cache lifetime: duration of PHP process

**Application-level caching:**

- Symfony cache component stores API responses
- Configured cache pool for Quable connector
- Cache invalidation via webhooks on data changes

**Cache configuration:**

```yaml
ibexa_connector_quable:
    cache:
        enabled: true  # Enable/disable caching
```

### API communication patterns

The connector communicates with Quable using:

- **HTTP Client**: Symfony HTTP client with connection pooling
- **Authentication**: Bearer token authentication using API token
- **Response format**: JSON
- **Error handling**: Graceful degradation with logging

## Features and limitations

### Supported features

#### Product display and viewing

✅ **Product listing**: View all products from Quable in [[= product_name =]] Product Catalog interface

✅ **Product details**: Access complete product information including attributes, specifications, and assets

✅ **Multi-language support**: Display products in multiple languages with localized attribute values

✅ **Variant handling**: View product variants with their specific attribute combinations

✅ **Product attributes**: All Quable attribute types are mapped and displayed in [[= product_name =]]

#### Product Picker integration

✅ **Product selection**: Use Product Picker to select Quable products in content editing

✅ **Category filtering**: Filter products by Quable classifications in Product Picker

✅ **Code search**: Search products by code/SKU

✅ **Product preview**: Preview product information before selection

#### Category and classification

✅ **Category synchronization**: Import Quable classification structure into [[= product_name =]] taxonomy

✅ **Hierarchical categories**: Maintain parent-child relationships from Quable

✅ **Category browsing**: Navigate products by category in [[= product_name =]]

✅ **Category filtering**: Filter product lists by category

#### Product Catalog management

✅ **Catalog creation**: Create product catalogs using Quable product data

✅ **Catalog filters**: Apply filters to include specific Quable products in catalogs

✅ **Pricing management**: View base prices from Quable, set custom prices in [[= product_name =]]

✅ **Availability tracking**: Access product availability information

#### Page Builder blocks

✅ **Product Collection block**: Display selected Quable products on pages

✅ **Product Catalog block**: Show full product listings from catalogs

✅ **Product Embed block**: Embed individual products in content

✅ **Dashboard blocks**: Use Quable products in dashboard widgets (e.g., Products by categories)

#### Content integration

✅ **Product embeds in rich text**: Embed Quable products within text content (requires configuration)

✅ **Product specification fields**: Add product specification fields to content types

✅ **Content-product relationships**: Link content items to Quable products

### Technical limitations

#### Read-only product access

❌ **No product creation**: Products cannot be created in [[= product_name =]]. Create products in Quable PIM.

❌ **No product editing**: Product data is read-only in [[= product_name =]]. Edit products in Quable, changes sync automatically.

❌ **No variant management**: Variants are managed in Quable only.

❌ **Edit action redirects**: Clicking "Edit" on a Quable product redirects to Quable PIM interface.

#### Category management

❌ **No category creation**: Categories cannot be created in [[= product_name =]]. Manage in Quable.

❌ **No category editing**: Category structure is synchronized from Quable, cannot be modified in [[= product_name =]].

❌ **No manual assignment**: Products cannot be manually assigned to categories in [[= product_name =]].

#### REST API restrictions

❌ **Product CRUD endpoints disabled**: REST API endpoints for creating, editing, and deleting products are disabled for Quable products.

❌ **Variant API limitations**: Variant management API endpoints are not available for remote products.

#### Permission and policy

⚠️ **Policy limitation validation**: Product Type limitations in policies may not validate correctly. This is a known issue being addressed.

❌ **No content tab for categories**: Content editing tab is not applicable to Quable categories.

#### User interface

❌ **Create actions hidden**: "Create Product" and "Create Variant" buttons are hidden when using Quable engine.

❌ **No inline editing**: Product attributes cannot be edited inline in [[= product_name =]] interface.

❌ **Special character handling**: Products with codes containing reserved characters may require special handling.

### Design decisions

#### Why read-only in DXP?

**Single source of truth principle**: Keeping product data creation and editing exclusively in Quable ensures:

- **Data integrity**: No conflicts between systems
- **Clear ownership**: Quable owns product data, [[= product_name =]] displays it
- **Audit trail**: All changes tracked in Quable
- **Workflow consistency**: Product teams work in one system

#### System boundaries

**Quable responsibilities:**
- Product creation and editing
- Attribute definition and management
- Category/classification structure
- Product assets (images, documents)
- Product variants
- Core product data

**[[= product_name =]] responsibilities:**
- Product display and presentation
- Content-product relationships
- Catalog organization for storefronts
- Custom pricing (overrides)
- Product embeds in content
- Storefront experience

### UI feature integration

The following UI features work seamlessly with Quable products. Refer to user documentation for detailed workflows:

#### Product Picker

- Select Quable products when editing content
- Filter by category, search by name/code
- Preview product details before selection
- **User docs**: [Product management]([[= user_doc =]]/persona_paths/manage_products/)

#### Page Builder blocks

- **Product Collection**: Manually select products to display
- **Product Catalog**: Automatically show products from a catalog
- **Product Embed**: Embed individual products in page content
- **User docs**: [Using Page Builder]([[= user_doc =]]/page_builder/)

#### Dashboard

- **Products by categories** widget shows product distribution
- Quable categories available for visualization
- **User docs**: [Dashboard management]([[= user_doc =]]/persona_paths/manage_dashboard/)

#### Product navigation

- **Edit button**: Redirects to Quable PIM for product editing
- **View in Quable**: Link to source product in Quable interface
- Seamless navigation between systems
