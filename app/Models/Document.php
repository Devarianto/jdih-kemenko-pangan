<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cactuar\Admin\Traits\Models\TranslateTrait;
use Cactuar\Admin\Traits\Models\PermalinkTrait;

use lang;

class Document extends Model
{
    use TranslateTrait, PermalinkTrait;

    protected $table = 'documents';

    const PERATURAN = 1;
    const JURNAL = 2;
    const KLIPING = 3;
    const MAJALAH = 4;
    const PUTUSAN = 5;
    const MONOGRAFI = 6;
    const NASKAH = 7;

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

    public static function getId($value)
    {
        $constName = strtoupper($value);
        $class = __CLASS__; // atau nama class secara eksplisit

        if (defined("$class::$constName")) {
            return constant("$class::$constName");
        }

        return null; // jika tidak ditemukan
    }

    public function rule_type()
    {
        return $this->belongsTo(RuleType::class, 'rule_type_id');
    }

    public function rule_theme()
    {
        return $this->belongsTo(RuleTheme::class, 'rule_theme_id');
    }

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }

    public function getDisplayStatusBerlakuAttribute()
    {
        if ($this->status_berlaku == 0) {
            return 'Tidak';
        } else if ($this->status_berlaku == 1) {
            return 'Ya';
        }
        return '-';
    }

    public function getFrontStatusBerlakuAttribute()
    {
        if ($this->status_berlaku == 0) {
            return lang::translate('document.status-berlaku.tidak');
        } else if ($this->status_berlaku == 1) {
            return lang::translate('document.status-berlaku.ya');
        }
        return '-';
    }

    public function getFrontStatusTersediaAttribute()
    {
        if ($this->status_tersedia == 0) {
            return lang::translate('document.status-tersedia.tidak');
        } else if ($this->status_tersedia == 1) {
            return lang::translate('document.status-tersedia.ya');
        }
        return '-';
    }
}
