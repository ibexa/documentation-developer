# Creating custom Field Type

Ograniczony wybor, nie daje mozliwosc rozwijanie przez to, ze sa w corze
Money, Language, Currency, Birth Day

Generic Field Type is used as a template for any Field Type you would like to create. It makes creation process faster and easier. 
Generic Field Type comes with the implementation of basic methods, reduces the number of classes which must be created and simplifies tagging process during the creation of custom Field Type.


Bazowa implementacja, ktora wykorzystuje Symfony serializer, symfony validator component

!!! tip

    Generic Field Type should not be used when a very specific implementation is needed.
    Nie uzywac kiedy potrzebujesz scislej kontrali nad tym jak dane sa przechowywane/prezystowane
    
Generic Field Type to bazowa implementacja dla niestandardowych typów pól upraszczająca proces do niezbędnego minimum:

Zdefiniowania VO
Zdefiniowania formularza dla VO z pkt. 1
Definicji pola + konfiguracja w YAMLu
Twig z blokiem renderującego wartośc pola
Przykładowy typ pola reprezentujący punkt w dwuwymiarowej przestrzeni:

## Value Object np punkt 2D - stworzenie punktu/zdefiniowanie klasy

0. Katalog FieldType w src a w nim katalog Point2D na swojej clean installation in your project - baza
1. Stworzyc klase Value z atrybutami/polami x i y, ktore reprezentuja wspolrzedne Value.php - konwencja klasa powinna nazywac sie "Value"

## Definicja FT 
666
class Point2D extends 

2. Implementacja definicji Field Type extends Generic Field Type
dodac nowa klase w services.yaml `App\Type`

```yaml
App\FieldType\Point2D\Type:
    tags:
        - { name: ezplatform.field_type, alias: point2d }
```

## Formularz do edycji FT (jest maly, mozna dolozyc do tej klasy)

3. Formularz stworzyc w katalogu src/Form/Type tam dodac klase Point2DType (extends abstractType, zaimplementowac BuildForm)
Wazne: metoda BuildForm dodaje pola, w ktore bedzie sie wprowadzac wspolrzedne x i y
Pozwala uniknac implementacji Data Transformera, 
ustawic opcje data class na Value::class

- dodac do definicji FT, dodajemy interfejs FieldValueFormMappperInterface (\EzSystems\RepositoryForms\FieldType\FieldValueFormMapperInterface)

- do formularza edycji tresci dodajemy pole pozwalajace wprowadzic wartosc dla naszego FT

- dodac kolejny tag do definicji serwisu: ` - { name: ezplatform.field_type.form_mapper.value, fieldType: point2d }`

## Widok dla wartosci FT

4. W katalogu templates tworzymy plik `field_type.html.twig`
w srodku tworzymy blok 

```twig
{% block point2d_field %}
    ({{ field.value.getX() }}, {{ field.value.getY() }})
{% endblock %}
```

dodac do konfiguracji config/packages/ezplatform.yaml

pod ezpublish.system.default: 

```yaml
field_templates:
    - { template: 'field_type.html.twig', priority: 0 }
```

## Publikujemy

5. Tylko klianie

## Value Validation

Generic Field Type uses `symfony/validator` component to validate field values.
As shown in the example for the simple cases annotations could be used to define constraints.

In more advanced cases like validation based on the field definition, the `eZ/Publish/SPI/FieldType/Generic/Type::getFieldValueConstraints` method has to be overridden.

```php
 protected function getFieldValueConstraints(FieldDefinition $fieldDefinition): ?Assert\Collection 
 { 
     return null; 
 } 
```

## Settings Validation

Generic Field Type is also using `symfony/validator` component to validate field settings. To do so the `eZ/Publish/SPI/FieldType/Generic/Type::getFieldSettingsConstraints` method has to be overridden. 

[Symfony documentation](https://symfony.com/doc/4.3/validation/raw_values.html)

For example:

```php
namespace AppBundle\FieldType\Point2D;

// ... 
use eZ\Publish\SPI\FieldType\Generic\Type as GenericType;
use Symfony\Component\Validator\Constraints as Assert;
// ... 

final class Type extends GenericType
{
    protected $settingsSchema = [
        'format' => [
            'default' => "%f"
        ],
    ];

    // ... 

    protected function getFieldSettingsConstraints(): ?Assert\Collection
    {
        return new Assert\Collection([
            'format' => [
                new Assert\NotBlank()
            ]
        ]);
    }
}
```

## Storage Converter

If `eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\CnType then `eZ\Publish\Core\FieldType\Generic\Converter` will be used as storage converter.

Internally the field definition / value are serialized to JSON format using `symfony/serializer` component and stored in `data_text`/`data_text5` columns.


Jeśli użytkownik nie zdefiniowano jawnie konwertera (implementacji eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter) zostanie użyty domyślny konwerter.

Wartość pola i ustawienia przechowywane są w formacie JSON odpowiednio w kolumnach data_text/data_text5, gdzie do serializacji wykorzystywany jest komponent Serializer (https://symfony.com/doc/current/components/serializer.html).

Wartość pola i ustawienia walidatowane są przy wykorzystawniu komponentu Validator (https://symfony.com/doc/current/components/validator.html).