<?php

return [
    'label' => 'Banner',
    'subtitle' => 'Banner Section',
    'min' => 1,
    'max' => 1,
    'widgets' => [
        'image' => [
            'label' => 'Image Large',
            'type' => 'text',
            'attributes' => [
                'class' => 'required cfind',
                'cfind-type' => 'image',
                'cfind-alt' => 1,
                'cfind-thumb' => '1440x560',
                'cfind-convert' => 'webp',
            ],
        ],
        'image-medium' => [
            'type' => 'text',
            'label' => 'Image Medium',
            'attributes' => [
                'class' => 'cfind',
                'cfind-type' => 'image',
                'cfind-thumb' => '768x590',
                'cfind-convert' => 'webp'
            ],
        ],
        'image-small' => [
            'type' => 'text',
            'label' => 'Image Small',
            'attributes' => [
                'class' => 'cfind',
                'cfind-type' => 'image',
                'cfind-thumb' => '375x805',
                'cfind-convert' => 'webp'
            ],
        ],
        'subtitle' => [
            'type' => 'text',
            'label' => 'Subtitle',
            'multilang' => true,
            'ai' => ['translate','correction'],
            'attributes' => [
                'class' => 'required',
                'maxlength' => 50
            ],
        ],
        'title' => [
            'type' => 'text',
            'label' => 'Title',
            'multilang' => true,
            'ai' => ['translate','correction'],
            'attributes' => [
                'class' => 'required',
                'maxlength' => 50
            ],
        ],
    ],
];