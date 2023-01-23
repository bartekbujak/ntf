<?php
declare(strict_types=1);

namespace App\Tests\Unit\Domain\Strategy;

use App\Domain\Entity\Customer;
use App\Domain\Exception\NotificationSendFailed;
use App\Domain\Service\ChannelProvider;
use App\Domain\Service\ChannelProviderCollection;
use App\Domain\Service\Tracker;
use App\Domain\Strategy\AllAvailableProviderStrategy;
use App\Domain\ValueObject\FullName;
use App\Domain\ValueObject\Language;
use App\Domain\ValueObject\NotificationTranslation;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class AllAvailableProviderStrategyTest extends TestCase
{
    public function testExecute()
    {
        $firstNotAvailableProvider = $this->createMock(ChannelProvider::class);
        $firstNotAvailableProvider->expects($this->once())->method('sendNotification');
        $firstNotAvailableProvider->method('sendNotification')->willThrowException(new NotificationSendFailed());
        $firstNotAvailableProvider->method('isEnabled')->willReturn(true);
        $firstNotAvailableProvider->method('getName')->willReturn('First Provider');
        $secondAvailableProvider = $this->createMock(ChannelProvider::class);
        $secondAvailableProvider->expects($this->once())->method('sendNotification');
        $secondAvailableProvider->method('isEnabled')->willReturn(true);
        $secondAvailableProvider->method('getName')->willReturn('Second Provider');
        $thirdAvailableProvider = $this->createMock(ChannelProvider::class);
        $thirdAvailableProvider->expects($this->once())->method('sendNotification');
        $thirdAvailableProvider->method('isEnabled')->willReturn(true);
        $thirdAvailableProvider->method('getName')->willReturn('Third Provider');
        $customerMock = $this->createMock(Customer::class);
        $customerMock->method('fullName')->willReturn(new FullName('firstName', 'lastName'));
        $providers = [
            $firstNotAvailableProvider,
            $secondAvailableProvider,
            $thirdAvailableProvider,
        ];
        $providersForCustomer = new ChannelProviderCollection($providers);
        $trackerMock = $this->createMock(Tracker::class);
        $loggerMock = $this->createMock(LoggerInterface::class);
        $strategy = new AllAvailableProviderStrategy($loggerMock, $trackerMock);

        $strategy->execute(
            $customerMock,
            new NotificationTranslation(new Language('en'), 'test'),
            $providersForCustomer,
        );
    }
}
