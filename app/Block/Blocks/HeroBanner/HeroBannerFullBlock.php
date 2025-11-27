<?php namespace App\Block\Blocks\HeroBanner;

class HeroBannerFullBlock
{
	public static $codename = 'hero-banner-full'; //harus unique
	
	public static function cmsWidgets()
	{
		return [
			'hero-banner-full-banner'=>[
				'type'=>'widget',
				'min'=>1,
				'subtitle'=>'Banner',
				'more-label'=>'Add banner',
				'draft'=>true,
				'widgets'=>[
					'type'=>[
						'type'=>'select',
						'label'=>'Type',
						'options'=>['image'=>'Image','video'=>'Video'],
					],
					'image-large'=>[
						'type'=>'text',
						'label'=>'Banner (large)',
						'attributes'=>[
							'class'=>'cfind required',
							'cfind-type'=>'image',
							'cfind-alt'=>1,
							'cfind-thumb'=>'hero-banner-full-large',
							'cfind-convert'=>'webp',
						],
					],
					'image-medium'=>[
						'type'=>'text',
						'label'=>'Banner (medium)',
						'attributes'=>[
							'class'=>'cfind required',
							'cfind-type'=>'image',
							'cfind-thumb'=>'hero-banner-full-medium',
							'cfind-convert'=>'webp',
						],
					],
					'image-small'=>[
						'type'=>'text',
						'label'=>'Banner (small)',
						'attributes'=>[
							'class'=>'cfind required',
							'cfind-type'=>'image',
							'cfind-thumb'=>'hero-banner-full-small',
							'cfind-convert'=>'webp',
						],
					],
					'video'=>[
						'type'=>'text',
						'label'=>'Video',
						'attributes'=>[
							'class'=>'cfind required',
							'cfind-type'=>'file',
							'cfind-ext'=>'mp4',
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
					'hero-banner-full-buttons'=>[
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
				],
			],
		];
	}

	public static function cmsAppend()
	{
		return view('dynamic.blocks.admin.hero-banner.hero-banner-full-admin');
	}
	
	public static function render($menu)
	{
		return view('dynamic.blocks.hero-banner.hero-banner-full',['menu'=>$menu]);
	}
}