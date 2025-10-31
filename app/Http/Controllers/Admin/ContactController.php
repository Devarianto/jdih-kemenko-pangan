<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\DeleteTrait;
use Cactuar\Admin\Traits\Controllers\DownloadTrait;
use Cactuar\Admin\Traits\Controllers\EmailTemplateTrait;
use App\Models\Contact;

class ContactController extends Controller
{
    use BaseTrait, ListingTrait, DeleteTrait, DownloadTrait, EmailTemplateTrait;

    public function emailTemplates()
    {
        return [
            'contact-submit-admin' => [
                'type' => 'Admin Custom',
                'label' => 'Send notif email to admin',
		        'required' => true,
                'keywords' => [
                    'name' => 'Name',
                    'email' => 'Email',
                    'phone' => 'Phone',
                    'message' => 'Message',
                ]
            ],
            'contact-submit-user' => [
                'type' => 'End User',
                'label' => 'Send notif email thankyou to user',
		        'required' => false,
                'keywords' => [
                    'name' => 'Name',
                    'email' => 'Email',
                    'phone' => 'Phone',
                    'message' => 'Message',
                ]
            ],
        ];
    }

    public function listingRes()
    {
        return Contact::select();
    }
    
    public function listingFields()
    {
        return [
            'name' => 'Name',
            'email' => 'email',
            'phone' => 'Phone',
            'message' => 'Message'
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
	    return new Contact;
	}
}
