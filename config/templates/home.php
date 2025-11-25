<?php

return [
    'label' => 'Home',
    'preview' => '/templates/home.png',
    'max' => 1,
    'widgets' => [
        'banner-home' => [],
        'rule-theme' => [
            'subtitle' => 'Tema Peraturan',
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
                        'cfind-thumb' => '1440x794',
                        'cfind-convert' => 'webp',
                    ],
                ],
                'image-medium' => [
                    'type' => 'text',
                    'label' => 'Image Medium',
                    'attributes' => [
                        'class' => 'cfind',
                        'cfind-type' => 'image',
                        'cfind-thumb' => '768x865',
                        'cfind-convert' => 'webp'
                    ],
                ],
                'image-small' => [
                    'type' => 'text',
                    'label' => 'Image Small',
                    'attributes' => [
                        'class' => 'cfind',
                        'cfind-type' => 'image',
                        'cfind-thumb' => '375x1165',
                        'cfind-convert' => 'webp'
                    ],
                ],
                'title' => [
                    'label' => 'Title',
                    'type' => 'text',
                    'multilang' => true,
                    'attributes' => [
                        'class' => 'required'
                    ]
                ],
                'subtitle' => [
                    'label' => 'Subtitle',
                    'type' => 'text',
                    'multilang' => true,
                    'attributes' => [
                        'class' => 'required'
                    ]
                ]
            ]
        ],
        'statistik' => [
            'subtitle' => 'Statistik Section',
            'type' => 'widget',
            'max' => 1,
            'min' => 1,
            'widgets' => [
                'title' => [
                    'label' => 'Title',
                    'type' => 'text',
                    'multilang' => true,
                    'attributes' => [
                        'class' => 'required'
                    ]
                ],
                'button-cta' => [
                    'child-subtitle' => 'Button CTA',
                    'type' => 'widget',
                    'max' => 1,
                    'widgets' => [
                        'label' => [
                            'label' => 'Label',
                            'type' => 'text',
                            'ai' => ['translate','correction'],
                            'multilang' => true,
                            'attributes' => [
                                'class' => 'required'
                            ]
                        ],
                        'target' => [
                            'type' => 'select',
                            'label' => 'Target',
                            'options' => [
                                '_self' => 'Default',
                                '_blank' => 'New Tab',
                            ],
                        ],
                        'link' => [
                            'label' => 'URL',
                            'type' => 'text',
                            'multilang' => true,
                            'info' => 'Can use permalink or http/https.',
                        ],
                    ]
                ],
            ]
        ],
        'rating' => [
            'subtitle' => 'Rating Section',
            'type' => 'widget',
            'max' => 1,
            'min' => 1,
            'widgets' => [
                'title' => [
                    'label' => 'Title',
                    'type' => 'text',
                    'multilang' => true,
                    'attributes' => [
                        'class' => 'required'
                    ]
                ],
                'intro' => [
                    'label' => 'Intro',
                    'type' => 'textarea',
                    'multilang' => true,
                    'attributes' => [
                        'class' => 'required'
                    ]
                ],
                'button' => [
                    'label' => 'Button',
                    'type' => 'text',
                    'multilang' => true,
                    'attributes' => [
                        'class' => 'required'
                    ]
                ],
            ]
        ],
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