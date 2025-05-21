<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\ConnectorAi\Action\ActionContext;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Image;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Text;
use Ibexa\Contracts\ConnectorAi\Action\GenerateAltTextAction;
use Ibexa\Contracts\ConnectorAi\Action\RuntimeContext;
use Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationOptions;
use Ibexa\Contracts\ConnectorAi\ActionServiceInterface;
use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\FieldTypeService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\Repository\Values\Content\ContentList;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\ContentTypeIdentifier;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\DateMetadata;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Operator;
use Ibexa\Contracts\Core\Repository\Values\Filter\Filter;
use Ibexa\Core\FieldType\Image\Value;
use Ibexa\Core\IO\IOBinarydataHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:add-alt-text',
)]
final class AddMissingAltTextCommand extends Command
{
    private const IMAGE_FIELD_IDENTIFIER = 'image';

    private ContentService $contentService;

    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private FieldTypeService $fieldTypeService;

    private ActionServiceInterface $actionService;

    private IOBinarydataHandler $binaryDataHandler;

    public function __construct(
        ContentService $contentService,
        PermissionResolver $permissionResolver,
        UserService $userService,
        FieldTypeService $fieldTypeService,
        ActionServiceInterface $actionService,
        IOBinarydataHandler $binaryDataHandler
    ) {
        $this->contentService = $contentService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;
        $this->fieldTypeService = $fieldTypeService;
        $this->actionService = $actionService;
        $this->binaryDataHandler = $binaryDataHandler;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('user', InputArgument::OPTIONAL, 'Login of the user executing the actions', 'admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->setUser($input->getArgument('user'));

        $modifiedImages = $this->getModifiedImages();
        $output->writeln(sprintf('Found %d modified image in the last 24h', $modifiedImages->getTotalCount()));

        /** @var \Ibexa\Contracts\Core\Repository\Values\Content\Content $content */
        foreach ($modifiedImages as $content) {
            /** @var \Ibexa\Core\FieldType\Image\Value $value */
            $value = $content->getFieldValue(self::IMAGE_FIELD_IDENTIFIER);

            if ($value === null || !$this->shouldGenerateAltText($value)) {
                $output->writeln(sprintf('Image %s has the image field empty, the file cannot be accessed, or the alternative text is already specified. Skipping.', $content->getName()));
                continue;
            }

            $contentUpdateStruct = $this->contentService->newContentUpdateStruct();
            $value->alternativeText = $this->getSuggestedAltText($this->convertImageToBase64($value->uri), $content->getDefaultLanguageCode());
            $contentUpdateStruct->setField(self::IMAGE_FIELD_IDENTIFIER, $value);

            $updatedContent = $this->contentService->updateContent(
                $this->contentService->createContentDraft($content->getContentInfo())->getVersionInfo(),
                $contentUpdateStruct
            );
            $this->contentService->publishVersion($updatedContent->getVersionInfo());
        }

        return Command::SUCCESS;
    }

    private function getSuggestedAltText(string $imageEncodedInBase64, string $languageCode): string
    {
        $action = new GenerateAltTextAction(new Image([$imageEncodedInBase64]));

        $action->setRuntimeContext(new RuntimeContext(['languageCode' => $languageCode]));
        $action->setActionContext(
            new ActionContext(
                new ActionConfigurationOptions(['default_locale_fallback' => 'en']), // System context
                new ActionConfigurationOptions(['max_lenght' => 100]), // Action Type options
                new ActionConfigurationOptions( // Action Handler options
                    [
                        'prompt' => 'Generate the alt text for this image in less than 100 characters.',
                        'temperature' => 0.7,
                        'max_tokens' => 4096,
                        'model' => 'gpt-4o-mini',
                    ]
                )
            )
        );

        $output = $this->actionService->execute($action)->getOutput();

        assert($output instanceof Text);

        return $output->getText();
    }

    private function convertImageToBase64(string $uri): string
    {
        $id = $this->binaryDataHandler->getIdFromUri($uri);
        $file = $this->binaryDataHandler->getContents($id);

        return 'data:image/jpeg;base64,' . base64_encode($file);
    }

    private function getModifiedImages(): ContentList
    {
        $filter = (new Filter())
            ->withCriterion(
                new DateMetadata(DateMetadata::MODIFIED, Operator::GTE, strtotime('-1 day'))
            )
        ->andWithCriterion(new ContentTypeIdentifier('image'));

        return $this->contentService->find($filter);
    }

    /** @phpstan-assert-if-true string $value->uri */
    private function shouldGenerateAltText(Value $value): bool
    {
        return $this->fieldTypeService->getFieldType('ezimage')->isEmptyValue($value) === false &&
            $value->isAlternativeTextEmpty() &&
            $value->uri !== null;
    }

    private function setUser(string $userLogin): void
    {
        $this->permissionResolver->setCurrentUserReference($this->userService->loadUserByLogin($userLogin));
    }
}
