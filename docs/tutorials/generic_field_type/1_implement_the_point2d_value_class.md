# Step 1 - Implement the Point 2D Value class

!!! tip

    You can find all files used and modified in this step on [GitHub]().

## Project installation

Start by [installing eZ Platform](../../getting_started/install_ez_platform/), [configuring a server](../../getting_started/requirements/),
and [starting the web server](../../getting_started/install_ez_platform/#use-phps-built-in-server).
 
Open your project with a clean installation and create the base directory for a new Point 2D Field Type in `src/FieldType/Point2D`.

## The Value class

The Value class of a Field Type is by design very simple.
It is used to represent an instance of the Field Type within a Content item.
Each Field presents its data using an instance of the Type's Value class.
For more information about Field Type Value see [Value handling](../../api/field_type_type_and_value/#value-handling).

!!! tip

    Value class should always be contained in the file named `Value.php`.

The Point 2D Value class will contain:

- public properties, used to store the actual data
- an implementation of the `__toString()` method, required by the Value interface it inherits from

By default, the constructor from `FieldType\Value` will be used.
It enables you to pass a hash of property/value pairs.

The Point 2D is going to store two elements:

- `x` value
- `y` value

At this point, it does not matter where they are stored. You want to focus on what the Field Type exposes as an API.

`src/FieldType/Point2D/Value.php` should have the following properties:

```php
<?php
{
//Properties of the class Value
/** @var float|null */
private $x;
/** @var float|null */
private $y;
}
```

To match the `FieldType\Value` interface you also need to add `getX()`,  `setX`, `getY`, `setY`, `__toString()` methods to the constructor.
A Value class must also implement the `eZ\Publish\SPI\FieldType\Value` interface.
It will return the point 2D.
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
