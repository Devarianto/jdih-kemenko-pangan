<?php namespace App\Http\Controllers\Admin\Misc;

use App\Http\Controllers\Controller;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ConfTrait;

class Page404AsideController extends Controller
{
	use BaseTrait, ConfTrait;
	
	public function configFields()
	{
		return [
			'icon'=>[
				'type'=>'text',
				'label'=>'Icon',
				'info'=>'please use image 600px x 600px max',
				'attributes'=>[
					'class'=>'required cfind',
					'cfind-type'=>'image',
					'cfind-alt'=>1,
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
				'type'=>'textarea',
				'label'=>'Intro',
				'multilang'=>true,
			],
			'button'=>[
				'type'=>'text',
				'label'=>'Button',
				'multilang'=>true,
			],
		];	
	}
}	