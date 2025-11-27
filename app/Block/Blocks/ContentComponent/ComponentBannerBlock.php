<?php namespace App\Block\Blocks\ContentComponent;

class ComponentBannerBlock
{
	public static $codename = 'component-banner';

	public static function cmsWidgets()
	{
		return [
			'component-banner-banner'=>[
				'type'=>'widget',
				'max'=>1,
				'more-label'=>'Add banner',
				'subtitle'=>'Banner',
				'draft'=>true,
				'widgets'=>[
					'image'=>[
						'type'=>'text',
						'label'=>'Banner',
						'attributes'=>[
							'class'=>'required cfind',
							'cfind-type'=>'image',
							'cfind-alt'=>1,
							'cfind-thumb'=>'component-banner-banner',
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
				],	
			],
		];
	}

	public static function render($menu)
	{
		return view('dynamic.blocks.content-component.component-banner',['menu'=>$menu]);
	}
}	