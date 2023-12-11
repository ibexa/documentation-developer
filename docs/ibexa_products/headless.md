---
description: [[= product_name =]] Headless edition features, capabilities and benefits.
---

# Ibexa DXP Headless edition product guide

## What is [[= product_name_headless =]]

[[= product_name =]] Headless edition focuses on content management. It provides tools to collaboratively create content,
and interfaces (API) to distribute this content.

Multilingual, multichannel, extensible, [[= product_name_headless =]] is an advanced Content Management Framework (CMF),
a Product Information Management (PIM) platform, and even a Digital Asset Management (DAM) repository.
It's provided without a default front office but with a complete back office, and several APIs to manage and access content.

## Availability

See [[[= product_name_headless =]] license pricing](https://www.ibexa.co/products/pricing?tab=1).
You can [contact us](https://www.ibexa.co/products/pricing) or [contact one of our partners](https://www.ibexa.co/partners).

## How it works

### Contributor's practical usage

You access with any web browser from any platform to a rich back office, the main place to

- define users and their rights (customers, subscribers, editors, etc.),
- organize content (content types, fields, tree, tags, languages, and more),
- edit content in a collaborative workplace with versions and workflows.

Then, content is available to end users through REST, GraphQL, or every output you can imagine like websites or apps.

### Technical backstage

When you have a license, you install [[= product_name_headless =]] through Composer
on an architecture including at least a web server with PHP and a relational database server.
For performance, several bricks can be added to your stack such as a reverse proxy or a search engine.

By using a version control system and environment variables, you can deploy your configuration and extensions on several environments including [[= product_name_cloud =]].

Standard web APIs and [[= product_name_connect =]] help, even non-developers, to establish interoperability.

[[= product_name_headless =]] is based on Symfony. Any Symfony developer, or even PHP developer, can quickly learn how to extend it with the help of an online documentation.

APIs summary:

- The REST and GraphQL APIs give access to access the content in standardized ways.
- The OAuth 2 Client and Server allow to connect to an SSO or be the SSO.
- The design engine and its theme templates mechanism allows to serve the content in several shapes.
- The PHP API allows to extend [[= product_name_headless =]] and fit your needs. For example, content can be manipulated or served in specific ways (such as scheduled/live imports/exports, automated edition tasks, specific output controllers to feed a mobile app, etc.)

## Capabilities and benefits

[[= product_name_headless =]] is a tool box with a back office.
It comes without a default front office.
You don't lose time to develop a theme for a provided front office before discovering it won't fit your needs.
No distraction.
[[= product_name_headless =]] helps you focus on the content, create and organize with its straightforward user interface (UI),
imagine its inputs/outputs, and implement them with its various layers' APIs.

### Core features

The core of [[= product_name =]] Headless edition is already awesome as it offers everything to structure your content repositories and access them.

#### Content model

- Content items are organized as a tree in a repository.
- An item can have multiple locations in this tree.
- Content items are typed.
- Content types are sets of typed data fields, with eventually conditions on the possible values.
- Rich Text field type comes with an online editor. See [Online Editor product guide](online_editor_guide.md) for more.
- Multilingual, it can store a content in several languages, the content model define which field must be translated, and which don't vary.

See [Content management product guide](content_management_guide.md) for more.

#### User management

- User and user group rights are set by roles with thin granular limited permission policies in a safe deny-by-default security system.
- Users are content items as well, so your knowledge about content management is reused.

See [User management product guide](user_management_guide.md) for more.

#### Content access

- The REST API and GraphQL API support access to and edition of the content.
- [[= product_name_headless =]] offers a complete PHP API to extend the ways to access content.
- A design engine and a view controller offer to create plain text content views (such as HTML, JSON, XML, CSS, JS, CSV, or Markdown),
  and to factorize those views by using theme cascades.
  This design engine is used in the back office which is equally extendable.
- Multichannel, content can be accessed through several channel configurations,
  such as the domain name it replies to, the sub-part of the content tree it starts from, the users rights, or the design theme.
  The back office itself is such a channel.
- Multi-repository, the same platform can use separate databases if impermeability is needed between channel groups.

### Advanced features

On top of this strong core, [[= product_name =]] Headless edition brings tools to increase user experience, from final front users to back office contributors.

#### [[= product_name_headless =]] is a complete Digital Experience Platform (DXP)

- [[= product_name_headless =]] comes with a personalization engine, allowing to recommend content to the front user according to its behavior,
  or, when authenticated, contents matching user's segment/group. See [Personalization product guide](personalization_brochure.md) for more.
- [[= product_name_headless =]]' scheduler allows to establish the future of the content and having a living front application with events even when the editorial team is absent or reduced. At midnight, during weekends or vacations, front users can discover new contents. A calendar summaries those scheduled content event. The calendar is extendable as everything in the back office, some event source could be added to coordinate content events with other company events.

#### [[= product_name_headless =]] adds more ways to structure and organize your content

- [[= product_name_headless =]] has specific feature to organise complex products and their catalogs, making it a strong Product Information Management (PIM) software.
  - Product are organized per product types × variants × catalogs × categories × tags.
  - Product attributes are grouped and factorized among product types. For example, fabric + color + size can be shared by many clothing product types.
  - Product variants can rapidly be created by the automatic declination of attributes having a defined set of values.
  - See [PIM product guide](pim_guide.md) for more.
- [[= product_name_headless =]]' taxonomy feature allows to tag content items to organize them by topics in a much intuitive way for the editor than a content tree with multiple locations would.
  Tags themselves are organized in a tree, and synonyms are linked to a favorite terms. This tags organisation can be the task of a supervisor who won't need to move content items around a corporate content tree. At search time, tags can be keywords with a high value in relevance score to help the end user having results closer to the searched topic.

#### [[= product_name_headless =]] is a collaborative workplace

- Version comparison helps to track changes and to solve concurrent editing conflicts.
- Workflows helps with collaborative editing chain.
  A built-in “Quick review“ workflow allows an editor to send a content draft to a colleague for review, and comment or publishing.
  But, as a framework, more complex workflows can be imagined, with several steps and paths, even some automated tasks.

#### [[= product_name_headless =]] accelerates content editing

- [[= product_name_headless =]]'s content tree has several actions available directly on its items. For example, no need to open a content to hide it, you can do it directly from the content tree.
- An Image Editor offers to crop and flip images. When serving the image in various context, you can even set a focal point to indicate to automated cropping which part of the image should be kept.
- A Digital Asset Management (DAM) help to crawl in your image ressources to use and reuse them in your content. And a DAM connector allows to also search in your images hosted on third party DAM servers.

#### [[= product_name_headless =]] integrates into the networks

##### Intranets and extranets

- [[= product_name_connect =]] is to create application interconnections with low code, drag-and-drop and a very visual interface.
  Complex data flows can be easily implemented with a huge library of connectors and actions for famous to specific applications.
  See [[[= product_name_connect =]] product guide]([[= connect_doc =]]/general/ibexa_connect/) for more.
- An OAuth 2 server offers the possibility to use the DXP as the authentification service for other applications.
- An OAuth 2 client supports authentication with a third-party OAuth 2 server.
- A DAM Connector, previously mentioned, helps to access any image repository when needing to illustrate a content.
- [[= product_name_headless =]] supports Elasticsearch and Solr.
  It gives the choice between using Solr or Elasticsearch as a search engine, whether hosted on [[= product_name_cloud =]] or on-premises.
  This choice might be influenced by technology you already use, or you want to invest in for other internal projects.
- [[= product_name_headless =]] offers to export and import from command line part of the content model or content items.
  For example, it can be used to move new content types and items from a staging instance to the production one.

##### Internet, delivery, web search engines, and social networks

- [[= product_name_headless =]] comes with the support of Fastly content delivery network (CDN).
  The HTTP cache varies on current user's role and is purged when content change.
  With is huge network of points of presence (POP) around the world, Fastly is quickly delivering cached content from nearest server for a better user experience.
- A Search Engine Optimization (SEO) field implements best practices about web search engine indexing and social network sharing.
  It covers canonical URLs which are mandatory if multiple locations are used for a same content item to avoid duplicate content, Open Graph protocol to better describe a content item to social networks and search engine, and Twitter Cards.

## Feature summary

To summarize, here is a list of the main [[= product_name_headless =]] features:

* Structured content
* PIM/Product catalog
* Multilingual
* Taxonomy
* Collaboration and Workflow
* Version comparison
* Rich text editor
* Image Editor
* Scheduler and Calendar
* SEO
* Behavioral-driven personalization
* Recommendations
* Interoperability
* DAM Connector
* [[= product_name_connect =]]
* REST and GraphQL APIs
* Continuous Deployment
* Oauth2 Client & Server
* Fastly/Varnish
* Elasticsearch/Solr
* Data migrations
* Web development framework
* PHP API
* Extendability

At last and not least, [[= product_name =]] Headless edition can be upgraded to Experience and Commerce editions with minimal effort (for example, to start selling online what you exposed in your product catalog).

## Use cases

- A corporate website to inform about your organization
- An online catalog to expose your products and convince potential customer to contact you
- A feed providing contents to a partner or parent company's network
- A structuring first step to create online presence, before increasing user experience with [[= product_name_experience =]], and finally becoming an online store with [[= product_name_commerce =]].
- A smartphone app feed allowing to consult instructions manual with mobility while using your product

### Brick and mortar, but with an online showcase

If you prefer the human warmth of a retail store, if your products' numerous options should be discussed, or if you're simply not ready yet to sell online,
[[= product_name_headless =]] helps to build an exposition of your product catalog and your philosophy,
an online presence to keep previous customers interested and gather new ones.
