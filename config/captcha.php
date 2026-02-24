<?php
/*
 * Secret key and Site key get on https://dashboard.hcaptcha.com/sites
 * */
return [
    'secret' => env('HCAPTCHA_SECRET_KEY', 'default_secret'),
    'sitekey' => env('HCAPTCHA_SITE_KEY', 'default_sitekey'),
    // \GuzzleHttp\Client used is the default client
    'http_client' => \Buzz\LaravelHCaptcha\HttpClient::class,
    'options' => [
        'multiple' => false,
        'lang' => app()->getLocale(),
    ],
    'attributes' => [
        'theme' => 'light'
    ],
];
