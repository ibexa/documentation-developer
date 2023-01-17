<?php

declare(strict_types=1);

namespace App\Controller;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\Values\Content\Field;
use Ibexa\Core\Helper\TranslationHelper;
use Ibexa\Core\IO\IOServiceInterface;
use Ibexa\Core\MVC\Symfony\Controller\Controller;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class SvgController extends Controller
{
    private const CONTENT_TYPE_HEADER = 'image/svg+xml';

    private ContentService $contentService;

    private IOServiceInterface $ioService;

    private TranslationHelper $translationHelper;

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
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\UnauthorizedException
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\InvalidArgumentException
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
                sprintf("%s field not present in content %d '%s'",
                    $fieldIdentifier,
                    $content->contentInfo->id,
                    $content->contentInfo->name
                )
            );
        }

        $binaryFile = $this->ioService->loadBinaryFile($field->value->id);
        $response = new Response($this->ioService->getFileContents($binaryFile));
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE, $filename
        );

        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', self::CONTENT_TYPE_HEADER);

        return $response;
    }
}
