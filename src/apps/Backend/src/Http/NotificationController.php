<?php
declare(strict_types=1);

namespace Backend\Http;

use App\Application\Command\Impl\CreateNotificationCommand;
use App\Application\Command\Impl\SendNotificationCommand;
use App\Application\Dto\NotificationDTO;
use App\Domain\ValueObject\CustomerId;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

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
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      )
     * )
     */
    public function send(Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), NotificationDTO::class, 'json');
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
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      )
     * )
     */
    public function sendToCustomer(string $customerId, Request $request): JsonResponse
    {
        /** @var NotificationDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), NotificationDTO::class, 'json');
        $this->commandBus->dispatch(new SendNotificationCommand(
            $dto->toValueObject(),
            new CustomerId($customerId)
        ));

        return new JsonResponse([], Response::HTTP_ACCEPTED);
    }
}
