<?php

namespace Baufragen\Sdk\Services;

use Baufragen\Sdk\Client\BauspotClient;

class SpotService extends BaseService {
    /** @var BaufragenClient $client */
    protected $client;

    public function __construct() {
        $this->client = app(BauspotClient::class);
    }

    public function getSpotInfo($spotId) {
        try {

            /** @var Response $response */
            $response = $this->client->request('GET', 'internal/spots/' . $spotId);

            if (!$this->responseIsSuccessful($response)) {
                return false;
            }

            $responseData = json_decode($response->getBody(), true);

            return !empty($responseData['data']) ? $responseData['data'] : null;

        } catch (RequestException $e) {
            $this->handleRequestException($e, LoginTokenException::class);
        }
    }
}
