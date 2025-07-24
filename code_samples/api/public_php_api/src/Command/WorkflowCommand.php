<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Workflow\Registry\WorkflowRegistryInterface;
use Ibexa\Contracts\Workflow\Service\WorkflowServiceInterface;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:workflow',
    description: 'Starts content in the selected workflow and makes the provided transition.'
)]
class WorkflowCommand
{
    public function __construct(
        private readonly WorkflowServiceInterface $workflowService,
        private readonly WorkflowRegistryInterface $workflowRegistry,
        private readonly ContentService $contentService
    ) {
    }

    public function __invoke(
        OutputInterface $output,
        #[Argument(description: 'Content ID')] int $contentId,
        #[Argument(description: 'Workflow identifier')] string $workflowName,
        #[Argument(description: 'Transition name')] string $transitionName
    ): int {
        $contentId = (int) $contentId;
        $workflowName = $workflowName;
        $transitionName = $transitionName;

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

        return Command::SUCCESS;
    }
}
