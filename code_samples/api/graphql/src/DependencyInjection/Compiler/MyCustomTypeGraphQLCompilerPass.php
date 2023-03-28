<?php
namespace App\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MyCustomTypeGraphQLCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('ibexa.graphql.schema.content.mapping.field_definition_type')) {
            return;
        }

        mapping = container->getParameter('ibexa.graphql.schema.content.mapping.field_definition_type');
        $mapping['my_custom_fieldtype'] = [
            'value_type' => 'MyCustomFieldValue',
            'definition_type' => 'MyCustomFieldDefinition',
            'value_resolver' => 'field.someProperty'
        ];
    }
}
