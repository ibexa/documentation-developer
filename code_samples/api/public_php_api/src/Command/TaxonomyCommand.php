<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Taxonomy\Service\TaxonomyServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:taxonomy'
)]
class TaxonomyCommand
{
    public function __construct(
        private readonly TaxonomyServiceInterface $taxonomyService,
        private readonly PermissionResolver $permissionResolver,
        private readonly UserService $userService
    ) {
    }

    public function __invoke(OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $allEntries = $this->taxonomyService->loadAllEntries(null, 50);

        $entry = $this->taxonomyService->loadEntryByIdentifier('desks');

        $output->writeln($entry->name . ' with parent ' . $entry->parent->name);

        // Loads first 10 children
        $entryChildren = $this->taxonomyService->loadEntryChildren($entry, 10);

        foreach ($entryChildren as $child) {
            $output->writeln($child->name);
        }

        $entryToMove = $this->taxonomyService->loadEntryByIdentifier('standing_desks');
        $newParent = $this->taxonomyService->loadEntryByIdentifier('desks');

        $this->taxonomyService->moveEntry($entryToMove, $newParent);

        $sibling = $this->taxonomyService->loadEntryByIdentifier('school_desks');
        $this->taxonomyService->moveEntryRelativeToSibling($entryToMove, $sibling, TaxonomyServiceInterface::MOVE_POSITION_PREV);

        return Command::SUCCESS;
    }
}
