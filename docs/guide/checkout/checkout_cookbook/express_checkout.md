# Express checkout

You can implement an express checkout functionality with a custom controller.

The following example:

- Checks if a user is logged in (to get address data)
- Copies the current basket in order to finish it
- Sets the state to `ordered`
- Removes the original basket

The controller displays a confirmation page after finishing the order.
The logic respects the fact that the ERP is not available and in this case a lost order process is initiated. 

``` php
<?php

class expressCheckout
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function orderAction(Request $request)
    {
        /** @var CustomerProfileDataServiceInterface $customerProfileDataService */
        $customerProfileDataService = $this->getCustomerProfileDataService();
        $customerProfileData = $customerProfileDataService->getCustomerProfileData();
        if ($customerProfileData->sesUser->isAnonymous) {
            throw new AccessDeniedException();
        }

        /** @var BasketService $basketService */
        $basketService = $this->getBasketService();
        /** @var TransService $transService */
        $transService = $this->getTransService();
        $basketEvent = $basketService->getBasketByUserId(
            $customerProfileData->sesUser->sesUserObjectId,
            BasketService::TYPE_BASKET,
            BasketService::STATE_NEW
        );

        if ($request->getMethod() === 'POST') {
            $postData = $request->request->all();
            $errors = false;
            // DATA Validations
            if (!isset($postData['terms_and_conditions']) || (!$postData['terms_and_conditions'])) {
                $basketEvent->setErrorMessage($transService->translate('Please accept our terms and conditions before you proceed with your order'));
                $errors = true;
            }

            //SUBMIT Process
            if (!$errors){
                /** @var  AbstractErpService $erpService */
                $erpService = $this->get('silver_erp.facade');

                /** @var EntityManagerInterface $entityManager */
                $entityManager = $this->get('doctrine.orm.entity_manager');

                $basketEvent->addToDataMap($request->getLocale(), 'locale');
                try {
                    $copiedBasket = $basketService->copyBasket($basketEvent);
                    $guidService = $this->get('silver_basket.guid_service');

                    $copiedBasket->setGuid($guidService->createGuid($basketEvent));
                    $copiedBasket->setState(BasketService::STATE_PAYED);

                    //Set the emails should be before the su
                    $customerProfileEmail = $customerProfileData->sesUser->email;
                    $copiedBasket->setConfirmationEmail($customerProfileEmail);

                    //Get the sales confirmation email from the checkoutBundle
                    /** @var SummaryCheckoutFormService $checkoutFormSummary */
                    $checkoutFormSummary = $this->get('siso_checkout.checkout_form.summary');
                    $salesConfirmationEmail = $checkoutFormSummary->getSalesEmailForOrderConfirmation($copiedBasket);
                    $copiedBasket->setSalesConfirmationEmail($salesConfirmationEmail);

                    //After set the values the information should be stored
                    $entityManager->persist($copiedBasket);
                    $entityManager->flush();

                    /** @var OrderResponse $orderResponse */
                    $orderResponse = $erpService->submitOrder($copiedBasket);

                    //Change the status of the copy of the basket to confirmed
                    if ($orderResponse !== null) {
                        $copiedBasket->setErpOrderId($orderResponse->SalesOrderID->value);
                        $copiedBasket->setState(BasketService::STATE_CONFIRMED);

                        //Store the information in the database
                        $entityManager->persist($copiedBasket);
                        $entityManager->flush();
                    }
                    //It should render the confirmation template even if it is a lost order
                    if ($basketEvent instanceof Basket) {
                        $basketService->removeBasket($basketEvent);
                        $basketEvent = $copiedBasket;
                    }
                    return $this->render(
                        'MyBundle:checkout:order_confirmation.html.twig',
                        array(
                            'basket' => $basketEvent,
                            'type' =>   $this->basketTypeEvent,
                        ));
                }
                catch (\Exception $e) {
                }
            }
        }

        //Default info
        return $this->render(
            'MyBundle:checkout:show_basket.html.twig',
            array(
                'basket' => $basketEvent,
                'type' =>   BasketService::TYPE_BASKET,,
                'error' => $basketEvent->getErrorMessages(),
                'success' => $basketEvent->getSuccessMessages(),
                'notice' => $basketEvent->getNoticeMessages()
            )
        );
    }
}
```
