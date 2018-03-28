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

The gateway configuration for basic field types are located in [eZ/Publish/Core/settings/storage_engines/legacy/external_storage_gateways.yml](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/settings/storage_engines/legacy/external_storage_gateways.yml).