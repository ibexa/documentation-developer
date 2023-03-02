<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Form\Type\OnePageCheckoutType;
use Ibexa\Bundle\Checkout\Controller\AbstractStepController;
use Ibexa\Contracts\Checkout\Value\CheckoutInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class OnePageCheckout extends AbstractStepController
{
    public function __invoke(
        Request $request,
        CheckoutInterface $checkout,
        string $step
    ): Response {
        $form = $this->createForm(
            OnePageCheckoutType::class,
            $checkout->getContext()->toArray(),
            [
                'cart' => $this->getCart($checkout->getCartIdentifier()),
            ]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->advance($checkout, $step, $form->getData());
        }

        return $this->render(
            '@ibexadesign/storefront/checkout.html.twig',
            [
                'form' => $form->createView(),
                'checkout' => $checkout,
            ]
        );
    }
}
