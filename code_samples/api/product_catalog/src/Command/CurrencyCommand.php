<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\CurrencyServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Currency\CurrencyCreateStruct;
use Ibexa\Contracts\ProductCatalog\Values\Currency\CurrencyUpdateStruct;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:currency'
)]
final readonly class CurrencyCommand
{
    public function __construct(
        private CurrencyServiceInterface $currencyService,
        private UserService $userService,
        private PermissionResolver $permissionResolver
    ) {
    }

    public function __invoke(
        OutputInterface $output,
        #[Argument(description: 'Currency code')] string $currencyCode,
        #[Argument(description: 'New currency code')] string $newCurrencyCode
    ): int {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $currency = $this->currencyService->getCurrencyByCode($currencyCode);
        $output->writeln('Currency ID: ' . $currency->getId());

        $currencies = $this->currencyService->findCurrencies();

        foreach ($currencies as $currency) {
            $output->writeln('Currency ' . $currency->getId() . ' with code ' . $currency->getCode());
        }

        $currencyUpdateStruct = new CurrencyUpdateStruct();
        $currencyUpdateStruct->setCode('MOD');
        $currencyUpdateStruct->setSubunits(4);

        $this->currencyService->updateCurrency($currency, $currencyUpdateStruct);

        assert($newCurrencyCode !== '', 'Currency code cannot be empty');
        $currencyCreateStruct = new CurrencyCreateStruct($newCurrencyCode, 2, true);

        $this->currencyService->createCurrency($currencyCreateStruct);

        return Command::SUCCESS;
    }
}
