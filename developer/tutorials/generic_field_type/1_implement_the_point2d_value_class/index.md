# Step 1 - Implement the Point 2D Value class

Learn how to create a Value class that stores the value of the field.

## Project installation

To start the tutorial, you need to make a clean Ibexa DXP installation. Follow the guide for your system to [install Ibexa DXP](../../../getting_started/install_ibexa_dxp/index.md), [configure a server](../../../getting_started/requirements/index.md), and [start the web server](../../../getting_started/install_ibexa_dxp/index.md#use-phps-built-in-server). Remember to install using the `dev` environment.

Open your project with a clean installation and create the base directory for a new Point 2D field type in `src/FieldType/Point2D`.

## The Value class

The Value class of a field type is by design very simple. It's used to represent an instance of the field type within a content item. Each field presents its data using an instance of the Type's Value class. For more information about field type Value, see [Value handling](../../../content_management/field_types/type_and_value/index.md#value-handling).

> **Tip: Tip**
>
> According to the convention, the class representing field type Value should be named `Value` and should be placed in the same namespace as the Type definition.

> **Caution: Simple hash values**
>
> A simple hash value always means an array of scalar values and/or nested arrays of scalar values. To avoid issues with format conversion, don't use objects inside the simple hash values.

The Point 2D Value class contains:

- private properties, used to store the actual data
- an implementation of the `__toString()` method, required by the Value interface

By default, the constructor from `FieldType\Value` is used.

The Point 2D is going to store two elements (coordinates for point 2D):

- `x` value
- `y` value

At this point, it doesn't matter where they're stored. You want to focus on what the field type exposes as an API.

`src/FieldType/Point2D/Value.php` should have the following properties:

```php
public function __construct(
    private ?float $x = null,
    private ?float $y = null
) {
}
```

A Value class must also implement the `Ibexa\Contracts\Core\FieldType\Value` interface. To match the `FieldType\Value` interface, you need to implement `__toString()` method. You also need to add getters and setters for `x` and `y` properties. This class represents the point 2D.

The final code should look like this:

```php
<?php
declare(strict_types=1);

namespace App\FieldType\Point2D;

use Ibexa\Contracts\Core\FieldType\Value as ValueInterface;

final class Value implements ValueInterface
{
    public function __construct(
        private ?float $x = null,
        private ?float $y = null
    ) {
    }

    public function getX(): ?float
    {
        return $this->x;
    }

    public function setX(?float $x): void
    {
        $this->x = $x;
    }

    public function getY(): ?float
    {
        return $this->y;
    }

    public function setY(?float $y): void
    {
        $this->y = $y;
    }

    public function __toString(): string
    {
        return "({$this->x}, {$this->y})";
    }
}
```
