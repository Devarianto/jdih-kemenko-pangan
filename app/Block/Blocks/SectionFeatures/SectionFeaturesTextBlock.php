<?php namespace App\Block\Blocks\SectionFeatures;

class SectionFeaturesTextBlock
{
	public static $codename = 'section-features-text'; //harus unique

	public static function cmsWidgets()
	{
		return [

            'section-feature-text' => [
                'type' => 'widget',
                'subtitle' => 'Section feature text',
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
                    'section-feature-text-buttons'=>[
						'type'=>'widget',
						'max'=>2,
						'more-label'=>'Add button',
						'widgets'=>[
							'url'=>[
								'type'=>'text',
								'label'=>'Button URL',
								'multilang'=>true,
								'attributes'=>[
									'class'=>'required url',
								],
							],
							'label'=>[
								'type'=>'text',
								'label'=>'Button Label',
								'multilang'=>true,
								'attributes'=>[
									'class'=>'required',
								],
							],
						],
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
