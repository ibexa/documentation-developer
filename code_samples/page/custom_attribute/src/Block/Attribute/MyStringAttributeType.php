<?php declare(strict_types=1);

namespace App\Block\Attribute;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MyStringAttributeType extends AbstractType
{
    public function getParent(): ?string
    {
        return TextType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'my_string_attribute';
    }
}
