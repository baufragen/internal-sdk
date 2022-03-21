<?php

namespace Baufragen\Sdk\Services;

use Baufragen\Sdk\Client\BaufragenClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class KeywordService extends BaseService {
    /** @var BaufragenClient $client */
    protected $client;

    public function __construct() {
        $this->client = app(BaufragenClient::class);
    }

    public function getAllKeywords() {
        try {

            /** @var Response $response */
            $response = $this->client->request('GET', 'keyword');

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
}
