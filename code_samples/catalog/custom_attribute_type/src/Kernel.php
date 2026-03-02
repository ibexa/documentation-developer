<?php declare(strict_types=1);

namespace App;

use App\DependencyInjection\AddFloatStorageDefinitionTag;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new AddFloatStorageDefinitionTag(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 10);
    }
}
