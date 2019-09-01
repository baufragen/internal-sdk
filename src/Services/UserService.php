<?php

namespace Baufragen\Sdk;

use Baufragen\Sdk\Client\BaufragenClient;
use GuzzleHttp\Exception\RequestException;

class UserService {
    public function registerUser($email, $password, $additional = []) {
        /** @var BaufragenClient $client */
        $client = app(BaufragenClient::class);

        try {
            $response = $client->post('/auth/register', [
                'headers' => [
                    'Accept'    => 'application/json',
                ],
            ]);
        } catch (RequestException $e) {

        }
    }
}
