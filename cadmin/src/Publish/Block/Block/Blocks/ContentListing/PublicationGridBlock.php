<?php  namespace App\Block\Blocks\ContentListing;

use App\Models\PublicationGrid as Publication;

class PublicationGridBlock
{
	public static $codename = 'publication-grid';

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
		$highlight = Publication::translate()->whereIsHighlight(1)->whereIsActive(1)
			->orderBy('updated_at','desc')->orderBy('id','desc')->first();

		$lists = Publication::translate()->where('id','!=',($highlight ? $highlight->id : 0))
			->orderBy('date',request()->get('sort') == 'asc' ? 'asc' : 'desc')
			->orderBy('id','desc')->paginate(9);

		return view('dynamic.blocks.content-listing.publication-grid',['menu'=>$menu,'highlight'=>$highlight,'lists'=>$lists]);
	}
}