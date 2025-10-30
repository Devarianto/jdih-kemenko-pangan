<?php namespace App\Block\Blocks\Testimoni;

class SectionTestimoniColumnBlock
{
	public static $codename = 'section-testimoni-column'; //harus unique

	public static function cmsWidgets()
	{
		return [

            'section-testimoni-column' => [
                'type' => 'widget',
                'subtitle' => 'Section Testimoni Column',
                'draft' => true,
                'widgets' => [

                    'image'=>[
                        'type'=>'text',
                        'label'=>'Image',
                        'attributes' => [
                            'class' => 'required cfind',
                            'cfind-type' => 'image',
                            'cfind-thumb' => 'section-testimoni-column',
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

                    'intro'=>[
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
                            'style'=>'max-height:80px;',
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
		return view('dynamic.blocks.testimoni.section-testimoni-column',['menu'=>$menu]);
	}
}
