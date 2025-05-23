<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Calendar;
use Ibexa\Contracts\Calendar\CalendarServiceInterface;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Scheduler\Calendar\EventAction\RescheduleEventActionContext;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'doc:calendar', description: 'Lists Calendar event in the provided time range and reschedules them.')]
class CalendarCommand extends Command
{
    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private CalendarServiceInterface $calendarService;

    public function __construct(PermissionResolver $permissionResolver, UserService $userService, CalendarServiceInterface $calendarService)
    {
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;
        $this->calendarService = $calendarService;

        parent::__construct();
    }

    public function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $dateFrom = new \DateTimeImmutable('2023-01-01T10:00:00+00:00');
        $dateTo = new \DateTimeImmutable('2023-12-31T10:0:00+00:00');
        $dateRange = new Calendar\DateRange($dateFrom, $dateTo);

        $eventQuery = new Calendar\EventQuery($dateRange, 10);

        $eventList = $this->calendarService->getEvents($eventQuery);

        foreach ($eventList as $event) {
            $output->writeln($event->getName() . '; date: ' . $event->getDateTime()->format('T Y-m-d H:i:s'));
        }

        $eventCollection = $eventList->getEvents();
        $output->writeln('First event: ' . $eventCollection->first()->getName() . '; date: ' . $eventCollection->first()->getDateTime()->format('T Y-m-d H:i:s'));

        $newCollection = $eventCollection->slice(3, 5);
        foreach ($newCollection as $event) {
            $output->writeln('New collection: ' . $event->getName() . '; date: ' . $event->getDateTime()->format('T Y-m-d H:i:s'));
        }

        $newDate = new \DateTimeImmutable('2023-12-06T13:00:00+00:00');
        $context = new RescheduleEventActionContext($eventCollection, $newDate);

        $this->calendarService->executeAction($context);

        return self::SUCCESS;
    }
}
