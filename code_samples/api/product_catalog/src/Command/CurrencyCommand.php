<?php

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\Values\Currency\CurrencyCreateStruct;
use Ibexa\Contracts\ProductCatalog\Values\Currency\CurrencyUpdateStruct;
use Ibexa\Contracts\ProductCatalog\CurrencyServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CurrencyCommand extends Command
{
    private $currencyService;

    private $userService;

    private $permissionResolver;

    public function __construct(CurrencyServiceInterface $currencyService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->currencyService = $currencyService;

        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;

        parent::__construct("doc:currency");
    }

    public function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('currencyCode', InputArgument::REQUIRED, 'Currency code'),
                new InputArgument('newCurrencyCode', InputArgument::REQUIRED, 'New currency code')
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $currencyCode = $input->getArgument('currencyCode');
        $newCurrencyCode = $input->getArgument('newCurrencyCode');

        $currency = $this->currencyService->findCurrencyByCode($currencyCode);
        $output->writeln('Currency ID: ' . $currency->getId());

        $currencies = $this->currencyService->findCurrencies();

        foreach ($currencies as $currency) {
            $output->writeln('Currency ' . $currency->getId() . ' with code ' . $currency->getCode());
        }
        
        $id = $this->currencyService->findCurrencyByCode($currencyCode)->getId();

        $currencyUpdateStruct = new CurrencyUpdateStruct($id);
        $currencyUpdateStruct->setCode('MOD');
        $currencyUpdateStruct->setSubunits(2);

        $this->currencyService->updateCurrency($currencyUpdateStruct);

        $currencyCreateStruct = new CurrencyCreateStruct($newCurrencyCode, 2, true);

        $this->currencyService->createCurrency($currencyCreateStruct);

        return self::SUCCESS;
    }
}
