<?php

return [

    'office' => [
        'name' => 'SIGGA',
        'city' => 'Guarulhos',
        'state' => 'SP',
        'party' => 'SGG',
        'note' => 'Fake',
        'is_active' => true
    ],

    'role' => [
        'administrator' => [
            'name' => 'Administrador',
            'is_active' => true
        ],
        'common' => [
            'name' => 'Assessor',
            'is_active' => true
        ]
    ],

    'user' => [
        'administrator' => [
            'name' => 'Admin',
            'email' => 'admin@sigga.com.br',
            'is_active' => true
        ],
        'common' => [
            'name' => 'Assessor',
            'email' => 'assessor@sigga.com.br',
            'is_active' => true
        ]
    ],

    'category' => [
        ['name' => 'Atendimento Jurídico', 'is_active' => true],
        ['name' => 'Transporte', 'is_active' => true],
        ['name' => 'Saúde', 'is_active' => true],
        ['name' => 'Emprego / Cursos', 'is_active' => true],
        ['name' => 'Ajuda de custo', 'is_active' => true],
        ['name' => 'Reclamação', 'is_active' => true],
        ['name' => 'Iluminação', 'is_active' => true],
        ['name' => 'Atendimento Geral', 'is_active' => true],
    ]

];