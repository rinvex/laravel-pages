<?php

declare(strict_types=1);

return [

    // Pageable Database Tables
    'tables' => [
        'pages' => 'pages',
    ],

    // Pageable Models
    'models' => [
        'page' => \Rinvex\Pages\Models\Page::class,
    ],

    // Register routes
    'register_routes' => true,

];
