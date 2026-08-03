<?php



return [

    /*
    |--------------------------------------------------------------------------
    | Admin dashboard configuration
    |--------------------------------------------------------------------------
    */
    
    'dashboard' => [
        'default_admin_user' => env('DEFAULT_ADMIN_NAME', 'admin'),
        'default_admin_email' => env('DEFAULT_ADMIN_EMAIL', 'admin@admin.com'),
        'default_admin_password' => env('DEFAULT_ADMIN_PASSWORD', 'admin'),
    ],
];