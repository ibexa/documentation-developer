<?php declare(strict_types=1);

namespace App\Command;

use eZ\Publish\API\Repository\LanguageService;
use eZ\Publish\API\Repository\PermissionResolver;
use eZ\Publish\API\Repository\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddLanguageCommand extends Command
{
    private $languageService;

    private $userService;

    private $permissionResolver;

    public function __construct(LanguageService $languageService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->languageService = $languageService;
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;
        parent::__construct('doc:add_language');
    }

    protected function configure()
    {
        $this->setDescription('Lists available languages and add Polish.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
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
