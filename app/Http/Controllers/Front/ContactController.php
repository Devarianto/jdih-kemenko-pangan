<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;

use Validator;
use lang;
use Cactuar\Admin\Models\EmailSending;

class ContactController extends Controller
{
    public function postSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|rejectxss',
            'email' => 'required|custom_email|max:225',
            'phone' => 'required|numeric|digits_between:10,13',
            'message' => 'required|string|rejectxss',
            'g-recaptcha-response' => 'required|recaptcha'
        ], [], [
            'name' => lang::translate('contact.form-title.name'),
            'email' => lang::translate('contact.form-title.email'),
            'phone' => lang::translate('contact.form-title.phone'),
            'message' => lang::translate('contact.form-title.message'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $contact = new Contact;
        $contact->name = strip_tags($request->name);
        $contact->email = $request->email;
        $contact->phone = strip_tags($request->phone);
        $contact->message = strip_tags($request->message);
        $contact->save();

        try {
            $data = [
                'name' => $contact->name,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'message' => $contact->message,
            ];
            
            EmailSending::initial('contact-submit-admin')->data($data)->send();
			EmailSending::initial('contact-submit-user')->data($data)->to($contact->email)->send();
		} catch(\Exception $e) {
            \Log::error($e);
        }

        return redirect()->back()->withSuccess('success submit');
    }
}
