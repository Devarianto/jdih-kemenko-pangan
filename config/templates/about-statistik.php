<?php

return [
    'label' => 'About - Statistik',
    'preview' => '/templates/about-statistik.png',
    'max' => 1,
    'widgets' => [
        'banner' => [],
        'content' => [
            'subtitle' => 'Content',
            'type' => 'widget',
            'max' => 1,
            'widgets' => [
                'title' => [
                    'label' => 'Title',
                    'type' => 'text',
                    'multilang' => true,
                    'attributes' => [
                        'class' => 'required'
                    ]
                ],
                'description' => [
                    'label' => 'Description',
                    'type' => 'textarea',
                    'multilang' => true,
                    'attributes' => [
                        'class' => 'required'
                    ]
                ]
            ]
        ]
    ]
];