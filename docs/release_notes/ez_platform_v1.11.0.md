# eZ Platform v1.11.0

**The FAST TRACK v1.11.0 release of eZ Platform and eZ Platform Enterprise Edition is available as of August 24, 2017.**

If you are looking for the Long Term Support (LTS) release, see [https://ezplatform.com/Blog/Long-Term-Support-is-Here](https://ezplatform.com/Blog/Long-Term-Support-is-Here)

## Notable changes since v1.10.0

### eZ Platform

#### Improved way of writing Field Type gateways

[EZP-26885](https://jira.ez.no/browse/EZP-26885): you now have access to the Doctrine connection instead of
the Zeta Components Database connection-like object which has been exposed to Field Types until now.
Note that the former way will be removed in a future major version.

#### Content Type limitation for Relation (single) field

[EZP-24800](https://jira.ez.no/browse/EZP-24800): you can now specify a Content Type limitation for the Relation field,
just like with the Relation List field. This enables you to limit what kind of relations Editors can select also on singular relation fields.

![Adding a new Relation (single) Field with allowed Content Types](relation_single_allowed_cts.png)

This has been made possible by initial legacy contribution from [@peterkeung](https://github.com/peterkeung), and [@slaci](https://github.com/slaci) who ported this feature over to eZ Platform so that both could go in.

#### API endpoint for removing translations

[EZP-27417](https://jira.ez.no/browse/EZP-27417) provides an API endpoint to remove a given translation completely from a Content item.

### eZ Platform Enterprise Edition

#### Collection block

New Collection block is available in the Landing Page editor.
It enables you to manually select a set of Content items to be displayed.

![Collection block options with three Content items selected](collection_block.png)

!!! note

    To enable adding content to a Collection block in a clean installation,
    you need to configure the views for the block and define which Content Types can be embedded in it.
    See [block templates](https://doc.ibexa.co/en/latest/content_management/pages/page_blocks/#block-templates) for more information and an example.

#### RecommendationBundle adapted for YooChoose v2

In the RecommendationBundle, the id generation of a visitor was changed to use a persistent cookie value
instead of a new one each time a visitor arrives at the site.

Fetching recommendations was also refactored to use the v2 of the Recommendation API.
With this step the *clickrecommended* event now includes detailed feedback information about how recommendations were generated.
This is very important for the analysis of statistics to measure the performance of recommendations.

See [EZEE-1611](https://jira.ez.no/browse/EZEE-1611) for details.

#### Official Enterprise Support for Legacy Bridge

Starting with this release we are going to officially support an alternative *(and perhaps simpler)* way to gradually migrate
from eZ Publish to eZ Platform. From now on, also as an Enterprise user, you can use **Legacy Bridge**.

There is a corresponding new eZ Publish legacy release called 2017.08 available for this, for both community and enterprise users.
Unlike eZ Publish 5.4LTS, this should be seen as a Fast Track release of legacy: it's tailored for those that want
a more modern eZ Platform and Symfony version to take advantage of all new features of the platform and facilitate
the migration. More info on this in a separate blog post soon. As with eZ Platform itself, Enterprise users will receive the same
full support, maintenance, and priority security patch handling as they are used to for this setup.

!!! note

    Not supported for clean/new installs, intended for use with migrations. The Legacy Bridge integration does not have same performance,
    scalability or integrated experience as pure Platform setup. There are known edge cases where for instance cache or search index
    won't always be immediately updated across the two systems using the bridge, which is one of the many reasons why we recommend
    a pure Platform setup where that is possible.

## Full list of new features, improvements and bug fixes since v1.10.0

| eZ Platform   | eZ Enterprise  |
|--------------|------------|
| [List of changes for final of eZ Platform v1.11.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.11.0) | [List of changes for final for eZ Platform Enterprise Edition v1.11.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.11.0) |
| [List of changes for rc1 of eZ Platform v1.11.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.11.0-rc1) | [List of changes for rc1 for eZ Platform Enterprise Edition v1.11.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.11.0-rc1) |
| [List of changes for beta1 of eZ Platform v1.11.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.11.0-beta1) | [List of changes for beta1 of eZ Platform Enterprise Edition v1.11.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.11.0-beta1) |

### Installation

[Installation Guide](https://doc.ibexa.co/en/latest/getting_started/install_ez_platform)

[Technical Requirements](https://doc.ibexa.co/en/latest/getting_started/requirements)

### Download

#### eZ Platform

- Download at [eZPlatform.com](http://ezplatform.com/#download)

#### eZ Enterprise

- [Customers: eZ Enterprise subscription (BUL License)](https://support.ez.no/Downloads)
- Partners: Test & Trial software access (TTL License)

If you would like to become familiar with the products, [request a demo](https://www.ibexa.co/forms/request-a-demo).

### Updating

To update the product, follow the [updating guide](https://doc.ibexa.co/en/latest/updating/updating/).
