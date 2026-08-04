# Step 7 - Add basic validation

Learn how to validate custom field data.

To provide basic validation that ensures both coordinates are provided, add assertions to the `src/FieldType/Point2D/Value.php`:

```php
<?php
declare(strict_types=1);

namespace App\FieldType\Point2D;

use Ibexa\Contracts\Core\FieldType\Value as ValueInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class Value implements ValueInterface
{
    public function __construct(
        #[Assert\NotBlank]
        private ?float $x = null,
        #[Assert\NotBlank]
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

As a result, if a user tries to publish the Point 2D with one value, they receive an error message.

![Point 2D validation](https://doc.ibexa.co/en/5.0/tutorials/generic_field_type/img/point2d_validation.png)
