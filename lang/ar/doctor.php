<?php

return [

    'fields' => [
        'name'           => 'اسم الطبيب',
        'specialization' => 'التخصص',
        'experience'     => 'الخبرة',
        'image'          => 'صورة الطبيب',
    ],

    'validation' => [
        'name_required'           => 'حقل :attribute مطلوب.',
        'specialization_required' => 'حقل :attribute مطلوب.',
        'experience_required'     => 'حقل :attribute مطلوب.',
    ],
    'messages' => [
        'not_found' => 'الدكتور غير موجود',
        'deleted'   => 'تم حذف الدكتور بنجاح',
    ],



];
