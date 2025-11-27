<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicationGrid as Publication;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\CreateTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\DeleteTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;

class PublicationGridController extends Controller
{
	use BaseTrait, ListingTrait, CreateTrait, EditTrait, PublishTrait, DeleteTrait;

	public function listingRes()
	{
		return Publication::translate();
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

	public function formRes()
	{
		return new Publication;
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
					'class'=>'required',
				],	
			],
			'thumb'=>[
				'type'=>'text',
				'label'=>'Thumbnail',
				'draft'=>true,
				'attributes'=>[
					'class'=>'cfind required',
					'cfind-type'=>'image',
					'cfind-alt'=>1,
					'cfind-thumb'=>'publication-thumb',
				],
			],
			'doc'=>[
				'type'=>'text',
				'label'=>'File',
				'multilang'=>true,
				'attributes'=>[
					'class'=>'cfind required',
					'cfind-type'=>'file',
				],
			],
			'date'=>[
				'label'=>'Date',
				'type'=>'text',
				'draft'=>true,
				'attributes'=>[
					'class'=>'required datepicker',
				],	
			],
			'is_highlight'=>[
				'type'=>'select',
				'label'=>'Highlight',
				'options'=>[
					0=>'no',1=>'yes',
				],
				'attributes'=>[
					'style'=>'max-width:200px',
				],	
			],
			'intro'=>[
				'type'=>'textarea',
				'label'=>'Intro<script>
					$(\'select[origin=is_highlight]\').change(function() {
						if($(this).val() == 1) 
							$(\'.form-group[origin=intro]\').show();
						else
							$(\'.form-group[origin=intro]\').hide();

					}).trigger(\'change\');
				</script>',
				'draft'=>true,
				'multilang'=>true,
			],
		];
	}

	public function formCallbackAfter($item)
	{
		if ((int) $item->is_highlight == 1) {
			Publication::where('id','!=',$item->id)->update(['is_highlight'=>0]);
		}	
		return true;
	}

	public function listingCallback($key,$value,$item)
	{
		if ($key == 'date' && $value)
			return date2string($value,'d F Y');

		if ($key == 'label' && $item->is_highlight == 1) 
			return '<b style="display:inline-block;padding:5px 10px;background:#c7ffd7;color:#144a23;">'.e($value).'</b>';
	}
}