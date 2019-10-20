<?php

namespace Baufragen\Sdk\Services;

use Baufragen\Sdk\Client\BaufragenClient;
use Baufragen\Sdk\Exceptions\RegisterException;
use Baufragen\Sdk\Exceptions\UpdateUserException;
use Baufragen\Sdk\User\UserUpdater;
use \GuzzleHttp\Exception\RequestException;
use \Illuminate\Validation\ValidationException;

class UserService {
    /** @var BaufragenClient $client */
    protected $client;

    public function __construct() {
        $this->client = app(BaufragenClient::class);
    }

    public function registerUser($email, $password, $origin, $additional = []) {
        try {

            $response = $this->client->request('POST', 'auth/register', [
                'form_params' => array_merge([
                    'email'     => $email,
                    'password'  => $password,
                    'origin'    => $origin,
                ], $additional),
                'headers' => [
                    'Accept'    => 'application/json',
                ],
            ]);

            if (in_array($response->getStatusCode(), [200, 201])) {
                return true;
            }

            return false;

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();

                if ($response->getStatusCode() === 422) {
                    throw ValidationException::withMessages(json_decode($response->getBody(), true)['errors']);
                }

                throw new RegisterException("Error during registration: " . $response->getStatusCode() . " - " . $response->getBody());
            }
        }
    }

    public function setAvatar($userId, $avatar) {
        try {

            $response = $this->client->request('POST', 'user/' . $userId . '/avatar', [
                'multipart' => [
                    [
                        'name'     => 'avatar',
                        'contents' => fopen($avatar->getRealPath(), 'r'),
                        'filename' => $avatar->getClientOriginalName(),
                    ],
                ]
            ]);

            if (in_array($response->getStatusCode(), [200, 201])) {
                return true;
            }

            return false;

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();

                if ($response->getStatusCode() === 422) {
                    throw ValidationException::withMessages(json_decode($response->getBody(), true)['errors']);
                }

                throw new UpdateUserException("Error during upload of avatar:" . $response->getStatusCode() . " - " . (string)$response->getBody());
            }
        }
    }

    public function deleteAvatar($userId) {
        try {

            $response = $this->client->request('DELETE', 'user/' . $userId . '/avatar');

            if (in_array($response->getStatusCode(), [200, 201])) {
                return true;
            }

            return false;

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();

                if ($response->getStatusCode() === 422) {
                    throw ValidationException::withMessages(json_decode($response->getBody(), true)['errors']);
                }

                throw new UpdateUserException("Error during deletion of avatar:" . $response->getStatusCode() . " - " . (string)$response->getBody());
            }
        }
    }

    public function changeEmail($userId, $newEmail) {
        try {

            $response = $this->client->request('PUT', 'user/' . $userId . '/email', [
                'json'      => ['email' => $newEmail],
                'headers'   => [
                    'Accept'    => 'application/json',
                ],
            ]);

            if (in_array($response->getStatusCode(), [200, 201])) {
                return true;
            }

            return false;
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();

                if ($response->getStatusCode() === 422) {
                    throw ValidationException::withMessages(json_decode($response->getBody(), true)['errors']);
                }

                throw new UpdateUserException("Error during update of email:" . $response->getStatusCode() . " - " . (string)$response->getBody());
            }
        }
    }

    public function changePassword($userId, $newPassword) {
        try {

            $response = $this->client->request('PUT', 'user/' . $userId . '/password', [
                'json'      => ['password' => $newPassword],
                'headers'   => [
                    'Accept'    => 'application/json',
                ],
            ]);

            if (in_array($response->getStatusCode(), [200, 201])) {
                return true;
            }

            return false;
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();

                if ($response->getStatusCode() === 422) {
                    throw ValidationException::withMessages(json_decode($response->getBody(), true)['errors']);
                }

                throw new UpdateUserException("Error during update of email:" . $response->getStatusCode() . " - " . (string)$response->getBody());
            }
        }
    }

    public function updateUser($id) {
        return new UserUpdater($id);
    }

    public function executeUpdateUser(UserUpdater $userUpdater) {
        try {

            $response = $this->client->request('PUT', 'user/' . $userUpdater->getUser(), [
                'json'      => $userUpdater->getData(),
                'headers'   => [
                    'Accept'    => 'application/json',
                ],
            ]);

            if (in_array($response->getStatusCode(), [200, 201])) {
                return true;
            }

            return false;

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();

                if ($response->getStatusCode() === 422) {
                    throw ValidationException::withMessages(json_decode($response->getBody(), true)['errors']);
                }

                throw new UpdateUserException("Error during update of userdata:" . $response->getStatusCode() . " - " . (string)$response->getBody());
            }
        }
    }
}
