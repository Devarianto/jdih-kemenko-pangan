<?php namespace App\Block\Blocks\SectionFeatures;

class SectionFeaturesText
{
	public static $codename = 'section-features-text'; //harus unique

	public static function cmsWidgets()
	{
		return [

            'section-feature-text-content' => [
                'type' => 'widget',
                'subtitle' => 'Content (Text)',
                'draft' => true,
                'widgets' => [

                    'title' => [
                        'type' => 'text',
                        'label' => 'Title',
                        'multilang' => true,
                    ],
                    'intro' => [
                        'type' => 'textarea',
                        'label' => 'Intro',
                        'multilang' => true,
                        'attributes' => [
                            'rows' => 3
                        ]
                    ],

                    'label-button' => [
                        'type' => 'text',
                        'label' => 'Label button',
                        'multilang' => true,
                    ],
                ]
            ]
		];
	}

	public static function cmsAppend()
	{
		return '';
	}

	public static function render($menu)
	{
		return view('dynamic.blocks.section-features.section-features-text',['menu'=>$menu]);
	}
}
