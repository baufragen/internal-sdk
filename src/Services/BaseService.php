<?php

namespace Baufragen\Sdk\Services;

use \GuzzleHttp\Exception\RequestException;
use \Illuminate\Validation\ValidationException;

abstract class BaseService {
    protected function responseIsSuccessful($response) {
        return in_array($response->getStatusCode(), [200, 201]);
    }

    protected function handleRequestException(RequestException $e, $exceptionClass) {
        if ($e->hasResponse()) {
            $response = $e->getResponse();

            if ($response->getStatusCode() === 422) {
                throw ValidationException::withMessages(json_decode($response->getBody(), true)['errors']);
            }

            throw new $exceptionClass("Error: " . $response->getStatusCode() . " - " . (string)$response->getBody());
        }
    }

    protected function getValueFromJsonResponse(string $key, $response) {
        $responseData = json_decode($response->getBody(), true);

        if (isset($responseData[$key])) {
            return $responseData[$key];
        }

        return null;
    }
}
