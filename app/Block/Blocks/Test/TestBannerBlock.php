<?php namespace App\Block\Blocks\Test;

class TestBannerBlock
{
	public static $codename = 'test-banner'; //harus unique
	
	public static function cmsWidgets()
	{
		return [
			'test-banner-banner'=>[
				'type'=>'widget',
				//'min'=>1,
				'subtitle'=>'Banner',
				'widgets'=>[
					'banner'=>[
						'type'=>'text',
						'label'=>'Banner',
						'attributes'=>[
							'class'=>'cfind',
							'cfind-type'=>'image',
							'cfind-alt'=>1,
							'cfind-thumb'=>'test-banner-banner',
						],
					],
					'title'=>[
						'type'=>'text',
						'label'=>'Title',
						'multilang'=>true,
					],	
					'test-banner-buttons'=>[
						'type'=>'widget',
						'widgets'=>[
							'button'=>[
								'type'=>'text',
								'label'=>'Button',
								'info'=>'Button label',
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
		return view('dynamic.blocks.test-banner',['menu'=>$menu]);
	}
}