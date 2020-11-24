# Contribute code

If you intend to change existing or introduce new code, start with a proper explanation.
It should be placed in a public ticket.
All the rules to follow can be found in [Contribute to documentation](documentation.md) section.

Once you are done with describing your idea, focus on the main part - sharing the actual solution.
Ibexa uses a regular git workflow, so if you are familiar with the concept, the whole procedure should be pretty straightforward.

[[= product_name =]] is divided into meta-repositories.
The core of our system is [`ezplatform-kernel`](https://github.com/ezsystems/ezplatform-kernel)
containing an advanced Content Model and aiming to provide additional features for the MVC layer (Symfony).
On the other hand, e.g. `ezplatform-admin-ui` is strictly dedicated to the Admin Panel purposes.
If you want to learn more about our code structure, take a look at [our organization page on GitHub](https://github.com/ezsystems)
or the list of [core bundles](../guide/bundles/#core-bundles).

After finishing your work, fork repository which you want to contribute to.
Now you need to determine which version of the package your changes should target.
If you plan to fix something in your current project, check `composer.json` for the version of the package and pick proper branch.

For example: you added a `try { } catch () {}` statement fixing an annoying error in `ezplatform-admin-ui`
and you are using version 2.5. You should aim for branch `1.5` then, as version `1.5.0` is used.

Now you can follow the same procedure as in [Contributing through git](documentation/#contributing-through-git).

!!! caution "Public repositories"

    You can contribute only to the public repositories.
    This means that all repositories marked as `private` are not open to contributions outside our organization.
    However, you can generate a patch from your own codebase and attach it to the Customer Ticket.
    That will allow our engineers to open a pull request in a private repository on your behalf.

To become a part of the product your changes must pass our team's review.
Not all pull requests can be approved. Be prepared that some will need changes before they can be accepted.
When you respond to questions and discussion around your PR and make changes to it as needed,
you increase the chance that it will be accepted and reduce the waiting period.
Keep in mind that not every suggestion meets requirements of the product or chosen business strategy.

**Don't hesitate to share your work** even if you don't consider yourself an experienced developer.
Our Engineers will help you meet our standards, follow good coding practices,
adapt to our solutions/code conventions and pay attention to details.
