<?php  

namespace App\Http\Controllers\Admin;

use	Cactuar\Admin\Models\Menu;
use Cactuar\Admin\Http\Controllers\MenuTreeViewController as BaseController;

class MenuController extends BaseController
{
	protected $templates = [];
    protected $mainMax = 7;
    protected $footBottomMax = 2;

    protected $positions = [
        'main'=>'Main Menu',
        'foot-top'=>'Top Footer Menu',
        'foot-bottom'=>'Bottom Footer Menu'
    ];
    
    protected $deep = 2;
    
    public function draftAble($item)
    {
        return !in_array($item->type, ['blank','url']);
    }

    public function __construct()
    {
        parent::__construct();
        $this->templates = config('templates');
        unset($this->templates['sections']);

        foreach ($this->templates as $key => &$template) {
            if (!isset($template['widgets'])) continue;

            foreach(config('templates.sections', []) as $section => $widget) {
                if (array_key_exists($section, $template['widgets']) && empty($template['widgets'][$section])) {
                    $template['widgets'][$section] = $widget;
                    if(isset($template['customs'][$section])){
                        $template['widgets'][$section] = array_replace_recursive($template['widgets'][$section], $template['customs'][$section]);
                    }
                }
            }
        }
    }

    public function formAppend($type){ 
        $module = $this->module();

        $template = request()->query('type') ?? $this->listingRes()->findOrFail(request()->query('unique'))->type;

        $view = 'admin.menu.'.$template;
        if(view()->exists($view)){
            return view($view, compact('module'));
        }

        return '';
    }

    public function formValidateCallback($post,$type,&$error)
    {
        if ($type == 'create'){
            if (isset($post['related']['position'])) {
                if (in_array('main', $post['related']['position'])) {
                    $mainMenu = Menu::position('main', true);
                    if (count($mainMenu) >= $this->mainMax) {
                        $error[] = 'Max position main is '.$this->mainMax.' menu, remove another menu from main position before continue.';
                        return false;
                    }
                    $footBottomMenu = Menu::position('foot-bottom', true);
                    if (count($footBottomMenu) >= $this->footBottomMax) {
                        $error[] = 'Max position foot-bottom is '.$this->footBottomMax.' menu, remove another menu from foot-bottom position before continue.';
                        return false;
                    }
                }
            }
        }
        if($type == 'edit'){
            $mainMenu = collect(Menu::position('main', true));
            $check = $mainMenu->where('id', request()->get('unique'))->first();
            if (!$check) {
                if (isset($post['related']['position'])) {
                    if (in_array('main', $post['related']['position'])) {
                        if ($mainMenu->count() >= $this->mainMax) {
                            $error[] = 'Max position main is '.$this->mainMax.' menu, remove another menu from '.$this->positions['main'].' position before continue.';
                            return false;
                        }
                    }
                }
            }
            $footBottomMenu = collect(Menu::position('foot-bottom', true));
            $checkFootBottom = $footBottomMenu->where('id', request()->get('unique'))->first();
            if (!$checkFootBottom) {
                if (isset($post['related']['position'])) {
                    if (in_array('foot-bottom', $post['related']['position'])) {
                        if (count($footBottomMenu) >= $this->footBottomMax) {
                            $error[] = 'Max position foot-bottom is '.$this->footBottomMax.' menu, remove another menu from '.$this->positions['foot-bottom'].' position before continue.';
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }
}