<?php

declare(strict_types=1);

namespace App\Menu\Builder;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Base class for all facet based menus.
 *
 * @template TOptions array<string, mixed>
 */
abstract class AbstractFacetsMenuBuilder
{
    public function __construct(
        protected readonly FactoryInterface $itemFactory,
        protected readonly RequestStack $requestStack
    ) {
    }

    /**
     * @param array<string, mixed> $options
     */
    final public function build(array $options): ItemInterface
    {
        $menu = $this->itemFactory->createItem('root');
        $this->doBuild($menu, $this->resolveOptions($options));

        return $menu;
    }

    /**
     * @param TOptions $options
     */
    abstract protected function doBuild(ItemInterface $menu, array $options): void;

    protected function configureOptions(OptionsResolver $resolver): void
    {
        // No options
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return TOptions
     */
    private function resolveOptions(array $options): array
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        /** @var TOptions */
        return $resolver->resolve($options);
    }
}
