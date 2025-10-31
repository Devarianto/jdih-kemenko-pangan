<?php

return [
    'label' => 'About - SOP',
    'preview' => '/templates/about-sop.png',
    'widgets' => [
        'banner' => [],
        'content' => [
            'type' => 'widget',
            'subtitle' => 'Content',
            'more-label' => 'Add Section',
            'max' => 1,
            'widgets' => [
                'title' => [
                    'type' => 'text',
                    'label' => 'Title',
                    'multilang' => true,
                    'ai' => ['translate', 'meta-title','correction'],
                ],
                'description' => [
                    'type' => 'textarea',
                    'label' => 'Description',
                    'multilang' => true,
                    'ai' => ['translate', 'meta-description', 'correction']
                ]
            ]
        ],
        'image' => [
            'type' => 'widget',
            'subtitle' => 'Image',
            'more-label' => 'Add Section',
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
                'image' => [
                    'type' => 'text',
                    'label' => 'Image',
                    'multilang' => true,
                    'attributes'=>[
                        'class'=>'cfind required',
                        'cfind-type' => 'image',
                        'cfind-thumb' => '926x619',
                        'cfind-convert' => 'webp',
                        'cfind-alt' => 1,
                    ],
                ]
            ]
        ]
    ],
];