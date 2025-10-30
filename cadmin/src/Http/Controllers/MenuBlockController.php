<?php  namespace Cactuar\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Block\Block;
use Auth;

class MenuBlockController extends MenuTreeViewController
{
	protected $templates = [];
    
    protected $deep = 3;
	
	public function __construct()
	{
		parent::__construct();
		$blocks = $templates = [];

		foreach(Block::blocks() as $v)
			$blocks[$v::$codename] = $v;
		
		$blocktemplates = ['home'=>Block::home()] + Block::templates();
		$blocktemplates['home']['label'] = 'Home';
		$blocktemplates['home']['max'] = 1;
		
		foreach($blocktemplates as $k=>$v) {
			$b = [];
			foreach($v['blocks'] as $vv)
				$b[$vv::$codename] = $vv;
			$v['blocks'] = $b;

			$templates[$k] = $v;
		}
		
		foreach($templates as $templateid=>$template) {
			$t = [
				'label'=>array_get($template,'label'),
				'preview'=>array_get($template,'preview'),
				'widgets'=>[],
				'max'=>array_get($template,'max') ?: null,
			];
			
			foreach($template['blocks'] as $blockid=>$block) {
				if (!array_key_exists($blockid,$blocks))
					continue;
				
				$block = $blocks[$blockid];

				foreach($block::cmsWidgets() as $widgetid=>$widget) {
					$t['widgets'][$widgetid] = $widget;
				}
			}
			$this->templates[$templateid] = $t;
		}
	}
	
	public function formFields($type)
	{
		$fields = parent::formFields($type);
		
		$positionidx = 0;
		$idx = 0;
		foreach($fields as $k=>$v) {
			if ($k == 'position')
				$positionidx = $idx;
			$idx++;
		}
		
		\Cactuar\Admin\Helpers\helper::array_insert($fields,[
			'mainthumb'=>[
				'type'=>'widget',
				'max'=>1,
				'min'=>1,
				'more-label'=>'Add thumbnail',
				'widgets'=>[
					'header-thumb'=>[
						'type'=>'text',
						'label'=>'Thumbnail',
						'attributes'=>[
							'class'=>' cfind',
							'cfind-type'=>'image',
							'cfind-alt'=>1,
							'cfind-thumb'=>'header-double-thumb',
						],
					],
				],	
			],	
		],$positionidx+1);
		
		return $fields;
	}
	
	public function formAppend()
	{
		$html = '
			<script>
				$(\'select[origin=position]\').on("change", function(e) { 
					let exists = false;
					$.each($(this).val(),function(k,v) {
						if (v == \'mainthumb\')
							exists = true;
					});
					if (exists == true)
						$(\'.widgets[widget-source=mainthumb]\').show();
					else
						$(\'.widgets[widget-source=mainthumb]\').hide();
				}).trigger(\'change\');
			</script>
		';
		foreach(Block::blocks() as $v) {
			if (method_exists($v,'cmsAppend'))
				$html .= $v::cmsAppend();
		}
		
		return $html;
	}
}