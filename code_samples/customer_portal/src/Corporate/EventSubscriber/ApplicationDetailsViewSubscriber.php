<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Corporate\EventSubscriber;

use App\Corporate\Form\VerifyType;
use Ibexa\Bundle\CorporateAccount\EventSubscriber\AbstractViewSubscriber;
use Ibexa\Core\MVC\Symfony\SiteAccess\SiteAccessServiceInterface;
use Ibexa\Core\MVC\Symfony\View\View;
use Ibexa\CorporateAccount\View\ApplicationDetailsView;
use Symfony\Component\Form\FormFactoryInterface;

final class ApplicationDetailsViewSubscriber extends AbstractViewSubscriber
{
    private FormFactoryInterface $formFactory;

    public function __construct(
        SiteAccessServiceInterface $siteAccessService,
        FormFactoryInterface $formFactory
    ) {
        parent::__construct($siteAccessService);

        $this->formFactory = $formFactory;
    }

    /**
     * @param \Ibexa\CorporateAccount\View\ApplicationDetailsView $view
     */
    protected function configureView(View $view): void
    {
        $application = $view->getApplication();

        $view->addParameters([
            'verify_form' => $this->formFactory->create(
                VerifyType::class, [
                    'application' => $application->getId()
                ]
            )->createView(),
        ]);
    }

    protected function supports(View $view): bool
    {
        return $view instanceof ApplicationDetailsView;
    }
}
