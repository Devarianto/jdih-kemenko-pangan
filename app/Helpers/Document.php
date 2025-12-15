<?php
namespace App\Helpers;

use App\Models\RuleType;
use App\Models\RuleTheme;
use App\Models\DocumentType;

use helper;

use App\Helpers\DocumentPeraturan;
use App\Models\Document as DocumentModel;
use Illuminate\Support\Facades\Storage;

class Document {

    public static function listingFields($type)
    {
        if ($type == 'naskah') {
            return [
                'title' => 'Judul',
                'nomor_perjanjian' => 'No. Perjanjian',
                'tanggal_berlaku' => 'Tanggal Berlaku',
                'tanggal_berakhir' => 'Tempat Berakhir',
                'status_berlaku' => 'Status Berlaku',
            ];
        }
    }

    public static function formCallbackBefore($post,$item,$type,$document,$fields = [])
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

            if ($type == 'edit' && 
            !isset($request['delete_pdf']) && 
            $item->pdf != null) {
                $pdf_field = array_get($fields, 'pdf', []);
                if (isset($pdf_field['is_delete']) && $pdf_field['is_delete']) {
                    if (Storage::exists($item->pdf))
                        Storage::delete($item->pdf);

                    $post['main']['pdf'] = null;
                }
                
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

            if ($type == 'edit' && 
            !isset($request['delete_abstract']) && 
            $item->abstract != null) {
                $abstract_field = array_get($fields, 'abstract', []);
                if (isset($abstract_field['is_delete']) && $abstract_field['is_delete']) {
                    if (Storage::exists($item->abstract))
                        Storage::delete($item->abstract);

                    $post['main']['abstract'] = null;
                }
                
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