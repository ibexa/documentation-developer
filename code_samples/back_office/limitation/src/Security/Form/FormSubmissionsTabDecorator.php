<?php

namespace App\Security;

use Ibexa\Contracts\AdminUi\Tab\ConditionalTabInterface;
use Ibexa\Contracts\AdminUi\Tab\OrderedTabInterface;
use Ibexa\Contracts\AdminUi\Tab\TabInterface;
use Ibexa\Contracts\Core\Repository\ContentTypeService;
use Ibexa\Contracts\Core\Repository\LanguageService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;
use Ibexa\Contracts\FormBuilder\FormSubmission\FormSubmissionServiceInterface;
use Ibexa\FormBuilder\FieldType\FormFactory;
use Ibexa\FormBuilder\FieldType\Type;
use Ibexa\FormBuilder\Tab\LocationView\SubmissionsTab;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class FormSubmissionsTabDecorator extends SubmissionsTab implements TabInterface, OrderedTabInterface, ConditionalTabInterface
{
    private $innerTab;
    private $permissionResolver;

    public function __construct(
        Environment $twig,
        TranslatorInterface $translator,
        FormSubmissionServiceInterface $formSubmissionService,
        FormFactory $formFactory,
        ContentTypeService $contentTypeService,
        LanguageService $languageService,
        Type $formBuilderType,
        ConfigResolverInterface $configResolver,
        TabInterface $innerTab,
        PermissionResolver $permissionResolver
    ) {
        parent::__construct($twig, $translator, $formSubmissionService, $formFactory, $contentTypeService, $languageService, $formBuilderType, $configResolver);
        $this->innerTab = $innerTab;
        $this->permissionResolver = $permissionResolver;
    }

    public function getIdentifier(): string
    {
        return $this->innerTab->getIdentifier();
    }

    public function getName(): string
    {
        return $this->innerTab->getName();
    }

    public function renderView(array $parameters): string
    {
        return $this->innerTab->renderView($parameters);
    }

    public function evaluate(array $parameters): bool
    {
        /** @var \Ibexa\Contracts\Core\Repository\Values\Content\Content $content */
        $content = $parameters['content'];

        return $this->innerTab->evaluate($parameters) &&
            $this->permissionResolver->canUser('form', 'read_submissions', $content);
    }

    public function getOrder(): int
    {
        return  $this->innerTab->getOrder();
    }
}
