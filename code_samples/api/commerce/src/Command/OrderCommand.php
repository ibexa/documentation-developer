<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ibexa\Contracts\OrderManagement\OrderServiceInterface;
use Ibexa\Contracts\OrderManagement\Value\OrderQuery;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\CompanyNameCriterion;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\CustomerNameCriterion;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\IdentifierCriterion;
use Ibexa\Contracts\ProductCatalog\Values\Common\Query\Criterion\LogicalOr;
use Ibexa\Contracts\OrderManagement\Value\OrderCreateStruct;
use Ibexa\Contracts\OrderManagement\Value\OrderUpdateStruct;
use Ibexa\Contracts\Security\Permission\PermissionResolver;
use Ibexa\Contracts\Security\User\UserService;

final class OrderCommand extends Command 
{
    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private OrderServiceInterface $orderService;

    public function __construct(
        PermissionResolver $permissionResolver,
        UserService $userService
        OrderServiceInterface $orderService,
    ) {
        $this->orderService = $orderService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;

        parent::__construct('doc:order');
    }

    public function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currentUser = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($currentUser);

        // Get order by identifier
        $orderIdentifier = '4ac4b8a0-eed8-496d-87d9-32a960a10629';
        $order = $this->orderService->getOrderByIdentifier($orderIdentifier);

        $output->writeln(sprintf('Order has status %s', $orderIdentifier, $order->getStatus()));

        // Get order by id
        $orderId = 1;
        $order = $this->orderService->getOrder($orderId);


        $output->writeln(sprintf('Order %d has status %s', $orderId, $order->getStatus()));

        // Create order
        $orderCreateStruct = new OrderCreateStruct();

            // Set properties of $orderCreateStruct here
        
        $order = $this->orderService->createOrder($orderCreateStruct);
        
        $output->writeln(sprintf('Created order with identifier %s', $order->getIdentifier()));

        // Update order
        $orderUpdateStruct = new OrderUpdateStruct();
        $orderUpdateStruct->setStatus('processed');
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
    }
}
