<?php

return [

    'fields' => [
        'name'           => 'doctor name',
        'specialization' => 'specialization',
        'experience'     => 'experience',
        'image'          => 'doctor image',
    ],

    'validation' => [
        'name_required'           => 'The :attribute field is required.',
        'specialization_required' => 'The :attribute field is required.',
        'experience_required'     => 'The :attribute field is required.',
    ],
    'messages' => [
        'not_found' => 'Doctor not found',
        'deleted'   => 'Doctor deleted successfully',
    ],


];
