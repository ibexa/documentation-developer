# How to run tests

1. Add developer-documentation to your project:
`composer require --dev ezsystems/developer-documentation:dev-2.4`
1. Run setup script:
`./vendor/ezsystems/developer-documentation/tests/scripts/setup.sh`
1. Adjust behat.yml.dist `default.extensions.Behat\Symfony2Extension.kernel.env` value to your SYMFONY_ENV
1. Run tests:
`bin/behat --profile=doc` to run all of them
`bin/behat --profile=doc --tags=step1` to run a specific one
1. After execusion run `composer run post-install-cmd`
