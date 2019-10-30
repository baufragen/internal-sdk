<?php

namespace Baufragen\Sdk\Services;

use Baufragen\Sdk\Client\BaufragenClient;
use Baufragen\Sdk\Exceptions\DeleteUserException;
use Baufragen\Sdk\Exceptions\LoginTokenException;
use Baufragen\Sdk\Exceptions\RegisterException;
use Baufragen\Sdk\Exceptions\UpdateUserException;
use Baufragen\Sdk\User\UserUpdater;
use \GuzzleHttp\Exception\RequestException;
use \Illuminate\Validation\ValidationException;

class UserService extends BaseService {
    /** @var BaufragenClient $client */
    protected $client;

    public function __construct() {
        $this->client = app(BaufragenClient::class);
    }

    public function requestLoginToken($userId) {
        try {

            /** @var Response $response */
            $response = $this->client->request('GET', 'user/' . $userId . '/login-token');

            if (!$this->responseIsSuccessful($response)) {
                return false;
            }

            $responseData = json_decode($response->getBody(), true);

            return !empty($responseData['token']) ? $responseData['token'] : null;

        } catch (RequestException $e) {
            $this->handleRequestException($e, LoginTokenException::class);
        }
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

            return $this->responseIsSuccessful($response);

        } catch (RequestException $e) {
            $this->handleRequestException($e, RegisterException::class);
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

            return $this->responseIsSuccessful($response);

        } catch (RequestException $e) {
            $this->handleRequestException($e, UpdateUserException::class);
        }
    }

    public function deleteAvatar($userId) {
        try {

            $response = $this->client->request('DELETE', 'user/' . $userId . '/avatar');

            return $this->responseIsSuccessful($response);

        } catch (RequestException $e) {
            $this->handleRequestException($e, UpdateUserException::class);
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

            return $this->responseIsSuccessful($response);

        } catch (RequestException $e) {
            $this->handleRequestException($e, UpdateUserException::class);
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

            return $this->responseIsSuccessful($response);

        } catch (RequestException $e) {
            $this->handleRequestException($e, UpdateUserException::class);
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

            return $this->responseIsSuccessful($response);

        } catch (RequestException $e) {
            $this->handleRequestException($e, UpdateUserException::class);
        }
    }

    public function deleteUser($userId) {
        try {

            $response = $this->client->request('DELETE', 'user/' . $userId);

            return $this->responseIsSuccessful($response);

        } catch (RequestException $e) {
            $this->handleRequestException($e, DeleteUserException::class);
        }
    }
}
