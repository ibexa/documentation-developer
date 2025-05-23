<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Core\MVC\Symfony\View\Builder\ContentViewBuilder;
use Ibexa\Core\MVC\Symfony\View\Renderer\TemplateRenderer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:view', description: 'Render the view of a content item')]
class ViewCommand extends Command
{
    private ContentViewBuilder $contentViewBuilder;

    private TemplateRenderer $templateRenderer;

    public function __construct(
        ContentViewBuilder $contentViewBuilder,
        TemplateRenderer $templateRenderer
    ) {
        $this->contentViewBuilder = $contentViewBuilder;
        $this->templateRenderer = $templateRenderer;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('content-id', 'c', InputOption::VALUE_OPTIONAL, 'Content ID')
            ->addOption('location-id', 'l', InputOption::VALUE_OPTIONAL, 'Location ID')
            ->addOption('view-type', 't', InputOption::VALUE_OPTIONAL, 'View Type', 'line');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $contentId = $input->getOption('content-id');
        $locationId = $input->getOption('location-id');
        if (empty($contentId) && empty($locationId)) {
            throw new \InvalidArgumentException('No Content ID nor Location ID given');
        }

        $viewParameters = [
            'viewType' => $input->getOption('view-type'),
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
