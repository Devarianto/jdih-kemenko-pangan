<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\CreateTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\DeleteTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;
use Cactuar\Admin\Traits\Controllers\EmailTemplateTrait;
use Cactuar\Admin\Models\EmailSending;

use App\Models\Account;

use Illuminate\Validation\Rule;
use Validator;
use Str;

class AccountController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait, EmailTemplateTrait;

    public function emailTemplates()
    {
        return [
            'send-account-user' => [
                'type' => 'End User',
                'label' => 'Kirim notif email ke user jdih',
		        'required' => true,
                'keywords' => [
                    'name' => 'Name',
                    'email' => 'Email',
                    'password' => 'Password'
                ]
            ]
        ];
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
        return ['name', 'email'];
    }
    
    public function formRes()
    {
        return new Account;
    }

    public function getCreate()
    {
        $data = new Account;
        $type = 'create';
        return view('admin.account.form', compact('data', 'type'));
    }

    public function postCreate(Request $request)
    {
        $validator = $this->validator($request, 'create');

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $save = $this->saveAccount($request, 'create');

        return redirect()->back()->withSuccess('Successfully create new user!');
    }

    public function getEdit()
    {
        $unique = request()->query('unique');
        $data = Account::findOrFail($unique);
        $type = 'detail';
        return view('admin.account.form', compact('data', 'type'));
    }

    public function postEdit(Request $request)
    {
        $validator = $this->validator($request, 'edit');

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $save = $this->saveAccount($request, 'edit');

        return redirect()->back()->withSuccess('Successfully edit user!');
    }

    public function listingCustomActs($item)
    {
        $button = [];

        if (\Auth::user()->allow('account', 'new-password')) {
            $button['new-password'] = '<a href="'.url()->admin($this->module().'/new-password').'?unique='.$item->id.'" class="btn btn-green">New Password</a>';
        }
        
        return $button;
    }

    public function getNewPassword()
    {
        return view('admin.account.new-password');
    }

    public function postNewPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $account = Account::findOrFail($request->query('unique'));
        $account->password = bcrypt($request->password);
        $account->save();

        try {
            EmailSending::initial('send-account-user')->data([
                'name' => $account->name,
                'email' => $account->email,
                'password' => $request->password
            ])->to($account->email)->send();
        } catch (\Throwable $th) {
            \Log::error($th);
        }

        return redirect()->back()->withSuccess('Success update password');
    }

    public function validator($request, $type)
    {
        $unique = request()->query('unique');
        $valid = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email'
            ]
        ];

        if ($type == 'edit') {
            array_push($valid['email'], Rule::unique('accounts')->ignore($unique));
        } else {
            array_push($valid['email'], 'unique:accounts,email');
        }

        $validator = Validator::make($request->all(), $valid);

        return $validator;
    }

    public function saveAccount($request, $type)
    {
        $model = null;

        if ($type == 'create') {
            $model = new Account;
        } else if ($type == 'edit') {
            $model = Account::findOrFail(request()->query('unique'));
        } else {
            abort(500);
        }
        
        $password = Str::random(10);
        $account = $model;
        $account->name = strip_tags($request->name);
        $account->email = $request->email;
        if ($type == 'create') {
            $account->password = bcrypt($password);
        }
        $account->is_active = $request->is_active;
        $account->save();

        if ($type == 'create') {
            try {
                EmailSending::initial('send-account-user')->data([
                    'name' => $account->name,
                    'email' => $account->email,
                    'password' => $password
                ])->to($account->email)->send();
            } catch (\Throwable $th) {
                \Log::error($th);
            }
        }

        return $account;
    }
}
