<?php

return [
    'label' => 'FAQ',
    'preview' => '/templates/faq.png',
    'widgets' => [
        'banner' => [],
        'faq' => [
            'type' => 'widget',
            'subtitle' => 'FAQ',
            'widgets' => [
                'title' => [
                    'label' => 'Title',
                    'type' => 'text',
                    'multilang' => true,
                    'attributes' => [
                        'class' => 'required'
                    ]
                ],
                'description' => [
                    'label' => 'Description',
                    'type' => 'textarea',
                    'multilang' => true,
                    'attributes' => [
                        'class' => 'required ckeditor'
                    ]
                ]
            ]
        ]
    ]
];