<?php

namespace App;

use App\Security\MyPolicyProvider;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container): void
    {
        // Retrieve "ezpublish" container extension
        $eZExtension = $container->getExtension('ezpublish');
        // Add the policy provider
        $eZExtension->addPolicyProvider(new MyPolicyProvider());
    }
}
