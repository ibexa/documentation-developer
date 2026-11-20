<?php

declare(strict_types=1);

namespace App;

use App\Security\FormPolicyProvider;
use App\Security\MyPolicyProvider;
use Ibexa\Bundle\Core\DependencyInjection\IbexaCoreExtension;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container): void
    {
        // Retrieve "ibexa" container extension
        /** @var IbexaCoreExtension $ibexaExtension */
        $ibexaExtension = $container->getExtension('ibexa');

        // Add the policy provider, you can register multiple providers by calling the method repeatedly
        $ibexaExtension->addPolicyProvider(new FormPolicyProvider());
        $ibexaExtension->addPolicyProvider(new MyPolicyProvider());
    }
}
