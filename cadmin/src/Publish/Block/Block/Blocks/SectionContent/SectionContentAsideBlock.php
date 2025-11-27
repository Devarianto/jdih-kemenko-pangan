<?php namespace App\Block\Blocks\SectionContent;

class SectionContentAsideBlock
{
	public static $codename = 'section-content-aside'; //harus unique
	
	public static function cmsWidgets()
	{
		return [
			'section-content-aside'=>[
				'type'=>'widget', 
				'subtitle'=>'Section Content Aside',
				'more-label'=>'Add Section Content Aside',
				'draft'=>true,
				'widgets'=>[  
                    'image'=>[
						'type'=>'text',
						'label'=>'Image',
						'attributes'=>[
							'class'=>'required cfind',
							'cfind-type'=>'image',
							'cfind-alt'=>1,
							'cfind-thumb'=>'section-content-aside',
							'cfind-convert'=>'webp',
						],
					],
                    'iframe'=>[
						'type'=>'widget',
						'max'=>1,
						'more-label'=>'Add Video',
						'widgets'=>[ 
							'url'=>[
								'type'=>'text',
								'label'=>'Link Youtube', 
								'info'=>'Example : https://www.youtube.com/watch?v=9owCqghz-eQ',
								'attributes'=>[
									'class'=>'required url',
								],
							], 
						],
					],
                    'background'=>[
                        'type'=>'select',
                        'label'=>'Background',
                        'options'=>[
                            0=>'No',
                            1=>'Yes'
                        ],
                    ], 
                    'position'=>[
                        'type'=>'select',
                        'label'=>'Position',
                        'options'=>[
                            'left'=>'Left',
                            'right'=>'Right'
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
					'section-content-aside-buttons'=>[
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
		return view('dynamic.blocks.section-content.sectioncontent-aside',['menu'=>$menu]);
	}
}