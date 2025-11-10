<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicantDivision;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\CreateTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\DeleteTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;

class ApplicantDivisionController extends Controller
{
	use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait;
	
	public function listingRes()
	{
		return ApplicantDivision::translate();
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
		return new ApplicantDivision;
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
