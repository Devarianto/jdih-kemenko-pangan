<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\CategoryProject;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\CreateTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\DeleteTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;

use Validator;

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
        return ['name' => 'Name', 'email' => 'Email'];
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

        if (!preg_match("/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/", $email)) {
            $error[] = 'Please insert valid email!';
            return false;
        }

        $cek = Account::where('email',$email)->first();

        if ($type == 'create'){
            if(!empty($cek)){
                $error[] = 'Email already exist';
                return false;
              }
        }
        return true;
    }



    public function listingCustomActs($item)
    {

        return [
            '<a href="'.url()->admin($this->module().'/new-password?unique='.$item->id).'" class="btn bg-success btn-flat btn-info"><i class="fa fa-key"></i> New Password</a>',
        ];
      
    }

    public function getNewPassword(Request $request)
    {
        if ($request->queryValidated('unique','numeric|required')) {
            $account = Account::findOrFail($request->query('unique'));
            return view('admin.account.new-password', compact('account'));
        }
        abort(404);
    }

    public function postNewPassword(Request $request)
    {
        $validated = $request->validate([
            'unique' => 'required|numeric|exists:accounts,id',
            'password' => 'required|string|min:6',
        ]);

        $account = Account::findOrFail($validated['unique']);
        $account->password = bcrypt($validated['password']);
        $account->save();

        return back()->with('success', 'Password berhasil diperbarui.');
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
                        'class' => 'required validEmail',
                    ],
                ],
            ];

        if ($type == 'create')
        {
            $form['password'] =[
                    'type' => 'text',
                    'label' => 'Password',
                    'attributes' => [
                        'class' => 'required',
                    ],
                ];
            
        }

        return $form;
        
    }
}
