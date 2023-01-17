<?php

declare(strict_types=1);

namespace Backend\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

final class ExceptionListener implements EventSubscriberInterface
{
    private string $environment;

    private array $exceptionToStatus;

    public function __construct(
        private LoggerInterface $logger,
        string $environment,
        array $exceptionToStatus = [],
    ) {
        $this->environment = $environment;
        $this->exceptionToStatus = $exceptionToStatus;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $this->getException($event);
        $statusCode = $this->determineStatusCode($exception);
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/vnd.api+json');
        $response->setStatusCode($statusCode);
        $response->setData($this->getErrorMessage($exception, $response));
        $event->setResponse($response);
        $this->log($exception, $statusCode);
    }

    private function log(Throwable $e, int $statusCode): void
    {
        if (Response::HTTP_INTERNAL_SERVER_ERROR === $statusCode) {
            $this->logger->error($e->getMessage());
        }
    }

    private function getException(ExceptionEvent $event): Throwable
    {
        $exception = $event->getThrowable();
        if ($exception instanceof HandlerFailedException) {
            return $exception->getPrevious() ?? $exception;
        }

        return $exception;
    }

    private function getErrorMessage(Throwable $exception, Response $response): array
    {
        $error = [
            'error' => [
                'detail' => $this->getExceptionMessage($exception),
                'code' => $exception->getCode(),
            ],
        ];

        if ('dev' === $this->environment) {
            $error = \array_merge(
                $error,
                [
                    'exceptionClass' => get_class($exception),
                    'meta' => [
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                        'message' => $exception->getMessage(),
                        'trace' => $exception->getTrace(),
                        'traceString' => $exception->getTraceAsString(),
                    ],
                ]
            );
        }

        if (422 === $response->getStatusCode()) {
            $error = $this->getValidationErrorMessage($exception);
        }

        return $error;
    }

    private function getValidationErrorMessage(Throwable $exception): array
    {
        return [
            'message' => 'Unprocessable Entity',
            'errors' => json_decode($exception->getMessage(), true),
        ];
    }

    private function getExceptionMessage(Throwable $exception): string
    {
        return $exception->getMessage();
    }

    private function determineStatusCode(Throwable $exception): int
    {
        $exceptionClass = \get_class($exception);

        foreach ($this->exceptionToStatus as $class => $status) {
            if (\is_a($exceptionClass, $class, true)) {
                return $status;
            }
        }

        // Process HttpExceptionInterface after `exceptionToStatus` to allow overrides from config
        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }

        // Default status code is always 500
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
