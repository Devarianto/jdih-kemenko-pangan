<?php namespace App\Http\Controllers\Admin\Misc;

use App\Http\Controllers\Controller;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ConfTrait;

class Page404CenterController extends Controller
{
	use BaseTrait, ConfTrait;
	
	public function configFields()
	{
		return [
			'image'=>[
				'type'=>'text',
				'label'=>'Background',
				'attributes'=>[
					'class'=>'required cfind',
					'cfind-type'=>'image',
					'cfind-alt'=>1,
					'cfind-thumb'=>'300x218',
					'cfind-convert'=>'webp',
				],
			],
			'title'=>[
				'type'=>'text',
				'label'=>'Title',
				'multilang'=>true,
				'attributes' => []
			],
			'intro'=>[
				'type'=>'textarea',
				'label'=>'Intro',
				'multilang'=>true,
				'attributes' => []
			]
		];	
	}
}	