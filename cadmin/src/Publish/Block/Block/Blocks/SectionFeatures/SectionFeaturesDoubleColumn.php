<?php namespace App\Block\Blocks\SectionFeatures;

class SectionFeaturesDoubleColumn
{
	public static $codename = 'section-features-double-column'; //harus unique

	public static function cmsWidgets()
	{
		return [

            'section-feature-double-column-content' => [
                'type' => 'widget',
                'subtitle' => 'Content (Double Column)',
                'draft' => true,
                'widgets' => [
                    'icon' => [
                        'type' => 'text',
                        'label' => 'Icon',
                        'attributes' => [
                            'class' => 'cfind',
                            'cfind-type' => 'image',
                            'cfind-thumb' => '243x243'
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
