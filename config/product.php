<?php

return [
    'limit_create_product' => env('LIMIT_CREATE_PRODUCT', 3),
    'limit_create_product_totp' => env('LIMIT_CREATE_PRODUCT_TOTP', 10),
    'limit_photo_on_product' => env('LIMIT_PHOTO_ON_PRODUCT', 3),
    'height' => 600,
    'width' => 720,
    'activate_period' => env('PRODUCT_ACTIVATE_PERIOD', 1), // Months
];
