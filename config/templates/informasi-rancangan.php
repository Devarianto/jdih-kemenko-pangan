<?php

return [
    'label' => 'Informasi - Rancangan',
    'preview' => '/templates/informasi-rancangan.png',
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
                    'multilang' => true
                ],
                'description' => [
                    'label' => 'Description',
                    'type' => 'textarea',
                    'multilang' => true,
                    'attributes' => [
                        'class' => 'required ckeditor'
                    ]
                ]
            ]
        ],
        'box-content' => [
            'subtitle' => 'Box Content',
            'type' => 'widget',
            'max' => 1,
            'widgets' => [
                'image' => [
                    'label' => 'Image Large',
                    'type' => 'text',
                    'attributes' => [
                        'class' => 'required cfind',
                        'cfind-type' => 'image',
                        'cfind-alt' => 1,
                        'cfind-thumb' => '990x358',
                        'cfind-convert' => 'webp',
                    ],
                ],
                'image-medium' => [
                    'type' => 'text',
                    'label' => 'Image Medium',
                    'attributes' => [
                        'class' => 'cfind',
                        'cfind-type' => 'image',
                        'cfind-thumb' => '682x355',
                        'cfind-convert' => 'webp'
                    ],
                ],
                'image-small' => [
                    'type' => 'text',
                    'label' => 'Image Small',
                    'attributes' => [
                        'class' => 'cfind',
                        'cfind-type' => 'image',
                        'cfind-thumb' => '327x540',
                        'cfind-convert' => 'webp'
                    ],
                ],
                'title' => [
                    'label' => 'Title',
                    'type' => 'text',
                    'multilang' => true
                ],
                'intro' => [
                    'label' => 'Intro',
                    'type' => 'text',
                    'multilang' => true
                ],
                'button' => [
                    'label' => 'Button',
                    'type' => 'text',
                    'multilang' => true,
                    'attributes' => [
                        'class' => 'required'
                    ]
                ]
            ]
        ]
    ]
];