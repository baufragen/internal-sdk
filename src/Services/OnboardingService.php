<?php

namespace Baufragen\Sdk\Services;

use Baufragen\Sdk\Client\BaufragenClient;
use Baufragen\Sdk\Exceptions\EmailExistsException;
use Baufragen\Sdk\Exceptions\Sync\CreateManufacturerException;
use Baufragen\Sdk\Exceptions\Sync\UpdateManufacturerException;
use \GuzzleHttp\Exception\RequestException;

class OnboardingService extends BaseService {
    /** @var BaufragenClient $client */
    protected $client;

    public function __construct() {
        $this->client = app(BaufragenClient::class);
    }

    public function emailExists(string $email) : bool {
        try {

            $response = $this->client->request('GET', 'onboarding/email-exists', [
                'query' => [
                    'email' => $email,
                ],
            ]);

            return !empty($this->getValueFromJsonResponse('exists', $response));

        } catch (RequestException $e) {
            $this->handleRequestException($e, EmailExistsException::class);
        }
    }

    public function createManufacturer(string $name) : int {
        try {

            $response = $this->client->request('POST', 'onboarding/manufacturer', [
                'query' => [
                    'name' => $name,
                ],
            ]);

            return $this->getValueFromJsonResponse('id', $response);

        } catch (RequestException $e) {
            $this->handleRequestException($e, CreateManufacturerException::class);
        }
    }

    public function updateManufacturer(int $manufacturerId, array $data) : bool {
        try {

            $response = $this->client->request('PUT', 'onboarding/manufacturer/' . $manufacturerId, [
                'form_params' => $data,
            ]);

            return $this->responseIsSuccessful($response);

        } catch (RequestException $e) {
            $this->handleRequestException($e, UpdateManufacturerException::class);
        }
    }
}
