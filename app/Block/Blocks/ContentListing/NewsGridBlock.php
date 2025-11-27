<?php  namespace App\Block\Blocks\ContentListing;

use App\Models\NewsGrid;

class NewsGridBlock
{
	public static $codename = 'news-grid';

	public static function cmsWidgets()
	{
		return [];
	}

	public static function cmsAppend()
	{
		return '';
	}

	public static function render($menu)
	{
		$lists = NewsGrid::translate()->whereIsActive(1)->select('id','thumb','label','intro','date','author')
				->orderBy('date',request()->query('sort')=='asc' ? 'asc' : 'desc')
				->orderBy('id','desc')->paginate(9);

		return view('dynamic.blocks.content-listing.news-grid',['menu'=>$menu,'lists'=>$lists]);
	}
}