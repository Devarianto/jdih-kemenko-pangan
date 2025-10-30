<?php namespace App\Block\Blocks\News;

use App\Models\NewsGrid;

class SectionNewsHighlightBlock
{
	public static $codename = 'section-news-highlight';

	public static function cmsWidgets()
	{
		return [
			'section-news-highlight-title'=>[
				'type'=>'widget',
				'max'=>1,
				'more-label'=>'Add news highlight',
				'subtitle'=>'News highlight',
				'widgets'=>[
					'subtitle'=>[
						'type'=>'text',
						'label'=>'Subtitle',
						'multilang'=>true,
						'draft'=>true,
					],
					'title'=>[
						'type'=>'text',
						'label'=>'Title',
						'multilang'=>true,
						'draft'=>true,
					],
				],
			]
		];
	}

	public static function render($menu)
	{
		$widget = widget($menu->id,'menu','section-news-highlight-title');
		if ($widget->count() <= 0)
			return '';

		$news = NewsGrid::whereIsActive(1)->translate()->select('id','label','intro','thumb','author','date')->orderBy('date','desc')->orderBy('id','desc')->limit(4)->get();
		
		$menunewstype = '';
		$menunews = null;
		foreach(\App\Block\Block::templates() as $k=>$t) {
			foreach(array_get($t,'blocks') ?: [] as $block) {
				if ($block::$codename == 'news-grid') {
					$menunewstype = $k;
					break;
				}
			}
		}
		if ($menunewstype) {
			$menunews = \Cactuar\Admin\Models\Menu::whereType($menunewstype)->whereIsActive(1)->first();
		}
		return view('dynamic.blocks.news.section-news-highlight',['menu'=>$menu,'news'=>$news,'menunews'=>$menunews,'widget'=>$widget]);
	}
}	