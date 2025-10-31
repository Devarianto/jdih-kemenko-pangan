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
                    'label' => 'Image',
                    'attributes' => [
                        'class' => 'required cfind',
                        'cfind-type' => 'image',
                        'cfind-thumb' => '1070x240',
                        'cfind-convert' => 'webp',
                        'cfind-alt' => 1
                    ]
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