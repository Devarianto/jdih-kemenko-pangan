<?php namespace App\Block\Blocks\SectionService;

class SectionServiceGridBottomBlock
{
	public static $codename = 'section-service-grid-bottom'; //harus unique
	
	public static function cmsWidgets()
	{
		return [
			'section-service-grid-bottom'=>[
				'type'=>'widget', 
				'subtitle'=>'Section Service Grid Bottom',
				'more-label'=>'Add Section Service Grid Bottom',
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
						'type'=>'textarea',
						'label'=>'Intro',
						'multilang'=>true,
						'attributes' => [ 
                            'style' => 'height:80px', 
                        ]
					], 
					'is_slider'=>[
						'type'=>'select',
						'label'=>'Grid Slider',
						'options'=>[
							0=>'No',
							1=>'Yes'
						],
					],
					'section-service-grid-bottom-buttons'=>[
						'type'=>'widget',
						'max'=>1,
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
					'section-service-grid-bottom-list'=>[
						'type'=>'widget', 
						'more-label'=>'Add Item',
						'widgets'=>[
							'image'=>[
								'type'=>'text',
								'label'=>'Image',
								'attributes'=>[
									'class'=>'required cfind',
									'cfind-type'=>'image',
									'cfind-alt'=>1,
									'cfind-thumb'=>'section-service-grid-bottom-thumbnail',
									'cfind-convert'=>'webp',
								],
							],
							'title'=>[
								'type'=>'text',
								'label'=>'Title',
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
							'url'=>[
								'type'=>'text',
								'label'=>'URL',
								'multilang'=>true,
								'attributes'=>[
									'class'=>' url',
								],
							],
							'btn-label'=>[
								'type'=>'text',
								'label'=>'Button Label',
								'multilang'=>true,
								'attributes'=>[
									'class'=>'',
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
		return view('dynamic.blocks.section-service.section-service-grid-bottom',['menu'=>$menu]);
	}
}