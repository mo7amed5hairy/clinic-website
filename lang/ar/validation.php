<?php

return [

    'required' => 'حقل :attribute مطلوب.',
    'string'   => 'حقل :attribute يجب أن يكون نصًا.',
    'email'    => 'صيغة البريد الإلكتروني غير صحيحة.',
    'unique'   => 'قيمة :attribute مستخدمة بالفعل.',
    'confirmed'=> 'تأكيد :attribute غير متطابق.',
    'min' => [
        'string' => 'حقل :attribute يجب ألا يقل عن :min أحرف.',
    ],
    'max' => [
        'string' => 'حقل :attribute يجب ألا يزيد عن :max أحرف.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    */
    'attributes' => [
        'name'                  => 'الاسم',
        'email'                 => 'البريد الإلكتروني',
        'phone'                 => 'رقم الهاتف',
        'password'              => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
    ],
];
