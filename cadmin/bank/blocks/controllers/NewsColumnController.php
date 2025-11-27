<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsColumn;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\CreateTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\DeleteTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;

class NewsColumnController extends Controller
{
	use BaseTrait, ListingTrait, CreateTrait, EditTrait, PublishTrait, DeleteTrait;

	public function listingRes()
	{
		return NewsColumn::translate();
	}

	public function listingOrderDefault($q)
	{
		return $q->orderBy('date','desc')->orderBy('id');
	}

	public function listingFields()
	{
		return ['date'=>'Date','label'=>'Label'];
	}

	public function listingSearchs()
	{
		return ['label'];
	}

	public function listingRanges()
	{
		return ['date'];
	}

	public function listingCallback($key,$value)
	{
		if ($key == 'date' && $value)
			return date2string($value,'d F Y');
	}	

	public function formRes()
	{
		return new NewsColumn;
	}

	public function formFields()
	{
		return [
			'label'=>[
				'type'=>'text',
				'label'=>'Label',
				'multilang'=>true,
				'draft'=>true,
				'attributes'=>[
					'class'=>'title required',
				],	
			],
			'permalink'=>[
				'type'=>'permalink'
			],
			'thumb'=>[
				'type'=>'text',
				'label'=>'Thumbnail',
				'draft'=>true,
				'attributes'=>[
					'class'=>'cfind required',
					'cfind-type'=>'image',
					'cfind-alt'=>1,
					'cfind-thumb'=>'news-column-thumb',
				],
			],
			'author'=>[
				'type'=>'text',
				'label'=>'Author',
				'draft'=>true,
			],
			'date'=>[
				'label'=>'Date',
				'type'=>'text',
				'draft'=>true,
				'attributes'=>[
					'class'=>'required datepicker',
				],	
			],
			'intro'=>[
				'type'=>'textarea',
				'label'=>'Intro',
				'draft'=>true,
				'multilang'=>true,
			],
		];
	}

	public function listingCallback($key,$value)
	{
		if ($key == 'date' && $value)
			return date2string($value,'d F Y');
	}
}