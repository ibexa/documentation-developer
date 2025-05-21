<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Workflow\Registry\WorkflowRegistryInterface;
use Ibexa\Contracts\Workflow\Service\WorkflowServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'doc:workflow', description: 'Starts content in the selected workflow and makes the provided transition.')]
class WorkflowCommand extends Command
{
    private WorkflowServiceInterface $workflowService;

    private WorkflowRegistryInterface $workflowRegistry;

    private ContentService $contentService;

    public function __construct(WorkflowServiceInterface $workflowService, WorkflowRegistryInterface $workflowRegistry, ContentService $contentService)
    {
        $this->contentService = $contentService;
        $this->workflowService = $workflowService;
        $this->workflowRegistry = $workflowRegistry;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('contentId', InputArgument::REQUIRED, 'Content ID'),
                new InputArgument('workflowName', InputArgument::REQUIRED, 'Workflow identifier'),
                new InputArgument('transitionName', InputArgument::REQUIRED, 'Transition name'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $contentId = (int) $input->getArgument('contentId');
        $workflowName = $input->getArgument('workflowName');
        $transitionName = $input->getArgument('transitionName');

        $content = $this->contentService->loadContent($contentId);

        $supportedWorkflows = $this->workflowRegistry->getSupportedWorkflows($content);
        foreach ($supportedWorkflows as $supportedWorkflow) {
            $output->writeln('Supports workflow: ' . $supportedWorkflow->getName());
        }

        $this->workflowService->start($content, $workflowName);
        $workflowMetadata = $this->workflowService->loadWorkflowMetadataForContent($content, $workflowName);

        foreach ($workflowMetadata->markings as $marking) {
            $output->writeln($content->getName() . ' is in stage ' . $marking->name . ' in workflow ' . $workflowMetadata->workflow->getName());
        }

        if ($this->workflowService->can($workflowMetadata, $transitionName)) {
            $workflow = $this->workflowRegistry->getWorkflow($workflowName);
            $workflow->apply($workflowMetadata->content, $transitionName, ['message' => 'done', 'reviewerId' => 14]);
            $output->writeln('Moved ' . $content->getName() . ' through transition ' . $transitionName);
        }

        return self::SUCCESS;
    }
}
