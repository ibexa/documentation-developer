# getBasket

`basket.get_basket` gets the current basket.

## Example

``` php
use Ibexa\Platform\Commerce\Checkout\Entities\BusinessLayer\InputValueObjects\GetBasket as InputGetBasket;
use Ibexa\Platform\Commerce\Checkout\Entities\BusinessLayer\OutputValueObjects\GetBasket as OutputGetBasket;

/** @var InputGetBasket $inputGetBasket */
$inputGetBasket = new InputGetBasket(array('request' => $request));

/** @var OutputGetBasket $outputGetBasket */
$outputGetBasket = $this->getBusinessApi()->call('basket.get_basket', $inputGetBasket);

$message = $this->getBasketMessage($outputGetBasket->basket);
```

## Input parameters

``` php
namespace Silversolutions\Bundle\EshopBundle\Entities\BusinessLayer\InputValueObjects;

use Silversolutions\Bundle\EshopBundle\Content\ValueObject;

/**
 * Class GetBasket
 *
 * This class is used as an input parameter for an appropriate business method
 *
 * @property-read \Symfony\Component\HttpFoundation\Request $request
 */
class GetBasket extends ValueObject
{
    /** @var \Symfony\Component\HttpFoundation\Request $request */
    protected $request;
    /** @var array $checkProperties */
    protected $checkProperties = array(
        array(
            'name' => 'request',
            'mandatory' => true,
            'type' => '\Symfony\Component\HttpFoundation\Request',
            'isObject' => true
        )
    );
}
```

## Returns output

``` php
namespace Silversolutions\Bundle\EshopBundle\Entities\BusinessLayer\OutputValueObjects;

use Silversolutions\Bundle\EshopBundle\Content\ValueObject;

/**
 * Class GetBasket
 *
 * This class is used as an output parameter for an appropriate business method
 *
 * @property-read \Ibexa\Platform\Bundle\Commerce\Checkout\Entity\Basket $basket
 */
class GetBasket extends ValueObject
{
    /** @var Ibexa\Platform\Bundle\Commerce\Checkout\Entity\Basket $basket */
    protected $basket;
    /** @var array $checkProperties */
    protected $checkProperties = array(
        array(
            'name' => 'basket',
            'mandatory' => true,
            'type' => '\Ibexa\Platform\Bundle\Commerce\Checkout\Entity\Basket',
            'isObject' => true
        )
    );
}
```
