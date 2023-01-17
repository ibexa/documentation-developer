---
description: "Ibexa DXP releases new versions periodically in different flavors: Ibexa Content, Ibexa Experience and Ibexa Commerce, plus open-source Ibexa OSS."
---

# Ibexa DXP release process and roadmap

## Release process

[[= product_name =]] has three distributions:

- [[= product_name_content =]] is a multichannel and headless content management system.
- [[= product_name_exp =]] is a modern modular Digital Experience Platform to build outstanding customer experiences
- [[= product_name_com =]] is a commerce-ready B2B DXP designed to digitalize your business from customer awareness to purchase and beyond.

Additionally, [[= product_name =]] also has an open-source version called Ibexa OSS.
Ibexa OSS is developed by Ibexa together with the open source community.
The Ibexa OSS code is available on GitHub under the GPLv2 license.
It comes with no commercial support and maintenance services. 

We manage the release of [[= product_name =]] using an agile iterative process and a continuous software development model, which is why we provide two kinds of [[= product_name =]] releases:

- Long Term Support releases (LTS) which are supported by Ibexa for a long period of time (see [support lifecycle below](#support-lifecycle)).
- Fast Track releases (FT) give access to the latest features and are supported for a short period of time. They are maintained only until the next FT release is introduced.

FT releases are tailored for those who want to stay up-to-date with newest functionalities,
while LTS releases are suitable for highly stable enterprise rollouts.

## Versioning conventions

All [[= product_name =]] editions use [semantic versioning](http://semver.org/).  

The version number of [[= product_name =]] and all its internal components follows the semantic versioning conventions: vX.Y.Z.

- Changes to X indicate breaking changes. They usually concern mostly internal things, but developers should check in our change logs if they need to adjust their code to continue using the API or features. If there are larger breaks, this is announced well in advance of the upcoming release.
- Y represents new features and functionalities.
- Z represents patches, bug fixes, smaller improvements, etc.

Distribution files of our three editions are as follows:

- for [[= product_name_content =]]: ibexa-content-vX.Y.Z.tgz
- for [[= product_name_exp =]]: ibexa-experience-vX.Y.Z.tgz
- for [[= product_name_com =]]: ibexa-commerce-vX.Y.Z.tgz

Our support and maintenance services specific to each release are only available from a given start date until an end date.
The time in between the start and end dates is what we call the product's **Service Life**.

You can find the specific dates of service life for each release on our [support portal service life page](https://support.ibexa.co/Public/Service-Life).
