<?php

return [
    'label' => 'Text Content',
    'subtitle' => 'Text Content',
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
        'content' => [
            'type' => 'textarea',
            'label' => 'Content',
            'multilang' => true,
            'ai' => ['translate','correction'],
            'attributes' => [
                'class' => 'required ckeditor'
            ],
        ],
    ],
];