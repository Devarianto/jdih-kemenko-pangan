<?php namespace App\Block\Blocks\SectionFeatures;

class SectionFeaturesCenterBlock
{
	public static $codename = 'section-features-center'; //harus unique

	public static function cmsWidgets()
	{
		return [

            'section-feature-center' => [
                'type' => 'widget',
                'subtitle' => 'Section feature center',
                'draft' => true,
                'widgets' => [

                    'icon' => [
                        'type' => 'text',
                        'label' => 'Icon',
                        'attributes' => [
                            'class' =>'wa-icon-input'
                        ]
                    ],
                    'title' => [
                        'type' => 'text',
                        'label' => 'Title',
                        'multilang' => true,
                    ],
                    'intro' => [
                        'type' => 'text',
                        'label' => 'Intro',
                        'multilang' => true,
                    ]
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
		return view('dynamic.blocks.section-features.section-features-center',['menu'=>$menu]);
	}
}
