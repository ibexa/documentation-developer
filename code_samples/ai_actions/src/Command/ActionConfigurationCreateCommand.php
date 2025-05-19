<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\ConnectorAi\Action\DataType\Text;
use Ibexa\Contracts\ConnectorAi\Action\RefineTextAction;
use Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationCreateStruct;
use Ibexa\Contracts\ConnectorAi\ActionConfigurationServiceInterface;
use Ibexa\Contracts\ConnectorAi\ActionServiceInterface;
use Ibexa\Contracts\ConnectorAi\ActionType\ActionTypeRegistryInterface;
use Ibexa\Contracts\Core\Collection\ArrayMap;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:action-configuration-create'
)]
final class ActionConfigurationCreateCommand extends Command
{
    private ActionConfigurationServiceInterface $actionConfigurationService;

    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private ActionServiceInterface $actionService;

    private ActionTypeRegistryInterface $actionTypeRegistry;

    public function __construct(
        ActionConfigurationServiceInterface $actionConfigurationService,
        PermissionResolver $permissionResolver,
        UserService $userService,
        ActionServiceInterface $actionService,
        ActionTypeRegistryInterface $actionTypeRegistry
    ) {
        $this->actionConfigurationService = $actionConfigurationService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;
        $this->actionService = $actionService;
        $this->actionTypeRegistry = $actionTypeRegistry;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('user', InputArgument::OPTIONAL, 'Login of the user executing the actions', 'admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $input->getArgument('user');
        $this->permissionResolver->setCurrentUserReference($this->userService->loadUserByLogin($user));

        $refineTextActionType = $this->actionTypeRegistry->getActionType('refine_text');

        $actionConfigurationCreateStruct = new ActionConfigurationCreateStruct('rewrite_casual');

        $actionConfigurationCreateStruct->setType($refineTextActionType);
        $actionConfigurationCreateStruct->setName('eng-GB', 'Rewrite in casual tone');
        $actionConfigurationCreateStruct->setDescription('eng-GB', 'Rewrites the text using a casual tone');
        $actionConfigurationCreateStruct->setActionHandler('openai-text-to-text');
        $actionConfigurationCreateStruct->setActionHandlerOptions(new ArrayMap([
            'max_tokens' => 4000,
            'temperature' => 1,
            'prompt' => 'Rewrite this content to improve readability. Preserve meaning and crucial information but use casual language accessible to a broader audience.',
            'model' => 'gpt-4-turbo',
        ]));
        $actionConfigurationCreateStruct->setEnabled(true);

        $this->actionConfigurationService->createActionConfiguration($actionConfigurationCreateStruct);

        $action = new RefineTextAction(new Text([
<<<TEXT
Proteins differ from one another primarily in their sequence of amino acids, which is dictated by the nucleotide sequence of their genes, 
and which usually results in protein folding into a specific 3D structure that determines its activity.
TEXT
        ]));
        $actionConfiguration = $this->actionConfigurationService->getActionConfiguration('rewrite_casual');
        $actionResponse = $this->actionService->execute($action, $actionConfiguration)->getOutput();

        assert($actionResponse instanceof Text);

        $output->writeln($actionResponse->getText());

        return Command::SUCCESS;
    }
}
