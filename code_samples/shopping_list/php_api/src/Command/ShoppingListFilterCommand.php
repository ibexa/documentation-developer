<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface;
use Ibexa\Contracts\ShoppingList\Value\EntryAddStruct;
use Ibexa\Contracts\ShoppingList\Value\ShoppingListCreateStruct;
use Ibexa\Contracts\ShoppingList\Value\ShoppingListInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:shopping-list:filter', description: 'Test Shopping List duplicate entry filtering before addition')]
class ShoppingListFilterCommand extends Command
{
    public function __construct(
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver,
        private readonly ShoppingListServiceInterface $shoppingListService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $login = 'admin';
        $desiredProductCodes = ['TODO', 'TODO'];
        $name = 'shopping-list-test-filtering';

        $user = $this->userService->loadUserByLogin($login);
        $this->permissionResolver->setCurrentUserReference($user);

        $list = $this->shoppingListService->createShoppingList(new ShoppingListCreateStruct($name));

        $list = $this->shoppingListService->addEntries($list, [new EntryAddStruct($desiredProductCodes[1])]);

        $filteredProductCodes = array_filter(
            $desiredProductCodes,
            static fn ($productCode): bool => !$list->getEntries()->hasEntryWithProductCode($productCode)
        );
        $list = $this->shoppingListService->addEntries(
            $list,
            array_map(
                static fn ($productCode): EntryAddStruct => new EntryAddStruct($productCode),
                $filteredProductCodes
            )
        );

        $this->displayList($output, $list);

        $this->shoppingListService->deleteShoppingList($list);

        return Command::SUCCESS;
    }

    private function displayList(OutputInterface $output, ShoppingListInterface $list): void
    {
        $output->writeln("{$list->getOwner()->getName()} ({$list->getOwner()->getLogin()})");
        $output->writeln("{$list->getName()} ({$list->getIdentifier()})" . ($list->isDefault() ? ' [default]' : ''));
        $entries = $list->getEntries();
        $output->writeln(count($entries) . (count($entries) > 1 ? ' entries' : ' entry'));
        foreach ($entries as $entry) {
            $output->writeln("- <info>{$entry->getProduct()->getName()} ({$entry->getProduct()->getCode()})</info>");
        }
    }
}
