<?php declare(strict_types=1);

namespace App\Discounts\Step;

use Ibexa\Contracts\Discounts\Admin\Form\Data\AbstractDiscountStep;

final class CustomStep extends AbstractDiscountStep
{
    public const IDENTIFIER = 'custom';

    public ?string $data = null;

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(?string $data): void
    {
        $this->data = $data;
    }
}
