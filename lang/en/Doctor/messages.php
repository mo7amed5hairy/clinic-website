<?php

return [
    'fields' => [
        'name'           => 'Doctor Name',
        'specialization' => 'Specialization',
        'experience'     => 'Experience',
        'image'          => 'Doctor Image',
    ],
    'validation' => [
        'name_required'           => 'The name field is required.',
        'specialization_required' => 'The specialization field is required.',
        'experience_required'     => 'The experience field is required.',
    ],
    'messages' => [
        'not_found' => 'Doctor not found.',
        'deleted'   => 'Doctor deleted successfully.',
    ],
];
