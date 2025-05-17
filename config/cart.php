<?php

return [
    'session_key' => 'laravel_cart',
    'format_numbers' => env('CART_FORMAT_NUMBERS', false),
    'decimals' => env('CART_DECIMALS', 2),
    'dec_point' => env('CART_DEC_POINT', '.'),
    'thousands_sep' => env('CART_THOUSANDS_SEP', ','),
    
    'storage' => null,
    
    'events' => null,
];