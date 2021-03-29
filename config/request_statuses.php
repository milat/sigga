<?php

use App\Utils\Language;

/**
 *  Used on migrations and seeders
 */
return [

    [
        'name' => Language::get('opened'),
        'class' => 'table-primary',
        'rgba' => 'rgba(54, 162, 235, <opacity>)'
    ],

    [
        'name' => Language::get('paused'),
        'class' => 'table-warning',
        'rgba' => 'rgba(255, 206, 86, <opacity>)'
    ],

    [
        'name' => Language::get('completed'),
        'class' => 'table-success',
        'rgba' => 'rgba(75, 192, 192, <opacity>)'
    ],

    [
        'name' => Language::get('failed'),
        'class' => 'table-danger',
        'rgba' => 'rgba(255, 99, 132, <opacity>)'
    ],

    [
        'name' => Language::get('canceled'),
        'class' => 'table-light',
        'rgba' => 'rgba(255, 159, 64, <opacity>)'
    ]
];
