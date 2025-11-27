<?php namespace App\Block\Blocks\ContentListing;

class ProfileColumnBlock
{
	public static $codename = 'profile-column'; //harus unique

	public static function cmsWidgets()
	{
		return [

            'profile-column-content' => [
                'type' => 'widget',
                'subtitle' => 'Content',
                'draft' => true,
                'widgets' => [

                    'title'=>[
                        'type'=>'text',
                        'label'=>'Title',
                        'multilang'=>true,
                        'attributes'=>[
                            'class'=>'required',
                        ],
                    ],

                    'intro'=>[
                        'type'=>'textarea',
                        'label'=>'Intro',
                        'multilang'=>true,
                        'attributes'=>[
                            'class'=>'required',
                            'rows' => 3
                        ],
                    ],

                    'description'=>[
                        'type'=>'textarea',
                        'label'=>'Description',
                        'multilang'=>true,
                        'attributes'=>[
                            'class'=>'required',
                            'rows' =>  3,
                        ],
                    ],

                    'profile-column-profile'=>[
                    'type'=>'widget',
                    'more-label'=>'Add Profile',
						'widgets'=>[

							'image'=>[
                                'type'=>'text',
                                'label'=>'Image',
                                'attributes' => [
                                    'class' => 'required cfind',
                                    'cfind-type' => 'image',
                                    'cfind-thumb' => 'profile-column-profile',
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

                            'position'=>[
								'type'=>'text',
								'label'=>'Position',
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
									'class'=>'ckeditor',
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
		return view('dynamic.blocks.content-listing.profile-column',['menu'=>$menu]);
	}
}
