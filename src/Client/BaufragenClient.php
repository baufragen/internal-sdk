<?php

namespace Baufragen\Sdk\Client;

use GuzzleHttp\Client;

class BaufragenClient extends Client {
    public function __construct()
    {
        $config = [
            'base_uri'  => config('baufragensdk.api.baseurl'),
            'verify'    => false, // TODO: make this configurable
        ];

        parent::__construct($config);
    }
}
