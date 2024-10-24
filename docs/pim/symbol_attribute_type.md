---
description: Create a symbol attribute type that enables for the efficient representation of string-based values while enforcing their format in product specifications.
---

# Symbol attribute type

In product specifications, the symbol attribute type enables the efficient representation of string-based data and enforces their format.

## Installation

### Download the bundle

To get the most recent stable version of this bundle, open a command terminal, navigate to your project directory, and run the following command:

``` bash
ibexa/product-catalog-symbol-attribute
```

!!! caution

    To use this command requires you need to first install the Composer locally.
    For more information about Composer installation process, see [documentation](install_ibexa_dxp.md#get-composer).

### Enable the bundle

Flex enables and configures the `IbexaProductCatalogSymbolAttributeBundle` automatically.
If you don't use it, you can manually enable Flex by adding the line below to the Kernel of your project:

``` php
// config/bundles.php

return [
   // ...
   Ibexa\Bundle\ProductCatalogSymbolAttribute\IbexaProductCatalogSymbolAttributeBundle => ['all' => true],
   // ...
];
```

### Update database schema

To store symbol attribute values, the `IbexaProductCatalogSymbolAttributeBundle` needs an extra table.
The following SQL query can be used to build the required database structure:

``` bash
create table ibexa_product_specification_attribute_symbol (
    id int not null primary key,
    value varchar(255) null,
    constraint ibexa_product_specification_attribute_symbol_fk
        foreign key (id) references ibexa_product_specification_attribute (id)
            on update cascade on delete cascade
) collate = utf8mb4_unicode_520_ci;

create index ibexa_product_specification_attribute_symbol_value_idx
    on ibexa_product_specification_attribute_symbol (value);
```

### Create symbol attribute definition (optional)

Now, you're able to define symbol attributes at this point.

To create symbol attribute definition, in the back office, go to **Product catalog** -> **Attributes**, and click **Create**.
Then, choose **Symbol** attribute type.

## Build-in symbol attribute formats

The built-in symbol attribute formats in `ibexa/product-catalog-symbol-attribute` are listed below:

| Name | Description | Example |
|-----------------|-----------------|-----------------|
| Generic | Accepts any string value  | #FR1.2 |
| Generic (alphabetic characters only) | Accepts any string value that contais only letters  | ABCD |
| Generic (digits only) | Accepts any string value that contais only digits  | 123456 |
| Generic (alphanumeric characters only) | Accepts any string value that contains only letters or digits | 2N6405G |
| Generic (hexadecimal digits only) | Accepts any string value that contains only hexadecimal digits (digits or A-F characters) | DEADBEEF |
| EAN-8 | European Article Number (8 characters)  | 29033706 |
| EAN-13 | European Article Number (13 characters)  | 5023920187205 |
| EAN-14 | European Article Number (14 characters)   | 50239201872050 |
| ISBN-10 | International Standard Book Number (10 characters)  | 0-19-852663-6 |
| ISBN-13 | International Standard Book Number (13 characters)  | 978-1-86197-876-9 |

!!! caution

    Maximum length of the symbol value is 160 characters.

## Create custom symbol attribute format

Under the `ibexa_product_catalog_symbol_attribute.formats` key, you can use configuration to create your own symbol format.

See the example below:

``` yaml
ibexa_product_catalog_symbol_attribute:
    formats:
        manufacturer_part_number:
            name: 'Manufacturer Part Number'
            pattern: '/^[A-Z]{3}-\d{5}$/'
            examples:
                - 'RPI-14645'
                - 'MSS-24827'
                - 'SEE-15444'
```

The following example specifies the format for a "Manufacturer Part Number."

According to the pattern option, the value:

- must be a string
- uses a regular expression
- begins with three capital letters
- ends with five numbers

Certain formats, such as the International Standard Book Number (ISBN-10) and the European Article Number (EAN-13), contain checksum digits and are self-validating.

To validate checksum of symbol:

1\. Implement `\Ibexa\Contracts\ProductCatalogSymbolAttribute\Value\ChecksumInterface`:

``` php
<?php

declare(strict_types=1);

namespace Ibexa\Contracts\ProductCatalogSymbolAttribute\Value;

use Ibexa\Contracts\ProductCatalog\Values\AttributeDefinitionInterface;

interface ChecksumInterface
{
    public function validate(AttributeDefinitionInterface $attributeDefinition, string $value): bool;
}
```

2\. Register service with `ibexa.product_catalog.attribute.symbol.checksum` tag and format attribute.

See below the example implementation of checksum validation using Luhn formula:

``` php
<?php

declare(strict_types=1);

namespace App\PIM\Symbol\Format\Checksum;

use Ibexa\Contracts\ProductCatalog\Values\AttributeDefinitionInterface;
use Ibexa\Contracts\ProductCatalogSymbolAttribute\Value\ChecksumInterface;

final class LuhnChecksum implements ChecksumInterface
{
    public function validate(AttributeDefinitionInterface $attributeDefinition, string $value): bool
    {
        $digits = $this->getDigits($value);

        $count = count($digits);
        $total = 0;
        for ($i = $count - 2; $i >= 0; $i -= 2) {
            $digit = $digits[$i];
            if ($i % 2 === 0) {
                $digit *= 2;
            }

            $total += $digit > 9 ? $digit - 9 : $digit;
        }

        $checksum = $digits[$count - 1];

        return $total + $checksum === 0;
    }

    /**
     * Returns an array of digits from the given value (skipping any formatting characters).
     *
     * @return int[]
     */
    private function getDigits(string $value): array
    {
        $chars = array_filter(
            str_split($value),
            static fn (string $char): bool => $char !== '-'
        );

        return array_map('intval', array_values($chars));
    }
}
```

## Search for products with given symbol attribute

You can use `SymbolAttribute` Search Criterion to find products by symbol attribute:

For more information, see [SymbolAttribute Criterion](symbolattribute_criterion.md).