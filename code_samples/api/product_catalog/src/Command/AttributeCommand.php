<?php

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\AttributeDefinitionServiceInterface;
use Ibexa\Contracts\ProductCatalog\Local\LocalAttributeDefinitionServiceInterface;
use Ibexa\Contracts\ProductCatalog\AttributeGroupServiceInterface;
use Ibexa\Contracts\ProductCatalog\Local\LocalAttributeGroupServiceInterface;
use Ibexa\ProductCatalog\Local\Repository\AttributeTypeService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class AttributeCommand extends Command
{
    private $attributeGroupService;

    private $localAttributeGroupService;

    private $attributeDefinitionService;

    private $localAttributeDefinitionService;

    private $attributeTypeService;

    private $userService;

    private $permissionResolver;

    public function __construct(LocalAttributeDefinitionServiceInterface $localAttributeDefinitionService, AttributeDefinitionServiceInterface $attributeDefinitionService, AttributeGroupServiceInterface $attributeGroupService, LocalAttributeGroupServiceInterface $localAttributeGroupService,  AttributeTypeService $attributeTypeService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->localAttributeGroupService = $localAttributeGroupService;
        $this->attributeGroupService = $attributeGroupService;
        $this->attributeTypeService = $attributeTypeService;
        $this->attributeDefinitionService = $attributeDefinitionService;
        $this->localAttributeDefinitionService = $localAttributeDefinitionService;
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;

        parent::__construct("doc:attributes");
    }

    public function configure(): void
    {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $attributeTypes = $this->attributeTypeService->getAttributeTypes();

        foreach ($attributeTypes as $attributeType){
            $output->writeln('Attribute type ' . $attributeType->getIdentifier() . ' with name ' . $attributeType->getName());
        }

        $attributeGroupCreateStruct = $this->localAttributeGroupService->newAttributeGroupCreateStruct('dimensions');
        $attributeGroupCreateStruct->setNames(['eng-GB' => 'Size']);

        $this->localAttributeGroupService->createAttributeGroup($attributeGroupCreateStruct);

        $attributeGroup = $this->attributeGroupService->getAttributeGroup('dimensions');

        $attributeGroupUpdateStruct = $this->localAttributeGroupService->newAttributeGroupUpdateStruct($attributeGroup);
        $attributeGroupUpdateStruct->setNames(['eng-GB' => 'Dimensions']);
        $attributeGroupUpdateStruct->setIdentifier('dimensions');
        $attributeGroupUpdateStruct->setPosition(0);

        $attribute = $this->attributeDefinitionService->getAttributeDefinition('length');
        $output->writeln($attribute->getName());

        $attributeType = $this->attributeTypeService->getAttributeType('checkbox');

        $attributeCreateStruct = $this->localAttributeDefinitionService->newAttributeDefinitionCreateStruct('size');
        $attributeCreateStruct->setType($attributeType);
        $attributeCreateStruct->setName('eng-GB', 'Size');
        $attributeCreateStruct->setGroup($attributeGroup);

        $this->localAttributeDefinitionService->createAttributeDefinition($attributeCreateStruct);

        $this->localAttributeGroupService->updateAttributeGroup($attributeGroup, $attributeGroupUpdateStruct);

        $attributeGroups = $this->attributeGroupService->findAttributeGroups();

        foreach ($attributeGroups as $attributeGroup){
            $output->writeln('Attribute group ' . $attributeGroup->getIdentifier() . ' with name ' . $attributeGroup->getName());
        }

        return self::SUCCESS;
    }
}
