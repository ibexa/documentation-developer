<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\FormBuilder\FormSubmission\FormSubmissionServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'doc:form-submission'
)]
final class FormSubmissionCommand extends Command
{
    private UserService $userService;

    private PermissionResolver $permissionResolver;

    private FormSubmissionServiceInterface $formSubmissionService;

    private ContentService $contentService;

    public function __construct(UserService $userService, PermissionResolver $permissionResolver, FormSubmissionServiceInterface $formSubmissionService, ContentService $contentService)
    {
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;
        $this->formSubmissionService = $formSubmissionService;
        $this->contentService = $contentService;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $content = $this->contentService->loadContent(143);
        $contentInfo = $content->contentInfo;

        $formValue = $content->getFieldValue('form', 'eng-GB')->getFormValue();
        $data = [
            ['id' => 7, 'identifier' => 'single_line', 'name' => 'Line', 'value' => 'The name'],
            ['id' => 8, 'identifier' => 'number', 'name' => 'Number', 'value' => 123],
            ['id' => 9, 'identifier' => 'checkbox', 'name' => 'Checkbox', 'value' => 0],
        ];

        $this->formSubmissionService->create(
            $contentInfo,
            'eng-GB',
            $formValue,
            $data
        );

        $submissions = $this->formSubmissionService->loadByContent($contentInfo);

        $output->writeln('Total number of submissions: ' . $submissions->getTotalCount());
        foreach ($submissions as $sub) {
            $output->write($sub->getId() . '. submitted on ');
            $output->write($sub->getCreated()->format('Y-m-d H:i:s') . ' by ');
            $output->writeln((string) $this->userService->loadUser($sub->getUserId())->getName());
            foreach ($sub->getValues() as $value) {
                $output->writeln('- ' . $value->getIdentifier() . ': ' . $value->getDisplayValue());
            }
        }

        $submission = $this->formSubmissionService->loadById(29);
        $this->formSubmissionService->delete($submission);

        return self::SUCCESS;
    }
}
