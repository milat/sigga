<?php

return [
    // Root user created on seeding
    'root_superuser' => env('SUPERUSER_EMAIL'),
    'root_init_password' => env('SUPERUSER_INIT_PASSWORD'),

    // Default pagination
    'paginate' => 10,

    // Whatsapp default breakline
    'whatsapp_breakline' => '%0D%0A%0D%0A',

    // Default request attachments path
    'request_attachments_path' => 'offices/<office_id>/attachments/<request_id>/<file_name>',

    // Default documents path
    'documents_path' => 'offices/<office_id>/documents/<file_name>',

    // Default date format
    'date_format' => 'd/m/Y',

    // Amount of days to warn about documents sent
    'document_request_deadline' => 20,

    // Password used to create new users
    'generate_password' => '123456',
];