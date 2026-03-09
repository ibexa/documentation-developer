<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentTypeService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\AttributeDefinitionServiceInterface;
use Ibexa\Contracts\ProductCatalog\Local\LocalProductTypeServiceInterface;
use Ibexa\Contracts\ProductCatalog\Local\Values\ProductType\AssignAttributeDefinitionStruct;
use Ibexa\Contracts\ProductCatalog\ProductTypeServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:product_type'
)]
final class ProductTypeCommand extends Command
{
    public function __construct(
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver,
        private readonly ProductTypeServiceInterface $productTypeService,
        private readonly LocalProductTypeServiceInterface $localProductTypeService,
        private readonly ContentTypeService $contentTypeService,
        private readonly AttributeDefinitionServiceInterface $attributeDefinitionService
    ) {
        parent::__construct('doc:product_type');
    }

    public function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('productTypeIdentifier', InputArgument::REQUIRED, 'Product type identifier'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $productTypeIdentifier = $input->getArgument('productTypeIdentifier');

        $productTypeCreateStruct = $this->localProductTypeService->newProductTypeCreateStruct(
            'digital_product',
            'eng-GB'
        );

        $productTypeCreateStruct->setNames([
            'eng-GB' => 'Digital Product',
            'pol-PL' => 'Produkt Cyfrowy',
        ]);

        $productTypeCreateStruct->setVirtual(true);

        $contentTypeCreateStruct = $productTypeCreateStruct->getContentTypeCreateStruct();

        $marketingDescriptionFieldDefinition = $this->contentTypeService->newFieldDefinitionCreateStruct(
            'marketing_description',
            'ibexa_string'
        );
        $marketingDescriptionFieldDefinition->names = ['eng-GB' => 'Marketing Description'];
        $marketingDescriptionFieldDefinition->position = 100;
        $contentTypeCreateStruct->addFieldDefinition($marketingDescriptionFieldDefinition);

        $sizeAttribute = $this->attributeDefinitionService->getAttributeDefinition('size');

        $attributeAssignment = new AssignAttributeDefinitionStruct(
            $sizeAttribute,
            false,
            false
        );

        $productTypeCreateStruct->setAssignedAttributesDefinitions([$attributeAssignment]);

        $newProductType = $this->localProductTypeService->createProductType($productTypeCreateStruct);

        $productType = $this->productTypeService->getProductType($productTypeIdentifier);

        $output->writeln($productType->getName());

        $productTypes = $this->productTypeService->findProductTypes();

        foreach ($productTypes as $productType) {
            $output->writeln($productType->getName() . ' with identifier ' . $productType->getIdentifier());
        }

        return self::SUCCESS;
    }
}
