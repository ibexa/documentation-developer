---
description: Learn about all the main attributes, features, and benefits of the [[= product_name =]] SaaS version.
month_change: false
---

# [[= product_name =]] SaaS product guide

## What is [[= product_name =]] SaaS?

[[= product_name =]] SaaS is the fully managed version of [[= product_name =]] for organizations that want to manage their content through the [[= product_name =]] back office and deliver it to websites and other digital channels through APIs.

[[= product_name =]] SaaS is a good solution when you don't need custom platform code or heavy customization.
It's designed for medium-sized mid-market B2B teams that run several brand sites across multiple languages.
[[= product_name =]] SaaS is headless-only - you input and manage content through the back office, and deliver it through the REST and MCP APIs.
An agency or in-house team can build the front end, for example, in Next.js, and host it independently of [[= product_name =]] SaaS.

[[= product_name_base =]] operates the infrastructure and the application, while you provide the content and build your front end.
You can configure everything that the back office exposes, including content types, Page Builder blocks, layout overrides, site settings, and other available configuration.

There's no PHP to write, no Composer packages to install, no database scripts to run, and no server or filesystem access.

## Availability

To access the [[= product_name =]] SaaS instance, [contact the sales team](https://www.ibexa.co/about-ibexa/contact-us), who prepare a demo environment, and later provision the first account with administrator permissions during onboarding.
The environment is ready for you within a single working day.
Your administrator can then invite other members of the team, up to the number of seats included in the plan.

To start using [[= product_name =]] SaaS, you need to purchase a product license.
For more information, see [[[= product_name_base =]] license pricing](https://www.ibexa.co/products/pricing).

## How does [[= product_name =]] SaaS work?

[[= product_name =]] SaaS is a multi-tenant setup.
Each organization uses an isolated database, search core, cache, and asset storage.
[[= product_name_base =]] SSO provides preconfigured identity management and automatic user provisioning.
Under the bonnet, [[= product_name_base =]] runs the infrastructure on [Upsun](https://upsun.com/) systems located in the EU and takes care of automatic upgrades, backups, disaster recovery, and monitoring.

![[[= product_name =]] SaaS framework](img/saas_framework_purple.png "[[= product_name =]] SaaS framework")

You access a single environment, which is always a production one.
While there are no staging or preview environments, you can limit access to different parts of the content structure by using [user permissions]([[= user_doc =]]/permission_management/permission_system/).
It's the same approach that is present in PaaS and on-premise projects, where you grant users access rights on the need-to-see basis, rather than by creating separate environments.

From the administrator's standpoint, all configuration is done through the back office.
This includes [content types]([[= user_doc =]]/content_management/content_model/), [Page Builder blocks]([[= user_doc =]]/content_management/block_reference/) and [layouts]([[= user_doc =]]/content_management/configure_ct_field_settings/#available-page-layouts) exposed by the available configuration screens.

Content is authored in the back office and delivered through the REST API and MCP server, with both interfaces secured out-of-the-box with OAuth2.
Once you've received the first administrator account created, you can start setting up the content model, creating content and making it available through the APIs.

![[[= product_name =]] SaaS operating principle](img/saas_principle_purple.png "[[= product_name =]] SaaS operating principle")

You're free to build and host your front end on a framework of your choice, which means that [[= product_name_base =]] can't estimate or control the time required to build the data-consuming application.

## Capabilities

The following capabilities are available to every [[= product_name =]] SaaS customer.
Some capabilities integrate with other products in the wider [[= product_name_base =]] portfolio.
In these cases, the integrated product, such as [[= product_name_cdp_base =]], [[= pim_product_name =]] or [[= product_name_engage =]], requires its own license.

### Site Factory

Configure, instantiate and manage websites [from the back office]([[= user_doc =]]/website_organization/work_with_sites/).
Sites can share content and assets, while granular [user permissions]([[= user_doc =]]/permission_management/permission_system/) can be used to control access to particular parts of the content tree.

### Agentic AI

With [AI Assistant]([[= user_doc =]]/content_management/create_edit_content_items/#ai-assistant) as the entry point, you can use an [MCP tool set](mcp_guide.md#built-in-tools) identical across the [[= product_name_base =]] ecosystem.
The MCP server allows AI tools and agents to interact with [[= product_name =]] capabilities through a standardized interface rather than requiring a separate integration for each agent or tool.

### Secured remote MCP endpoint

[[= product_name =]] SaaS provides a secured, bi-directional MCP server out of the box.
[AI agents](mcp_guide.md) can use the available tools to retrieve information from [[= product_name =]] SaaS and, where supported, return modified content to the SaaS tenant.

### Automated translation

Translate your content with [language management tools]([[= user_doc =]]/content_management/translate_content/#manage-translation-services-and-language-pairs) such as AI-assisted machine translation, and use a [side-by-side editing view]([[= user_doc =]]/content_management/translate_content/#side-by-side-translation-view) to review and edit translated content.

### Product catalog

Use the built-in Product Information Management (PIM) capability to manage products and their specifications, attributes, variants, assets, pricing, availability, categories, catalogs, and completeness scoring.
You can use the product catalog independently within [[= product_name =]] SaaS, or connect it to a PIM platform, such as [[[= pim_product_name =]]](https://www.quable.com/en).
When the [[= pim_product_name =]] connector is enabled, you can view, select and embed its products in [[= product_name =]] SaaS, while you handle product management operations in [[= pim_product_name =]].

### [[= product_name_cdp =]] integration

The Raptor connector provides an integration with the [Raptor recommendation engine](https://www.raptorservices.com/) and [Customer Data Platform](https://www.raptorservices.com/) to help you deliver personalized experiences across digital channels.

### Visual editing

Use the advanced editing tools, such as the [Headless Page Builder]([[= user_doc =]]/content_management/create_edit_pages/) where you can use blocks and layouts to visually compose pages, even when the front end is separate from the [[= product_name =]] back end.

### Back office-based configuration

Configure your instance by setting up Content Types and Page Builder through back-office features.
Compared to other variants of the [[= product_name =]] range, there's no need to maintain YAML configuration or deploy platform changes.

### Webhooks

Transfer data to and from [[= product_name =]] SaaS in real time.

### Migration and growth

If you're an existing [[= product_name_base =]] customer and have a PaaS or on-premise [[= product_name =]] installation, or you're on a competitive solution, and you find [[= product_name =]] SaaS attractive, [[= product_name_base =]] Professional Services and/or Certified Partners can help you draw a migration path and support you throughout the process.
[[= product_name =]] comes equipped with multiple remote APIs that can be used to streamline the migration where appropriate.

In the future, should your project grow and need to be custom-tailored with broader than out-of-the-box functionality, migration to PaaS or on-premise installation is straightforward because [[= product_name =]] SaaS uses the same codebase and content model.

## Benefits

[[= product_name =]] SaaS lets you focus on managing digital content and experiences without having to operate the [[= product_name =]] platform itself.
[[= product_name_base =]] takes care of the application and infrastructure, while you manage your content, configuration, and frontend applications.

### No platform team required

With configuration through the back office, you don't have to worry about platform code changes, deployments or infrastructure maintenance.
[[= product_name_base =]] operates the application and underlying infrastructure, including upgrades, backups, disaster recovery, and monitoring.
Your team can focus on content, configuration and the frontend applications that consume it.

### Short time-to-value

Onboarding is handled internally and can happen within one working day, including provisioning the tenant and setting up the first administrator account.
From that point, you can start creating content immediately, and content can be consumed through the APIs as soon as it's available.
While a complete client-facing website may take more time to be live, we call it "same-day time-to-first-content".

### One platform for multiple sites and languages

Site Factory, content management and language management features provide a common back office for organizations that manage several websites and languages.
You can share content and assets across sites, while you use granular user permissions to control access to particular parts of the content tree.

### Enterprise-grade reliability without overhead

[[= product_name =]] SaaS provides minimal downtime, 24/7 support, backups and disaster recovery up to the [[[= product_name_base =]] Cloud](https://www.ibexa.co/products/ibexa-cloud) standard, together with managed infrastructure and monitoring.
You don't have to provision or maintain the infrastructure yourself.

### Secured APIs and MCP endpoint

The REST API and MCP endpoints are secured and tenant-scoped out of the box.
The authentication layer is provided by [[= product_name_base =]], so you don't have to deal with its configuration.

### True multi-tenancy

Each organization or tenant has isolated data, search and cache, as well as their own asset storage.
This way you can use the service without having to operate a dedicated [[= product_name =]] infrastructure yourself.

### Preconfigured identity

[[= product_name_base =]] SSO provides preconfigured identity management and automatic user provisioning.
Identity management is therefore available as part of the SaaS setup, so you don't need to configure it specifically for [[= product_name =]].

### Faster access to new capabilities

[[= product_name =]] SaaS follows the fastest release cycle, so new features land here before they reach PaaS and on-premise customers.

### EU data residency

[[= product_name =]] SaaS is always hosted on infrastructure located in the EU, ensuring strict legal compliance with the GDPR.
This data residency model is specifically targeted at organizations that need to protect themselves from regulatory penalties, foreign government surveillance, and the loss of customer trust.

Even if your company is located outside of the EU, it's a benefit rather than a limitation, as customers from anywhere in the world experience the same level of protection.

## Use case

### Mid-market B2B organization with multiple brand sites

An EU-based hotelier company runs several boutique accommodations that are primarily targeted at B2B customers.
A marketing team that consists of twelve people manages several websites that advertise their aesthetically distinct venues.
Each of the websites is dedicated to a different clientele, but all must be available in multiple languages.
With primarily visual storytelling in focus, websites that present photo galleries, room layouts, amenities, and dining menus, can be delivered with no custom code on the [[= product_name =]] SaaS side.
At the same time, individual customer profiles can contain sensitive data, so the company prefers to use secure EU data residency.

[[= product_name_base =]] provisions and manages the [[= product_name =]] SaaS instance.
The company receives administrator access during onboarding.
It can then invite the remaining users up to the number of seats included in their licensing plan.
With [[= product_name =]] SaaS, the marketing team can add and edit content, and handle other configuration through the back office.
The team can manage their websites through the Site Factory, share content and media assets between them where appropriate, and set user permissions to distinguish offerings and presences according to visitor type.
Translation management tools help support the languages, while the available content and Page Builder templates allow the team to structure the sites without having to maintain any code.

The company's digital agency builds the websites and hosts them independently.
The agency builds and maintains Next.js-based front ends and consumes the content that comes from [[= product_name =]] through the REST API.
