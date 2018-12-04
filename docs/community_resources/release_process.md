# eZ Platform Release Process and Roadmap

## Release process

eZ Platform is distributed in two flavors:

- eZ Platform is an open source Content Management System (CMS) developed by eZ Systems together with the open source community. eZ Platform's code base is available on GitHub under the GPLv2 license. eZ Platform comes with no commercial support and maintenance services. It is supported by the community on public channels.
- eZ Platform Enterprise Edition (EE) is commercial software available under eZ Business User License (BUL) to eZ Enterprise subscribers. It is comprised of eZ Platform Open Source edition, additional enterprise support and maintenance services, as well as additional features which are not available in the open source software.

We manage the release of eZ Platform using an agile iterative process and a continuous software development model, which is why we provide two kinds of eZ Platform releases:

- Long Term Support releases (LTS) which are supported by eZ Systems for a long period of time (see [support lifecycle below](#support-lifecycle)), for eZ Enterprise subscribers.
- Fast Track releases (FT) give access to the latest features and are supported for a short period of time, only until the next FT release is introduced. These are supported for both the open source community and eZ Enterprise subscribers.

FT releases are tailored for those who want to stay more on the bleeding edge, while LTS releases are suitable for highly stable enterprise rollouts.

We usually release eZ Platform four times a year following the seasons (Winter, Spring, Summer and Fall). This usually includes one LTS release and three FT releases.

## Versioning conventions

eZ Platform Open Source and Enterprise editions use [semantic versioning](http://semver.org/).  

eZ Platform and all inner components have a version number following the semantic versioning conventions vX.Y.Z.

- Changes to X, the first digit, indicate a breaking change to the API, and developers know that they may need to implement a re-write of their code to continue consuming the API moving forward.
- Y, the middle digit, represents new features and functionality.
- Z, The final digit, represents patches, bug fixes, smaller improvements to unblock users and other forms of "oops" and "aha!".

This way, distribution files of our product are as following:

- eZ Platform uses its own unique semantic version number: ezplatform-vX.Y.Z.tgz
- eZ Platform Enterprise uses its semantic version number: ezplatformenterprise-vX.Y.Z.tgz

## Support lifecycle

Our software products are continuously evolving, and we have released many versions over the years.

As we strive to release stable products with cutting-edge technology, there is an obvious need for software maintenance services to provide bug fixes as well as adjustments for evolving web technologies. And, as our products always provide new features and possibilities, our documentation and user forums may not always be able to provide an answer to all questions that may arise. For that, our support and consulting professional services teams are available to assist as part of an eZ Enterprise subscription or as part of a specific statement of work. [Contact our Sales team](https://ez.no/Forms/Request-a-Consultation) for more information.

Over time, existing product versions mature and new versions become the center of attention for customers wanting the latest and greatest in features and extensibility. We adapt to this continuous evolution by phasing out services for the old versions while commencing services for the new ones. This means that our support and maintenance services specific to each release are only available from a given start date until an end date. The time in between the start and end dates is what we call the product's **Service Life**.

To know the specific dates of service life for each release, please visit our [support portal service life page](https://support.ez.no/Public/Service-Life).

## Roadmap

Our roadmap is updated continuously following our iterative development methodology (our own adaptation and combination of Scrum and Kanban). Our agile boards are open so that anyone can have a clear view of the ongoing and upcoming development. Progress is based on the prioritized stories from a living backlog into phases of specification and design, development and documentation, and QA. The final phase of our development includes a dedicated period of Certification and Quality Assurance, which ensures our ability to deliver a stable first version of the professionally supported software.

If you want to know more, please contact productmanagement@ez.no
