<?php
// ============================================================
// FICHIER 1 : config/auth.php
// Remplace le contenu de ton config/auth.php par ceci :
// ============================================================

return [

    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'utilisateurs',
    ],

    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'utilisateurs',
        ],
    ],

    // ⚠️ IMPORTANT : pointer vers App\Models\Utilisateur
    'providers' => [
        'utilisateurs' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Utilisateur::class,
        ],
    ],

    'passwords' => [
        'utilisateurs' => [
            'provider' => 'utilisateurs',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
