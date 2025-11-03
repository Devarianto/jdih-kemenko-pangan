<?php

return [
    'label' => 'About - Visi Misi',
    'preview' => '/templates/about-visimisi.png',
    'widgets' => [
        'banner' => [],
        'vision' => [
            'type' => 'widget',
            'subtitle' => 'Vision',
            'more-label' => 'Add Section',
            'max' => 1,
            'widgets' => [
                'image' => [
                    'type' => 'text',
                    'label' => 'Image Large',
                    'attributes' => [
                        'class' => 'required cfind',
                        'cfind-type' => 'image',
                        'cfind-thumb' => '1070x240',
                        'cfind-convert' => 'webp',
                        'cfind-alt' => 1
                    ]
                ],
                'image-medium' => [
                    'type' => 'text',
                    'label' => 'Image Medium',
                    'attributes' => [
                        'class' => 'cfind',
                        'cfind-type' => 'image',
                        'cfind-thumb' => '1024x400',
                        'cfind-convert' => 'webp'
                    ],
                ],
                'image-small' => [
                    'type' => 'text',
                    'label' => 'Image Small',
                    'attributes' => [
                        'class' => 'cfind',
                        'cfind-type' => 'image',
                        'cfind-thumb' => '327x520',
                        'cfind-convert' => 'webp'
                    ],
                ],
                'subtitle' => [
                    'type' => 'text',
                    'label' => 'Title',
                    'multilang' => true,
                    'ai' => ['translate', 'correction'],
                ],
                'title' => [
                    'type' => 'text',
                    'label' => 'Description',
                    'multilang' => true,
                    'ai' => ['translate', 'correction']
                ]
            ]
        ],
        'mission' => [
            'type' => 'widget',
            'subtitle' => 'Mission',
            'more-label' => 'Add Section',
            'max' => 1,
            'widgets' => [
                'title' => [
                    'type' => 'text',
                    'label' => 'Title',
                    'multilang' => true,
                    'attributes' => [
                        'class' => 'required'
                    ],
                    'ai' => ['translate','correction'],
                ],
                'content' => [
                    'type' => 'textarea',
                    'label' => 'Content',
                    'multilang' => true,
                    'attributes' => [
                        'class' => 'required ckeditor'
                    ],
                    'ai' => ['translate','correction'],
                ]
            ]
        ]
    ],
];