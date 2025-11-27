<?php namespace Cactuar\Admin\Helpers;

class form
{
    protected static function attr($attr)
    {
        $html = '';
        foreach($attr as $k=>$v) {
            $html .= $k.'="'.e($v).'" ';
        }   

        return $html;
    }

	public static function open($attr)
	{
        $attr['action'] = array_get($attr,'url');
        if (array_key_exists('url', $attr)) {
            unset($attr['url']);
        }
        if (!array_get('method',$attr)) {
            $attr['method'] = 'post';
        }
        return '<form '.self::attr($attr).'><input type="hidden" name="_token" value="'.csrf_token().'">';
	}

    public static function close()
    {
        return '</form>';
    }

    public static function select($name,$options,$val,$attr)
    {
        $html = '<select name="'.e($name).'" '.self::attr($attr).'>';
        foreach($options as $k=>$v) {
            $html .= '<option value="'.e($k).'" '.(($k == $val) ? 'selected' : '').'>'.e($v).'</option>';
        }
        $html .= '</select>';

        return $html;
    }

    public static function text($name,$val,$attr)
    {
        return '<input type="text" name="'.e($name).'" value="'.e($val).'" '.self::attr($attr).'>';
    }

    public static function textarea($name,$val,$attr)
    {
        return '<textarea name="'.e($name).'" '.self::attr($attr).'>'.e($val).'</textarea>';
    }

    public static function hidden($name,$val,$attr)
    {
        return '<input type="hidden" name="'.e($name).'" value="'.e($val).'" '.self::attr($attr).'>';
    }

    public static function checkbox($name,$val,$checked,$attr)
    {
        return '<input type="checkbox" name="'.e($name).'" value="'.e($val).'" '.(($checked == true) ? 'checked' : '').' '.self::attr($attr).'>';
    }   
}