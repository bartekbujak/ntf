<?php

declare(strict_types=1);

namespace Backend\Listener;

use App\Infrastructure\Persistence\Doctrine\Filter\TenantFilter;
use App\Shared\Domain\Tenant\TenantContext;
use App\Shared\Domain\Tenant\TenantResolver;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class TenantRequestListener implements EventSubscriberInterface
{
    public function __construct(
        private TenantContext $tenantContext,
        private TenantResolver $tenantResolver,
        private DocumentManager $dm,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $tenant = $this->tenantResolver->findByShopName($event->getRequest()->headers->get('x-tenant'));
        $this->tenantContext->initialize($tenant);
        /** @var TenantFilter $filter */
        $filter = $this->dm->getFilterCollection()->getFilter('tenant_filter');
        $filter->setTenant($tenant);
    }
}
