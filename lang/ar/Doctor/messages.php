<?php

return [
    'fields' => [
        'name'           => 'اسم الطبيب',
        'specialization' => 'التخصص',
        'experience'     => 'الخبرة',
        'image'          => 'صورة الطبيب',
    ],
    'validation' => [
        'name_required'           => 'حقل الاسم مطلوب.',
        'specialization_required' => 'حقل التخصص مطلوب.',
        'experience_required'     => 'حقل الخبرة مطلوب.',
    ],
    'messages' => [
        'not_found' => 'الدكتور غير موجود.',
        'deleted'   => 'تم حذف الدكتور بنجاح.',
    ],
];
