# REST API Reference

## Overview

The Ibexa DXP REST API provides programmatic access to all platform features via HTTP endpoints. The API follows REST principles and supports both JSON and XML formats.

**Base URL**: `/api/ibexa/v2`

## Full API Specification

The complete REST API reference is available in OpenAPI 3.1 format:

**[openapi.yaml](rest_api_reference/openapi.yaml)** - Complete OpenAPI specification with:
- 180+ endpoints across 40 categories
- Request/response schemas
- Authentication requirements
- Example payloads (JSON/XML)
- Error codes and responses

## API Categories

### Content Management
- **Objects** (25 endpoints) - CRUD operations for content items
- **Location** (6 endpoints) - Content tree navigation and management
- **Language** (2 endpoints) - Multi-language content handling

### Commerce
- **Cart** (10 endpoints) - Shopping cart operations
- **Orders** (6 endpoints) - Order management and processing
- **Payments** (6 endpoints) - Payment processing
- **Discounts** (8 endpoints) - Discount and promotion management
- **Product** (12 endpoints) - Product catalog management
- **Product Attribute** (7 endpoints) - Product attribute definitions

### User Management
- **User** - User authentication and management
- **Corporate Account** (12 endpoints) - B2B account management
- **Bookmark** (4 endpoints) - User bookmarks

### Workflow & Content
- **Object State Groups** (10 endpoints) - Content state management
- **Calendar** (3 endpoints) - Event and calendar management
- **Activity Log** (1 endpoint) - Activity tracking

### AI Features
- **Connector AI** (6 endpoints) - AI-powered features integration

## Authentication

All REST API endpoints require authentication. The API supports:
- **Session-based authentication** - Using session cookies
- **OAuth tokens** - For third-party integrations
- **JWT tokens** - For stateless authentication

Unauthorized requests return `401 Unauthorized`.

## Media Types

The API supports content negotiation via `Accept` and `Content-Type` headers:

**JSON** (recommended):
- Request: `application/vnd.ibexa.api.[Type]+json`
- Response: `application/vnd.ibexa.api.[Type]+json`

**XML**:
- Request: `application/vnd.ibexa.api.[Type]+xml`
- Response: `application/vnd.ibexa.api.[Type]+xml`

## Common Response Codes

- `200 OK` - Successful request
- `201 Created` - Resource created successfully
- `204 No Content` - Successful deletion
- `400 Bad Request` - Invalid request data
- `401 Unauthorized` - Authentication required
- `403 Forbidden` - Insufficient permissions
- `404 Not Found` - Resource not found
- `409 Conflict` - Resource conflict (e.g., duplicate)
- `500 Internal Server Error` - Server error

## Key Endpoint Examples

### Content Operations
```
GET    /api/ibexa/v2/content/objects/{contentId}      # Load content
POST   /api/ibexa/v2/content/objects                  # Create content
PATCH  /api/ibexa/v2/content/objects/{contentId}      # Update content
DELETE /api/ibexa/v2/content/objects/{contentId}      # Delete content
```

### Cart & Commerce
```
POST   /api/ibexa/v2/cart                             # Create cart
GET    /api/ibexa/v2/cart/{identifier}                # Get cart
PATCH  /api/ibexa/v2/cart/{identifier}                # Update cart
POST   /api/ibexa/v2/cart/{identifier}/entry          # Add item to cart
```

### Product Catalog
```
GET    /api/ibexa/v2/product/catalog/products         # List products
GET    /api/ibexa/v2/product/catalog/products/{code}  # Get product
POST   /api/ibexa/v2/product/catalog/products         # Create product
```

### Orders
```
GET    /api/ibexa/v2/orders                           # List orders
GET    /api/ibexa/v2/orders/{identifier}              # Get order details
PATCH  /api/ibexa/v2/orders/{identifier}/status       # Update order status
```

## Usage Example

```bash
# Get content item (JSON)
curl -X GET \
  -H "Accept: application/vnd.ibexa.api.Content+json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  https://example.com/api/ibexa/v2/content/objects/123

# Create cart entry (JSON)
curl -X POST \
  -H "Content-Type: application/vnd.ibexa.api.CartEntry+json" \
  -H "Accept: application/vnd.ibexa.api.Cart+json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{"productCode": "SKU123", "quantity": 2}' \
  https://example.com/api/ibexa/v2/cart/my-cart/entry
```

## Integration with PHP API

REST API endpoints often map to PHP service methods:

| REST Endpoint | PHP Service Method |
|---------------|-------------------|
| `POST /content/objects` | `ContentService::createContent()` |
| `GET /content/objects/{id}` | `ContentService::loadContent()` |
| `POST /cart` | `CartService::createCart()` |
| `GET /product/catalog/products/{code}` | `ProductService::getProduct()` |

## Further Documentation

- **[OpenAPI Specification](rest_api_reference/openapi.yaml)** - Complete API reference
- **[REST API Guide](/api/rest_api/rest_api_guide)** - Usage guide and tutorials
- **[Authentication](/api/rest_api/rest_api_authentication)** - Authentication methods

## Tools & SDKs

- **OpenAPI UI** - Interactive API documentation (Swagger UI compatible)
- **Code generators** - Generate client SDKs from OpenAPI spec
- **Postman/Insomnia** - Import `openapi.yaml` for testing
