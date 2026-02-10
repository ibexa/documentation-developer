<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Controller;

use App\Collaboration\Cart\CartSessionCreateStruct;
use App\Collaboration\Cart\CartSessionType;
use App\Form\Type\ShareCartType;
use Ibexa\Contracts\Cart\CartResolverInterface;
use Ibexa\Contracts\Collaboration\Participant\ExternalParticipantCreateStruct;
use Ibexa\Contracts\Collaboration\SessionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/shared-cart/create', name: 'app.shared_cart.create')]
final class ShareCartCreateController extends AbstractController
{
    public function __construct(
        private SessionServiceInterface $sessionService,
        private CartResolverInterface $cartResolver
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(
            ShareCartType::class,
            null,
            [
                'method' => 'POST',
            ]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Form\Data\ShareCartData $data */
            $data = $form->getData();

            // Handle the form submission
            $cart = $this->cartResolver->resolveCart();

            $session = $this->sessionService->createSession(
                new CartSessionCreateStruct($cart)
            );

            $this->sessionService->addParticipant(
                $session,
                new ExternalParticipantCreateStruct(
                    $data->getEmail(),
                    CartSessionType::SCOPE_EDIT
                )
            );

            return $this->render(
                '@ibexadesign/cart/share_result.html.twig',
                [
                    'session' => $session,
                ]
            );
        }

        return $this->render(
            '@ibexadesign/cart/share.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
