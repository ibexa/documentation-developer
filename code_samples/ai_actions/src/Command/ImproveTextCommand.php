<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\ConnectorAi\ActionService;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Text;
use Ibexa\Contracts\ConnectorAi\Action\RefineTextAction;
use Ibexa\Contracts\ConnectorAi\ActionConfigurationServiceInterface;
use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\FieldTypeRichText\RichText\Converter;
use Ibexa\FieldTypeRichText\FieldType\RichText\Value;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImproveTextCommand extends Command
{
    protected static $defaultName = 'improve-text';

    private ContentService $contentService;

    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private ActionService $actionService;

    private const SIMPLE_RICHTEXT_XML = '<?xml version="1.0" encoding="UTF-8"?>
<section xmlns="http://docbook.org/ns/docbook" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:ezxhtml="http://ibexa.co/xmlns/dxp/docbook/xhtml" xmlns:ezcustom="http://ibexa.co/xmlns/dxp/docbook/custom" version="5.0-variant ezpublish-1.0">
<title ezxhtml:level="2">%s</title>
</section>';

    private ActionConfigurationServiceInterface $actionConfigurationService;

    private Converter $richTextConverter;

    public function __construct(
        ContentService $contentService,
        PermissionResolver $permissionResolver,
        UserService $userService,
        ActionService $actionService,
        ActionConfigurationServiceInterface $actionConfigurationService,
        Converter $richTextConverter
    ) {
        parent::__construct();
        $this->contentService = $contentService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;
        $this->actionService = $actionService;
        $this->actionConfigurationService = $actionConfigurationService;
        $this->richTextConverter = $richTextConverter;
    }

    protected function configure(): void
    {
        $this->addArgument('user', InputArgument::OPTIONAL, 'Login of the user executing the actions', 'admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $input->getArgument('user');

        $this->permissionResolver->setCurrentUserReference($this->userService->loadUserByLogin($user));

        $content = $this->contentService->loadContent(1);
        $output->writeln(sprintf('Refining text for: %s', $content->getName()));

        $contentUpdateStruct = $this->contentService->newContentUpdateStruct();
        /** @var \Ibexa\FieldTypeRichText\FieldType\RichText\Value $fieldValue */
        $fieldValue = $content->getFieldValue('short_description');
        $newText = $this->getRefinedText($this->xmlToPlainText($fieldValue));
        $contentUpdateStruct->setField('short_description', $newText);

        $updatedContent = $this->contentService->updateContent(
            $this->contentService->createContentDraft($content->getContentInfo())->getVersionInfo(),
            $contentUpdateStruct
        );
        $this->contentService->publishVersion($updatedContent->getVersionInfo());

        return Command::SUCCESS;
    }

    private function getRefinedText(string $text): Value
    {
        $action = new RefineTextAction(new Text([$text]));
        $actionConfiguration = $this->actionConfigurationService->getActionConfiguration('mention_kittens');
        $output = $this->actionService->execute($action, $actionConfiguration)->getOutput();

        assert($output instanceof Text);

        $text = sprintf(self::SIMPLE_RICHTEXT_XML, $output->getText());

        return new Value($text);
    }

    public function xmlToPlainText(Value $value): string
    {
        $html = $this->richTextConverter->convert($value->xml)->saveHTML();

        if ($html === false) {
            throw new \RuntimeException('Failure converting text');
        }

        return strip_tags($html);
    }
}
