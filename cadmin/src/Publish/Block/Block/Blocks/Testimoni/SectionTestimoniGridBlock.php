<?php namespace App\Block\Blocks\Testimoni;

class SectionTestimoniGridBlock
{
	public static $codename = 'section-testimoni-grid'; //harus unique

	public static function cmsWidgets()
	{
		return [
			'section-testimoni-grid'=>[
				'type'=>'widget',
				'max'=>1,
				'subtitle'=>'Section Testimoni Grid',
				// 'more-label'=>'Add Section Testimoni Grid Content',
				'draft'=>true,
				'widgets'=>[
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

                    'label-button'=>[
						'type'=>'text',
						'label'=>'Label Button',
						'multilang'=>true,
					],

                    'url-button'=>[
						'type'=>'text',
						'label'=>'URL Button',
						'multilang'=>true,
					],

					'section-testimoni-grid-content'=>[
						'type'=>'widget',
						'more-label'=>'Add Content',
						'widgets'=>[
							'image'=>[
                                'type'=>'text',
                                'label'=>'Image',
                                'attributes' => [
                                    'class' => 'required cfind',
                                    'cfind-type' => 'image',
                                    'cfind-thumb' => 'section-testimoni-grid',
                                    'cfind-alt' =>  1,
                                ]
                            ],
							'title'=>[
								'type'=>'text',
								'label'=>'Title',
								'multilang'=>true,
								'attributes'=>[
									'class'=>'required',
								],
							],

                            'name'=>[
								'type'=>'text',
								'label'=>'Name',
								'attributes'=>[
									'class'=>'required',
								],
							],

                            'description'=>[
								'type'=>'textarea',
								'label'=>'Description',
								'multilang'=>true,
								'attributes'=>[
									'class'=>'required',
                                    'rows' => 3,
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
		return view('dynamic.blocks.testimoni.section-testimoni-grid',['menu'=>$menu]);
	}
}
