<?php declare(strict_types=1);

namespace App\Twig\Component;

use Ibexa\Contracts\TwigComponents\Attribute\AsTwigComponent;
use Ibexa\Contracts\TwigComponents\ComponentInterface;

#[AsTwigComponent(
    group: 'admin-ui-dashboard-all-tab-groups',
    priority: 100
)]
final class MyComponent implements ComponentInterface
{
    public function render(array $parameters = []): string
    {
        return 'Hello world!';
    }
}
