<?php
namespace App\Helpers;

use App\Models\RuleType;
use App\Models\RuleTheme;
use App\Models\DocumentType;

use helper;

use App\Helpers\DocumentPeraturan;
use App\Models\Document as DocumentModel;

class Document {

    public static function listingFields($type)
    {
        if ($type == 'majalah') {
            return [
                'title' => 'Judul',
                'teu' => 'T.E.U Orang/Badan',
                'tempat_terbit' => 'Tempat Terbit',
                'tahun_terbit' => 'Tahun Terbit'
            ];
        } else if ($type == 'putusan') {
            return [
                'title' => 'Judul',
                'no_putusan' => 'No. Putusan',
                'jenis_peradilan' => 'Jenis Peradilan',
                'singkatan_peradilan' => 'Singkatan Jenis Peradilan',
                'tempat_peradilan' => 'Tempat Peradilan',
                'status_berlaku' => 'Status Berlaku'
            ];
        } else if ($type == 'monografi') {
            return [
                'title' => 'Judul',
                'no_panggil' => 'No. Panggil',
                'edisi' => 'Cetakan/Edisi',
                'tempat_terbit' => 'Tempat Terbit',
                'tahun_terbit' => 'Tahun Terbit',
                'status_tersedia' => 'Status Tersedia',
            ];
        } else if ($type == 'naskah') {
            return [
                'title' => 'Judul',
                'nomor_perjanjian' => 'No. Perjanjian',
                'tanggal_berlaku' => 'Tanggal Berlaku',
                'tanggal_berakhir' => 'Tempat Berakhir',
                'status_berlaku' => 'Status Berlaku',
            ];
        }
    }

    public static function formCallbackBefore($post,$item,$type,$document)
    {
        $request = request()->all();
        if ($type == 'create') 
            $post['main']['master_document_id'] = DocumentModel::getId($document);
        
        if ($type == 'create' || $type == 'edit') {
            if (isset($request['pdf']) && $request['pdf'] != null) {
                if ($type == 'edit' && $item->pdf != null) {
                    if (Storage::exists($item->pdf))
                        Storage::delete($item->pdf);
                }

                $original = pathinfo($request['pdf']->getClientOriginalName(), PATHINFO_FILENAME);
                $ext = $request['pdf']->getClientOriginalExtension();
                $filename = $original . '_' . time() . '.' . $ext;
                $path = $request['pdf']->storeAs('upload/pdf', $filename);
                
                $post['main']['pdf'] = $path;
            } else if ($type == 'edit' && $item->pdf != null) {
                $post['main']['pdf'] = $item->pdf;
            }

            if (isset($request['abstract']) && $request['abstract'] != null) {
                if ($type == 'edit' && $item->abstract != null) {
                    if (Storage::exists($item->abstract))
                        Storage::delete($item->abstract);
                }
                $original = pathinfo($request['abstract']->getClientOriginalName(), PATHINFO_FILENAME);
                $ext = $request['abstract']->getClientOriginalExtension();
                $filename = $original . '_' . time() . '.' . $ext;

                $path = $request['abstract']->storeAs('upload/abstract', $filename);
                $post['main']['abstract'] = $path;
            } else if ($type == 'edit' && $item->abstract != null) {
                $post['main']['abstract'] = $item->abstract;
            }
        }
        
        return $post;
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

    private static function formPutusan($form, $type)
    {
        $form += [
            'teu' => [
                'subtitle' => 'Meta Data', 
                'label' => 'T.E.U. Orang/Badan',
                'type' => 'text',
                'multilang' => true,
            ],
            'no_putusan' => [
                'label' => 'No. Putusan',
                'type' => 'text',
            ],
            'jenis_peradilan' => [
                'label' => 'Jenis Peradilan',
                'type' => 'text',
                'multilang' => true,
            ],
            'singkatan_peradilan' => [
                'label' => 'Singkatan Jenis Peradilan',
                'type' => 'text',
                'multilang' => true,
            ],
            'tempat_peradilan' => [
                'label' => 'Tempat Peradilan',
                'type' => 'text'
            ],
            'tanggal_dibacakan' => [
                'label' => 'Tanggal Dibacakan',
                'type' => 'text',
                'attributes' => [
                    'class' => 'required datepicker'
                ]
            ],
            'sumber' => [
                'label' => 'Sumber',
                'type' => 'text',
                'multilang' => true,
            ],
            'subjek' => [
                'label' => 'Subjek',
                'type' => 'text',
                'multilang' => true,
            ],
            'status_berlaku' => [
                'label' => 'Status Putusan (Berlaku/Tidak Berlaku)',
                'type' => 'select',
                'options' => [
                    0 => 'Tidak',
                    1 => 'Ya'
                ],
                'attributes' => [
                    'class' => 'required'
                ]
            ],
            'bahasa' => [
                'label' => 'Bahasa',
                'type' => 'text',
                'multilang' => true,
            ],
            'bidang_hukum' => [
                'label' => 'Bidang Hukum/Jenis Perkara',
                'type' => 'text',
                'multilang' => true,
            ],
            'lokasi' => [
                'label' => 'Lokasi',
                'type' => 'text',
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
                'cfind-thumb' => '240x220',
                'cfind-convert' => 'webp',
                'cfind-alt' => 1,
            ]
        ];

        if ($type == 'edit') {
            unset($form['pdf']['attributes']['class']);
        }

        return $form;
    }

    private static function formMonografi($form, $type)
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
            'deskripsi_fisik' => [
                'label' => 'Deskripsi Fisik',
                'type' => 'text',
                'multilang' => true
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
        }

        return $form;
    }

    private static function formNaskah($form, $type)
    {
        $form += [
            'pihak_internal' => [
                'label' => 'Pihak Internal',
                'type' => 'text'
            ],
            'pihak_eksternal' => [
                'label' => 'Pihak Eksternal',
                'type' => 'text'
            ],
            'nomor_perjanjian' => [
                'label' => 'No. Perjanjian',
                'type' => 'text'
            ],
            'tempat_penandatanganan' => [
                'label' => 'Tempat Penandatanganan',
                'type' => 'text'
            ],
            'tanggal_berlaku' => [
                'label' => 'Tanggal Berlaku',
                'type' => 'text',
                'attributes' => [
                    'class' => 'required datepicker'
                ]
            ],
            'tanggal_berakhir' => [
                'label' => 'Tanggal Berakhir',
                'type' => 'text',
                'attributes' => [
                    'class' => 'required datepicker'
                ]
            ],
            'jangka_waktu' => [
                'label' => 'Jangka Waktu',
                'type' => 'text',
                'multilang' => true
            ],
            'status_berlaku' => [
                'label' => 'Status Berlaku',
                'type' => 'select',
                'options' => [
                    0 => 'Tidak',
                    1 => 'Ya'
                ]
            ],
            'bahasa' => [
                'label' => 'Bahasa',
                'type' => 'text',
                'multilang' => true
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
                'cfind-thumb' => '240x220',
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