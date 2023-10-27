<?php declare(strict_types=1);

namespace App\Command;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\PermissionResolver;
use eZ\Publish\API\Repository\UserService;
use EzSystems\EzPlatformFormBuilder\FormSubmission\FormSubmissionServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class FormSubmissionCommand extends Command
{
    private $userService;

    private $permissionResolver;

    private $formSubmissionService;

    private $contentService;

    public function __construct(UserService $userService, PermissionResolver $permissionResolver, FormSubmissionServiceInterface $formSubmissionService, ContentService $contentService)
    {
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;
        $this->formSubmissionService = $formSubmissionService;
        $this->contentService = $contentService;

        parent::__construct('doc:form-submission');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $content = $this->contentService->loadContent(143);
        $contentInfo = $content->contentInfo;

        $formValue = $content->getFieldValue('form', 'eng-GB')->getFormValue();
        $data = [
            ['identifier' => 'single_line', 'name' => 'Line', 'value' => 'The name'],
            ['identifier' => 'number', 'name' => 'Number', 'value' => 123],
            ['identifier' => 'checkbox', 'name' => 'Checkbox', 'value' => 0],
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
            $output->writeln($this->userService->loadUser($sub->getUserId())->getName());
            foreach ($sub->getValues() as $value) {
                $output->writeln('- ' . $value->getIdentifier() . ': ' . $value->getDisplayValue());
            }
        }

        $submission = $this->formSubmissionService->loadById(29);
        $this->formSubmissionService->delete($submission);

        return self::SUCCESS;
    }
}
