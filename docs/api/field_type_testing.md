# Testing

Field Types should be integration tested on 2 different levels:

1.  Their integration with the Persistence SPI
2.  Their integration with the Public API

For both test environments, infrastructure is already in place, so that you can easily implement the required tests for your custom Field Type

## Persistence SPI

This type of integration test ensures, that a Field Type stores its data properly on basis of different Persistence SPI implementations.

!!! note

    By now, only the Legacy Storage implementation exists.

The integration tests with the Persistence SPI can be found in `eZ\Publish\SPI\Tests\FieldType`. In order to implement a test for your custom Field Type, you need to extend the common base class `eZ\Publish\SPI\Tests\FieldType\BaseIntegrationTest` and implement its abstract methods. As a reference the `KeywordIntegrationTest`, `UrlIntegrationTest` and `UserIntegrationTest` can deal.

Running the test is fairly simple: Just specify the global `phpunit.xml` for PHPUnit configuration and make it execute a single test or a directory of tests, for example:

``` bash
$ phpunit -c phpunit.xml eZ/Publish/SPI/Tests/FieldType
```

in order to run all Field Type tests.

## Public API

On a second level, the interaction between an implementation of the Public API (aka the Business Layer) and the Field Type is tested. Again, there is a common base class as the infrastructural basis for such tests, which resides in `eZ\Publish\API\Repository\Tests\FieldType\BaseIntegrationTest`.

!!! note

    Note that the In-Memory stubs for the Public API integration test suite, do not perform actual Field Type calls, but mainly emulate the behavior of a Field Type for simplicity reasons. 
    
    If your Field Type needs to convert data between `storeFieldData()` and `getFieldData()`, you need to implement a `eZ\Publish\API\Repository\Tests\Stubs\PseudoExternalStorage` in addition, which performs this task. Running the tests against the Business Layer implementation of the Public API is not affected by this.