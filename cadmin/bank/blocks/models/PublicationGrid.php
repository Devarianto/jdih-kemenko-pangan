<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cactuar\Admin\Traits\Models\TranslateTrait;

class PublicationGrid extends Model
{
	use TranslateTrait;
	protected $table = 'publications';
}