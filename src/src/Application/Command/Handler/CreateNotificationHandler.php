<?php
declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\Impl\BatchNotificationCommand;
use App\Application\Command\Impl\CreateNotificationCommand;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateNotificationHandler
{
    public function __construct(
        private MessageBusInterface $commandBus,
    ) {}

    public function __invoke(CreateNotificationCommand $command): void
    {
        $this->commandBus->dispatch(new BatchNotificationCommand($command->dto, null));
    }
}
