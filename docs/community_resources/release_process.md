# [[= product_name =]] release process and roadmap

## Release process

[[= product_name =]] has three distributions:

- [[= product_name =]] is an open source Content Management System (CMS) developed by Ibexa together with the open source community. [[= product_name =]]'s code base is available on GitHub under the GPLv2 license. [[= product_name =]] comes with no commercial support and maintenance services. It is supported by the community on public channels.
- [[= product_name_exp =]] is commercial software available under eZ Business User License (BUL) to [[= product_name_exp =]] subscribers. It is comprised of [[= product_name =]], additional enterprise support and maintenance services, as well as additional features which are not available in the open source software.

We manage the release of [[= product_name =]] using an agile iterative process and a continuous software development model, which is why we provide two kinds of [[= product_name =]] releases:

- Long Term Support releases (LTS) which are supported by Ibexa for a long period of time (see [support lifecycle below](#support-lifecycle)), for [[= product_name_exp =]] subscribers.
- Fast Track releases (FT) give access to the latest features and are supported for a short period of time. They are maintained only until the next FT release is introduced. These are supported for both the open source community and [[= product_name_exp =]] subscribers.

FT releases are tailored for those who want to stay up-to-date with newest functionalities,
while LTS releases are suitable for highly stable enterprise rollouts.

We usually release [[= product_name =]] four times a year following the seasons (winter, spring, summer and fall). This usually includes one LTS release and three FT releases.

## Versioning conventions

Both [[= product_name =]] editions use [semantic versioning](http://semver.org/).  

The version number of [[= product_name =]] and all its internal components follows the semantic versioning conventions: vX.Y.Z.

- Changes to X indicate breaking changes. They usually concern mostly internal things, but developers should check in our change logs if they need to adjust their code to continue using the API or features. If there are larger breaks (like the new Back Office in v2), this is announced well in advance of the upcoming release.
- Y represents new features and functionalities.
- Z represents patches, bug fixes, smaller improvements, etc.

Distribution files of our two editions are as follows:

- for [[= product_name =]]: ezplatform-vX.Y.Z.tgz
- for [[= product_name_exp =]]: ezplatformenterprise-vX.Y.Z.tgz

## Support lifecycle

Our software products are continuously evolving.
With each release we strive to release stable products with cutting-edge technology.
This means there is need for software maintenance services to provide bug fixes and adjustments.
As our products constantly provide new features and possibilities, our documentation and user forums may not always be able to provide an answer to all questions that may arise.

That is why our support and consulting professional services teams are available to assist
as part of an [[= product_name_exp =]] subscription or as part of a specific statement of work.
[Contact our Sales team](https://ez.no/Forms/Request-a-Consultation) for more information.

Over time, existing product versions mature and new versions become the center of attention for customers looking for the latest features.
We adapt to this continuous evolution by phasing out services for the old versions while commencing services for the new ones.
This means that our support and maintenance services specific to each release
are only available from a given start date until an end date.
The time in between the start and end dates is what we call the product's **Service Life**.

You can find the specific dates of service life for each release on our [support portal service life page](https://support.ez.no/Public/Service-Life).

## Roadmap

[Our roadmap](https://ezplatform.com/product-feedback) is updated continuously following our iterative development methodology (our own adaptation and combination of Scrum and Kanban).
Our agile boards offer a clear view of the ongoing and upcoming development and are open to the public.
Progress is based on the prioritized stories from a living backlog into phases of specification and design, development and documentation, and QA.
The final phase of development includes a dedicated period of Certification and Quality Assurance,
which ensures our ability to deliver a stable first version of the professionally supported software.

If you want to know more, please contact productmanagement@ez.no
