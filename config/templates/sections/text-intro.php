<?php

return [
    'label' => 'Text Intro',
    'subtitle' => 'Text Intro',
    'more-label' => 'Add Section',
    'max' => 1,
    'widgets' => [
        'title' => [
            'type' => 'text',
            'label' => 'Title',
            'multilang' => true,
            'ai' => ['translate', 'meta-title','correction'],
            'attributes' => [
                'class' => 'required'
            ],
        ],
        'intro' => [
            'type' => 'text',
            'label' => 'Intro',
            'multilang' => true,
            'ai' => ['translate','correction'],
            'attributes' => [
                'class' => 'required'
            ],
        ],
    ],
];