<?php namespace App\Block\Blocks\SectionService;

class SectionServiceColumnBlock
{
	public static $codename = 'section-service-column'; //harus unique
	
	public static function cmsWidgets()
	{
		return [
			'section-service-column'=>[
				'type'=>'widget', 
				'subtitle'=>'Section Service Column',
				'more-label'=>'Add Section Service Column',
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
					'section-service-column-buttons'=>[
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
					'section-service-column-list'=>[
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
									'cfind-thumb'=>'section-service-column-thumbnail',
									'cfind-convert'=>'webp',
								],
							],
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
							'description'=>[
								'type'=>'textarea',
								'label'=>'Description',
								'multilang'=>true,
								'attributes' => [ 
									'style' => 'height:80px', 
								]
							], 
							
							'btn-url'=>[
								'type'=>'text',
								'label'=>'Button URL',
								'multilang'=>true,
								'attributes'=>[
									'class'=>'url',
								],
							],
							'btn-label'=>[
								'type'=>'text',
								'label'=>'Button Label',
								'multilang'=>true,
								'attributes'=>[ 
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
		return view('dynamic.blocks.section-service.section-service-column',['menu'=>$menu]);
	}
}