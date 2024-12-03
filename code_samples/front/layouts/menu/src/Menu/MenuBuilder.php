<?php declare(strict_types=1);

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    private FactoryInterface $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function buildMenu(): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Home', ['route' => 'ibexa.url.alias', 'routeParameters' => [
            'locationId' => 2,
        ]]);
        $menu->addChild('Blog', ['route' => 'ibexa.url.alias', 'routeParameters' => [
            'locationId' => 67,
        ]]);
        $menu->addChild('Search', ['route' => 'ibexa.search']);

        return $menu;
    }
}
