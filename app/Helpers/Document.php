<?php
namespace App\Helpers;

use App\Models\RuleType;
use App\Models\RuleTheme;
use App\Models\DocumentType;

use helper;

class Document {

    public static function listingFields($type)
    {
        if ($type == 'peraturan') {
            return [
                'title' => 'Judul',
                'no_peraturan' => 'No. Peraturan',
                'rule_type_id' => 'Jenis Peraturan' ,
                'rule_theme_id' => 'Tema',
                'tanggal_penetapan' => 'Tanggal Penetapan',
                'tanggal_pengundangan' => 'Tanggal Pengundangan',
                'status_berlaku' => 'Status Berlaku',
            ];
        } else if ($type == 'jurnal') {
            return [
                'title' => 'Judul',
                'no_panggil' => 'No. Panggil',
                'edisi' => 'Cetakan/Edisi',
                'tempat_terbit' => 'Tempat Terbit',
                'tahun_terbit' => 'Tahun Terbit'
            ];
        } else if ($type =='kliping') {
            return [
                'title' => 'Judul',
                'teu' => 'T.E.U Orang/Badan',
                'tempat_terbit' => 'Tempat Terbit',
                'tahun_terbit' => 'Tahun Terbit'
            ];
        } else if ($type =='majalah') {
            return [
                'title' => 'Judul',
                'teu' => 'T.E.U Orang/Badan',
                'tempat_terbit' => 'Tempat Terbit',
                'tahun_terbit' => 'Tahun Terbit'
            ];
        }
    }

    public static function formFields($document, $type='create')
    {
        $function = helper::dash2camel('form-'.$document);
        if (!method_exists(__CLASS__, $function))
            abort(404);

        $form = [
            'title' => [
                'label' => 'Title',
                'type' => 'text',
                'multilang' => true,
                'attributes' => [
                    'class' => 'required title',
                    'maxlength' => 255,
                ]
            ],
            'permalink' => [
                'type' => 'permalink'
            ],
            'intro' => [
                'label' => 'Intro',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'required'
                ]
            ],
            'thumbnail' => [],
            'image' => [],
            'rule_theme_id' => [
                'label' => 'Tema Peraturan',
                'type' => 'select',
                'options' => RuleTheme::pluck('label', 'id')->toArray()
            ],
            'document_type_id' => [
                'label' => 'Tipe Dokumen',
                'type' => 'select',
                'options' => DocumentType::pluck('label', 'id')->toArray(),
                'attributes' => [
                    'class' => 'required select2'
                ]
            ],
        ];

