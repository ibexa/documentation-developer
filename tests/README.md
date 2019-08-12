# How to run tests

## Enterprise Tutorial

These tests should be run using the ezplatform-ee metarepository.

1. Add developer-documentation to your project by running the following commands:
```
composer config repositories.doc vcs http://github.com/ezsystems/developer-documentation.git
composer require --dev ezsystems/developer-documentation:dev-master

# optional: run to list all available branches
composer show -a ezystems/developer-documentation
```
2. Run setup script:
`./vendor/ezsystems/developer-documentation/tests/scripts/setup.sh`
3. In the `behat.yml.dist` file, adjust the `default.extensions.Behat\Symfony2Extension.kernel.env` value to your SYMFONY_ENV.
For example:
```
default:
    extensions:
        Behat\Symfony2Extension:
            kernel:
                env: prod
```
4. Run tests by using one of the following commands:
- To run all tests, use: `bin/behat --profile=doc`
- To run a specific test step, use: `bin/behat --profile=doc --tags=step1`
5. After execution, run `composer run post-install-cmd`.
