<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\SiteContext\BrandContextAssignmentServiceInterface;
use Ibexa\Contracts\SiteContext\BrandContextServiceInterface;
use Ibexa\Contracts\SiteContext\Values\BrandContext\Assignment\AssignmentCreateStruct;
use Ibexa\Contracts\SiteContext\Values\BrandContext\BrandContextQuery;
use Ibexa\Contracts\SiteContext\Values\BrandContext\Query\Criterion\NameCriterion;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'doc:brand_context:manage')]
final class ManageBrandContextCommand extends Command
{
    public function __construct(
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver,
        private readonly BrandContextServiceInterface $brandContextService,
        private readonly BrandContextAssignmentServiceInterface $assignmentService
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $this->permissionResolver->setCurrentUserReference(
            $this->userService->loadUserByLogin('admin')
        );

        // Create a brand context
        $createStruct = $this->brandContextService->newBrandContextCreateStruct('carotella');
        $createStruct->setName('eng-GB', 'Carotella');
        $createStruct->setDescription('eng-GB', 'Organic vegetable products for home cooks and professional kitchens');
        $createStruct->setLogo('ezcontent://57');
        $createStruct->setColor('#E8730C');
        $createStruct->setRegion('Europe');
        $createStruct->setAttributeValue('tagline', 'Fresh from the field', 'eng-GB');
        $createStruct->setAttributeValue('persona_definition', 'A friendly farmer who knows good food', 'eng-GB');

        $brandContext = $this->brandContextService->createBrandContext($createStruct);

        // Assign websites to the brand context
        $this->assignmentService->setAssignments($brandContext->getId(), [
            new AssignmentCreateStruct('carotella'),
            new AssignmentCreateStruct('carotella_pro'),
        ]);

        // Update the brand context
        $updateStruct = $this->brandContextService->newBrandContextUpdateStruct($brandContext);
        $updateStruct->setAttributeValue('tagline', 'Fresh from our fields', 'eng-GB');

        $brandContext = $this->brandContextService->updateBrandContext($brandContext, $updateStruct);

        // Find brand contexts
        $brandContexts = $this->brandContextService->findBrandContexts(
            new BrandContextQuery(new NameCriterion('Caro'), 0, 10)
        );

        foreach ($brandContexts as $foundBrandContext) {
            $output->writeln($foundBrandContext->getIdentifier() . ': ' . $foundBrandContext->getName());
        }

        // Get a brand context and its attribute values
        $brandContext = $this->brandContextService->getBrandContext('carotella', ['eng-GB']);

        $output->writeln($brandContext->getAttributeValue('tagline', 'eng-GB')?->getValue());

        // Get the brand context of a website
        $assignment = $this->assignmentService->resolveContextForSiteAccess('carotella_pro');
        if ($assignment !== null) {
            $output->writeln('carotella_pro belongs to the brand context with ID ' . $assignment->getContextId());
        }

        return self::SUCCESS;
    }
}
