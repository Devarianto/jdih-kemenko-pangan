<?php

return [
    'label' => 'About - Struktur',
    'preview' => '/templates/about-struktur.png',
    'widgets' => [
        'banner' => [],
        'content' => [
            'type' => 'widget',
            'subtitle' => 'Content',
            'more-label' => 'Add Section',
            'max' => 1,
            'widgets' => [
                'title' => [
                    'type' => 'textarea',
                    'label' => 'Title',
                    'multilang' => true,
                    'ai' => ['translate', 'meta-title','correction'],
                ]
            ]
        ],
        'structure' => [
            'type' => 'widget',
            'subtitle' => 'Structure',
            'more-label' => 'Add Section',
            'widgets' => [
                'subtitle' => [
                    'type' => 'text',
                    'label' => 'Subtitle',
                    'multilang' => true,
                    'attributes' => [
                        'class' => 'required'
                    ],
                    'ai' => ['translate','correction'],
                ],
                'title' => [
                    'type' => 'text',
                    'label' => 'Title',
                    'multilang' => true,
                    'attributes' => [
                        'class' => 'required'
                    ],
                    'ai' => ['translate','correction'],
                ],
                'image' => [
                    'type' => 'text',
                    'label' => 'Image',
                    'multilang' => true,
                    'attributes'=>[
                        'class'=>'cfind required',
                        'cfind-type' => 'image',
                        'cfind-convert' => 'webp',
                        'cfind-alt' => 1,
                    ],
                ]
            ]
        ]
    ],
];