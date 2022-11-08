<?php

return array(

    'IOSUser'     => array(
        'environment' => env('ENVIRONMENT'),
        'certificate' => storage_path().'/app/public/apns/user.pem',
        'passPhrase'  => env('IOS_PUSH_PASSWORD'),
        'service'     => 'apns'
    ),
    'IOSProvider' => array(
        'environment' => env('ENVIRONMENT'),
        'certificate' => storage_path().'/app/public/apns/provider.pem',
        'passPhrase'  => env('IOS_PUSH_PASSWORD'),
        'service'     => 'apns'
    ),
    'Android' => array(
        'environment' => env('ENVIRONMENT'),
        'apiKey'      => env('ANDROID_PUSH_KEY'),
        'service'     => 'gcm'
    )

);
