<?php

return [

    'fields' => [
        'name'           => 'specialization name',
        'description' => 'description',
    ],

    'validation' => [
        'name_required'           => 'The :attribute field is required.',
        'description_required' => 'The :attribute field is required.',
    ],
    'messages' => [
        'not_found' => 'specialization not found',
        'deleted'   => 'specialization deleted successfully',
    ],


];
