<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cactuar\Admin\Traits\Models\PermalinkTrait;
use Cactuar\Admin\Traits\Models\TranslateTrait;

class NewsColumn extends Model
{
	protected $table = 'news';
	use PermalinkTrait, TranslateTrait;
	protected $permalinkModule = 'news-column';
}