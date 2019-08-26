# Step 7 - Add basic validation

!!! tip

    You can find all files used and modified in this step on [GitHub]().

To provide basic validation that ensures both coordinates are provided add assertion to the `src/FieldType/Point2D/Value.php`:

```php
use Symfony\Component\Validator\Constraints as Assert;

final class Value implements ValueInterface

    /**
     * @var float|null
     *
     * @Assert\NotBlank()
     */
     
     private $x;
     
    /**
     * @var float|null
     *
     * @Assert\NotBlank()
     */
    private $y;
```