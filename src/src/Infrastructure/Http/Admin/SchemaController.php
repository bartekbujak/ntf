<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Admin;

use App\Application\Factory\Admin\ResourceFactory;
use App\Shared\Application\Exception\CannotMatchResourceException;
use App\Shared\Application\Schema\Schema;
use App\Shared\Application\Schema\SchemaBuilder;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SchemaController
{
    public function __construct(
        private SchemaBuilder $schemaBuilder,
        private ResourceFactory $resourceFactory,
        private SerializerInterface $serializer
    ) {
    }

    /**
     * @Route("/api/admin/schema/{resource}", methods={"GET"})
     * @OA\Tag(name="Admin_Common"),
     * @OA\Parameter(name="type", in="query")
     * @OA\Response(
     *     response=200,
     *     description="Returns list",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Schema::class))
     *     )
     * )
     *
     * @throws CannotMatchResourceException
     */
    public function getSchema(string $resource, Request $request): JsonResponse
    {
        $type = $request->get('type');
        $dto = $this->resourceFactory->createDtoForSchema($resource, $type);

        return new JsonResponse(
            $this->serializer->serialize($this->schemaBuilder->build($dto), 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
