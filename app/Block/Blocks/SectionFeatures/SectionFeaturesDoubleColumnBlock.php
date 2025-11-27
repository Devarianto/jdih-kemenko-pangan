<?php namespace App\Block\Blocks\SectionFeatures;

class SectionFeaturesDoubleColumnBlock
{
	public static $codename = 'section-features-double-column'; //harus unique

	public static function cmsWidgets()
	{
		return [

            'section-feature-double-column' => [
                'type' => 'widget',
                'subtitle' => 'Section feature double column',
                'draft' => true,
                'widgets' => [
                    'icon' => [
                        'type' => 'text',
                        'label' => 'Icon',
                        'attributes' => [
                            'class' => 'cfind required',
                            'cfind-type' => 'image',
                            'cfind-thumb' => 'section-feature-double-column-icon',
                            'cfind-alt'=>1,
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
		return view('dynamic.blocks.section-features.section-features-double-column',['menu'=>$menu]);
	}
}
