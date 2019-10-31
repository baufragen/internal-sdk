<?php

return [
    'apikey'    => env('BAUFRAGEN_SDK_APIKEY'),
    'baufragen' => [
        'api'   =>  [
            'baseurl'   =>  env('BAUFRAGEN_SDK_BAUFRAGEN_API_BASEURL', 'https://www.baufragen.de/api/'),
        ],
    ],
    'bauspot' => [
        'api' => [
            'baseurl'   =>  env('BAUFRAGEN_SDK_BAUSPOT_API_BASEURL', 'https://www.bauspot.de/api/'),
        ],
    ],
];
