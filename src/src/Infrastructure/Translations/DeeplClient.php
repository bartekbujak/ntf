<?php

declare(strict_types=1);

namespace App\Infrastructure\Translations;

use App\Application\Services\Translations\TranslationClient;
use App\Shared\Application\Dto\Translation\TranslationDTO;
use App\Shared\Application\Dto\Translation\TranslationResponseDTO;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DeeplClient implements TranslationClient
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private SerializerInterface $serializer,
        private LoggerInterface $logger,
        private string $apiKey
    ) {
    }

    public function translate(TranslationDTO $dto): TranslationResponseDTO
    {
        $data = [
            ['target_lang' => $dto->targetLang],
            ['source_lang' => $dto->sourceLang],
        ];
        foreach ($dto->textList as $item) {
            $data[] = ['text' => $item];
        }
        $formData = new FormDataPart($data);
        $response = $this->httpClient->request(
            'POST',
            'https://api-free.deepl.com/v2/translate?auth_key='.$this->apiKey,
            [
                'body' => $formData->bodyToIterable(),
                'headers' => $formData->getPreparedHeaders()->toArray(),
            ]
        );
        $statusCode = $response->getStatusCode();
        if ($statusCode >= 400) {
            switch ($statusCode) {
                case 403:
                    $this->logger->warning('[DeeplClient::translate] Authorization failed. Please supply a valid auth_key parameter.');

                break;
                case 413:
                    $this->logger->warning('[DeeplClient::translate] The request size exceeds the limit.');

                break;
                case 414:
                    $this->logger->warning('[DeeplClient::translate] The request URL is too long. You can avoid this error by using a POST request instead of a GET request, and sending the parameters in the HTTP body.');

                break;
                case 429:
                case 529:
                    $this->logger->warning('[DeeplClient::translate] Too many requests. Please wait and resend your request.');

                break;
                case 456:
                    $this->logger->warning('[DeeplClient::translate] Quota exceeded. The character limit has been reached.');

                break;
                case 503:
                    $this->logger->warning('[DeeplClient::translate] Resource currently unavailable. Try again later.');

                break;
                default:
                    $this->logger->warning('[DeeplClient::translate] Internal error');

                break;
            }

            throw new BadRequestException('Translation error');
        }

        return $this->serializer->deserialize($response->getContent(), TranslationResponseDTO::class, 'json');
    }
}
