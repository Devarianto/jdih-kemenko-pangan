<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cactuar\Admin\Traits\Models\TranslateTrait;
use Cactuar\Admin\Traits\Models\PermalinkTrait;

class News extends Model
{
    use TranslateTrait, PermalinkTrait;
    
    protected $table = 'news';
    protected $module = 'information-news';

    const SHARE_FACEBOOK = 'fb';
	const SHARE_LINKEDIN = 'linkedin';
	const SHARE_TWITTER = 'tw';
	const SHARE_WHATSAPP = 'wa';
	const SHARE_INSTAGRAM = 'ig';
    const SHARE_EMAIL = 'email';

    public function share($type)
	{
		$text = '';
		switch (strtolower($type)) {
			case self::SHARE_FACEBOOK:
				$text = 'https://www.facebook.com/sharer/sharer.php?u=' . url($this->permalink);
				break;
			case self::SHARE_LINKEDIN:
				$text = 'https://www.linkedin.com/sharing/share-offsite/?url=' . url($this->permalink);
				break;
			case self::SHARE_TWITTER:
				$text = 'https://twitter.com/intent/tweet?text=' . url($this->permalink);
				break;
			case self::SHARE_WHATSAPP:
				$text = 'https://api.whatsapp.com/send?text=' . url($this->permalink);
				break;
			case self::SHARE_INSTAGRAM:
				$text = 'https://www.instagram.com/share?text=' . url($this->permalink);
				break;
            case self::SHARE_EMAIL:
                $text = 'mailto:?subject=I wanted you to see this site&body=Check out this ' . url($this->permalink);
                break;
		}

		return $text;
	}
}
