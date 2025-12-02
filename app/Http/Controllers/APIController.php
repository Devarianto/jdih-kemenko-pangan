<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Document;

use media;

class APIController extends Controller
{
    public function apiJDIH(){
        $data = [];
        $dokumen = Document::translate()->whereIsActive(1)->get();
        foreach($dokumen as $k => $v){
            $row_array = (object) [];
            $row_array->masterDocument          = $v->master_document->label ?? '-';
            $row_array->idData                  = $v->id; //berisi id dokumen
            $row_array->tahun_pengundangan      = $v->api_tahun_pengundangan; //berisi tahun penetapan atau tahun terbit ex. 2019
            $row_array->tanggal_pengundangan    = $v->api_tanggal_pengundangan; //berisi tahun bulan tanggal (YYYY-MM-DD) ex. 2019-04-22
            $row_array->jenis                   = $v->api_jenis; //berisi jenis peraturan ex. Peraturan Daerah
            $row_array->noPeraturan             = $v->api_no_peraturan; //berisi no peraturan ex. 24
            $row_array->judul                   = $v->api_judul;
            $row_array->noPanggil               = $v->api_no_panggil; //khusus untuk monografi/buku
            $row_array->singkatanJenis          = $v->api_singkatan_jenis; //berisi singkatan dari jenis ex. Perda
            $row_array->tempatTerbit            = $v->api_tempat_terbit; //berisi tempat terbit
            $row_array->penerbit                = $v->api_penerbit; //untuk dokumen bertipe monografi
            $row_array->deskripsiFisik          = $v->api_deskripsi_fisik; //khusus untuk monografi/buku
            $row_array->sumber                  = $v->api_sumber; //Lembar daerah atau menyesuaikan
            $row_array->subjek                  = $v->api_subjek; //Kata kunci dari dokumen hukum
            $row_array->isbn                    = $v->api_isbn; //khusus untuk monografi/buku
            $row_array->status                  = $v->api_status; //berisi status perundang undangan
            $row_array->bahasa                  = $v->api_bahasa; //indonesia atau inggris
            $row_array->bidangHukum             = $v->api_bidang_hukum; //pembidangan dokumen hukum
            $row_array->teuBadan                = $v->api_teu_badan; //nama instansi terkait
            $row_array->nomorIndukBuku          = $v->api_nomor_induk_buku; //khusus untuk monografi/buku

            if ($v->pdf) {
                $row_array->pdf                 = basename($v->pdf); //berisi nama file ex. peraturan.pdf, peraturan.docx
                $row_array->urlDownload         = route('document.download', ['type' => 'pdf', 'id' => $v->id]); //berisi url dan nama file ex. domain.com/peraturan.pdf
                //$row_array->urlDownload='http://jdih.instansi.go.id/ildis/www/storage/document/'.$file; //
            }
            $row_array->urlDetailPeraturan      = url($v->permalink_document); //berisi link document
            $row_array->operasi="4";
            $row_array->display="1";

            array_push($data, $row_array);
        }
        return response()->json($data);
    }
}
