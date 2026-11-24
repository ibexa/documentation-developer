---
description: Cohesivo releases new versions periodically, following a Long Term Support release model.
---

# [[= product_name =]] release process and roadmap

## Release process

### Products

[[= product_name =]] is a multichannel content management system that you can use in a headful or headless way.
You can extend it with the [[= product_name_commerce_sdk =]], which adds commerce capabilities, and with optional LTS Updates and add-ons.

For more information, see [[[= product_name =]] products](../ibexa_products/cohesivo_products.md).

### Long Term Support releases

[[= product_name_base =]] manages the release of [[= product_name =]] by using an agile iterative process and a continuous software development model, which is why we provide Long Term Support releases (LTS) of [[= product_name =]] releases.

Long Term Support releases (LTS) are supported by [[= product_name_base =]] for a long period of time.
They're suitable for highly stable enterprise rollouts.

LTS releases provide you with:

- **Reliability and stability**, as they go through extensive testing to ensure they are free from major bugs and issues.
- **Long-term security**, as a result of updates and security patches.
- **Predictability** that comes from following an established release plan.
- **Reduced maintenance**, because you avoid the frequent upgrade cycles.

### LTS Updates

With LTS Updates customers can maintain their competitiveness by incorporating cutting-edge technologies into their LTS releases without losing stability.
LTS Updates are intended to improve the current platform by providing new features.
What's important, you are not required to switch to a newer version of [[= product_name =]] to use LTS Updates.
You can install them whenever you choose, and you can be sure that the next LTS release will include them by default.
You won't have to manually install or configure them after upgrading, so you can make the switch smoothly when the time comes.

## Versioning conventions

[[= product_name =]], the [[= product_name_commerce_sdk =]] and all other opt-in packages use [semantic versioning](https://semver.org/).

The version number of [[= product_name =]] and all its internal components follows the semantic versioning conventions: vX.Y.Z.

- Changes to X indicate breaking changes. They usually concern mostly internal things, but developers should check in our change logs if they need to adjust their code to continue using the API or features. If there are larger breaks, this is announced well in advance of the upcoming release.
- Y represents new features and functionalities.
- Z represents patches, bug fixes, or smaller improvements.

The distribution file of [[= product_name =]] is as follows:

- `ibexa-cohesivo-vX.Y.Z.tar.gz`

[[= product_name_base =]]'s support and maintenance services specific to each release are only available from a given start date until an end date.
The time in between the start and end dates is what [[= product_name_base =]] calls the product's **Service Life**.

You can find the specific dates of service life for each release on [[= product_name_base =]] [service life page](https://support.ibexa.co/Public/Service-Life).
