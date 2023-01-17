---
description: Policies are the main building block of the permissions system which lets you define the accesses for specific user Roles.
---

# Policies

Policies are the main building block of the permissions system.
Each Role you assign to  user or user group consists of Policies which define, which parts of the application or website the user has access to.

## Available Policies

| Module        | Function             | Effect                                                                                                                                  |
|---------------|----------------------|-----------------------------------------------------------------------------------------------------------------------------------------|
| `all modules` | `all functions`      | grant all available permissions                                                                                                         |
| `content`     | `read`               | view the content both in front and back end                                                                                             |
|               | `diff`               | unused                                                                                                                                  |
|               | `view_embed`         | view content embedded in another Content item (even when the User is not allowed to view it as an individual Content item)              |
|               | `create`             | create new content. Note: even without this Policy the User is able to enter edit mode, but cannot finalize work with the Content item. |
|               | `edit`               | edit existing content                                                                                                                   |
|               | `publish`            | publish content. Without this Policy, the User can only save drafts or send them for review (in [[= product_name_exp =]])                          |
|               | `manage_locations`   | remove Locations and send content to Trash                                                                                              |
|               | `hide`               | hide and reveal content Locations                                                                                                       |
|               | `reverserelatedlist` | see all content that a Content item relates to (even when the User is not allowed to view it as an individual Content items)            |
|               | `translate`          | unused                                                                                                                                  |
|               | `remove`             | remove Locations and send content to Trash                                                                                              |
|               | `versionread`        | view content after publishing, and to preview any content in the Site mode                                                              |
|               | `versionremove`      | remove archived content versions                                                                                                        |
|               | `translations`       | manage the language list in Admin                                                                                                  |
|               | `urltranslator`      | manage URL aliases of a Content item|
|               | `pendinglist`        | unused                                                                                                                                  |
|               | `restore`            | restore content from Trash                                                                                                              |
|               | `cleantrash`         | empty the Trash (even when the User does not have access to individual Content items) |
|               | `unlock`         | unlock drafts locked to a user for performing actions |
| `Content Type`       | `update`             | modify existing Content Types. Also required to create new Content Types                                                                |
|               | `create`             | create new Content Types. Also required to edit exiting Content Types                                                                   |
|               | `delete`             | delete Content Types                                                                                                                    |
| `state`       | `assign`             | assign Object states to Content items                                                                                                   |
|               | `administrate`       | view, add and edit Object states                                                                                                        |
| `role`        | `assign`             | assign Roles to Users and User Groups                                                                                                   |
|               | `update`             | modify existing Roles                                                                                                                   |
|               | `create`             | create new Roles                                                                                                                        |
|               | `delete`             | delete Roles                                                                                                                            |
|               | `read`               | view the Roles list in Admin. Required for all other role-related Policies                                                              |
| `section`     | `assign`             | assign Sections to content                                                                                                              |
|               | `edit`               | edit existing Sections and create new ones                                                                                              |
|               | `view`               | view the Sections list in Admin. Required for all other section-related Policies                                                        |
| `setup`       | `administrate`       | access Admin                                                                                                                            |
|               | `install`            | unused                                                                                                                                  |
|               | `setup`              | unused                                                                                                                                  |
|               | `system_info`        | view the System Information tab in Admin                                                                                      |
|`site` <br/> [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]|`view`|view the "Sites" in the top navigation|
|               |`create`|create sites in the Site Factory</br>|
|               |`edit`|edit sites in the Site Factory</br>[[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]|
|               |`delete`|delete sites from the Site Factory</br>[[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]|
|               |`change_status`|change status of the public accesses of sites to `Live` or `Offline` in the Site Factory</br>[[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]|
|| `update`|                                                                                                                                                                   |
| `user`        | `login`              | log in to the application                                                                                                               |
|               | `password`           | unused                                                                                                                                  |
|               | `preferences`        | access and set user preferences                                                                                                                                  |
|               | `register`           | register using the `/register` route                                                                                                    |
|               | `selfedit`           | unused                                                                                                                                  |
|               | `activation`         | unused                                                                                                                                  |
||`invite`| create and send invitations to create an account |
| `workflow`    | `change_stage`       | change stage in the specified workflow                                                                                                  |
| `comparison`  | `view`               | view version comparison |
| `personalization`    | `view`        | view scenario configuration and results for selected SiteAccesses |
|| `edit`|modify scenario configuration for selected SiteAccesses|
| `segment`</br>[[% include 'snippets/commerce_badge.md' %]] | `read`|load Segment information|
|| `create`|create Segments|
|| `update`|update Segments|
|| `remove`|remove Segments|
|| `assign_to_user` |assign Segments to Users|
| `segment_group`</br>[[% include 'snippets/commerce_badge.md' %]] | `read` |load Segment Group information|
|| `create` |create Segment Groups|
|| `update` |update Segment Groups|
|| `remove` |remove Segment Groups|
| `product` | `create` |create a product|
|| `view` |view products listed in the product catalog|
|| `edit` |edit a product|
|| `delete` |delete a product|
| `product_type` | `create` |create a product type, a new attribute, a new attribute group and add translation to product type and attribute|
|| `view` |view product types, attributes and attribute groups|
|| `edit` |edit a product type, attribute, attribute group|
|| `delete` |delete a product type, attribute, attribute group|
| `commerce` | `currency` |manage currencies|
|| `region` |manage regions|
| `customer_group` | `create` |create a customer group|
|| `view` |view customer groups|
|| `edit` |edit a customer group|
|| `delete` |delete a customer group|
| `catalog` | `create` |create a catalog|
|| `view` |view catalogs|
|| `edit` |edit a catalog|
|| `delete` |delete a catalog|
| `taxonomy` | `read` |view the Taxonomy interface|
||`manage`|create, edit, and delete tags|
||`assign`|tag or untag content|

## Combining Policies

Policies on one Role are connected with the *and* relation, not *or*,
so when Policy has more than one Limitation, all of them have to apply.

If you want to combine more than one Limitation with the *or* relation, not *and*,
you can split your Policy in two, each with one of these Limitations.
