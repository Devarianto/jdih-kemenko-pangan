<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cactuar\Admin\Traits\Models\TranslateTrait;
use Cactuar\Admin\Traits\Models\PermalinkTrait;

use lang;
use Carbon\Carbon;

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
				$text = 'https://www.facebook.com/sharer/sharer.php?u=' . url($this->permalink_document);
				break;
			case self::SHARE_LINKEDIN:
				$text = 'https://www.linkedin.com/sharing/share-offsite/?url=' . url($this->permalink_document);
				break;
			case self::SHARE_TWITTER:
				$text = 'https://twitter.com/intent/tweet?text=' . url($this->permalink_document);
				break;
			case self::SHARE_WHATSAPP:
				$text = 'https://api.whatsapp.com/send?text=' . url($this->permalink_document);
				break;
			case self::SHARE_INSTAGRAM:
				$text = 'https://www.instagram.com/share?text=' . url($this->permalink_document);
				break;
            case self::SHARE_EMAIL:
                $text = 'mailto:?subject=I wanted you to see this site&body=Check out this ' . url($this->permalink_document);
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

    public function master_document()
    {
        return $this->belongsTo(MasterDocument::class, 'master_document_id');
    }

    public function getTagColorHomeAttribute()
    {
        $master_document = $this->master_document == null ? null : $this->master_document->id;
        if ($master_document == self::PUTUSAN) {
            return '#091D77';
        } else if ($master_document == self::PERATURAN) {
            return '#091D77';
        } else if ($master_document == self::KLIPING) {
            return '#0086A7';
        } else if ($master_document == self::MAJALAH) {
            return '#0086A7';
        } else if ($master_document == self::JURNAL) {
            return '#0086A7';
        } else if ($master_document == self::MONOGRAFI) {
            return '#0086A7;';
        } else if ($master_document == self::NASKAH) {
            return '#091D77;';
        }
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

    public function getPermalinkDocumentAttribute()
    {
        $master_document = $this->master_document == null ? null : $this->master_document->id;
        if ($master_document == self::PUTUSAN) {
            return $this->customPermalink('document-putusan');
        } else if ($master_document == self::PERATURAN) {
            return $this->customPermalink('document-peraturan');
        } else if ($master_document == self::KLIPING) {
            return $this->customPermalink('document-kliping');
        } else if ($master_document == self::MAJALAH) {
            return $this->customPermalink('document-majalah');
        } else if ($master_document == self::JURNAL) {
            return $this->customPermalink('document-jurnal');
        } else if ($master_document == self::MONOGRAFI) {
            return $this->customPermalink('document-monografi');
        } else if ($master_document == self::NASKAH) {
            return $this->customPermalink('document-naskah');
        }
    }

    public function getApiJenisAttribute()
    {
        $master_document = $this->master_document_id;

        if ($master_document == self::PERATURAN) {
            return $this->jenis_bentuk_peraturan;
        } else {
            return '-';
        }
    }

    public function getApiTahunPengundanganAttribute()
    {
        $master_document = $this->master_document_id;

        if ($master_document == self::PERATURAN) {
            return !$this->tanggal_pengundangan ? '-' : Carbon::parse($this->tanggal_pengundangan)->format('Y');
        } else {
            return '-';
        }
    }

    public function getApiTanggalPengundanganAttribute()
    {
        $master_document = $this->master_document_id;

        if ($master_document == self::PERATURAN) {
            return !$this->tanggal_pengundangan ? '-' : $this->tanggal_pengundangan;
        } else {
            return '-';
        }
    }

    public function getApiNoPeraturanAttribute()
    {
        $master_document = $this->master_document_id;

        if ($master_document == self::PERATURAN) {
            return !$this->no_peraturan ? '-' : $this->no_peraturan;
        } else {
            return '-';
        }
    }

    public function getApiJudulAttribute()
    {
        return $this->title;
    }

    public function getApiNoPanggilAttribute()
    {
        $master_document = $this->master_document_id;

        if (in_array($master_document, [self::MONOGRAFI, self::JURNAL])) {
            return !$this->no_panggil ? '-' : $this->no_panggil;
        } else {
            return '-';
        }
    }

    public function getApiSingkatanJenisAttribute()
    {
        return $this->singkata_jenis_peraturan ?? '-';
    }

    public function getApiTempatTerbitAttribute()
    {
        return $this->tempat_terbit ?? '-';
    }

    public function getApiPenerbitAttribute()
    {
        $master_document = $this->master_document_id;
        if ($master_document == self::MONOGRAFI) {
            return !$this->penerbit ? '-' : $this->penerbit;
        } else {
            return '-';
        }
    }

    public function getApiDeskripsiFisikAttribute()
    {
        $master_document = $this->master_document_id;

        if ($master_document == self::MONOGRAFI) {
            return !$this->deskripsi_fisik ? '-' : $this->deskripsi_fisik;
        } else {
            return '-';
        }
    }

    public function getApiSumberAttribute()
    {
        return $this->sumber ?? '-';
    }

    public function getApiSubjekAttribute()
    {
        return $this->subjek ?? '-';
    }

    public function getApiStatusAttribute()
    {
        $master_document = $this->master_document_id;

        if ($master_document == self::PERATURAN) {
            if ($this->status_berlaku == 0) {
                return 'tidak berlaku';
            } else if ($this->status_berlaku == 1) {
                return 'masih berlaku';
            }
        } else {
            return '-';
        }
    }

    public function getApiBahasaAttribute()
    {
        return $this->bahasa ?? '-';
    }

    public function getApiBidangHukumAttribute()
    {
        return $this->bidang_hukum ?? '-';
    }

    public function getApiIsbnAttribute()
    {
        return $this->isbn ?? '-';
    }

    public function getApiTeuBadanAttribute()
    {
        return $this->teu ?? '-';
    }

    public function getApiNomorIndukBukuAttribute()
    {
        $master_document = $this->master_document_id;

        if ($master_document == self::MONOGRAFI) {
            return $this->nomor_induk_buku ?? '';
        } else {
            return '-';
        }
    }
    
}
