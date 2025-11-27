<?php namespace App\Http\Controllers\Admin\Misc;

use App\Http\Controllers\Controller;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ConfTrait;

class OfflineController extends Controller
{
	use BaseTrait, ConfTrait;
	
	public function configFields()
	{
		return [
			'background'=>[
				'type'=>'text',
				'label'=>'Background',
				'attributes'=>[
					'class'=>'required cfind',
					'cfind-type'=>'image',
					'cfind-alt'=>1,
					'cfind-thumb'=>'offline-background',
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
			'intro'=>[
				'type'=>'textarea',
				'label'=>'Intro',
				'multilang'=>true,
			],
		];	
	}
}	