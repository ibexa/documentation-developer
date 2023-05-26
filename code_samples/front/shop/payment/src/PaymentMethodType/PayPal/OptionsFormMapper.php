<?php

declare(strict_types=1);

namespace App\Attribute\PayPal;

use Ibexa\Bundle\ProductCatalog\Validator\Constraints\AttributeDefinitionOptions;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\OptionsFormMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;

final class OptionsFormMapper implements OptionsFormMapperInterface 
{ 
    public function createOptionsForm
    ( 
        string $name, 
        FormBuilderInterface $builder, 
        array $context = [] 
    ) : void { 
        $builder->add($name, PayPalOptionsType::class); 
    }
}