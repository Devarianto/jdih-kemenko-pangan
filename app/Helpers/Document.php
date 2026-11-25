<?php
namespace App\Helpers;

use App\Models\RuleType;
use App\Models\RuleTheme;
use App\Models\DocumentType;

use helper;

use App\Helpers\DocumentPeraturan;
use App\Models\Document as DocumentModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

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
        if ($type == 'create' && empty($post['main']['master_document_id'])) {
            $post['main']['master_document_id'] = DocumentModel::getId($document);
        }
        if (!isset($post['main']['is_active']) || $post['main']['is_active'] === '') {
            $post['main']['is_active'] = 0;
        }
        
        if ($type == 'create' || $type == 'edit') {
            $handleFile = function($fieldKey, $folder) use (&$post, $request, $item, $type) {
                $file = request()->file($fieldKey);
                if (!$file && isset($request[$fieldKey]) && $request[$fieldKey] instanceof UploadedFile) {
                    $file = $request[$fieldKey];
                }

                if ($file instanceof UploadedFile && $file->isValid()) {
                    if ($type == 'edit' && !empty($item->{$fieldKey})) {
                        if (Storage::exists($item->{$fieldKey})) {
                            Storage::delete($item->{$fieldKey});
                        }
                    }

                    $original = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $ext = $file->getClientOriginalExtension();
                    $filename = $original . '.' . $ext;
                    $path = $file->storeAs('upload/' . $folder, $filename);

                    $post['main'][$fieldKey] = $path;
                } else if (isset($request[$fieldKey]) && is_string($request[$fieldKey]) && trim($request[$fieldKey]) !== '') {
                    $post['main'][$fieldKey] = $request[$fieldKey];
                } else if ($type == 'edit' && !empty($item->{$fieldKey})) {
                    $post['main'][$fieldKey] = $item->{$fieldKey};
                }
            };

            $handleFile('pdf', 'pdf');
            $handleFile('abstract', 'abstract');
            $handleFile('attachment', 'attachment');
            $handleFile('translation_pdf', 'pdf');
            $handleFile('translation_attachment', 'attachment');

            // Handling translation fields
            if (isset($request['translation_title'])) {
                $post['main']['translation_title'] = !empty(trim($request['translation_title'])) ? trim($request['translation_title']) : null;
            }
            if (isset($request['translation_no_peraturan'])) {
                $post['main']['translation_no_peraturan'] = !empty(trim($request['translation_no_peraturan'])) ? trim($request['translation_no_peraturan']) : null;
            }
            if (isset($request['translation_intro'])) {
                $post['main']['translation_intro'] = !empty(trim($request['translation_intro'])) ? trim($request['translation_intro']) : null;
            }

            // Translation availability flag: respect explicit toggle state from the form when sent
            if (array_key_exists('has_translation', $request)) {
                $post['main']['has_translation'] = !empty($request['has_translation']) ? 1 : 0;
            } else {
                $hasTranslationInput = !empty($post['main']['translation_title']) || !empty($post['main']['translation_pdf']);
                if ($type == 'edit' && !$hasTranslationInput && !empty($item->translation_pdf) && empty($request['delete_translation_pdf'])) {
                    $hasTranslationInput = true;
                }
                $post['main']['has_translation'] = $hasTranslationInput ? 1 : 0;
            }

            // Handling delete file when editing
            foreach (['pdf', 'abstract', 'attachment', 'translation_pdf', 'translation_attachment'] as $fieldKey) {
                if ($type == 'edit' && !empty($request['delete_' . $fieldKey]) && !empty($item->{$fieldKey})) {
                    if (Storage::exists($item->{$fieldKey})) {
                        Storage::delete($item->{$fieldKey});
                    }
                    $post['main'][$fieldKey] = null;
                }
            }

            // Clean up empty string values for nullable relational/numeric fields
            foreach (['related_document_id', 'tahapan_puu_id', 'rule_type_id', 'rule_theme_id', 'document_type_id', 'date', 'tanggal_mulai', 'tanggal_selesai'] as $col) {
                if (isset($post['main'][$col]) && $post['main'][$col] === '') {
                    $post['main'][$col] = null;
                }
            }
        }
        
        return $post;
    }

    public static function formCallbackAfter($item, $type)
    {
        // Always touch updated_at so newly created or edited documents appear at the very top of page 1
        try {
            $item->touch();
        } catch (\Throwable $e) {}

        // CMS Metadata Dinamis
        try {
            DynamicMetadata::save($item);
        } catch (\Throwable $e) {
            \Log::warning('DynamicMetadata save failed: ' . $e->getMessage());
        }

        $regulations = request()->input('regulations_relations', []);
        $crossDocs = request()->input('cross_documents_relations', []);

        if (is_string($regulations)) {
            $regulations = json_decode($regulations, true) ?: [];
        }
        if (is_string($crossDocs)) {
            $crossDocs = json_decode($crossDocs, true) ?: [];
        }

        if (is_array($regulations) || is_array($crossDocs)) {
            \App\Models\DocumentRelation::syncRelations(
                $item->id,
                is_array($regulations) ? $regulations : [],
                is_array($crossDocs) ? $crossDocs : []
            );
        }

        // Sync English translation to documents_lang only when translation availability is active
        if ($item && !empty($item->has_translation)) {
            try {
                \DB::table('documents_lang')->updateOrInsert(
                    ['base_id' => $item->id, 'lang' => 'en'],
                    [
                        'title' => $item->translation_title ?: $item->translated('title'),
                        'intro' => $item->translation_intro ?: $item->translated('intro'),
                        'pdf_name' => $item->translation_pdf ? basename($item->translation_pdf) : ($item->translated('pdf_name') ?: $item->pdf),
                        'lampiran' => $item->translation_attachment ?: $item->attachment
                    ]
                );
            } catch (\Throwable $e) {}
        }

        return true;
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