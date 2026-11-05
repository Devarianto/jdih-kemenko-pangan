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
use App\Models\Gallery;
use App\Models\VideoClassification;

use media;

class GalleryController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait;

    public function listingRes()
    {
        return Gallery::translate()->with('classifications');
    }
    
    public function listingFields()
    {
        return [
            'title' => 'Title',
            'type' => 'Type',
            'classification' => 'Klasifikasi',
            'thumbnail' => 'Thumbnail',
            'date' => 'Date',
        ];
    }

    public function listingFilters()
    {
        $classifications = VideoClassification::whereIsActive(1)->orderBy('sort_id')->pluck('name', 'id')->toArray();

        return [
            'type' => [
                'label' => 'Type',
                'options' => [
                    'image' => 'Image',
                    'video' => 'Video' 
                ]
            ],
            'classification_id' => [
                'label' => 'Klasifikasi Video',
                'options' => $classifications
            ]
        ];
    }

    public function listingFilterCallback($res, $filters)
    {
        if (!empty($filters['classification_id'])) {
            $classId = (int) $filters['classification_id'];
            $res->whereHas('classifications', function($q) use ($classId) {
                $q->where('video_classifications.id', $classId);
            });
        }

        return $res;
    }

    public function listingCallback($key, $value, $item, $type)
    {
        if ($key == 'date') {
            return date2string($value);
        }

        if ($key == 'classification') {
            if ($item->type !== 'video') {
                return '<span class="badge" style="background:#6c757d; color:#fff; font-size:11px; padding:4px 8px; border-radius:4px;">Foto</span>';
            }

            $cls = $item->classifications;
            if ($cls->isEmpty()) {
                return '<span class="badge" style="background:#ffc107; color:#212529; font-size:11px; padding:4px 8px; border-radius:4px;">Belum Diatur</span>';
            }

            $badges = '';
            foreach ($cls as $c) {
                $color = $c->code === 'aksesibilitas' ? '#198754' : '#0d6efd';
                $badges .= '<span class="badge" style="background:'.$color.'; color:#fff; font-size:11px; padding:4px 8px; border-radius:4px; margin-right:4px;">'.e($c->name).'</span>';
            }
            return $badges;
        }

        if ($key == 'thumbnail') {
            return '<img src="'.media::url($value).'" alt="" width="100">';
        }

        return e($value) ?? '-';
    }

    public function listingSearchs()
    {
        return ['title'];
    }

    public function listingOrderDefault($res)
    {
        return $res->orderBy('sort_id', 'asc')->orderBy('date', 'desc');
    }

    public function formRes()
    {
        return new Gallery;
    }

    public function formFields()
    {
        $classificationOptions = VideoClassification::whereIsActive(1)
            ->orderBy('sort_id')
            ->pluck('name', 'id')
            ->toArray();

        return [
            'title' => [
                'label' => 'Title',
                'type' => 'text',
                'multilang' => true,
                'attributes' => [
                    'class' => 'required',],
                'ai' => ['translate', 'meta-title', 'correction'],
            ],
            'description' => [
                'label' => 'Description / Deskripsi Singkat',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'rows' => 3,
                ],
                'info' => 'Deskripsi ringkas konten video / galeri (opsional)',
            ],
            'thumbnail' => [
                'label' => 'Thumbnail',
                'type' => 'text',
                'attributes' => [
                    'class' => 'required cfind',
                    'cfind-type' => 'image',
                    'cfind-thumb' => '360x360',
                    'cfind-convert' => 'webp',
                    'cfind-alt' => 1,
                ]
            ],
            'date' => [
                'label' => 'Date',
                'type' => 'text',
                'attributes' => [
                    'class' => 'required date',
                    'style' => 'width: 200px'
                ]
            ],
            'sort_id' => [
                'label' => 'Urutan Tampil (Sort Order)',
                'type' => 'number',
                'attributes' => [
                    'style' => 'width: 150px',
                    'placeholder' => '0'
                ],
                'info' => 'Nilai lebih kecil tampil lebih awal (default: 0)'
            ],
            'type' => [
                'label' => 'Type',
                'type' => 'select',
                'options' => [
                    'image' => 'Image',
                    'video' => 'Video'
                ]
            ],
            'classification' => [
                'label' => 'Klasifikasi Video',
                'type' => 'multicheck-table',
                'table' => 'gallery_video_classifications',
                'id_column' => 'gallery_id',
                'relation_column' => 'classification_id',
                'options' => $classificationOptions,
                'info' => 'Pilih satu atau lebih klasifikasi. Satu video dapat tampil di Galeri dan Aksesibilitas secara bersamaan.'
            ],
            'iframe' => [
                'label' => 'URL Embed Youtube',
                'type' => 'text',
                'info' => 'Mendukung URL YouTube biasa (youtube.com/watch?v=...), tautan pendek (youtu.be/...), shorts, maupun embed (youtube.com/embed/...). Sistem otomatis mengonversinya menjadi embed yang valid.'
            ],
            'image' => [
                'type' => 'widget',
                'min' => 1,
                'widgets' => [
                    'thumbnail' => [
                        'label' => 'Thumbnail Popup',
                        'type' => 'text',
                        'attributes' => [
                            'class' => 'required cfind',
                            'cfind-type' => 'image',
                            'cfind-thumb' => '118x78',
                            'cfind-convert' => 'webp',
                            'cfind-alt' => 1,
                        ]
                    ],
                    'image' => [
                        'label' => 'Image Popup',
                        'type' => 'text',
                        'attributes' => [
                            'class' => 'required cfind',
                            'cfind-type' => 'image',
                            'cfind-thumb' => '792x509',
                            'cfind-convert' => 'webp',
                            'cfind-alt' => 1,
                        ]
                    ],
                    'title' => [
                        'label' => 'Title Popup',
                        'type' => 'text',
                        'multilang' => true,
                        'attributes' => [
                            'class' => 'required',]
                    ]
                ]
            ],
        ];
    }

    public function formCallbackBefore($post, $item, $type)
    {
        // Normalisasi URL YouTube embed
        if (isset($post['main']['type']) && $post['main']['type'] === 'video') {
            if (!empty($post['main']['iframe'])) {
                $post['main']['iframe'] = Gallery::formatYoutubeEmbed($post['main']['iframe']);
            }
        }

        if (empty($post['main']['thumbnail'])) {
            $post['main']['thumbnail'] = 'default.webp';
        }
        if (empty($post['main']['type'])) {
            $post['main']['type'] = 'photo';
        }
        if (empty($post['main']['date'])) {
            $post['main']['date'] = date('Y-m-d');
        }

        // Set default sort_id jika kosong
        if (empty($post['main']['sort_id'])) {
            $post['main']['sort_id'] = (Gallery::max('sort_id') ?? 0) + 1;
        }

        return $post;
    }

    public function formAppend()
    {
        return view('admin.gallery.form-js');
    }
}
