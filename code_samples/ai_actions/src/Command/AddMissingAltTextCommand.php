<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\ConnectorAi\ActionService;
use Ibexa\Contracts\ConnectorAi\Action\ActionContext;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Image;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Text;
use Ibexa\Contracts\ConnectorAi\Action\GenerateAltTextAction;
use Ibexa\Contracts\ConnectorAi\Action\RuntimeContext;
use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\FieldTypeService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\ContentTypeIdentifier;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\DateMetadata;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Operator;
use Ibexa\Contracts\Core\Repository\Values\Filter\Filter;
use Ibexa\Core\FieldType\Image\Value;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class AddMissingAltTextCommand extends Command
{
    protected static $defaultName = 'add-alt-text';

    private ContentService $contentService;

    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private FieldTypeService $fieldTypeService;

    private ActionService $actionService;

    private string $projectDir;

    public function __construct(
        ContentService $contentService,
        PermissionResolver $permissionResolver,
        UserService $userService,
        FieldTypeService $fieldTypeService,
        ActionService $actionService,
        string $projectDir
    ) {
        parent::__construct();
        $this->contentService = $contentService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;
        $this->fieldTypeService = $fieldTypeService;
        $this->actionService = $actionService;
        $this->projectDir = $projectDir;
    }

    protected function configure(): void
    {
        $this->addArgument('user', InputArgument::OPTIONAL, 'Login of the user executing the actions', 'admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $input->getArgument('user');

        $this->permissionResolver->setCurrentUserReference($this->userService->loadUserByLogin($user));

        // Find all Images modified in the last 24h
        $filter = (new Filter())
            ->withCriterion(
                new DateMetadata(DateMetadata::MODIFIED, Operator::GTE, strtotime('-1 day'))
            )
            ->andWithCriterion(new ContentTypeIdentifier('image'));

        $modifiedArticles = $this->contentService->find($filter);

        $output->writeln(sprintf('Found %d modified image in the last 24h', $modifiedArticles->getTotalCount()));

        /** @var \Ibexa\Core\Repository\Values\Content\Content $content */
        foreach ($modifiedArticles as $content) {
            $imageFieldIdentifier = 'image';
            $field = $this->fieldTypeService->getFieldType('ezimage');
            /** @var ?Value $value */
            $value = $content->getFieldValue($imageFieldIdentifier);

            if ($value === null || $this->fieldTypeService->getFieldType('ezimage')->isEmptyValue($value) || !$value->isAlternativeTextEmpty()) {
                $output->writeln(sprintf('Image %s has the image field empty or the alternative text is already specified. Skipping.', $content->getName()));
                continue;
            }

            $output->writeln(sprintf('Preparing alternative text for Image %s', $content->getName()));

            $contentUpdateStruct = $this->contentService->newContentUpdateStruct();
            $altText = $this->getSuggestedAltText($this->convertImageToBase64($value->uri));
            $output->writeln(['Suggestion: ', $altText]);
            $value->alternativeText = $altText;
            $contentUpdateStruct->setField('image', $value);

            $updatedContent = $this->contentService->updateContent(
                $this->contentService->createContentDraft($content->getContentInfo())->getVersionInfo(),
                $contentUpdateStruct
            );
            $this->contentService->publishVersion($updatedContent->getVersionInfo());
        }

        return Command::SUCCESS;
    }

    private function getSuggestedAltText(string $base64): string
    {
        $action = new GenerateAltTextAction(new Image([$base64]));
        // there should be an implementation of Options in the Contracts
        $action->setActionContext(
            new ActionContext(
                new RuntimeContext([]),
                new RuntimeContext([]),
                new RuntimeContext(
                    [
                        'prompt' => 'Mention Terry Pratchett in the description',
                        'temperature' => 1.0,
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

    private function convertImageToBase64(?string $uri): string
    {
        $file = file_get_contents($this->projectDir . \DIRECTORY_SEPARATOR . 'public' . \DIRECTORY_SEPARATOR . $uri);
        if ($file === false) {
            throw new \RuntimeException('Cannot read file');
        }

        return 'data:image/jpeg;base64,' . base64_encode($file);
    }
}
