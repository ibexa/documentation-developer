<?php 

declare(strict_types=1);

namespace App\Security;

use Ibexa\Bundle\Core\DependencyInjection\Security\PolicyProvider\YamlPolicyProvider;

class MyPolicyProvider extends YamlPolicyProvider
{
    /** @returns string[] */
    protected function getFiles(): array
    {
        return [
            __DIR__ . '/../Resources/config/policies.yaml',
        ];
    }
}
