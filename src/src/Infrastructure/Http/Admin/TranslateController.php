<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Admin;

use App\Application\Factory\Admin\ResourceFactory;
use App\Infrastructure\Http\BaseController;
use App\Shared\Application\Dto\Translation\TranslateDTO;
use App\Shared\Application\Exception\CannotMatchResourceException;
use App\Shared\Domain\Tenant\TenantContext;
use JMS\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TranslateController extends BaseController
{
    public function __construct(
        MessageBusInterface $commandBus,
        MessageBusInterface $queryBus,
        SerializerInterface $serializer,
        TenantContext $tenantContext,
        private ResourceFactory $resourceFactory,
        ValidatorInterface $validatorInterface
    ) {
        parent::__construct(
            $commandBus,
            $queryBus,
            $serializer,
            $tenantContext,
            $validatorInterface
        );
    }

    /**
     * @Route("/api/admin/translate/{resource}/{id}", methods={"POST"})
     * @OA\Post(
     *      path="/api/admin/translate/{resource}/{id}",
     *      operationId="translate",
     *      tags={"Admin_Common"},
     *      @OA\Parameter(
     *          name="x-lang",
     *          in="header",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
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
     *
     * @throws CannotMatchResourceException
     */
    public function translate(string $resource, int $id, Request $request): JsonResponse
    {
        $dto = new TranslateDTO();
        $dto->id = $id;
        $dto->locale = $this->getLanguage($request);
        $command = $this->resourceFactory->createTranslateCommand($resource, $dto);
        $this->commandBus->dispatch($command);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/api/admin/translate/{resource}/{id}", methods={"DELETE"})
     * @OA\Delete(
     *      path="/api/admin/translate/{resource}/{id}",
     *      operationId="removeTranslation",
     *      tags={"Admin_Common"},
     *      @OA\Parameter(
     *          name="x-lang",
     *          in="header",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
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
     *
     * @throws CannotMatchResourceException
     */
    public function removeTranslation(string $resource, int $id, Request $request): JsonResponse
    {
        $dto = new TranslateDTO();
        $dto->id = $id;
        $dto->locale = $this->getLanguage($request);
        $command = $this->resourceFactory->createRemoveTranslationCommand($resource, $dto);
        $this->commandBus->dispatch($command);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
