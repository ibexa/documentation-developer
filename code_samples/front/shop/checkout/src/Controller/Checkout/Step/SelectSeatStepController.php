<?php

declare(strict_types=1);

namespace App\Controller\Checkout\Step;

use App\Form\Type\SelectSeatType;
use Ibexa\Bundle\Checkout\Controller\AbstractStepController;
use Ibexa\Contracts\Checkout\Value\CheckoutInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SelectSeatStepController extends AbstractStepController
{
    public function __invoke(
        Request $request,
        CheckoutInterface $checkout,
        string $step
    ): Response {
        $form = $this->createStepForm($step, SelectSeatType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->advance($checkout, $step, $form->getData());
        }

        return $this->render(
            '@ibexadesign/checkout/step/select_seat.html.twig',
            [
                'layout' => $this->getSeatsLayout(),
                'current_step' => $step,
                'checkout' => $checkout,
                'form' => $form,
            ]
        );
    }

    private function getSeatsLayout(): array
    {
        return [
            'A' => 'X,X,0,0,1,1,1,1,X,X,X,X',
            'B' => '0,0,X,0,0,1,1,1,1,X,X,X',
            'C' => '1,1,1,1,0,0,0,0,0,0,0,0',
            'D' => '1,1,1,1,0,1,0,0,0,0,0,0',
            'E' => '1,1,1,1,0,1,0,1,0,0,0,0',
            'F' => '1,1,1,1,0,1,1,0,0,1,1,0',
            'G' => '1,1,1,1,1,1,1,1,1,1,1,1',
            'H' => '1,1,1,1,1,1,1,1,1,1,1,1',
            'I' => '1,1,1,1,1,1,1,1,1,1,1,1',
        ];
    }
}
