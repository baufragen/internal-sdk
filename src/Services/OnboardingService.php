<?php

namespace Baufragen\Sdk\Services;

use Baufragen\Sdk\Client\BaufragenClient;
use Baufragen\Sdk\Exceptions\DeleteUserException;
use Baufragen\Sdk\Exceptions\LoginTokenException;
use Baufragen\Sdk\Exceptions\OptinUserException;
use Baufragen\Sdk\Exceptions\RegisterException;
use Baufragen\Sdk\Exceptions\RegisterLoginException;
use Baufragen\Sdk\Exceptions\UpdateUserException;
use Baufragen\Sdk\User\UserUpdater;
use \GuzzleHttp\Exception\RequestException;
use \Illuminate\Validation\ValidationException;

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
            $this->handleRequestException($e, );
        }
    }
}
