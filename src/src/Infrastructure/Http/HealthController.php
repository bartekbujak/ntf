<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HealthController
{
    /**
     * @Route("/health", name="health_check")
     */
    public function health(): Response
    {
        return new JsonResponse(null, Response::HTTP_OK);
    }
}
