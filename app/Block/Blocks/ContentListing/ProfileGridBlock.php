<?php namespace App\Block\Blocks\ContentListing;

class ProfileGridBlock
{
	public static $codename = 'profile-grid'; //harus unique

	public static function cmsWidgets()
	{
		return [

            'profile-grid-content' => [
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

                    'profile-grid-profile'=>[
                    'type'=>'widget',
                    'more-label'=>'Add Profile',
						'widgets'=>[

							'image'=>[
                                'type'=>'text',
                                'label'=>'Image',
                                'attributes' => [
                                    'class' => 'required cfind',
                                    'cfind-type' => 'image',
                                    'cfind-thumb' => 'profile-grid-profile',
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
									'class'=>' ckeditor',
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
		return view('dynamic.blocks.content-listing.profile-grid',['menu'=>$menu]);
	}
}
