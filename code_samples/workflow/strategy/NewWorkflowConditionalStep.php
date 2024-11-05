<?php

declare(strict_types=1);

namespace App\Checkout\Workflow\Strategy;

use Ibexa\Checkout\Value\Workflow\Workflow;
use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Checkout\Value\Workflow\WorkflowInterface;
use Ibexa\Contracts\Checkout\Workflow\WorkflowStrategyInterface;

final class NewWorkflowConditionalStep implements WorkflowStrategyInterface
{
    private const IDENTIFIER = 'new_workflow';

    public function getWorkflow(CartInterface $cart): WorkflowInterface
    {
        return new Workflow(self::IDENTIFIER, 'conditional_step_name');
    }

    public function supports(CartInterface $cart): bool
    {
        return $cart->getCurrency()->getCode() === 'EUR';
    }
}
