<?php

declare(strict_types=1);

namespace App\Controller;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\Values\Content\Field;
use eZ\Publish\Core\Helper\TranslationHelper;
use eZ\Publish\Core\IO\IOServiceInterface;
use eZ\Publish\Core\MVC\Symfony\Controller\Controller;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class SvgController extends Controller
{
    private const CONTENT_TYPE_HEADER = 'image/svg+xml';

    /** @var \eZ\Publish\API\Repository\ContentService */
    private $contentService;

    /** @var \eZ\Publish\Core\IO\IOServiceInterface */
    private $ioService;

    /** @var \eZ\Publish\Core\Helper\TranslationHelper */
    private $translationHelper;

    public function __construct(
        ContentService $contentService,
        IOServiceInterface $ioService,
        TranslationHelper $translationHelper
    ) {
        $this->contentService = $contentService;
        $this->ioService = $ioService;
        $this->translationHelper = $translationHelper;
    }

    /**
     * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     */
    public function downloadSvgAction(
        int $contentId,
        string $fieldIdentifier,
        string $filename,
        Request $request
    ): Response {
        $version = null;

        if ($request->query->has('version')) {
            $version = $request->query->get('version');
        }

        $content = $this->contentService->loadContent($contentId, null, $version);
        $language = $request->query->has('inLanguage') ? $request->query->get('inLanguage') : null;
        $field = $this->translationHelper->getTranslatedField($content, $fieldIdentifier, $language);

        if (!$field instanceof Field) {
            throw new InvalidArgumentException(
                sprintf(
                    "%s field not present in content %d '%s'",
                    $fieldIdentifier,
                    $content->contentInfo->id,
                    $content->contentInfo->name
                )
            );
        }

        $binaryFile = $this->ioService->loadBinaryFile($field->value->id);
        $response = new Response($this->ioService->getFileContents($binaryFile));
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $filename
        );

        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', self::CONTENT_TYPE_HEADER);

        return $response;
    }
}
