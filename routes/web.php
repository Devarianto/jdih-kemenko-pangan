<?php

use Illuminate\Support\Facades\Route;

use Cactuar\Admin\Models\Permalink;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\DownloadFileController;

Route::group(['middleware' => ['web','front']],function() {

    if ($permalink = Permalink::active()) {
        if ($permalink->module == 'menu'){
            Route::get($permalink->permalink, [PageController::class, 'getTemplate']);
        }

        if ($permalink->module == 'information-news'){
            Route::get($permalink->permalink, [PageController::class, 'getNewsDetail']);
        }

        if ($permalink->module == 'document-peraturan') {
            Route::get($permalink->permalink, [PageController::class, 'getPeraturanHukumDetail']);
        }

        if ($permalink->module == 'document-jurnal') {
            Route::get($permalink->permalink, [PageController::class, 'getJurnalHukumDetail']);
        }

        if ($permalink->module == 'document-kliping') {
            Route::get($permalink->permalink, [PageController::class, 'getKlipingHukumDetail']);
        }

        if ($permalink->module == 'document-majalah') {
            Route::get($permalink->permalink, [PageController::class, 'getMajalahHukumDetail']);
        }
    }

    lang::routes(function() {
        Route::get('/', [PageController::class, 'home'])->name('home');
        Route::post('/contact/submit', [ContactController::class, 'postSubmit'])->name('contact.submit');
    });

    Route::get('document/download/{type}/{id}', [DownloadFileController::class, 'getDocumentDownload'])->name('document.download');
    Route::get('document/stream/{type}/{id}', [DownloadFileController::class, 'getDocumentStream'])->name('document.stream');
});