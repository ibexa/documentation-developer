<?php declare(strict_types=1);

namespace App\src\Command;

use App\src\Event\MyFeatureEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DispatchMyFeatureEventCommand extends Command
{
    protected static $defaultName = 'app:test:throw-my-feature-event';

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct(self::$defaultName);
        $this->eventDispatcher = $eventDispatcher;
    }

    protected function configure(): void
    {
        $this->setDescription('Throw/Dispatch a MyFeatureEvent');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $event = new MyFeatureEvent((object) ['id' => 123], 'simulate');
        $this->eventDispatcher->dispatch($event);

        return Command::SUCCESS;
    }
}
