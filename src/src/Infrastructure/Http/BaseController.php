<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Infrastructure\Exception\ValidationErrorsException;
use App\Shared\Application\Schema\SchemaInterface;
use App\Shared\Domain\Exception\TenantNotSetException;
use App\Shared\Domain\Tenant\TenantContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseController
{
    public function __construct(
        protected MessageBusInterface $commandBus,
        protected MessageBusInterface $queryBus,
        protected SerializerInterface $serializer,
        protected TenantContext $tenantContext,
        protected ValidatorInterface $validatorInterface,
    ) {
    }

    /**
     * @throws TenantNotSetException
     */
    protected function getLanguage(Request $request): string
    {
        return $request->headers->get('x-lang') ?? $this->tenantContext->getCurrentTenant()->defaultLanguage;
    }

    protected function createListResponse(mixed $result, int $amount): JsonResponse
    {
        $response = new JsonResponse($result, Response::HTTP_OK);
        $response->headers->set('Access-Control-Expose-Headers', 'X-Total-Count');
        $response->headers->set('X-Total-Count', $amount);

        return $response;
    }

    protected function validateDto(SchemaInterface $schema)
    {
        $errors = $this->validatorInterface->validate($schema);
        if (count($errors)) {
            $responseErrors = [];
            foreach ($errors as $error) {
                $responseErrors[$error->getPropertyPath()] = $error->getMessage();
            }

            throw new ValidationErrorsException(json_encode($responseErrors));
        }
    }

    protected function getLastHandledResult($envelope)
    {
        return $envelope->last(HandledStamp::class)->getResult();
    }
}
