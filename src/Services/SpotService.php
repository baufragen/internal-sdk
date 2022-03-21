<?php

namespace Baufragen\Sdk\Services;

use Baufragen\Sdk\Client\BauspotClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class SpotService extends BaseService {
    /** @var BauspotClient $client */
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
            $this->handleRequestException($e, \Exception::class);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 404) {
                return false;
            } else {
                $this->handleRequestException($e, \Exception::class);
            }
        }
    }

    public function getLatestSpots($count = 5) {
        try {

            /** @var Response $response */
            $response = $this->client->request('GET', 'internal/spots/latest', [
                'query' => [
                    'count' => $count,
                ],
            ]);

            if (!$this->responseIsSuccessful($response)) {
                return false;
            }

            $responseData = json_decode($response->getBody(), true);

            return !empty($responseData['data']) ? $responseData['data'] : null;

        } catch (RequestException $e) {
            $this->handleRequestException($e, \Exception::class);
        }
    }
}
