<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\CreateTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\DeleteTrait;
use Cactuar\Admin\Traits\Controllers\DownloadTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;
use Cactuar\Admin\Traits\Controllers\EmailTemplateTrait;
use App\Models\Rating;

class RatingController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait, DownloadTrait, EmailTemplateTrait;

    public function emailTemplates()
    {
        return [
            'rating-submit-admin' => [
                'type' => 'Admin',
                'label' => 'Send notif email to admin',
		        'required' => true,
                'keywords' => [
                    'rating' => 'Rating',
                    'name' => 'Name',
                    'email' => 'Email',
                    'comment' => 'Comment',
                ]
            ],
            'rating-submit-user' => [
                'type' => 'End User',
                'label' => 'Send notif email thankyou to user',
		        'required' => false,
                'keywords' => [
                    'rating' => 'Rating',
                    'name' => 'Name',
                    'email' => 'Email',
                    'comment' => 'Comment',
                ]
            ],
        ];
    }

    public function listingRes()
    {
        return Rating::select();
    }
    
    public function listingFields()
    {
        return [
            'name' => 'Name',
            'rating' => 'Rating',
            'email' => 'Email',
            'comment' => 'Comment'
        ];
    }

    public function listingCallback($key, $value, $item, $type)
    {
        return e($value) ?? '-';
    }

    public function listingTimes()
    {
        return ['created_at' => 'Created'];
    }

    public function listingOrders()
    {
        return ['created_at' => 'Created'];
    }

    public function listingRanges()
    {
        return ['created_at'];
    }

    public function listingOrderDefault($q)
    {
        return $q->orderBy('created_at', 'desc');
    }

    public function listingBulkAction()
	{
		$acts = [];
		$this->deleteBulkAction($acts);

		return $acts;
	}
	
	public function formRes()
	{
	    return new Rating;
	}

    public function formFields($type)
    {
        $form = [];
        if ($type == 'create') {
            $form = [
                'name' => [
                    'type' => 'text',
                    'label' => 'Name',
                    'attributes' => [
                        'class' => 'required'
                    ]
                ],
                'email' => [
                    'type' => 'text',
                    'label' => 'Email',
                    'attributes' => [
                        'class' => 'required validEmail'
                    ]
                ],
                'comment' => [
                    'type' => 'textarea',
                    'label' => 'Comment',
                    'attributes' => []
                ]
            ];
        }

        $form['rating'] = [
                'type' => 'number',
                'label' => 'Rating',
                'info' => 'Please input min 1 to max 5',
                'attributes' => [
                    'class' => 'required',
                    'min' => 1,
                    'max' => 5
                ]
            ];

        return $form;
    }
}
