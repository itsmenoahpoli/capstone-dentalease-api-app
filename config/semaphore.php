<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Semaphore API (3rd party)
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services
    | for semaphore (SMS) notifications.
    |
    */


    'api_key'       => env('SEMAPHORE_API_KEY'),
    'api_url'       => env('SEMAPHORE_API_URL'),
    'sender_name'   => env('SEMAPHORE_SENDER_NAME'),
];
