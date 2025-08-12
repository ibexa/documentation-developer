<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\URLService;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\Repository\Values\URL\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\URL\Query\SortClause;
use Ibexa\Contracts\Core\Repository\Values\URL\URLQuery;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:find_url',
    description: 'Finds all valid URLs in the provided Section.'
)]
class FindUrlCommand extends Command
{
    public function __construct(
        private readonly URLService $urlService,
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $query = new URLQuery();

        $query->filter = new Criterion\LogicalAnd(
            [
                new Criterion\SectionIdentifier(['standard']),
                new Criterion\Validity(true),
            ]
        );
        $query->sortClauses = [
            new SortClause\URL(SortClause::SORT_DESC),
        ];
        $query->offset = 0;
        $query->limit = 25;

        $results = $this->urlService->findUrls($query);

        foreach ($results->items as $result) {
            $output->writeln($result->url);
        }

        return self::SUCCESS;
    }
}
