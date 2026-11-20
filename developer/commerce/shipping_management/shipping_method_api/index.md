# Shipping method API

Use PHP API to manage shipping methods in Commerce. Create and update shipping methods, delete shipping methods and their translations.

Editions: Commerce

To get shipping methods and manage them, use the `Ibexa\Contracts\Shipping\ShippingMethodServiceInterface` interface.

Shipping methods are referenced with identifiers defined manually at method creation stage in user interface.

## Get shipping method

### Get shipping method by identifier

To access a shipping method by using its identifier, use the `ShippingMethodServiceInterface::getShippingMethod` method. The method takes a string as `$identifier` parameter and uses a prioritized language from SiteAccess settings unless you pass another language as `forcedLanguage`.

```php
$shippingMethodIdentifier = 'cash';
$shippingMethod = $this->shippingMethodService->getShippingMethod($shippingMethodIdentifier);

$output->writeln(
    sprintf(
        'Got shipping method by identifier "%s" and type "%s".',
        $shippingMethodIdentifier,
        $shippingMethod->getType()->getIdentifier()
    )
);
```

### Get shipping method by ID

To access a shipping method by using its ID, use the `ShippingMethodServiceInterface::getShippingMethod` method. The method takes a string as `$id` parameter and uses a prioritized language from SiteAccess settings unless you pass another language as `forcedLanguage`.

```php
$shippingMethodId = 1;
$shippingMethod = $this->shippingMethodService->getShippingMethodById($shippingMethodId);

$output->writeln(
    sprintf(
        'Availability status of shipping method %d is "%s"',
        $shippingMethodId,
        $shippingMethod->isEnabled()
    )
);
```

## Get multiple shipping methods

To fetch multiple shipping methods, use the `ShippingMethodServiceInterface::getShippingMethod` method. It follows the same search query pattern as other APIs:

```php
$shippingMethodQuery = new ShippingMethodQuery(new ShippingMethodRegion($this->regionService->getRegion('default')));
$shippingMethodQuery->setLimit(10);

$shippingMethods = $this->shippingMethodService->findShippingMethods($shippingMethodQuery);

$shippingMethods->getShippingMethods();
$shippingMethods->getTotalCount();

foreach ($shippingMethods as $shippingMethod) {
    $output->writeln(
        sprintf(
            '%s: %s- %s',
            $shippingMethod->getIdentifier(),
            $shippingMethod->getName(),
            $shippingMethod->getDescription()
        )
    );
}
```

## Create shipping method

To create a shipping method, use the `ShippingMethodServiceInterface::createShippingMethod` method and provide it with the `Ibexa\Contracts\Shipping\Value\ShippingMethodCreateStruct` object that you created by using the `newShippingMethodCreateStruct` method.

```php
$shippingMethodCreateStruct = $this->shippingMethodService->newShippingMethodCreateStruct(
    'courier',
);

$shippingMethodCreateStruct->setType(
    new ShippingMethodType('flat_rate')
);
$shippingMethodCreateStruct->setRegions(([new Region('default')]));
$shippingMethodCreateStruct->setOptions(
    ['currency' => 1, 'price' => 1200]
);
$shippingMethodCreateStruct->setVatCategoryIdentifier('standard');
$shippingMethodCreateStruct->setEnabled(true);
$shippingMethodCreateStruct->setName('eng-GB', 'Courier');

$shippingMethod = $this->shippingMethodService->createShippingMethod($shippingMethodCreateStruct);

$output->writeln(
    sprintf(
        'Created shipping method with name %s',
        $shippingMethod->getName()
    )
);
```

## Update shipping method

To update a shipping method, use the `ShippingMethodServiceInterface::updateShippingMethod` method and provide it with the `Ibexa\Contracts\Shipping\Value\ShippingMethodUpdateStruct` object that you created by using the `newShippingMethodUpdateStruct` method.

```php
$shippingMethodUpdateStruct = $this->shippingMethodService->newShippingMethodUpdateStruct();
$shippingMethodUpdateStruct->setEnabled(false);
$shippingMethodUpdateStruct->setOptions(
    ['currency' => 1, 'price' => 800]
);
$shippingMethodUpdateStruct->setVatCategoryIdentifier('standard');
$shippingMethodUpdateStruct->setName('eng-GB', 'Courier');

$this->shippingMethodService->updateShippingMethod($shippingMethod, $shippingMethodUpdateStruct);

$output->writeln(sprintf(
    'Updated shipping method "%s"',
    $shippingMethod->getName(),
));
```

## Delete shipping method

To update a shipping method, use the `ShippingMethodServiceInterface::deleteShippingMethod` method.

```php
$this->shippingMethodService->deleteShippingMethod($shippingMethod);
$output->writeln(sprintf(
    'Deleted shipping method with ID %d and identifier "%s".',
    $shippingMethod->getId(),
    $shippingMethod->getIdentifier()
));
```

## Delete shipping method translation

To delete shipping method translation, use the `ShippingMethodServiceInterface::deleteShippingMethodTranslation` method.

```php
$languageCode = 'eng-GB';
$shippingMethodDeleteTranslationStruct = new ShippingMethodDeleteTranslationStruct($shippingMethod, $languageCode);
$this->shippingMethodService->deleteShippingMethodTranslation($shippingMethodDeleteTranslationStruct);

$output->writeln(sprintf(
    'Deleted translation for shipping method "%s" and language "%s".',
    $shippingMethod->getName(),
    $languageCode
));
```
