<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\CurrencyServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Currency\CurrencyCreateStruct;
use Ibexa\Contracts\ProductCatalog\Values\Currency\CurrencyUpdateStruct;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:currency'
)]
final class CurrencyCommand extends Command
{
    private CurrencyServiceInterface $currencyService;

    private UserService $userService;

    private PermissionResolver $permissionResolver;

    public function __construct(CurrencyServiceInterface $currencyService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->currencyService = $currencyService;
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;

        parent::__construct();
    }

    public function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('currencyCode', InputArgument::REQUIRED, 'Currency code'),
                new InputArgument('newCurrencyCode', InputArgument::REQUIRED, 'New currency code'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $currencyCode = $input->getArgument('currencyCode');
        $newCurrencyCode = $input->getArgument('newCurrencyCode');

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

        $currencyCreateStruct = new CurrencyCreateStruct($newCurrencyCode, 2, true);

        $this->currencyService->createCurrency($currencyCreateStruct);

        return self::SUCCESS;
    }
}
