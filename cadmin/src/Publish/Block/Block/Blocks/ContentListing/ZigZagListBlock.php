<?php  namespace App\Block\Blocks\ContentListing;

use App\Models\NewsGrid;

class ZigZagListBlock
{
	public static $codename = 'zigzag-list';

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
				->orderBy('id','desc')->paginate(6);

		return view('dynamic.blocks.content-listing.zigzag-list',['menu'=>$menu,'lists'=>$lists]);
	}
}
