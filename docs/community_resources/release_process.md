# eZ Platform release process and roadmap

## Release process

eZ Platform has two distributions:

- eZ Platform is an open source Content Management System (CMS) developed by Ibexa together with the open source community. eZ Platform's code base is available on GitHub under the GPLv2 license. eZ Platform comes with no commercial support and maintenance services. It is supported by the community on public channels.
- eZ Platform Enterprise Edition (EE) is commercial software available under eZ Business User License (BUL) to eZ Enterprise subscribers. It is comprised of eZ Platform Open Source edition, additional enterprise support and maintenance services, as well as additional features which are not available in the open source software.

We manage the release of eZ Platform using an agile iterative process and a continuous software development model, which is why we provide two kinds of eZ Platform releases:

- Long Term Support releases (LTS) which are supported by Ibexa for a long period of time, for eZ Enterprise subscribers.
- Fast Track releases (FT) give access to the latest features and are supported for a short period of time. They are maintained only until the next FT release is introduced. These are supported for both the open source community and eZ Enterprise subscribers.

FT releases are tailored for those who want to stay up-to-date with newest functionalities,
while LTS releases are suitable for highly stable enterprise rollouts.

## Versioning conventions

Both eZ Platform editions use [semantic versioning](http://semver.org/).  

The version number of eZ Platform and all its internal components follows the semantic versioning conventions: vX.Y.Z.

- Changes to X indicate breaking changes. They usually concern mostly internal things, but developers should check in our change logs if they need to adjust their code to continue using the API or features. If there are larger breaks (like the new Back Office in v2), this is announced well in advance of the upcoming release.
- Y represents new features and functionalities.
- Z represents patches, bug fixes, smaller improvements, etc.

Distribution files of our two editions are as follows:

- for eZ Platform: ezplatform-vX.Y.Z.tgz
- for eZ Platform Enterprise: ezplatformenterprise-vX.Y.Z.tgz

Our support and maintenance services specific to each release are only available from a given start date until an end date.
The time in between the start and end dates is what we call the product's **Service Life**.

You can find the specific dates of service life for each release on our [support portal service life page](https://support.ibexa.co/Public/Service-Life).
