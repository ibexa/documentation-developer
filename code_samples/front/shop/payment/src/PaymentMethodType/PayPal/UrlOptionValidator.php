<?php

declare(strict_types=1);

namespace App\Attribute\PayPal;

use Ibexa\Bundle\ProductCatalog\Validator\Constraints\AttributeDefinitionOptions;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\OptionsFormMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;

final class OptionsValidator implements OptionsValidatorInterface 
{ 
    public function validateOptions(OptionsBag $options): array 
    { 
        $errors = []; 
        if (empty ($options->get('base_url'))) { 
            $errors[] = new OptionsValidatorError ('base_url', 'Base Url should not be blank');
        }

     # ...

    return $errors; 
    }
}
