<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\LanguageService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'doc:add_language', description: 'Lists available languages and add Polish.')]
class AddLanguageCommand extends Command
{
    private LanguageService $languageService;

    private UserService $userService;

    private PermissionResolver $permissionResolver;

    public function __construct(LanguageService $languageService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->languageService = $languageService;
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $languageList = $this->languageService->loadLanguages();

        foreach ($languageList as $language) {
            $output->writeln($language->languageCode . ': ' . $language->name);
        }

        $languageCreateStruct = $this->languageService->newLanguageCreateStruct();
        $languageCreateStruct->languageCode = 'pol-PL';
        $languageCreateStruct->name = 'Polish';
        $this->languageService->createLanguage($languageCreateStruct);
        $output->writeln('Added language Polish with language code pol-PL.');

        return self::SUCCESS;
    }
}
