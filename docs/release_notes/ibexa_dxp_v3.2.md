<!-- vale VariablesVersion = NO -->

# Ibexa DXP v3.2

**Version number**: v3.2

**Release date**: October 23, 2020

**Release type**: Fast Track

## Notable changes

![New login page](3.2_new_login_page.png)

### New UI

This version offers a completely reworked user interface, covering all of the back office,
including eCommerce administration.

![New Content structure](3.2_new_ui_content_structure.png "New back office interface")

![Commerce administration](3.2_commerce_cockpit.png "Commerce cockpit")

### DAM connector

You can now [connect your installation to a Digital Asset Management (DAM) system](https://doc.ibexa.co/en/latest/guide/config_connector/#dam-cofniguration)
and use assets such as images directly from the DAM in your content.

### Autosave

[[= product_name_base =]] Platform can now save your edits in a content item or product automatically to help you preserve the progress in an event of a failure.

For more information, see [Autosave](https://doc.ibexa.co/projects/userguide/en/latest/publishing/publishing/#autosave).

### Aggregation API

When using Solr or Elasticsearch search engines you can now use aggregations
to group search results and get the count of results per aggregation type.

You can aggregate results by general conditions such as content type or Section,
or by Field aggregations such as the value of specific Fields.

For more information, see [Aggregation API](https://doc.ibexa.co/en/latest/api/public_php_api_search/#aggregation).

### Targeting block and Segmentation API [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

Targeting block for the Page Builder enables you to display different content items to different users
depending on the Segments they belong to.

![Targeting block](3.2_targeting_block.png)

You can [configure Segments](https://doc.ibexa.co/en/latest/guide/admin_panel/#segments) in the back office.

[Segmentation API](https://doc.ibexa.co/en/latest/api/public_php_api_managing_users/#segments) enables you to create and edit Segments and Segment Groups, and assign Users to Segments.

### Twig helpers for content rendering

Three new Twig helpers are available to make rendering content easier.

Use `ez_render_content(content)` and `ez_render_location(location)` to render the selected content item.

You can also use `ez_render()` and provide it with either a content or Location object.

For more information, see [Using `ez_render` Twig helpers](https://doc.ibexa.co/en/latest/guide/templates/#using-ez_render-twig-helpers).

### JWT authentication

You can now use JWT tokens to authenticate in [REST API](https://doc.ibexa.co/en/latest/api/rest_api/rest_api_authentication/#jwt-authentication)
and [GraphQL](https://doc.ibexa.co/en/latest/api/graphql/#jwt-authentication).

See [JWT authentication](https://doc.ibexa.co/en/latest/guide/security/#jwt-authentication) to learn how to configure this authentication method.

### Searching in [[= product_name_com =]] with Elasticsearch [[% include 'snippets/commerce_badge.md' %]]

You can now use Elasticsearch for searching in [[= product_name_com =]].

See [Install Ibexa Platform](https://doc.ibexa.co/en/latest/getting_started/install_ez_platform/#install-and-configure-a-search-engine) to learn how to install and configure the search engine.

## Other changes

### Site Factory improvements [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

You can now define user group skeletons where you define policies and limitations that apply to a specific user group. 
You can then associate a number of such skeletons with a site template. 
User group skeletons survive deleting a site.

For more information, see [Configure user group skeleton](https://doc.ibexa.co/en/latest/guide/multisite/site_factory_configuration/#user-group-skeletons).

### Calendar widget improvements

You can now see the scheduled blocks in the calendar after you configure the reveal and/or hide dates for them. 
This way you can envision what content will be available in the future.

Also, you can now apply new filters that are intended to help you declutter the calendar view.

For more information, see [Calendar widget](https://doc.ibexa.co/projects/userguide/en/latest/publishing/advanced_publishing_options/#calendar-widget).

### Cloning content types

When creating content types in the back office, you don't have to start from scratch.
You can now clone an existing content type instead.

To do this, click the **Copy** icon located next to the content type that you want to clone.
Then, refresh the view to see an updated list of content types.

### Object state API improvements

You can now use `ObjectStateService::loadObjectStateByIdentifier()` and `ObjectStateService::loadObjectStateGroupByIdentifier()`
to [get object states and object state groups](https://doc.ibexa.co/en/latest/api/public_php_api_managing_repository/#getting-object-state-information) in the PHP API.

## Full changelog

| Ibexa Platform  | [[= product_name =]]  | [[= product_name_com =]] |
|--------------|------------|------------|
| [Ibexa Platform v3.2.0](https://github.com/ezsystems/ezplatform/releases/tag/v3.2.0) | [[[= product_name =]] v3.2.0](https://github.com/ezsystems/ezplatform-ee/releases/tag/v3.2.0) | [[[= product_name_com =]] v3.2.0](https://github.com/ezsystems/ezcommerce/releases/tag/v3.2.0)
