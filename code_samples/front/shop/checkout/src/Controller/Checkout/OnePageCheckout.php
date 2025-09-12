<?php

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

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $stepData = [
                'shipping_method' => [
                    'identifier' => $formData['shipping_method']->getIdentifier(),
                    'name' => $formData['shipping_method']->getName(),
                ],
                'payment_method' => [
                    'identifier' => $formData['payment_method']->getIdentifier(),
                    'name' => $formData['payment_method']->getName(),
                ],
            ];

            return $this->advance($checkout, $step, $stepData);
        }

        return $this->render(
            '@storefront/checkout/checkout.html.twig',
            [
                'form' => $form,
                'checkout' => $checkout,
            ]
        );
    }
}
