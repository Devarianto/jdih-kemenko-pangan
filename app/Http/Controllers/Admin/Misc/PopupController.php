<?php

namespace App\Http\Controllers\Admin\Misc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ConfTrait;

class PopupController extends Controller
{
    use BaseTrait, ConfTrait;

    public function configFields()
    {
        return [
            'active' => [
                'type' => 'select',
                'label' => 'Active',
                'options' => ['yes' => 'Yes', 'no' => 'No'],
            ],
            'session-display' => [
                'type' => 'select',
                'label' => 'Session Display',
                'info' => 'If yes, the popup will be displayed only once per session. If no, the popup will be displayed on every page load.',
                'options' => ['no' => 'No', 'yes' => 'Yes'],
            ],
            'session-time' => [
                'type' => 'text',
                'label' => 'Session Time',
                'info' => 'In Minute',
                'attributes' => [
                    'class' => 'required numeric'
                ],
            ],
            'image' => [
                'type' => 'text',
                'label' => 'Image',
                'attributes' => [
                    'class' => 'cfind required',
                    'cfind-thumb' => 'home-popup-image',
                    'cfind-type' => 'image',
                    'cfind-alt' => 1,
                ]
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
                'ai' => ['translate','correction'],
            ],
            'cta' => [
                'type' => 'widget',
                'max' => 1,
                'min' => 1,
                'subtitle' => 'CTA',
                'widgets' => [
                    'label' => [
                        'type' => 'text',
                        'multilang' => true,
                        'label' => 'Label',
                        'info'=>'Maximal 15 characters',
                        'attributes' => [
                            'class' => 'required',
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
                    'url' => [
                        'type' => 'text',
                        'multilang' => true,
                        'label' => 'URL',
                        'info' => 'can use permalink or http/https',
                        'attributes' => [
                            'class' => 'required'
                        ],
                    ],
                ],
            ],
        ];
    }

    public function configAppend()
    {
        return '<script>
            $(document).ready(function() {
                function toggleSessionTime() {
                    if ($("select[name=\"session-display\"]").val() === "yes") {
                        $("input[name=\"session-time\"]").addClass("required").closest(".form-group").show();
                    } else {
                        $("input[name=\"session-time\"]").removeClass("required").val("").closest(".form-group").hide();
                    }
                }

                toggleSessionTime();
                $("select[name=\"session-display\"]").change(function() {
                    toggleSessionTime();
                });
            });
        </script>';
    }
}
