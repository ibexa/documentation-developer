# Ibexa DXP release process and roadmap

Ibexa DXP releases new versions periodically in different flavors: Ibexa Headless, Ibexa Experience and Ibexa Commerce, plus open-source Ibexa OSS.

## Release process

### Distributions

Ibexa DXP has three distributions:

- Ibexa Headless is a multichannel and headless content management system.
- Ibexa Experience is a modern modular Digital Experience Platform to build outstanding customer experiences
- Ibexa Commerce is a commerce-ready B2B DXP designed to digitalize your business from customer awareness to purchase and beyond.

Additionally, Ibexa DXP also has an open-source version called Ibexa OSS. Ibexa OSS is developed by Ibexa together with the open source community. The Ibexa OSS code is available on GitHub under the GPLv2 license. It comes with no commercial support and maintenance services.

### Long Term Support releases

Ibexa manages the release of Ibexa DXP by using an agile iterative process and a continuous software development model, which is why we provide Long Term Support releases (LTS) of Ibexa DXP releases.

Long Term Support releases (LTS) are supported by Ibexa for a long period of time. They're suitable for highly stable enterprise rollouts.

LTS releases provide you with:

- **Reliability and stability**, as they go through extensive testing to ensure they are free from major bugs and issues.
- **Long-term security**, as a result of updates and security patches.
- **Predictability** that comes from following an established release plan.
- **Reduced maintenance**, because you avoid the frequent upgrade cycles.

### LTS Updates

With LTS Updates customers can maintain their competitiveness by incorporating cutting-edge technologies into their LTS releases without losing stability. LTS Updates are intended to improve the current platform by providing new features. What's important, you are not required to switch to a newer version of Ibexa DXP to use LTS Updates. You can install them whenever you choose, and you can be sure that the next LTS release will include them by default. You won't have to manually install or configure them after upgrading, so you can make the switch smoothly when the time comes.

## Versioning conventions

All Ibexa DXP editions use [semantic versioning](https://semver.org/).

The version number of Ibexa DXP and all its internal components follows the semantic versioning conventions: vX.Y.Z.

- Changes to X indicate breaking changes. They usually concern mostly internal things, but developers should check in our change logs if they need to adjust their code to continue using the API or features. If there are larger breaks, this is announced well in advance of the upcoming release.
- Y represents new features and functionalities.
- Z represents patches, bug fixes, or smaller improvements.

Distribution files of Ibexa three editions are as follows:

- for Ibexa Headless: ibexa-headless-vX.Y.Z.tgz
- for Ibexa Experience: ibexa-experience-vX.Y.Z.tgz
- for Ibexa Commerce: ibexa-commerce-vX.Y.Z.tgz

Ibexa's support and maintenance services specific to each release are only available from a given start date until an end date. The time in between the start and end dates is what Ibexa calls the product's **Service Life**.

You can find the specific dates of service life for each release on Ibexa [service life page](https://support.ibexa.co/Public/Service-Life).
