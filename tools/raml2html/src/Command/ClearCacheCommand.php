<?php

declare(strict_types=1);

namespace EzSystems\Raml2Html\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

final class ClearCacheCommand extends Command
{
    /** @var string */
    private $cacheDir;

    public function __construct(string $cacheDir)
    {
        parent::__construct();

        $this->cacheDir = $cacheDir;
    }

    protected function configure(): void
    {
        $this->setName('cache:clear');
        $this->setDescription('Clears the cache');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $fs = new Filesystem();
        $io = new SymfonyStyle($input, $output);

        try {
            $fs->remove($this->cacheDir);
            $io->success('Cache was successfully cleared.');
        } catch (IOException $e) {
            if ($output->isVerbose()) {
                $io->warning($e->getMessage());
            }
        }
    }
}
