<?php

declare(strict_types=1);

namespace Backend\Http;

use App\Application\Command\Impl\CreateNotificationCommand;
use App\Application\Command\Impl\SendNotificationCommand;
use App\Application\Dto\NotificationDTO;
use App\Domain\ValueObject\CustomerId;
use App\Infrastructure\Exception\ValidationErrorsException;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class NotificationController
{
    public function __construct(
        protected MessageBusInterface $commandBus,
        protected SerializerInterface $serializer,
        protected ValidatorInterface $validatorInterface,
    ) {
    }

    /**
     * @Route("/api/notification", methods={"POST"})
     * @OA\Post(
     *      path="/api/notification",
     *      operationId="send",
     *      tags={"Notification"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref=@Model(type=NotificationDTO::class))
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Bad Request"
     *      )
     * )
     */
    public function send(Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), NotificationDTO::class, 'json');
        $this->validateDto($dto);
        $this->commandBus->dispatch(new CreateNotificationCommand($dto));

        return new JsonResponse([], Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/api/notification/{customerId}", methods={"POST"})
     * @OA\Post(
     *      path="/api/notification/{customerId}",
     *      operationId="sendToCustomer",
     *      tags={"Notification"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref=@Model(type=NotificationDTO::class))
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Bad Request"
     *      )
     * )
     */
    public function sendToCustomer(string $customerId, Request $request): JsonResponse
    {
        /** @var NotificationDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), NotificationDTO::class, 'json');
        $this->validateDto($dto);
        $this->commandBus->dispatch(new SendNotificationCommand(
            $dto->toValueObject(),
            new CustomerId($customerId)
        ));

        return new JsonResponse([], Response::HTTP_ACCEPTED);
    }

    protected function validateDto(mixed $dto): void
    {
        $errors = $this->validatorInterface->validate($dto);
        if (count($errors)) {
            $responseErrors = [];
            foreach ($errors as $error) {
                $responseErrors[$error->getPropertyPath()] = $error->getMessage();
            }

            throw new ValidationErrorsException(json_encode($responseErrors));
        }
    }
}
