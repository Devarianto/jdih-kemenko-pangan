<?php

return [
    'label' => 'Home',
    'preview' => '/templates/home.png',
    'widgets' => [
        'banner-home' => [],
        'institution' => [
            'subtitle' => 'Institution Section',
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
                'institution-images' => [
                    'type' => 'widget',
                    'more-label' => 'Add Institution',
                    'widgets' => [
                        'image' => [
                            'label' => 'Image',
                            'type' => 'text',
                            'info' => 'Recomended size width : 297 x height : 68',
                            'attributes' => [
                                'class' => 'required cfind',
                                'cfind-type' => 'image',
                                'cfind-alt' => 1
                            ]
                        ],
                        'link' => [
                            'label' => 'Link',
                            'type' => 'text',
                            'info' => 'eg: https://google.com',
                            'attributes' => [
                                'class' => 'required url'
                            ]
                        ]
                    ]
                ],
            ],
        ],
    ]
];