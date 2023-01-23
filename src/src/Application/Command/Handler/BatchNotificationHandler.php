<?php
declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\Impl\BatchNotificationCommand;
use App\Application\Command\Impl\SendNotificationCommand;
use App\Domain\Repository\CustomerRepository;
use Symfony\Component\Messenger\MessageBusInterface;

class BatchNotificationHandler
{
    public function __construct(
        private readonly CustomerRepository $repository,
        private readonly MessageBusInterface $commandBus,
    ) {}

    public function __invoke(BatchNotificationCommand $command): void
    {
        $customers = $this->repository->findManyFromCursor($command->cursor);
        $lastCustomer = $customers->last();
        foreach ($customers as $customer) {
            $this->commandBus->dispatch(new SendNotificationCommand($command->dto->toValueObject(), $customer));
        }
        if ($lastCustomer) {
            $this->commandBus->dispatch(new BatchNotificationCommand($command->dto, $lastCustomer->id));
        }
    }
}
