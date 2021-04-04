<?php

use App\Utils\Language;

/**
 *  Used on migrations and seeders
 */
return [
    'application' => [
        'name' => Language::get('application'),
        'can_request' => true,
        'has_deadline' => true,
    ],
    'recommendation' => [
        'name' => Language::get('recommendation'),
        'can_request' => true,
        'has_deadline' => false,
    ],
    'letter' => [
        'name' => Language::get('letter'),
        'can_request' => true,
        'has_deadline' => false,
    ],
    'memo' => [
        'name' => Language::get('memo'),
        'can_request' => true,
        'has_deadline' => false,
    ],
    'motion' => [
        'name' => Language::get('motion'),
        'can_request' => true,
        'has_deadline' => false,
    ],
];