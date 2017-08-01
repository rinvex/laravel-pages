<?php

declare(strict_types=1);

use Rinvex\Pages\Models\Page;

return [

    // Pageable Database Tables
    'tables' => [
        'pages' => 'pages',
    ],

    // Pageable Models
    'models' => [
        'page' => Page::class,
    ],

    // Register routes
    'register_routes' => true,

];
