<?php

namespace Baufragen\Sdk\Client;

use GuzzleHttp\Client;

class BauspotClient extends Client {
    public function __construct()
    {
        $config = [
            'base_uri'  => config('baufragensdk.bauspot.api.baseurl'),
            'defaults'  => [
                'headers'   => [
                    'baufragen_sdk_apikey'  => config('baufragensdk.apikey'),
                ],
            ],
            'verify'    => false, // TODO: make this configurable
        ];

        parent::__construct($config);
    }
}
