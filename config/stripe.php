<?php

return [
    'product_id' => env('STRIPE_PRODUCT_ID'),
    'prices' => [
        'monthly' => env('STRIPE_PRICE_MONTHLY'),
        'one_year' => env('STRIPE_PRICE_ONE_YEAR'),
        'three_year' => env('STRIPE_PRICE_THREE_YEAR'),
    ],
];