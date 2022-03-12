<?php

return [
    'user' => [
        'FIO' => [
            'required' => 'Введите ФИО',
            'string' => 'Введите строчку'
        ],
        'FIO_parent_case' => [
            'required' => 'Введите ФИО в род. падеже',
            'string' => 'ФИО в родительном падеже должно быть строчкой'
        ],
        'block_reason' => [
            'required' => 'Передайте причину блокировки',
        ],
        'user_id' => [
            'required' => 'Передайте id',
        ],
        'status' => [
            'required' => 'Передайте статус',
        ],
        'id' => [
            'required' => 'Передайте id',
            'numeric' => 'id должен быть числового типа'
        ],
        'address' =>[
            'required' => 'Адресс обязателен'
        ]
    ],
    'post_id' =>[
        'required' => 'Передайте должность',
    ],
    'email' =>[
        'required' => 'Передайте почту',
        'email' => 'Вводимое значение должно быть в формате почты'
    ],
    'password' => [
        'required' => 'Передайте пароль',
        'same:password_confirm' => 'Пароли должны совпадать',
        'min' => 'Пароль должен быть не менее 6 символов'
    ],
    'password_confirm' => [
        'required' => 'Подтвердите пароль'
    ],
    'code' => [
        'required' => 'Передайте код',
    ],
    'post' => [
        'name' => [
            'required' => 'Введите имя должности',
            'string' => 'Имя должно быть строкового типа'
        ],
        'name_parent_case' => [
            'required' => 'Введите имя должности в род. падеже',
            'string' => 'Имя должно быть строкового типа'
        ]
    ],
    'organization' => [
        'name' => [
            'required' => 'Передайте имя',
            'string' => 'Имя должно быть строкой'
        ],
        'director_id' => [
            'required' => 'Передайте пользователя',
        ],
        'max_duration_of_vacation' => [
            'required' => 'Передайте максимальное количество дней отпуска'
        ],
        'min_duration_of_vacation' => [
            'required' => 'Передайте минимальное количество дней отпуска'
        ]
    ]

];
