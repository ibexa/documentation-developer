<?php declare(strict_types=1);

namespace App\shopping_list\php_api\src\Command;

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

#[AsCommand(name: 'app:shopping-list:move', description: 'Test move entries between shopping lists')]
class ShoppingListMoveCommand extends Command
{
    public function __construct(
        private UserService $userService,
        private PermissionResolver $permissionResolver,
        private ShoppingListServiceInterface $shoppingListService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $login = 'admin';
        $productCodes = ['TODO', 'TODO'];
        $movedProductCodes = $productCodes;
        $prefix = 'shopping-list-test';

        $user = $this->userService->loadUserByLogin($login);
        $this->permissionResolver->setCurrentUserReference($user);

        $sourceList = $this->shoppingListService->createShoppingList(new ShoppingListCreateStruct($prefix . '-source'));
        $targetList = $this->shoppingListService->createShoppingList(new ShoppingListCreateStruct($prefix . '-target'));

        $sourceList = $this->shoppingListService->addEntries($sourceList, [new EntryAddStruct($productCodes[0]), new EntryAddStruct($productCodes[1])]);
        $targetList = $this->shoppingListService->addEntries($targetList, [new EntryAddStruct($productCodes[1])]);

        $entriesToMove = [];
        $entriesToRemove = [];
        foreach ($movedProductCodes as $productCode) {
            if ($sourceList->getEntries()->hasEntryWithProductCode($productCode)) {
                if ($targetList->getEntries()->hasEntryWithProductCode($productCode)) {
                    $entriesToRemove[] = $sourceList->getEntries()->getEntryWithProductCode($productCode);
                } else {
                    $entriesToMove[] = $sourceList->getEntries()->getEntryWithProductCode($productCode);
                }
            }
        }
        $this->shoppingListService->moveEntries($targetList, $entriesToMove);
        $targetList = $this->shoppingListService->getShoppingList($targetList->getIdentifier()); // Refresh local object from persistence
        $sourceList = $this->shoppingListService->removeEntries($sourceList, $entriesToRemove); // Refresh local object from persistence even if $entriesToRemove is empty

        $this->displayList($output, $sourceList);
        $this->displayList($output, $targetList);

        $this->shoppingListService->deleteShoppingList($sourceList);
        $this->shoppingListService->deleteShoppingList($targetList);

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
