<?php

namespace Baufragen\Sdk\Services;

use Baufragen\Sdk\Client\BaufragenClient;
use GuzzleHttp\Exception\ClientException;

class SentEmailService extends BaseService {
    /** @var BaufragenClient $client */
    protected $client;

    public function __construct() {
        $this->client = app(BaufragenClient::class);
    }

    public function createTrackableEmail(string $service, string $type) {
        try {

            /** @var Response $response */
            $response = $this->client->request('POST', 'email-tracking', [
                'form_params' => [
                    'service'   => $service,
                    'type'      => $type,
                ],
            ]);

            if (!$this->responseIsSuccessful($response)) {
                return false;
            }

            $responseData = json_decode($response->getBody(), true);

            return $responseData['data']['id'] ?? null;
        } catch (RequestException $e) {
            $this->handleRequestException($e, \Exception::class);
        }
    }

    public function updateTrackableEmail(int $sentEmailId, string $email, string $messageId, int $userId = null) {
        try {

            /** @var Response $response */
            $response = $this->client->request('PUT', 'email-tracking/' . $sentEmailId, [
                'email'         => $email,
                'message_id'    => $messageId,
                'user_id'       => $userId,
            ]);

            if (!$this->responseIsSuccessful($response)) {
                return false;
            }
        } catch (RequestException $e) {
            $this->handleRequestException($e, \Exception::class);
        }
    }
}
