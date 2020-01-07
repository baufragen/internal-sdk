<?php

namespace Baufragen\Sdk\Client;

use GuzzleHttp\Client;

class BauspotClient extends Client {
    public function __construct()
    {
        $config = [
            'base_uri'  => config('baufragensdk.bauspot.api.baseurl'),
            'headers'   => [
                'X-BAUFRAGEN-SDK-APIKEY'  => config('baufragensdk.apikey'),
            ],
            'verify'    => false, // TODO: make this configurable
        ];

        if (!empty(config('baufragensdk.bauspot.auth.user')) && !empty(config('baufragensdk.bauspot.auth.password'))) {
            $config['auth'] = [config('baufragensdk.bauspot.auth.user'), config('baufragensdk.bauspot.auth.password')];
        }

        parent::__construct($config);
    }
}
