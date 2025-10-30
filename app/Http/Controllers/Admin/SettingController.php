<?php namespace App\Http\Controllers\Admin;

use Cactuar\Admin\Http\Controllers\SettingController as BaseController;

class SettingController extends BaseController
{
    public function configFields()
    {
        $fields = parent::configFields();
        
        return $fields;
    }
}