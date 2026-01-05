<?php

return [
    'fields' => [
        'name'           => 'اسم التخصص',
        'description' => 'الوصف',
    ],
    'validation' => [
        'name_required'           => 'حقل الاسم مطلوب.',
        'description_required' => 'حقل الوصف مطلوب.',
    ],
    'messages' => [
        'not_found' => 'التخصص غير موجود.',
        'deleted'   => 'تم حذف التخصص بنجاح.',
    ],
];
