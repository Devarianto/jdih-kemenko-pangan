<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use App\Models\StatusProject;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\CreateTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\DeleteTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;

class StatusProjectController extends Controller
{
	use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait;
	
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
            ]
        ];
    }
}
