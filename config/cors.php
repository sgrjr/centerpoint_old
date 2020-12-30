<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */
    'supports_credentials' => true,
    'allowed_origins' => ['*','localhost','http://localhost:3000','localhost:3000'],
    'allowed_origins_patterns' => ['*'],
    'allowed_headers' => ['Access-Control-Allow-Origin','Origin','Content-Type','Authorization','Cache-Control'],
    'allowed_methods' => ['GET', 'POST', 'PUT',  'DELETE'],
    'exposed_headers' => ['Access-Control-Allow-Origin: *'],
    'max_age' => 60800,
    'hosts' => ['localhost','localhost:3000'],
    'paths' => ['api/*', 'graphql']
];