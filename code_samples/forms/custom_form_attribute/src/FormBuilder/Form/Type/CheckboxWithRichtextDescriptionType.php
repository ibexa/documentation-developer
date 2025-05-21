<?php declare(strict_types=1);

namespace App\FormBuilder\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckboxWithRichtextDescriptionType extends AbstractType
{
    /**
     * @return string|null
     */
    public function getParent(): ?string
    {
        return CheckboxType::class;
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'checkbox_with_richtext_description';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'richtext_description' => '',
        ]);
        $resolver->setAllowedTypes('richtext_description', ['null', 'string']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        // pass the Dom object of the richtext doc to the template
        $dom = new \DOMDocument();
        if (!empty($options['richtext_description'])) {
            $dom->loadXML($options['richtext_description']);
        }
        $view->vars['richtextDescription'] = $dom;
    }
}
