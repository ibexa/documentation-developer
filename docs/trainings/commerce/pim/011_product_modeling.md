---
description: "PIM training: Product modeling"
edition: experience
page_type: training
---

# Product modeling

## Product types

The product type base concept is close to the content type one.
Like a content type structures a family of content items, a product type structures products.

See a first conceptualisation of what a product is, and what a product type is, in [Documentation > PIM (Product management) > Products](products.md).

In fact, a product type is really a content type from the hidden system group `product` with a field of type “Product specification” (`ibexa_product_specification`).

The presence of an `ibexa_product_specification` field is what distinct product type from content type.
Don't remove this field from a product type (or it becomes a unreachable hidden content type).
Don't add such field to a content type (or it becomes an uneditable broken product type).
You can't have more than one `ibexa_product_specification`, the laters won't be editable.

You can trick the system URL to display a product type as a content type but know that this is dangerous and mustn't be exposed to final users.
Always prefer the dedicated route (as the back office does) `/product-type/view/<product_type_identifier` (`ibexa.product_catalog.product_type.view`).
To view it through `/contenttypegroup/<product_group_id>/contenttype/<product_type_id>` (`ibexa.content_type.view`) is doable. You could even edit it from there. But this is strongly not recommended.

The "Product specification" field type (`ibexa_product_specification`) brings in the power of attributes.
When defining the product model, the product schema, you go back and forth between attributes and product types.

### Product type default fields

When creating a new product type, several fields are already present.

| identifier            | type                            |
|:----------------------|:--------------------------------|
| name                  | ezsting                         |
| product_specification | ibexa_product_specification     |
| description           | ezrichtext                      |
| image                 | ezimageasset                    |
| category              | ibexa_taxonomy_entry_assignment |

Prices are not part of this training but:

- Notice that you don't need to add a field or an attribute for price. Prices are handled by a particular side mechanism, the price engine, which is not treated in this training.
- Also notice that VAT is set at product type level. The associations of VAT categories to regions are also stored by the `ibexa_product_specification` field.

Product assets presented bellow are explaining why there is no need to add fields to handle more images of the product.

## Attributes VS Fields

Like fields, attributes are typed.

Unlike fields, attributes are not translatable in the product.
Attributes are translated from their definition.
Attributes are product constant properties.
Attributes values can't be translated from the product because those properties don't change with the language.
Only the display of those properties changes with the language.
See the following concept examples:

- The color of a product is the same whatever the language is, only the corresponding color name is translated.
- The radius of a sphere doesn't depend on the language, only its numeral representation need translation according to local length units.

Unlike fields, attributes are first defined outside the product types.
Attributes and attribute groups are to be reused from product type to product type.

An attribute can be used to make product variant.

## Product and product variants

Technically, a product is a content item.

But a variant isn't.
A variant has simpler representation
refering to the base product
and declaring values for the variable attributes.

TODO: Continue content VS product VS variant

A variant doesn't need translation.
It combines base product's and attributes' translations.

## Product assets

Product assets are collection(s) of images associated to a base product and eventually to its variants.

The default `image` field is for an introduction image to the base product.
It's the image appearing in the product catalog's list of products.

Assets are the images appearing on the product page.

In the PIM, product assets are more powerful than a relation list or other field type could be.

A collection of assets is associated to attribute values used for variants.
When displaying a product variant, the application combines the asset collections which suit its attribute values.
For example, you can associate close-up photos of a feature to the checkbox representing its presence,
while associating full views of the products to each of its available colors.

Assets are not translatable.
If a product is not the same from a region to another, from a language to another, this isn't the same product.
For example, if you want to be able to select the language of the instruction manual whatever the user's region,
you could set this choice in a selection attribute, then load a preview asset to each of its values. 

## Exercise: Bike modeling

Exercise: Think about attributes and content type to sell full bicycles and bicycle parts.

The following is an example of a bicycle feature model sketch.
As you can see, it's a rich and complex matrix.
And it doesn't even involve different brands and models for the same feature yet!

