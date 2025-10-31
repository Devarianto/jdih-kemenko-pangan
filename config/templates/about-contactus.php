<?php

return [
    'label' => 'About - Contact Us',
    'preview' => '/templates/about-contactus.png',
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
        'contact' => [
            'type' => 'widget',
            'subtitle' => 'Contact',
            'more-label' => 'Add Section',
            'max' => 1,
            'widgets' => [
                'image' => [
                    'type' => 'text',
                    'label' => 'Image',
                    'attributes' => [
                        'class' => 'required cfind',
                        'cfind-type' => 'image',
                        'cfind-thumb' => '990x287',
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
                        'cfind-thumb' => '1024x480',
                        'cfind-convert' => 'webp'
                    ],
                ],
                'image-small' => [
                    'type' => 'text',
                    'label' => 'Image Small',
                    'attributes' => [
                        'class' => 'cfind',
                        'cfind-type' => 'image',
                        'cfind-thumb' => '375x340',
                        'cfind-convert' => 'webp'
                    ],
                ],
                'title' => [
                    'type' => 'text',
                    'label' => 'Title',
                    'multilang' => true,
                    'ai' => ['translate', 'meta-title','correction'],
                ],
                'address' => [
                    'type' => 'textarea',
                    'label' => 'Address',
                    'attributes' => [
                        'class' => 'required'
                    ]
                ],
                'phone' => [
                    'type' => 'text',
                    'label' => 'Phone',
                    'attributes' => [
                        'class' => 'required'
                    ]
                ],
                'email' => [
                    'type' => 'text',
                    'label' => 'Email',
                    'attributes' => [
                        'class' => 'required email'
                    ]
                ],
                'google-map' => [
                    'type' => 'widget',
                    'child-subtitle' => 'Google Map',
                    'more-label' => 'Add CTA',
                    'max' => 1,
                    'widgets' => [
                        'label' => [
                            'type' => 'text',
                            'label' => 'Label',
                            'multilang' => true,
                            'ai' => ['translate','correction'],
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
                            'type' => 'text',
                            'label' => 'Google Map Link',
                            'info' => 'eg: https://maps.app.goo.gl/3VuQF41tG3XPW91J6',
                            'attributes' => [
                                'class' =>' required url'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
];