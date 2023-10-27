<?php

namespace App\Security;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Security\PolicyProvider\YamlPolicyProvider;

class MyPolicyProvider extends YamlPolicyProvider
{
    protected function getFiles()
    {
        return [
            __DIR__ . '/../Resources/config/policies.yaml',
        ];
    }
}