- Bicycle:
    - Frameset:
        - Frame:
            - Size: [XS, S, M, L, XL]
            - Shape/Features: [Diamond, Step-through, Diamond w/ suspension, Folding, Recumbent, Cargo, Tandem, …]
            - Material: [Steel, Aluminum, Titanium, Carbon, Wood, Bamboo, Mixed, …]
            - Paint job: […]
        - Fork
            - Size: [XS, S, M, L, XL]
            - Suspension: yes/no
            - Paint job: […]
    - Handlebar:
        - Shape: [Standard, Drop, Bullhorn, Flat, Riser, …]
        - Paint job: […]
    - Saddle:
        - Shape: [Thin, Large, Noseless, …]
        - Cushion material: [Foam, Gel, …]
        - Cover material: [Spandex, Vinyl, Kevlar, Leather, …]
        - Paint job: […]
    - Saddlepost:
        - Material: [Steel, Aluminum, Titanium, Carbon, Wood, Bamboo, Mixed, …]
        - Type: [Rigid, Suspension, Dropper, …]
        - Attachment: [Quick release, Bolt/nut, Anti-thief, …]
    - Pedals:
        - Type: [Flat, Quill, Clipless, …]
        - Foldable: yes/no
    - Gears:
        - Front gears:
            - Speed count: [1…3]
            - Type: [Single, External, Hub internal, Crank gearbox, …]
            - Control transmission: [Bowden cable, Hydraulic, Electronic, …]
            - Control type: [Lever, Ring, …]
            - Control placement: [Handlebar, Frame, …]
        - Rear gears:
            - Speed count: [1…12]
            - Control type: [Bowden cable, Hydraulic, Electronic, …]
            - Type: [Single, External, Hub internal, Crank gearbox, …]
            - Control transmission: [Bowden cable, Hydraulic, Electronic, …]
            - Control type: [Lever, Ring, …]
            - Control placement: [Handlebar, Frame, …]
    - Transmission: [Chain, Belt, Shaft, …]
    - Wheel set:
        - Rear wheel:
            - Axle attachment: [Quick release, Bolt/nut, Thru, Anti-thief, …]
            - Diameter: [622 mm (road 700C, mountain 29″), 584 mm (road 650B, mountain 27.5″), 559 mm (mountain 26″), 406 mm (mountain 20″), …]
            - Type: [Standard spokes, G3 spokes, Disc, …]
            - Brake: [Caliper, Disk, Roller, Drum, …]
            - Rim material: [Aluminum, Steel, Carbon, …]
            - Tire shape: [City, Race, Mountain, Fat, Mixed, …]
            - Tire insert: [Clincher/Tube, Tubular, Tubeless, Foam, Solid, …]
            - Paint job: […]
        - Front wheel:
            - Same as rear: ☑yes/☐no
            - Axle attachment: [Same as rear, Quick release, Bolt/nut, Thru, Anti-thief, …]
            - Diameter: [Same as rear, 622 mm (road 700C, mountain 29″), 584 mm (road 650B, mountain 27.5″), 559 mm (mountain 26″), 406 mm (mountain 20″), …]
            - Type: [Same as rear, Standard spokes, G3 spokes, Disc, …]
            - Brake: [Same as rear, Caliper, V, Disk, Roller, …]
            - Rim material: [Same as rear, Aluminum, Steel, Carbon, …]
            - Tire shape: [Same as rear, City, Race, Mountain, Fat, Mixed, …]
            - Tire insert: [Same as rear, Clincher/Tube, Tubular, Tubeless, Foam, Solid, …]
    - Electric assistance:
        - Electric assistance: ☐yes/☑no
        - Motor placement: [Front wheel, Rear wheel, Crank, …]
        - Battery placement: [Center, Rear, …]
        - Regulation: [EU pedelec, EU speed pedelec, …]

A bad practice would be to try to have a unique product type for modeling all the bikes from the catalog.
For example, series of product won't necessarily vary on the same attributes.
TODO: To have one product type per base product can happen.

