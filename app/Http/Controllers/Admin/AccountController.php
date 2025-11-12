<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\CategoryProject;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\CreateTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\DeleteTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;

class AccountController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait;

    protected $kategori;

    public function __construct()
    {
        $this->category = new CategoryProject;
    }

    public function listingRes()
    {
        return Account::select();
    }
    
    public function listingFields()
    {
        return ['name' => 'Name', 'email' => 'Email', 'status_users' => 'Role'];
    }
    
    public function listingSearchs()
    {
        return ['name','email'];
    }

    public function formRes()
    {
        return new Account;
    }

    public function formCallbackBefore($post,$item,$type)
    {
        if ($type == 'create')
            $post['main']['password'] = bcrypt($post['main']['password']);
            
        return $post;
    }

    public function listingOrderDefault($res)
    {
        return $res->orderBy('created_at','desc');
    }


    public function formValidateCallback($post,$type,&$error)
    {
        $email = $post['main']['email'];
        $cek = Account::where('email',$email)->first();

        if ($type == 'create'){
            if(!empty($cek)){
                $error[] = 'Email already exist';
                return false;
              }
        }
        return true;
    }


    public function formFields($type)
    {

        $form = [
                'name' => [
                    'type' => 'text',
                    'label' => 'Name',
                    'attributes' => [
                        'class' => 'required',
                    ],
                ],
                'email' => [
                    'type' => 'text',
                    'label' => 'Email',
                    'attributes' => [
                        'class' => 'required',
                    ],
                ],
            ];

        if ($type == 'create')
        {
            $form['password'] =[
                    'type' => 'password',
                    'label' => 'Password',
                    'attributes' => [
                        'class' => 'required',
                    ],
                ];
            
        }

        return $form;
        
    }
}
