<?php

return [
    'apikey'    => env('BAUFRAGEN_SDK_APIKEY'),
    'baufragen' => [
        'api'   =>  [
            'baseurl'   =>  env('BAUFRAGEN_SDK_BAUFRAGEN_API_BASEURL', 'https://www.baufragen.de/api/'),
        ],
        'auth'  => [
            'user'      => env('BAUFRAGEN_SDK_BAUFRAGEN_API_AUTH_USER', null),
            'password'  => env('BAUFRAGEN_SDK_BAUFRAGEN_API_AUTH_PASSWORD', null),
        ],
    ],
    'bauspot' => [
        'api' => [
            'baseurl'   =>  env('BAUFRAGEN_SDK_BAUSPOT_API_BASEURL', 'https://www.bauspot.de/api/'),
        ],
        'auth'  => [
            'user'      => env('BAUFRAGEN_SDK_BAUSPOT_API_AUTH_USER', null),
            'password'  => env('BAUFRAGEN_SDK_BAUSPOT_API_AUTH_PASSWORD', null),
        ],
    ],
];