        return self::$function($form, $type); // panggil fungsi statik dinamis
    }

    private static function formPeraturan($form, $type)
    {
        $form += [
            'rule_type_id' => [
                'label' => 'Jenis Peraturan',
                'type' => 'select',
                'options' => RuleType::pluck('label', 'id')->toArray(),
                'attributes' => [
                    'class' => 'required select2'
                ]
            ],
            'year' => [
                'label' => 'Tahun',
                'type' => 'number',
                'attributes' => [
                    'class' => 'required',
                    'minlength' => 1
                ]
            ],
            'status_berlaku' => [
                'label' => 'Status Peraturan (Berlaku/Tidak Berlaku)',
                'type' => 'select',
                'options' => [
                    0 => 'Tidak',
                    1 => 'Ya'
                ],
                'attributes' => [
                    'class' => 'required'
                ]
            ],
            'teu' => [
                'subtitle' => 'Meta Data', 
                'label' => 'T.E.U. Badan/Pengarang',
                'type' => 'text',
                'multilang' => true,
            ],
            'no_peraturan' => [
                'label' => 'Nomor Peraturan',
                'type' => 'text',
            ],
            'jenis_bentuk_peraturan' => [
                'label' => 'Jenis/Bentuk Peraturan',
                'type' => 'text',
                'multilang' => true,
            ],
            'singkatan_bentuk_peraturan' => [
                'label' => 'Singkatan Jenis/Bentuk Peraturan',
                'type' => 'text',
                'multilang' => true,
            ],
            'tempat_penetapan' => [
                'label' => 'Tempat Penetapan',
                'type' => 'text',
            ],
            'tanggal_penetapan' => [
                'label' => 'Tanggal Penetapan',
                'type' => 'text',
                'attributes' => [
                    'class' => 'datepicker'
                ]
            ],
            'tanggal_pengundangan' => [
                'label' => 'Tanggal Pengundangan',
                'type' => 'text',
                'attributes' => [
                    'class' => 'datepicker'
                ]
            ],
            'sumber' => [
                'label' => 'Sumber',
                'type' => 'text',
                'multilang' => true
            ],
            'subjek' => [
                'label' => 'Subjek',
                'type' => 'text',
                'multilang' => true
            ],
            'status_peraturan' => [
                'label' => 'Status Peraturan',
                'type' => 'textarea',
                'multilang' => true,
                'attributes' => [
                    'class' => 'ckeditor'
                ]
            ],
            'bahasa' => [
                'label' => 'Bahasa',
                'type' => 'text',
                'multilang' => true
            ],
            'lokasi' => [
                'label' => 'Lokasi',
                'type' => 'text',
            ],
            'bidang_hukum' => [
                'label' => 'Bidang Hukum',
                'type' => 'text',
                'multilang' => true
            ],
            'pdf_name' => [
                'subtitle' => 'File',
                'label' => 'File Name',
                'type' => 'text',
                'multilang' => true
            ],
            'pdf' => [
                'label' => 'PDF',
                'type' => 'file',
                'attributes' => [
                    'class' => 'required'
                ]
            ],
            'abstract_name' => [
                'label' => 'File Name',
                'type' => 'text',
                'multilang' => true
            ],
            'abstract' => [
                'label' => 'Abstrak',
                'type' => 'file',
                'attributes' => [
                    'class' => 'required'
                ]
            ]
        ];


        $form['thumbnail'] = [
            'label' => 'Thumbnail',
            'type' => 'text',
            'attributes' => [
                'class' => 'required cfind',
                'cfind-type' => 'image',
                'cfind-thumb' => '240x220',
                'cfind-convert' => 'webp',
                'cfind-alt' => 1,
            ]
        ];

        if ($type == 'edit') {
            unset($form['pdf']['attributes']);
            unset($form['abstract']['attributes']);
        }

        return $form;
    }

    private static function formJurnal($form, $type)
    {
        $form += [
            'teu' => [
                'subtitle' => 'Meta Data', 
                'label' => 'T.E.U. Orang/Badan',
                'type' => 'text',
                'multilang' => true,
            ],
            'no_panggil' => [
                'label' => 'No. Panggil',
                'type' => 'text',
            ],
            'edisi' => [
                'label' => 'Edisi',
                'type' => 'text',
                'multilang' => true,
            ],
            'tempat_terbit' => [
                'label' => 'Tempat Terbit',
                'type' => 'text',
            ],
            'penerbit' => [
                'label' => 'Penerbit',
                'type' => 'text',
            ],
            'tahun_terbit' => [
                'label' => 'Tahun Terbit',
                'type' => 'number',
                'attributes' => [
                    'minlength' => 1
                ]
            ],
            'subjek' => [
                'label' => 'Subjek',
                'type' => 'text',
                'multilang' => true
            ],
            'isbn' => [
                'label' => 'ISBN',
                'type' => 'text'
            ],
            'bahasa' => [
                'label' => 'Bahasa',
                'type' => 'text',
                'multilang' => true
            ],
            'bidang_hukum' => [
                'label' => 'Bidang Hukum',
                'type' => 'text',
                'multilang' => true
            ],
            'nomor_induk_buku' => [
                'label' => 'Nomor Induk Buku',
                'type' => 'text'
            ],
            'lokasi' => [
                'label' => 'Lokasi',
                'type' => 'text',
            ],
            'status_tersedia' => [
                'label' => 'Status Tersedia',
                'type' => 'select',
                'options' => [
                    0 => 'Tidak',
                    1 => 'Ya'
                ]
            ],
            'pdf_name' => [
                'subtitle' => 'File',
                'label' => 'File Name',
                'type' => 'text',
                'multilang' => true
            ],
            'pdf' => [
                'label' => 'PDF',
                'type' => 'file',
                'attributes' => [
                    'class' => 'required',
                    'accept' => 'pdf'
                ]
            ],
            'abstract_name' => [
                'label' => 'File Name',
                'type' => 'text',
                'multilang' => true
            ],
            'abstract' => [
                'label' => 'Abstrak',
                'type' => 'file',
                'attributes' => [
                    'class' => 'required',
                    'accept' => 'pdf'
                ]
            ]
        ];
        
        $form['thumbnail'] = [
            'label' => 'Thumbnail',
            'type' => 'text',
            'attributes' => [
                'class' => 'required cfind',
                'cfind-type' => 'image',
                'cfind-thumb' => '220x284',
                'cfind-convert' => 'webp',
                'cfind-alt' => 1,
            ]
        ];

        $form['image'] = [
            'label' => 'Image',
            'type' => 'text',
            'attributes' => [
                'class' => 'required cfind',
                'cfind-type' => 'image',
                'cfind-thumb' => '317x410',
                'cfind-convert' => 'webp',
                'cfind-alt' => 1,
            ]
        ];

        if ($type == 'edit') {
            unset($form['pdf']['attributes']['class']);
            unset($form['abstract']['attributes']['class']);
        }

        return $form;
    }

    private static function formKliping($form, $type)
    {
        $form += [
            'teu' => [
                'subtitle' => 'Meta Data', 
                'label' => 'T.E.U. Orang/Badan',
                'type' => 'text',
                'multilang' => true,
            ],
            'tempat_terbit' => [
                'label' => 'Tempat Terbit',
                'type' => 'text',
            ],
            'tahun_terbit' => [
                'label' => 'Tahun Terbit',
                'type' => 'number',
                'attributes' => [
                    'minlength' => 1
                ]
            ],
            'sumber' => [
                'label' => 'Sumber',
                'type' => 'textarea',
                'multilang' => true
            ],
            'subjek' => [
                'label' => 'Subjek',
                'type' => 'text',
                'multilang' => true
            ],
            'bahasa' => [
                'label' => 'Bahasa',
                'type' => 'text',
                'multilang' => true
            ],
            'bidang_hukum' => [
                'label' => 'Bidang Hukum',
                'type' => 'text',
                'multilang' => true
            ],
            'lokasi' => [
                'label' => 'Lokasi',
                'type' => 'text'
            ],
            'lampiran' => [
                'label' => 'Lampiran',
                'type' => 'textarea',
                'multilang' => true
            ],
        ];

        $form['thumbnail'] = [
            'label' => 'Thumbnail',
            'type' => 'text',
            'attributes' => [
                'class' => 'required cfind',
                'cfind-type' => 'image',
                'cfind-thumb' => '370x240',
                'cfind-convert' => 'webp',
                'cfind-alt' => 1,
            ]
        ];

        $form['image'] = [
            'label' => 'Image',
            'type' => 'widget',
            'min' => 1,
            'widgets' => [
                'image' => [
                    'label' => 'Image',
                    'type' => 'text',
                    'attributes' => [
                        'class' => 'required cfind',
                        'cfind-type' => 'image',
                        'cfind-thumb' => '990x480',
                        'cfind-convert' => 'webp',
                        'cfind-alt' => 1,
                    ]
                ],
                'link-cta' => [
                    'child-subtitle' => 'Link CTA',
                    'type' => 'widget',
                    'max' => 1,
                    'widgets' => [
                        'label' => [
                            'label' => 'Label',
                            'type' => 'text',
                            'multilang' => true,
                            'attributes' => [
                                'class' => 'link'
                            ]
                        ],
                        'target' => [
                            'type' => 'select',
                            'label' => 'Target',
                            'options' => [
                                '_self' => 'Default',
                                '_blank' => 'New Tab',
                            ],
                        ],
                        'link' => [
                            'label' => 'Link',
                            'type' => 'text',
                            'multilang' => true,
                            'attributes' => [
                                'class' => 'url'
                            ]
                        ],
                    ]
                ],
            ]
        ];

        unset($form['intro']);

        return $form;
    }

    private static function formMajalah($form, $type)
    {
        $form += [
            'teu' => [
                'subtitle' => 'Meta Data', 
                'label' => 'T.E.U. Orang/Badan',
                'type' => 'text',
                'multilang' => true,
            ],
            'edisi' => [ 
                'label' => 'Cetakan/Edisi',
                'type' => 'text',
                'multilang' => true,
            ],
            'tempat_terbit' => [
                'label' => 'Tempat Terbit',
                'type' => 'text',
            ],
            'tahun_terbit' => [
                'label' => 'Tahun Terbit',
                'type' => 'number',
                'attributes' => [
                    'minlength' => 1
                ]
            ],
            'sumber' => [
                'label' => 'Sumber',
                'type' => 'textarea',
                'multilang' => true
            ],
            'subjek' => [
                'label' => 'Subjek',
                'type' => 'text',
                'multilang' => true
            ],
            'bahasa' => [
                'label' => 'Bahasa',
                'type' => 'text',
                'multilang' => true
            ],
            'bidang_hukum' => [
                'label' => 'Bidang Hukum',
                'type' => 'text',
                'multilang' => true
            ],
            'lokasi' => [
                'label' => 'Lokasi',
                'type' => 'text'
            ],
            'lampiran' => [
                'label' => 'Lampiran',
                'type' => 'textarea',
                'multilang' => true
            ],
            'pdf_name' => [
                'subtitle' => 'File',
                'label' => 'File Name',
                'type' => 'text',
                'multilang' => true
            ],
            'pdf' => [
                'label' => 'PDF',
                'type' => 'file',
                'attributes' => [
                    'class' => 'required',
                    'accept' => 'pdf'
                ]
            ],
        ];

        $form['thumbnail'] = [
            'label' => 'Thumbnail',
            'type' => 'text',
            'attributes' => [
                'class' => 'required cfind',
                'cfind-type' => 'image',
                'cfind-thumb' => '220x284',
                'cfind-convert' => 'webp',
                'cfind-alt' => 1,
            ]
        ];

        $form['image'] = [
            'label' => 'Image',
            'type' => 'text',
            'attributes' => [
                'class' => 'required cfind',
                'cfind-type' => 'image',
                'cfind-thumb' => '317x410',
                'cfind-convert' => 'webp',
                'cfind-alt' => 1,
            ]
        ];

        if ($type == 'edit') {
            unset($form['pdf']['attributes']['class']);
        }

        return $form;
    }

}