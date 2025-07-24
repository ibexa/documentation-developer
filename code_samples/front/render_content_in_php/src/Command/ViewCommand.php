<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Core\MVC\Symfony\View\Builder\ContentViewBuilder;
use Ibexa\Core\MVC\Symfony\View\Renderer\TemplateRenderer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:view',
    description: 'Render the view of a content item'
)]
class ViewCommand
{
    public function __construct(private readonly ContentViewBuilder $contentViewBuilder, private readonly TemplateRenderer $templateRenderer)
    {
    }

    public function __invoke(
        #[Option] int $content_id,
        #[Option] int $location_id,
        #[Option] string $view_type,
        OutputInterface $output
    ): int {
        $contentId = $content_id;
        $locationId = $location_id;
        if (empty($contentId) && empty($locationId)) {
            throw new \InvalidArgumentException('No Content ID nor Location ID given');
        }

        $viewParameters = [
            'viewType' => $view_type,
            '_controller' => 'ibexa_content:viewAction',
        ];

        if (!empty($locationId)) {
            $viewParameters['locationId'] = $locationId;
        }
        if (!empty($contentId)) {
            $viewParameters['contentId'] = $contentId;
        }

        // build view
        $contentView = $this->contentViewBuilder->buildView($viewParameters);

        // render view
        $renderedView = $this->templateRenderer->render($contentView);

        $output->writeln($renderedView);

        return 0;
    }
}
