<?php

namespace Baufragen\Sdk\Client;

use GuzzleHttp\Client;

class BaufragenClient extends Client {
    public function __construct()
    {
        $config = [
            'base_uri'  => config('baufragensdk.baufragen.api.baseurl'),
            'headers'   => [
                'X-BAUFRAGEN-SDK-APIKEY'  => config('baufragensdk.apikey'),
            ],
            'verify'    => false, // TODO: make this configurable
        ];

        if (!empty(config('baufragensdk.baufragen.auth.user')) && !empty(config('baufragensdk.baufragen.auth.password'))) {
            $config['auth'] = [config('baufragensdk.baufragen.auth.user'), config('baufragensdk.baufragen.auth.password')];
        }

        parent::__construct($config);
    }
}
