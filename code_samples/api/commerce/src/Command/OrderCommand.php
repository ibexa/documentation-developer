<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\CoreSearch\Values\Query\Criterion\LogicalOr;
use Ibexa\Contracts\OrderManagement\OrderServiceInterface;
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\CompanyNameCriterion;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\CustomerNameCriterion;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\IdentifierCriterion;
use Ibexa\Contracts\OrderManagement\Value\OrderCurrency;
use Ibexa\Contracts\OrderManagement\Value\OrderItem;
use Ibexa\Contracts\OrderManagement\Value\OrderItemProduct;
use Ibexa\Contracts\OrderManagement\Value\OrderItemValue;
use Ibexa\Contracts\OrderManagement\Value\OrderUser;
use Ibexa\Contracts\OrderManagement\Value\OrderValue;
use Ibexa\Contracts\OrderManagement\Value\Struct\OrderCreateStruct;
use Ibexa\Contracts\OrderManagement\Value\Struct\OrderUpdateStruct;
use Money;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:order'
)]
final class OrderCommand extends Command
{
    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private OrderServiceInterface $orderService;

    public function __construct(
        PermissionResolver $permissionResolver,
        UserService $userService,
        OrderServiceInterface $orderService
    ) {
        $this->orderService = $orderService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;

        parent::__construct();
    }

    public function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $currentUser = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($currentUser);

        // Get order by identifier
        $orderIdentifier = '2e897b31-0d7a-46d3-ba45-4eb65fe02790';
        $order = $this->orderService->getOrderByIdentifier($orderIdentifier);

        $output->writeln(sprintf('Order %s has status %s', $orderIdentifier, $order->getStatus()));

        // Get order by id
        $orderId = 1;
        $order = $this->orderService->getOrder($orderId);

        $output->writeln(sprintf('Order %d has status %s', $orderId, $order->getStatus()));

        // OrderCreateStruct parameters
        $items = [
            new OrderItem(
                10,
                new OrderItemValue(
                    new Money\Money(12, new Money\Currency('EUR')),
                    new Money\Money(10, new Money\Currency('EUR')),
                    '12',
                    new Money\Money(24, new Money\Currency('EUR')),
                    new Money\Money(20, new Money\Currency('EUR')),
                ),
                new OrderItemProduct(
                    1,
                    'desk1',
                    'Desk 1'
                )
            ),
            ];

        $value = new OrderValue(
            new Money\Money(20, new Money\Currency('EUR')),
            new Money\Money(120, new Money\Currency('EUR')),
            new Money\Money(100, new Money\Currency('EUR')),
        );

        $user = new OrderUser(14, 'johndoe', 'jd@example.com');
        $currency = new OrderCurrency(1, 'EUR');

        // Create order
        $orderCreateStruct = new OrderCreateStruct(
            $user,
            $currency,
            $value,
            'local_shop',
            $items
        );

        $order = $this->orderService->createOrder($orderCreateStruct);

        $output->writeln(sprintf('Created order with identifier %s', $order->getIdentifier()));

        // Update order
        $orderUpdateStruct = new OrderUpdateStruct('processed');
        $this->orderService->updateOrder($order, $orderUpdateStruct);

        $output->writeln(sprintf('Changed order status to %s', $order->getStatus()));

        // Query for orders
        $orderCriterions = [
            new IdentifierCriterion('c328773e-8daa-4465-86d5-4d7890f3aa86'),
            new CompanyNameCriterion('IBM'),
            new CustomerNameCriterion('foo_user'),
        ];
        $orderQuery = new OrderQuery(new LogicalOr(...$orderCriterions));
        $orders = $this->orderService->findOrders($orderQuery);

        $output->writeln(sprintf('Found %d orders with provided criteria', count($orders)));

        return self::SUCCESS;
    }
}
