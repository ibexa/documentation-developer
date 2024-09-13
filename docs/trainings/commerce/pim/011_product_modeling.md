---
description: "PIM training: Product modeling"
edition: experience
page_type: training
---

# Product modeling

## Product types

The product type base concept is close to the content type one.
Like a content type structures a family content items, a product type structures products.

See a first conceptualisation of what a product is, and what a product type is, in [Documentation > PIM (Product management) > Products](products.md).

In fact, a product type is really a content type from the hidden system group `product` with a field of type “Product specification” (`ibexa_product_specification`).

The presence of an `ibexa_product_specification` field is what distinct product type from content type.
Don't remove this field from a product type (or it will become a unreachable hidden content type).
Don't add such field to a content type (or it will become an uneditable broken product type).

TODO: What happens if you have several `ibexa_product_specification` fields?

You can trick the system URL to display a product type as a content type but know that this is dangerous and mustn't be exposed to final users.
Always prefer the dedicated route (as the Back Office does) `/product-type/view/<product_type_identifier` (`ibexa.product_catalog.product_type.view`).
To view it through `/contenttypegroup/<product_group_id>/contenttype/<product_type_id>` (`ibexa.content_type.view`) is doable. You could even edit it from there. But this is strongly not recommended.

TODO: move to somewhere in the exercise
If you're curious, after having created a product type, you can run the following SQL query to see the database representation.

```sql
SELECT cg.group_id, cg.group_name, g.is_system, c.id, c.identifier, c.version
    FROM ezcontentclass AS c
        JOIN ezcontentclass_classgroup AS cg ON c.id = cg.contentclass_id AND c.version = cg.contentclass_version
        JOIN ezcontentclassgroup AS g ON cg.group_id = g.id
    ORDER BY cg.group_id ASC, c.id ASC
;
```

The "Product specification" field type (`ibexa_product_specification`) brings in the power of attributes.

Notice that you don't need to add a field or an attribute for price.
Prices are handled by a particular side mechanism, the price engine, which is treated later in the training with VAT, currencies, etc.

## Attributes VS Fields

Like fields, attributes are typed.

Unlike fields, attributes are never translatable.
Attributes are product constant properties.
Attributes values can't be translated because those properties don't change with the language.
Only the display of those properties changes with the language. See the following concept examples:

- The color of a product is the same whatever the language is, only the corresponding color name is translated.
- The radius of a sphere doesn't depend on the language, only its numeral representation need translation according to local length units.

TODO: Later in the training, in the templating part, is shown how to localize the attributes.

Unlike fields, attributes are first defined outside the product types.
Attributes and attribute groups are to be reused from product type to product type.

An attribute can be used to make product variant.

TODO: Best practices:
How to think product types?
How to not have a product type per product?
How to not want a "god" product type trying to cover everything?

TODO: Variants
TODO: attribute value display translation

## Product and product variants

Technically, a product is a content item.

But a variant isn't.

TODO: Continue content VS product VS variant

## Exercise: Bikes and bike parts modeling

Exercise: Think about attributes and content type to sell full bicycles and bicycle parts.

The following is an example of a bicycle feature model sketch.
As you can see, it's a rich and complex matrix.
And it doesn't involve different brands and models for the same feature yet.

- Bicycle:
    - Frameset:
        - Frame:
            - Size: [XS, S, M, L, XL]
            - Shape/Features: [Diamond, Step-through, Diamond w/ suspension, Folding, Recumbent, Cargo, Tandem, …]
            - Material: [Steel, Aluminium, Titanium, Carbon, Wood, Bamboo, Mixed, …]
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
        - Material: [Steel, Aluminium, Titanium, Carbon, Wood, Bamboo, Mixed, …]
        - Type: [Rigid, Suspension, Dropper, …]
        - Attachment: [Quick release, Bolt/nut, Anti-thief, …]
    - Gears:
        - Front gears:
            - Speed count: [1…3]
            - Type: [Single, External, Hub internal, Crank gearbox, …]
            - Control transmission: [Bowden cable, Hydraulic, Electronic, …]
            - Control type: [Lever, Ring, …]
            - Control placement: [Handlebar, Frame, …]
        - Rear gears:
            - Speed count: [1…8]
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
            - Rim material: [Aluminium, Steel, Carbon, …]
            - Tire shape: [City, Race, Mountain, Fat, Mixed, …]
            - Tire insert: [Clincher/Tube, Tubular, Tubeless, Foam, Solid, …]
            - Paint job: […]
        - Front wheel:
            - Same as rear: ☑yes/☐no
            - Axle attachment: [Same as rear, Quick release, Bolt/nut, Thru, Anti-thief, …]
            - Diameter: [Same as rear, 622 mm (road 700C, mountain 29″), 584 mm (road 650B, mountain 27.5″), 559 mm (mountain 26″), 406 mm (mountain 20″), …]
            - Type: [Same as rear, Standard spokes, G3 spokes, Disc, …]
            - Brake: [Same as rear, Caliper, V, Disk, Roller, …]
            - Rim material: [Same as rear, Aluminium, Steel, Carbon, …]
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




Mountain Bike (MTB)
- MTB 4 series
    - Fuji (3776€) (MTBS4-4)
        - Frame: [Diamond, Step-through]
        - TODO
    - Matterhorn (4478€) (MTBS4-5)
    - Annapurna (8091€) (MTBS4-6)
        - Frame: [Diamond w/ suspension]
    - Etna (3369€) (MTBS4-7)
- MTB 5 series
    - Kilimanjaro (5895€) (MTBS5-0)
    - Stádda (1392€) (MTBS5-1)
    - Aconcagua (6960€) (MTBS5-2)
    - Ventoux (1910€) (MTBS5-3)
    - Castor (4225€) (MTBS5-4)


- Create the attribute groups
- Create the attributes
- Create the product types
- Create the products

TODO: Variants
TODO: [Create custom product code generator strategy](create_product_code_generator.md) 

Your new products are in the "Uncategorized products" section of the **Products** admin page.
It's now time to fix this in the next chapter.
