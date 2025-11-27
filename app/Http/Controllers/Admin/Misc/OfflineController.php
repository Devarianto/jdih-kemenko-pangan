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
			'image'=>[
				'type'=>'text',
				'label'=>'Image',
				'attributes'=>[
					'class'=>'required cfind',
					'cfind-type'=>'image',
					'cfind-alt'=>1,
					'cfind-thumb'=>'310x316',
					'cfind-convert'=>'webp',
				],
			],
			'title'=>[
				'type'=>'text',
				'label'=>'Title',
				'multilang'=>true,
				'attributes' => [
					'maxlength' => 50
				]
			],
			'intro'=>[
				'type'=>'textarea',
				'label'=>'Intro',
				'multilang'=>true,
				'attributes' => [
					'maxlength' => 300
				]
			],
			'social-media' => [
				'type' => 'widget',
				'subtitle' => 'Social Media',
				'more-label' => 'Add Section',
				'widgets' => [
					'image' => [
						'type' => 'text',
						'label' => 'Image',
						'attributes'=>[
							'class'=>'cfind required',
							'cfind-type' => 'image',
							'cfind-alt'=>1,
						],
					],
					'link' => [
						'type' => 'text',
						'label' => 'Link',
						'info' => 'eg: https://instagram.com',
						'attributes' => [
							'class' => 'required url'
						]
					]
				]
			]
		];	
	}
}	