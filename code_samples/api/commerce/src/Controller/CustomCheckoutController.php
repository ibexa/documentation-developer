<?php

declare(strict_types=1);

namespace App\Controller;

use Ibexa\Bundle\Core\Controller;
use Ibexa\Contracts\Cart\CartServiceInterface;
use Ibexa\Contracts\Checkout\CheckoutServiceInterface;

class CustomCheckoutController extends Controller
{
    private CartServiceInterface $cartService;

    private CheckoutServiceInterface $checkoutService;

    public function __construct(CartServiceInterface $cartService, CheckoutServiceInterface $checkoutService)
    {
        $this->cartService = $cartService;
        $this->checkoutService = $checkoutService;
    }

    public function showContentAction(): Response
    {
        // Get checkout for a specific cart
        $cart = $this->cartService->getCart('d7424b64-7dc1-474c-82c8-1700f860d55e');

        $checkoutForCart = $this->checkoutService->getCheckoutForCart($cart);
        $checkoutIdentifier = $checkoutForCart->getIdentifier();

        // Get checkout by checkout ID
        $checkout = $this->checkoutService->getCheckout($checkoutIdentifier);

        // Create a new checkout
        $newCart = $this->cartService->getCart('1844450e-61da-4814-8d82-9301a3df0054');

        $checkoutCreateStruct = $this->checkoutService->newCheckoutCreateStruct($newCart);
        $newCheckout = $this->checkoutService->createCheckout($checkoutCreateStruct);

        $newCheckoutIdentifier = $newCheckout->getIdentifier();

        // Update a checkout
        $checkoutUpdateStruct = $this->checkoutService->newCheckoutUpdateStruct('select_address');
        $this->checkoutService->updateCheckout($newCheckout, $checkoutUpdateStruct);

        // Delete a checkout
        $this->checkoutService->deleteCheckout($newCheckout);

        return $this->render('custom_checkout.html.twig', [
            'checkout_id' => $checkoutIdentifier,
            'new_checkout_id' => $newCheckoutIdentifier,
        ]);
    }
}
