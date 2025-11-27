<?php namespace App\Block\Blocks\SectionText;

class SectionTextCenterBlock
{
	public static $codename = 'section-text-center'; //harus unique
	
	public static function cmsWidgets()
	{
		return [
			'section-text-center'=>[
				'type'=>'widget', 
				'subtitle'=>'Section Text Center',
				'more-label'=>'Add Section Text Center',
				'draft'=>true,
				'widgets'=>[  
                    'subtitle'=>[
						'type'=>'text',
						'label'=>'Subtitle',
						'multilang'=>true,
					],
					'title'=>[
						'type'=>'text',
						'label'=>'Title',
						'multilang'=>true,
					],
					'intro'=>[
						'type'=>'text',
						'label'=>'Intro',
						'multilang'=>true,
					],
                    'description'=>[
						'type'=>'textarea',
						'label'=>'Description',
						'multilang'=>true,
						'attributes' => [ 
                            'style' => 'height:80px', 
                        ]
					], 
					'section-text-center-buttons'=>[
						'type'=>'widget',
						'max'=>2,
						'more-label'=>'Add button',
						'widgets'=>[
							'highlight'=>[
								'type'=>'select',
								'label'=>'Button Highlight',
								'options'=>[
                                    0=>'No',
                                    1=>'Yes'
                                ],
							],
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
				],
			],
		];
	}

	public static function cmsAppend()
	{
		return '';
	}
	
	public static function render($menu)
	{
		return view('dynamic.blocks.section-text.sectiontext-center',['menu'=>$menu]);
	}
}