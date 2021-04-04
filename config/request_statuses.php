<?php

use App\Utils\Language;

/**
 *  Used on migrations and seeders
 */
return [

    'opened' => [
        'id' => 1,
        'name' => Language::get('opened'),
        'class' => 'table-info',
        'rgba' => 'rgba(120, 170, 300, <opacity>)'
    ],

    'sent' => [
        'id' => 2, // Used on document's insertion inside request
        'name' => Language::get('sent'),
        'class' => 'table-warning',
        'rgba' => 'rgba(255, 206, 86, <opacity>)'
    ],

    'received' => [
        'id' => 3,
        'name' => Language::get('received'),
        'class' => 'table-primary',
        'rgba' => 'rgba(54, 162, 235, <opacity>)'
    ],

    'completed' => [
        'id' => 4,
        'name' => Language::get('completed'),
        'class' => 'table-success',
        'rgba' => 'rgba(75, 192, 192, <opacity>)'
    ],

    'failed' => [
        'id' => 5,
        'name' => Language::get('failed'),
        'class' => 'table-danger',
        'rgba' => 'rgba(255, 99, 132, <opacity>)'
    ],

    'canceled' => [
        'id' => 6,
        'name' => Language::get('canceled'),
        'class' => 'table-light',
        'rgba' => 'rgba(255, 159, 64, <opacity>)'
    ]
];
