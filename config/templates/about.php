<?php

return [
    'label' => 'About - Landasan Hukum',
    'preview' => '/templates/about.png',
    'widgets' => [
        'banner' => [],
        'content' => [
            'type' => 'widget',
            'subtitle' => 'Content',
            'more-label' => 'Add Section',
            'max' => 1,
            'widgets' => [
                'subtitle' => [
                    'type' => 'text',
                    'label' => 'Subtitle',
                    'multilang' => true,
                    'ai' => ['translate','correction'],
                ],
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
        'file' => [
            'type' => 'widget',
            'subtitle' => 'File',
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
                'file' => [
                    'type' => 'text',
                    'label' => 'File',
                    'multilang' => true,
                    'attributes'=>[
                        'class'=>'cfind required',
                        'cfind-type'=>'file',
                        'cfind-ext'=>'pdf',
                    ],
                ]
            ]
        ]
    ],
];