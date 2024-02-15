<?php declare(strict_types=1);

namespace App\Command;

use App\Event\MyFeatureEvent;
use App\MyFeature\MyFeature;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DispatchMyFeatureEventCommand extends Command
{
    protected static $defaultName = 'app:test:throw-my-feature-event';

    protected static $defaultDescription = 'Throw/Dispatch a MyFeatureEvent';

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $event = new MyFeatureEvent(new MyFeature(['id' => 123, 'name' => 'Logged Name']), 'simulate');
        $this->eventDispatcher->dispatch($event);

        $event = new MyFeatureEvent((object) ['id' => 456, 'name' => 'Some Name'], 'simulate');
        $this->eventDispatcher->dispatch($event);

        return Command::SUCCESS;
    }
}
