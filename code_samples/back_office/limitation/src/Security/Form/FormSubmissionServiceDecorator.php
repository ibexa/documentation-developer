<?php declare(strict_types=1);

namespace App\Security;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo;
use Ibexa\Contracts\FormBuilder\FieldType\Model\Form;
use Ibexa\Contracts\FormBuilder\FieldType\Model\FormSubmission;
use Ibexa\Contracts\FormBuilder\FieldType\Model\FormSubmissionList;
use Ibexa\Contracts\FormBuilder\FormSubmission\FormSubmissionServiceInterface;
use Ibexa\Core\Base\Exceptions\NotFoundException;
use Ibexa\Core\Base\Exceptions\UnauthorizedException;
use Ibexa\FormBuilder\FormSubmission\Gateway\FormSubmissionGateway;

class FormSubmissionServiceDecorator implements FormSubmissionServiceInterface
{
    public function __construct(
        readonly FormSubmissionServiceInterface $innerService,
        readonly PermissionResolver $permissionResolver,
        readonly ContentService $contentService,
        readonly FormSubmissionGateway $gateway,
    ) {
    }

    public function create(ContentInfo $content, string $languageCode, Form $form, array $data): FormSubmission
    {
        return $this->innerService->create($content, $languageCode, $form, $data);
    }

    public function loadById(int $id): FormSubmission
    {
        $submissions = $this->gateway->loadById($id); // First manual data fetch

        if (empty($submissions)) {
            throw new NotFoundException('FormSubmission', $id);
        }

        $content = $this->contentService->loadContent($submissions[0]['content_id']);
        if (!$this->permissionResolver->canUser('form', 'read_submissions', $content)) {
            throw new UnauthorizedException('form', 'read_submissions', ['contentId' => $content->getId()]); // Permission check
        }

        return $this->innerService->loadById($id); // Second data fetch through inner service
    }

        // The same permission check pattern is repeated in the methods below

    public function delete(FormSubmission $submission): void
    {
        $submissionId = $submission->getId();
        $submissions = $this->gateway->loadById($submissionId);

        if (empty($submissions)) {
            throw new NotFoundException('FormSubmission', $submissionId);
        }

        $content = $this->contentService->loadContent($submissions[0]['content_id']);
        if (!$this->permissionResolver->canUser('form', 'read_submissions', $content)) {
            throw new UnauthorizedException('form', 'read_submissions', ['contentId' => $content->getId()]);
        }

        $this->innerService->delete($submission);
    }

    public function loadByContent(ContentInfo $content, ?string $languageCode = null, int $offset = 0, int $limit = 25): FormSubmissionList
    {
        if (!$this->permissionResolver->canUser('form', 'read_submissions', $content)) {
            throw new UnauthorizedException('form', 'read_submissions', ['contentId' => $content->getId()]);
        }

        return $this->innerService->loadByContent($content, $languageCode, $offset, $limit);
    }

    public function loadAllByContentForExport(ContentInfo $content, ?string $languageCode = null): array
    {
        if (!$this->permissionResolver->canUser('form', 'read_submissions', $content)) {
            throw new UnauthorizedException('form', 'read_submissions', ['contentId' => $content->getId()]);
        }

        return $this->innerService->loadAllByContentForExport($content, $languageCode);
    }

    public function loadHeaders(ContentInfo $content, ?string $languageCode = null): array
    {
        if (!$this->permissionResolver->canUser('form', 'read_submissions', $content)) {
            throw new UnauthorizedException('form', 'read_submissions', ['contentId' => $content->getId()]);
        }

        return $this->innerService->loadHeaders($content, $languageCode);
    }

    public function getCount(ContentInfo $content, ?string $languageCode = null): int
    {
        if (!$this->permissionResolver->canUser('form', 'read_submissions', $content)) {
            throw new UnauthorizedException('form', 'read_submissions', ['contentId' => $content->getId()]);
        }

        return $this->innerService->getCount($content, $languageCode);
    }
}
