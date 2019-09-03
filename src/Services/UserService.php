<?php

namespace Baufragen\Sdk;

use Baufragen\Sdk\Client\BaufragenClient;
use Baufragen\Sdk\Exceptions\RegisterException;
use \GuzzleHttp\Exception\RequestException;
use \Illuminate\Validation\ValidationException;

class UserService {
    public function registerUser($email, $password, $origin, $additional = []) {
        /** @var BaufragenClient $client */
        $client = app(BaufragenClient::class);

        try {
            $response = $client->post('/auth/register', array_merge([
                'email'     => $email,
                'password'  => $password,
                'origin'    => $origin,
            ], $additional), [
                'headers' => [
                    'Accept'    => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() === 201) {
                return true;
            }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();

                if ($response->getStatusCode() === 422) {
                    throw ValidationException::withMessages(json_decode($response->getContent(), true)['errors']);
                }

                throw new RegisterException("Error during registration");
            }
        }
    }
}
