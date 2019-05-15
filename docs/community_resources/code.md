# Contribute code

Every intention to change existing code or introduce new one should start with a proper explanation. It should be placed in a public ticket. All the rules which you should follow can be found in [contribute documentation section](documentation.md).

Once you are done with describing your idea, focus on the main part - sharing the actual solution. In eZ we are using regular git workflow, so if you are familiar with the concept, the whole procedure should be pretty straightforward.

As you probably know, eZ Platform is divided into meta-repositories. The core of our system is [ezpublish-kernel](https://github.com/ezsystems/ezpublish-kernel) containing an advanced Content Model and aiming to provide additional features for the MVC layer (Symfony). On the other hand, e.g. `ezplatform-admin-ui` is strictly dedicated for the Admin Panel purposes. If you want to learn more about our code structure, take a look at [organization page on GitHub](https://github.com/ezsystems) or the list of [core bundles](https://doc.ezplatform.com/en/latest/guide/bundles/#core-bundles). 

After finishing your work, you are free to fork repository which you want to contribute to. Now you need to determine which version of the package should be targeted by your changes. If you plan to fix something in your current project, check `composer.json` for version of the package and pick proper branch. Let's follow the example: you managed to add `try { } catch () {}` statement fixing some annoying error in `ezplatform-admin-ui` and you are using eZ Platform 2.5. You should aim for branch `1.5` then as version `1.5.0` is used. 

Now you can follow the procedure is exactly the same as in [Contributing through git](documentation/#contributing-through-git).

!!! caution "Public repositories"

    You can contribute only to the public repositories what means that all repositories marked as `private` are not open to contributions outside our organization. However, you can generate a patch from your own codebase and attach it to the Customer Ticket. That will allow our engineers to open a pull request in a private repository on your behalf.
    
Your changes will be reviewed and eventually become a part of the product. Not all pull requests can be approved. Some will need changes before they can be accepted, so you should be prepared for this. When you respond to questions and discussion around your PR and make changes to it as needed, you increase the chance that it will be accepted and reduce the waiting time. Keep in mind that not every suggestion meets requirements of the product or chosen business strategy.

**Don't hesitate to share your work** even if you consider yourself as not experienced developer. Our Engineers will guide you and point out possible ways to choose in order to meet our standards. Following good coding practises, adapting our solutions/code conventions and paying attention to the details are also things worth considering.