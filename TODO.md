TODO:

1) Command `ibexa:quable:languages:check`
2) Wspieramy wszystkie atrybuty - ale co z ich wyszukiwaniem?
3) Dodanie "Manage in Quable" na poziomie product view też, nie tylko product list view?
4) Regenrate API key
5) Firewall do connectora
6) Integracja z messengerem
7) Search integration
8) Embedding products
9) https://ibexa.atlassian.net/browse/IBX-10990 (edit product redirect)
10) #### Product navigation

- **Edit button**: Redirects to Quable PIM for product editing
- **View in Quable**: Link to source product in Quable interface
- Seamless navigation between systems

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
- availability
- Product embeds in content
- Storefront experience

⚠️ **Policy limitation validation**: Product Type limitations in policies may not validate correctly. This is a known issue being addressed.

Mentiond: The Quable integration is built on [[= product_name =]]'s [Remote PIM framework](../add_remote_pim_support.md), which provides a foundation for connecting external Product Information Management systems.
