# How to run tests

## Enterprise Tutorial

These tests should be run using ezplatform-ee metarepository.

1. Add developer-documentation to your project:
```
composer config repositories.doc vcs http://github.com/ezsystems/developer-documentation.git
composer require --dev ezsystems/developer-documentation:dev-master
```
1. Run setup script:
`./vendor/ezsystems/developer-documentation/tests/scripts/setup.sh`
1. Adjust behat.yml.dist `default.extensions.Behat\Symfony2Extension.kernel.env` value to your SYMFONY_ENV
1. Run tests:
`bin/behat --profile=doc` to run all of them
`bin/behat --profile=doc --tags=step1` to run a specific one
1. After execution run `composer run post-install-cmd`
