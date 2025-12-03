<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use App\Models\StatusProject;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;

class StatusProjectController extends Controller
{
	use BaseTrait, ListingTrait, EditTrait, PublishTrait;
	
	public function listingRes()
	{
		return StatusProject::translate();
	}
	
	public function listingFields()
	{
		return ['label' => 'Label'];
	}
	
	public function listingSearchs()
	{
		return ['label'];
	}
	
	public function formRes()
	{
		return new StatusProject;
	}
	
	public function formFields()
	{
		return [
			'label' => [
                'type' => 'text',
                'label' => 'Label',
                'multilang' => true,
                'attributes' => [
                    'class' => 'required',
                ]
            ],
			'color' => [
                'type' => 'color',
                'label' => 'Color Background',
                'attributes' => [
                    'class' => 'required form-control-color',
                ]
			],
			'color_label' => [
                'type' => 'color',
                'label' => 'Color Label',
                'attributes' => [
                    'class' => 'required form-control-color',
                ]
            ]
        ];
    }
}
