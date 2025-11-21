<?php

use Illuminate\Support\Facades\Route;

use Cactuar\Admin\Models\Permalink;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\RatingController;
use App\Http\Controllers\Front\DownloadFileController;
use App\Http\Controllers\Front\DocumentController;
use App\Http\Controllers\Front\VisitorController;

use App\Http\Controllers\APIController;

Route::group(['middleware' => ['web','front', 'visitor-count']],function() {

    Route::fallback(function () {
       return view('errors.404');
    });

    if ($permalink = Permalink::active()) {
        if ($permalink->module == 'menu'){
            Route::get($permalink->permalink, [PageController::class, 'getTemplate']);
        }

        if ($permalink->module == 'information-news'){
            Route::get($permalink->permalink, [PageController::class, 'getNewsDetail']);
        }

        if ($permalink->module == 'information-infografis'){
            Route::get($permalink->permalink, [PageController::class, 'getInformasiInfografisDetail']);
        }

        if ($permalink->module == 'information-kamus-hukum'){
            Route::get($permalink->permalink, [PageController::class, 'getInformasiKamusHukumDetail']);
        }

        if ($permalink->module == 'document-peraturan') {
            Route::get($permalink->permalink, [DocumentController::class, 'getPeraturanHukumDetail']);
        }

        if ($permalink->module == 'document-jurnal') {
            Route::get($permalink->permalink, [DocumentController::class, 'getJurnalHukumDetail']);
        }

        if ($permalink->module == 'document-kliping') {
            Route::get($permalink->permalink, [DocumentController::class, 'getKlipingHukumDetail']);
        }

        if ($permalink->module == 'document-majalah') {
            Route::get($permalink->permalink, [DocumentController::class, 'getMajalahHukumDetail']);
        }

        if ($permalink->module == 'document-putusan') {
            Route::get($permalink->permalink, [DocumentController::class, 'getPutusanHukumDetail']);
        }

        if ($permalink->module == 'document-monografi') {
            Route::get($permalink->permalink, [DocumentController::class, 'getMonografiHukumDetail']);
        }

        if ($permalink->module == 'document-naskah') {
            Route::get($permalink->permalink, [DocumentController::class, 'getNaskahHukumDetail']);
        }
    }

    \Cactuar\Admin\Helpers\lang::routes(function() {
        Route::get('/', [PageController::class, 'home'])->name('home');
        Route::post('/contact/submit', [ContactController::class, 'postSubmit'])->name('contact.submit');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::middleware('auth:account')->group(function () {
            Route::post('/projects', [DashboardController::class, 'storeProject'])->name('projects.store');
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/dashboard/formulir-usulan', [DashboardController::class, 'formUsulan'])->name('form.usulan');
            Route::get('/dashboard/detail-usulan/{id}', [DashboardController::class, 'detailUsulan'])->name('detail.usulan');
            Route::get('/dashboard/project', [DashboardController::class, 'listProject'])->name('project');
            Route::get('/dashboard/detail-project/{id}', [DashboardController::class, 'detailProject'])->name('detail.project');
        });
        Route::post('/rating/submit', [RatingController::class, 'postSubmit'])->name('rating.submit');
    });

    Route::get('document/download/{type}/{id}', [DownloadFileController::class, 'getDocumentDownload'])->name('document.download');
    Route::get('document/stream/{type}/{id}', [DownloadFileController::class, 'getDocumentStream'])->name('document.stream');
});

Route::get('/api/visitor/get', [VisitorController::class, 'getVisitor'])->name('api.visitor');

Route::get('jdihn-json', [APIController::class, 'apiJDIH']);//->middleware('auth.basic.once');