# Field Type testing

Field Types should be integration tested on 2 different levels:

1.  Their integration with the Persistence SPI
2.  Their integration with the Public API

For both test environments, infrastructure is already in place, so you can easily implement the required tests for your custom Field Type.

## Persistence SPI

This type of integration test ensures that a Field Type stores its data properly on the basis of different Persistence SPI implementations.

!!! note

    At the moment only Legacy Storage implementation is available.

The integration tests with the Persistence SPI is in `eZ\Publish\SPI\Tests\FieldType`. In order to implement a test for your custom Field Type, you need to extend the common base class `eZ\Publish\SPI\Tests\FieldType\BaseIntegrationTest` and implement its abstract methods.

!!! tip

    You can use `KeywordIntegrationTest`, `UrlIntegrationTest` and `UserIntegrationTest` as reference.

    Gateway configuration for built-in Field Types is located in [`eZ/Publish/Core/settings/storage_engines/legacy/external_storage_gateways.yml`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/settings/storage_engines/legacy/external_storage_gateways.yml).

## Public API

On the second level, the interaction between an implementation of the Public API and the Field Type is tested.
Again, there is a common base class as the infrastructural basis for such tests,
which resides in `eZ\Publish\API\Repository\Tests\FieldType\BaseIntegrationTest`.

!!! note

    Note that the In-Memory stubs for the Public API integration test suite do not perform actual Field Type calls, but mainly emulate the behavior of a Field Type for the sake of simplicity.

    If your Field Type needs to convert data between `storeFieldData()` and `getFieldData()`, you need to additionally implement an `eZ\Publish\API\Repository\Tests\Stubs\PseudoExternalStorage`, which performs this task. Running the tests against the business layer implementation of the Public API is not affected by this.
