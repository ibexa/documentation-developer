<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Mcp\McpServerConfigurationRegistryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:mcp:server_list', description: 'List MCP servers')]
class McpServerListCommand
{
    public function __construct(private readonly McpServerConfigurationRegistryInterface $configRegistry)
    {
    }

    public function __invoke(SymfonyStyle $io): int
    {
        foreach($this->configRegistry->getServerConfigurations() as $serverConfiguration) {
            $io->title($serverConfiguration->identifier);
            dump($serverConfiguration);
        }

        return Command::SUCCESS;
    }
}
