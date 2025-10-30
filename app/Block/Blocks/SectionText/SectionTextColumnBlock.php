<?php namespace App\Block\Blocks\SectionText;

class SectionTextColumnBlock
{
	public static $codename = 'section-text-column'; //harus unique
	
	public static function cmsWidgets()
	{
		return [
			'section-text-column'=>[
				'type'=>'widget', 
				'subtitle'=>'Section Text Column',
				'more-label'=>'Add Section Text Column',
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
					'section-text-column-buttons'=>[
						'type'=>'widget',
						'max'=>2,
						'more-label'=>'Add button',
						'widgets'=>[
							'highlight'=>[
								'type'=>'select',
								'label'=>'Button Highlight',
								'options'=>[0=>'No',1=>'Yes'],
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
                    'section-text-column-data-list'=>[
                        'type'=>'widget', 
                        'subtitle'=>'Add Data list',
                        'more-label'=>'Add Data List', 
						'max'=>3, 
                        'widgets'=>[  
                            'title'=>[
                                'type'=>'text',
                                'label'=>'Data title',
                                'multilang'=>true,
                            ],
                            'description'=>[
                                'type'=>'text',
                                'label'=>'Data description',
                                'multilang'=>true,
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
		return view('dynamic.blocks.section-text.sectiontext-column',['menu'=>$menu]);
	}
}