The exercise consists into modeling the following catalog of mountain bikes (MTB).
The catalog is split in series, each series got few base products with variations.

- Mountain Bike
    - 4 Series
        - Fuji
        - Matterhorn
        - Annapurna
        - Etna
    - 5 Series
        - Kilimanjaro
        - Stádda
        - Aconcagua
        - Ventoux
        - Castor

To simplify casual customer experience (and above all the exercise), the vendor don't give a lot of choices.

- Manufacturers, brands and models are predefined.
- Front and rear gears, transmission and shifting system are set in one bundle with predefined models.
- Paint jobs are predefined palette/colorscheme/color set, and patterns.

The following table shows only properties that can vary. When not all combinations are available, the product has multiple lines.

| Series   | Name        | Base code | Material | Frame shape                | Frameset + wheel size | Saddle           | Paint job              |  Gears   | Price |
|:---------|:------------|:----------|:---------|:---------------------------|:----------------------|:-----------------|:-----------------------|:--------:|------:|
| 4 Series | Fuji        | MTB-S4-4  | Aluminum | Diamond                    | [S, M, L, XL] + 29″   | Thin             | [Sakura, Ronin]        | G02-2x10 | 3776€ |
| 4 Series | Fuji        | MTB-S4-4  | Aluminum | [Diamond, Step-through]    | [S, M, L] + 29″       | [Thin, Large]    | [Sakura, Ronin]        | G02-1x10 | 3676€ |
| 4 Series | Fuji        | MTB-S4-4  | Aluminum | [Diamond, Step-through]    | XS + 27.5″            | [Thin, Large]    | [Sakura, Ronin]        | G02-1x08 | 3666€ |
| 4 Series | Matterhorn  | MTB-S4-5  | Aluminum | Diamond                    | [S, M, L, XL] + 29″   | [Thin, Large]    | [Snow, Rock]           | G02-2x12 | 4478€ |
| 4 Series | Annapurna   | MTB-S4-6  | Carbon   | Diamond w/ suspension      | [S, M, L, XL] + 29″   | [Thin, Noseless] | Annapurna              | G01-3x12 | 8091€ |
| 4 Series | Etna        | MTB-S4-7  | Aluminum | [Diamond, Step-through]    | [S, M, L, XL] + 29″   | [Thin, Large]    | Etna                   | G02-1x06 | 3369€ |
| 4 Series | Etna        | MTB-S4-7  | Aluminum | [Diamond, Step-through]    | XS + 27.5″            | [Thin, Large]    | Etna                   | G02-1x06 | 3339€ |
| 5 Series | Kilimanjaro | MTB-S5-0  | Aluminum | Step-through w/ suspension | [S, M, L, XL] + 29″   | [Thin, Large]    | [Shira, Mawenzi, Kibo] | G03-2x12 | 5895€ |
| 5 Series | Stádda      | MTB-S5-1  | Aluminum | Step-through               | XS + [26″, 27.5″]     | Large            | [Sunrise, Sunset]      | G04-1x03 | 1392€ |
| 5 Series | Aconcagua   | MTB-S5-2  | Carbon   | Diamond w/ suspension      | [S, M, L, XL] + 29″   | [Thin, Noseless] | [Condor, Llama]        | G01-3x12 | 6960€ |
| 5 Series | Ventoux     | MTB-S5-3  | Aluminum | Step-through               | XS + [26″, 27.5″]     | [Thin, Large]    | [Provence, Mistral]    | G04-1x04 | 1910€ |
| 5 Series | Castor      | MTB-S5-4  | Aluminum | Diamond                    | [S, M, L, XL] + 29″   | [Thin, Large]    | [Castor, Pollux]       | G03-2x12 | 4225€ |

- Create the attribute group(s)
- Create the attributes (TODO: two ways in the BO, Attributes page, or attribute group "Attributes" tab)
- Create the product type(s)
- Create the products
- Create the product variants

