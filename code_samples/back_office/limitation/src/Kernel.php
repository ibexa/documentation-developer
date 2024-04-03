<?php

declare(strict_types=1);

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
        // Retrieve "ibexa" container extension
        /** @var \Ibexa\Bundle\Core\DependencyInjection\IbexaCoreExtension $IbexaExtension */
        $ibexaExtension = $container->getExtension('ibexa');
        // Add the policy provider
        $ibexaExtension->addPolicyProvider(new MyPolicyProvider());
    }
}
