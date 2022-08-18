# eZ Platform v2.0.0

**Version number**: v2.0.0

**Release date**: December 22, 2017

**Release type**: Fast Track

!!! note "LTS release"

    Parallel to this v2.0.0 version we are releasing a Long Term Support (LTS) version based on 1.x:
    [v1.13.0](ez_platform_v1.13.0_lts.md).

## Notable changes

eZ Platform v2.0.0 introduces significant changes to the architecture, especially to the back-office interface.

#### Symfony 3

eZ Platform has become a pure Symfony application, based on Symfony 3, which brings with it many enhancements.

!!! note

    Note that the move to [Symfony 3](https://symfony.com/roadmap?version=3.4) causes some changes, for example to the project's directory structure.

    Among others, the `var` directory now contains cache and logs.
    The `bin` directory is now used to call the `console` command, so use `bin/console` instead of `app/console`.

#### Back-office interface

The back-office interface no longer uses YUI, and is instead based on React components and Bootstrap, which makes it easier to extend.
Explore the Extending section in the menu to learn how to extend the new version of the UI.

The features of eZ Platform remain the same as in 1.x versions. However, the look of the interface has changed significantly.

![v2.0.0 interface](v2_general_screen.png)

#### Studio

The StudioUI still uses the 1.x interface. It will be rewritten to the new architecture in an upcoming version.

### Changed requirements

eZ Platform v2.0.0 requires PHP version 7.1, instead of 5.6, as before. Together with improved architecture, this ensures that the application can work up to several times more quickly than before.

## Installation

[Installation guide](https://doc.ibexa.co/en/2.5/getting_started/install_ez_platform)

[Technical requirements](https://doc.ibexa.co/en/2.5/getting_started/requirements)
