<?php

return [
    'fields' => [
        'name'           => 'Specialization Name',
        'description' => 'Description',
    ],
    'validation' => [
        'name_required'           => 'The name field is required.',
        'description_required' => 'The description field is required.',
    ],
    'messages' => [
        'not_found' => 'Specialization not found.',
        'deleted'   => 'Specialization deleted successfully.',
    ],
];