The product variants codes can be generated automatically from the base product code
by the default 'incremental' code generator as product variants codes won't be used in the training.
But, if you're curious, you can read or implements as a bonus the following custom code generators.

??? note "Bonus: Code generator"

    A code generator is associated to a whole catalog/repository.

    See how to [create custom product code generator strategy](create_product_code_generator.md).

    To be able to generate product variants' codes from their attributes, a filtering/dispatching code generator is needed.

    In `config/services.yaml`, the code generator services declaration looks like this:
    ```yaml
    [[= include_file('code_samples/trainings/commerce/pim/001_product_modeling/config/services.yaml', 0, None, '    ') =]]
    ```
    The `ProductTypeCodeGeneratorDispatcher` is a code generator using other code generator depending on the product type. Its service receive a map associating product type itendifier to code generator type identifier.
    It also have a default code generator for product type not in the map.

    ```php
    [[= include_file('code_samples/trainings/commerce/pim/001_product_modeling/src/CodeGenerator/Strategy/ProductTypeCodeGeneratorDispatcher.php', 0, None, '    ') =]]
    ```

    The `BikeCodeGenerator` is a code generator dedicated to the `bike` product type. It must cover every `bike` attributes that can vary to ensure code unicity.

    ```php
    [[= include_file('code_samples/trainings/commerce/pim/001_product_modeling/src/CodeGenerator/Strategy/BikeCodeGenerator.php', 0, None, '    ') =]]
    ```

    In `config/packages/ibexa_product_catalog.yaml` is set the use of `per_product_type_code_generator` for the `default` engine/repository:
    ```yaml hl_lines="8"
    [[= include_file('code_samples/trainings/commerce/pim/001_product_modeling/config/packages/ibexa_product_catalog.yaml', 0, None, '    ') =]]
    ```

??? note "TODO: Possible solution(s)"

    TODO: Propose grouped attributes and product type(s), illustrate their usage with few products and product variants.
    TODO: Materials as 1 attribute. Paintjobs as 2 attributes, one per series to reduce selection list length? 3 attributes groups, one common, one per series? Then 2 product types, one per series?

??? note "Bonus: Database schema"

    If you're curious, after having created product type(s), you can run the following SQL query to see the database representation:
    
    ```sql
    SELECT cg.group_id, cg.group_name, g.is_system, c.id, c.identifier, c.version
        FROM ezcontentclass AS c
            JOIN ezcontentclass_classgroup AS cg ON c.id = cg.contentclass_id AND c.version = cg.contentclass_version
            JOIN ezcontentclassgroup AS g ON cg.group_id = g.id
        ORDER BY cg.group_id ASC, c.id ASC
    ;
    ```

??? note "Bonus: Translation"

    - Add a language to your installation (Admin > Languages > Add language).
    - Translate your attribute groups and attributes using the "Translations" tab when you displaying a group or an attribute in the back office.
    - Translate your product types.
    - Translate your base products.

Here are some assets for the Fuji bikes, and for the G02 bundles front gears:

On Fuji, create the asset collections for the assets to be associated to the corresponding variants.
(Download the targets of the following links.)

- [Fuji: Diamond frame + Ronin paint](Fuji-diamond-ronin.png)
- [Fuji: Diamond frame + Sakura paint](Fuji-diamond-sakura.png)
- [Fuji: Step-through frame + Ronin paint](Fuji-stepthrough-ronin.png)
- [Fuji: Step-through frame + Sakura paint](Fuji-stepthrough-sakura.png)
- [G02-2x10: Front gears](G02-2.png)
- [G02-1x10 and G02-1x8: Front gears](G02-1.png)

For the Fuji base product generic image, use [this one](Fuji-diamond.png).

??? note "TODO: Possible solution(s)"

    ![Fuji, example of asset collection for diamond frame shame with "Sakura" paint job.](Fuji-asset-collection-diamond-sakura.png)

Your new products are in the "Uncategorized products" section of the **Products** admin page.
It's now time to fix this in the next chapter.
