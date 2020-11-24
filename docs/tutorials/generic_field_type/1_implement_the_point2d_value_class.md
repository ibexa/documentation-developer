# Step 1 - Implement the Point 2D Value class

!!! tip

    You can find all files used and modified in this step on [GitHub](https://github.com/ezsystems/generic-field-type-tutorial/tree/Step_1).

## Project installation

To start the tutorial, you need to make a clean [[= product_name =]] installation.
Follow the guide for your system to [install [[= product_name =]]](../../getting_started/install_ez_platform.md),
[configure a server](../../getting_started/requirements.md),
and [start the web server](../../getting_started/install_ez_platform.md#use-phps-built-in-server).
Remember to install using the `dev` environment.

Open your project with a clean installation and create the base directory for a new Point 2D Field Type in `src/FieldType/Point2D`.

## The Value class

The Value class of a Field Type is by design very simple.
It is used to represent an instance of the Field Type within a Content item.
Each Field presents its data using an instance of the Type's Value class.
For more information about Field Type Value, see [Value handling](../../api/field_type_type_and_value.md#value-handling).

!!! tip

    According to the convention, the class representing Field Type Value should be named `Value` and should be placed in the same namespace as the Type definition.

The Point 2D Value class will contain:

- private properties, used to store the actual data
- an implementation of the `__toString()` method, required by the Value interface

By default, the constructor from `FieldType\Value` will be used.

The Point 2D is going to store two elements (coordinates for point 2D):

- `x` value
- `y` value

At this point, it does not matter where they are stored. You want to focus on what the Field Type exposes as an API.

`src/FieldType/Point2D/Value.php` should have the following properties:

```php
{
//Properties of the class Value

    /** @var float|null */
    private $x;
    /** @var float|null */
    private $y;
}
```

A Value class must also implement the `eZ\Publish\SPI\FieldType\Value` interface.
To match the `FieldType\Value` interface, you need to implement `__toString()` method.
You also need to add getters and setters for `x` and `y` properties.
This class will represent the point 2D.

The final code should look like this:

```php
<?php
declare(strict_types=1);

namespace App\FieldType\Point2D;

use eZ\Publish\SPI\FieldType\Value as ValueInterface;

final class Value implements ValueInterface
{
    /** @var float|null */
    private $x;
    /** @var float|null */
    private $y;
    public function __construct(?float $x = null, ?float $y = null)
    {
        $this->x = $x;
        $this->y = $y;
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
    public function __toString()
    {
        return "({$this->x}, {$this->y})";
    }
}
```
