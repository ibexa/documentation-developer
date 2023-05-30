<?php

declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Form\Type\SinglePageCheckoutType;
use Ibexa\Bundle\Checkout\Controller\AbstractStepController;
use Ibexa\Contracts\Checkout\Value\CheckoutInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SinglePageCheckout extends AbstractStepController
{
    public function __invoke(
        Request $request,
        CheckoutInterface $checkout,
        string $step
    ): Response {
        $form = $this->createForm(
            SinglePageCheckoutType::class,
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
            '@ibexadesign/checkout/checkout.html.twig',
            [
                'form' => $form->createView(),
                'checkout' => $checkout,
            ]
        );
    }
}
