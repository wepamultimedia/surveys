<?php

// config for Wepa/Surveys
return [
    'backend_menu' => [
        [
            'label' => 'en:Surveys|es:Encuestas',
            'icon' => 'chart-bar',
            'route' => '#',
            'active' => 'admin.surveys.*',
            'can' => 'admin.auth',
            'children' => [
                [
                    'label' => 'en:Questions|es:Preguntas',
                    'route' => 'admin.surveys.questions.index',
                    'active' => 'admin.surveys.questions*',
                    'can' => 'admin.auth',
                ],
            ],
        ],
    ],
];
