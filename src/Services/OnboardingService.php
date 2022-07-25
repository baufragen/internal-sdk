<?php

namespace Baufragen\Sdk\Services;

use Baufragen\Sdk\Client\BaufragenClient;
use Baufragen\Sdk\Exceptions\EmailExistsException;
use \GuzzleHttp\Exception\RequestException;

class OnboardingService extends BaseService {
    /** @var BaufragenClient $client */
    protected $client;

    public function __construct() {
        $this->client = app(BaufragenClient::class);
    }

    public function emailExists(string $email) {
        try {

            $response = $this->client->request('GET', 'onboarding/email-exists', [
                'params' => [
                    'email' => $email,
                ],
            ]);

            $responseData = json_decode($response->getContent(), true);

            return !empty($responseData['exists']);

        } catch (RequestException $e) {
            $this->handleRequestException($e, EmailExistsException::class);
        }
    }
}
