<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Rating;

use Validator;
use lang;
use Cactuar\Admin\Models\EmailSending;

class RatingController extends Controller
{
    public function postSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'name' => 'required|string|max:255|rejectxss',
            'email' => 'required|custom_email|max:225',
            'comment' => 'required|string|rejectxss|max:300',
            'g-recaptcha-response' => 'required|recaptcha'
        ], [], [
            'rating' => lang::translate('home.rating.popup.form.title.rating'),
            'name' => lang::translate('home.rating.popup.form.title.name'),
            'email' => lang::translate('home.rating.popup.form.title.email'),
            'comment' => lang::translate('home.rating.popup.form.title.comment'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $rating = new Rating;
        $rating->rating = $request->rating;
        $rating->name = strip_tags($request->name);
        $rating->email = $request->email;
        $rating->comment = strip_tags($request->comment);
        $rating->save();

        try {
            $data = [
                'rating' => $rating->rating,
                'name' => $rating->name,
                'email' => $rating->email,
                'comment' => $rating->comment,
            ];
            
            EmailSending::initial('rating-submit-admin')->data($data)->send();
			EmailSending::initial('rating-submit-user')->data($data)->to($rating->email)->send();
		} catch(\Exception $e) {
            \Log::error($e);
        }

        return redirect()->back()->withSuccess('success submit');
    }
}
