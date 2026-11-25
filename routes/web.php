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
use App\Http\Controllers\Front\StatisticController;
use App\Models\Document;

use App\Http\Controllers\APIController;

if (\Str::contains(request()->getRequestUri(), 'index.php') || \Str::contains(request()->getRequestUri(), '//')) {
    $uri = preg_replace('#/index\.php(/|$)#', '/', request()->getRequestUri());
    $uri = preg_replace('#/+#', '/', $uri);
    $base = rtrim(url()->to('/'), '/') . '/' . ltrim($uri, '/');

    if (strlen($base) > 0 && $base !== request()->fullUrl()) {
        header("Location: $base", true, 301);
        exit;
    }
}

Route::group(['middleware' => ['web','front', 'visitor-count', 'csp']],function() {

    Route::fallback(function () {
       return response()->view('errors.404', [], 404);
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

        // Dokumen Pembentukan PUU (support both cadmin module key and URL alias)
        if ($permalink->module == 'puu-program-penyusunan' || $permalink->module == 'program-penyusunan-puu') {
            Route::get($permalink->permalink, function() {
                return app(DocumentController::class)->getPuuDetail(Document::PROGRAM_PENYUSUNAN, 'dynamic.pages.document-naskah-detail', 'program-penyusunan-puu');
            });
        }

        if ($permalink->module == 'puu-naskah-urgensi' || $permalink->module == 'naskah-akademik') {
            Route::get($permalink->permalink, function() {
                return app(DocumentController::class)->getPuuDetail(Document::NASKAH_AKADEMIK, 'dynamic.pages.document-naskah-detail', 'naskah-urgensiakademik');
            });
        }

        if ($permalink->module == 'puu-rancangan' || $permalink->module == 'rancangan-puu') {
            Route::get($permalink->permalink, function() {
                return app(DocumentController::class)->getPuuDetail(Document::RANCANGAN_PUU, 'dynamic.pages.document-peraturan-detail', 'rancangan-puu');
            });
        }

        if ($permalink->module == 'puu-risalah' || $permalink->module == 'risalah-pembahasan') {
            Route::get($permalink->permalink, function() {
                return app(DocumentController::class)->getPuuDetail(Document::RISALAH_PEMBAHASAN, 'dynamic.pages.document-naskah-detail', 'risalah-pembahasan');
            });
        }

        if ($permalink->module == 'puu-analisis-evaluasi' || $permalink->module == 'analisis-evaluasi' || $permalink->module == 'anev-puu') {
            Route::get($permalink->permalink, function() {
                return app(DocumentController::class)->getPuuDetail(Document::ANALISIS_EVALUASI, 'dynamic.pages.document-naskah-detail', 'anev-puu');
            });
        }

        if ($permalink->module == 'puu-kajian-hukum' || $permalink->module == 'kajian-hukum') {
            Route::get($permalink->permalink, function() {
                return app(DocumentController::class)->getPuuDetail(Document::KAJIAN_HUKUM, 'dynamic.pages.document-naskah-detail', 'kajian-hukum');
            });
        }

        if ($permalink->module == 'puu-partisipasi-publik' || $permalink->module == 'partisipasi-publik') {
            Route::get($permalink->permalink, function() {
                return app(\App\Http\Controllers\ERegulasi\PartisipasiPublikController::class)->index(request());
            });
        }
    }

    \Cactuar\Admin\Helpers\lang::routes(function() {
        Route::get('/', [PageController::class, 'home'])->name('home');
        Route::post('/contact/submit', [ContactController::class, 'postSubmit'])->name('contact.submit');
        Route::post('/partisipasi-publik/masukan', [DocumentController::class, 'postPublicFeedback'])->name('partisipasi.feedback');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::middleware('auth:account')->group(function () {
            Route::post('/projects', [DashboardController::class, 'storeProject'])->name('projects.store');
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/dashboard/formulir-usulan', [DashboardController::class, 'formUsulan'])->name('form.usulan');
            Route::get('/dashboard/detail-usulan/{id}', [DashboardController::class, 'detailUsulan'])->name('detail.usulan');
            Route::get('/dashboard/project', [DashboardController::class, 'listProject'])->name('project');
            Route::get('/dashboard/detail-project/{id}', [DashboardController::class, 'detailProject'])->name('detail.project');

            Route::get('project/download/{type}/{id}/{loop}', [DownloadFileController::class, 'getProjectDownload'])->name('project.download');

        });
        Route::get('/galeri', function() {
            $menu = \Cactuar\Admin\Models\Menu::find(8) ?? \Cactuar\Admin\Models\Menu::first();
            return app(PageController::class)->getInformasiGaleri($menu);
        })->name('galeri');
        Route::get('/gallery', function() {
            $menu = \Cactuar\Admin\Models\Menu::find(8) ?? \Cactuar\Admin\Models\Menu::first();
            return app(PageController::class)->getInformasiGaleri($menu);
        })->name('gallery');
        Route::get('/videografis', function() {
            return redirect()->route('aksesibilitas');
        })->name('videografis');
        Route::get('/aksesibilitas', [PageController::class, 'getAksesibilitas'])->name('aksesibilitas');
        Route::get('/statistik-produk-hukum', function() {
            $menu = \Cactuar\Admin\Models\Menu::fe()->whereIsActive(1)->where('type', 'about-statistik')->first();
            return app(PageController::class)->getAboutStatistik($menu);
        })->name('statistik-produk-hukum');
        Route::get('/program-penyusunan-puu', function() {
            $menu = \Cactuar\Admin\Models\Menu::find(37) ?? \Cactuar\Admin\Models\Menu::first();
            return app(PageController::class)->getProgramPenyusunanPuu($menu);
        })->name('program-penyusunan-puu');
        Route::get('/peraturan-terjemahan', function() {
            $menu = \Cactuar\Admin\Models\Menu::find(36) ?? \Cactuar\Admin\Models\Menu::first();
            return app(PageController::class)->getPeraturanTerjemahan($menu);
        })->name('peraturan-terjemahan');
        Route::get('/translated-regulations', function() {
            $menu = \Cactuar\Admin\Models\Menu::find(36) ?? \Cactuar\Admin\Models\Menu::first();
            return app(PageController::class)->getPeraturanTerjemahan($menu);
        })->name('translated-regulations');
        Route::get('/dokumen-hukum/peraturan-terjemahan', function() {
            $menu = \Cactuar\Admin\Models\Menu::find(36) ?? \Cactuar\Admin\Models\Menu::first();
            return app(PageController::class)->getPeraturanTerjemahan($menu);
        });
        Route::get('/partisipasi-publik', [\App\Http\Controllers\ERegulasi\PartisipasiPublikController::class, 'index'])->name('partisipasi-publik');
        Route::get('/putusan-hukum', [PageController::class, 'getPutusanHukumRoute'])->name('putusan-hukum');
        Route::get('/putusan-hukum/mahkamah-agung', [PageController::class, 'getPutusanMa'])->name('putusan.ma');
        Route::get('/putusan-hukum/mahkamah-konstitusi', [PageController::class, 'getPutusanMk'])->name('putusan.mk');
        Route::get('/document-putusan/{id}', function($id) {
            $document = \App\Models\Document::where('master_document_id', \App\Models\Document::PUTUSAN)
                ->where('id', $id)
                ->firstOrFail();
            $document->view_count += 1;
            $document->save();
            $menu = \Cactuar\Admin\Models\Menu::fe()->whereIsActive(1)->where('type', 'putusan-hukum')->first();
            return view('dynamic.pages.document-putusan-detail', compact('document', 'menu'));
        })->name('putusan.detail');
        Route::get('/pengajuan-puu', [\App\Http\Controllers\Front\ERegulasiController::class, 'redirect'])->name('pengajuan-puu');

        Route::post('/rating/submit', [RatingController::class, 'postSubmit'])->name('rating.submit');
    });

    // Public Statistics & Video Classification APIs
    Route::prefix('api')->group(function() {
        Route::get('/statistics/legal-products', [StatisticController::class, 'apiLegalProducts'])->name('api.stats.legal-products');
        Route::get('/statistics/legal-products/by-type', [StatisticController::class, 'apiLegalProductsByType'])->name('api.stats.by-type');
        Route::get('/statistics/legal-products/by-year', [StatisticController::class, 'apiLegalProductsByYear'])->name('api.stats.by-year');
        Route::get('/statistics/legal-products/matrix', [StatisticController::class, 'apiLegalProductsMatrix'])->name('api.stats.matrix');
        Route::get('/statistics/legal-products/documents', [StatisticController::class, 'apiLegalProductsDocuments'])->name('api.stats.documents');
        Route::get('/statistics/legal-products/export-pdf', [StatisticController::class, 'exportPdf'])->name('api.stats.export-pdf');
        Route::get('/videos', [StatisticController::class, 'apiVideos'])->name('api.videos');
        // [AUDIT FIX] Admin-only APIs: previously reachable by guests (data exposure + SSRF proxy).
        Route::middleware('auth')->group(function () {
            Route::get('/admin/documents/search-related', ['App\Http\Controllers\Admin\Document\DocumentController', 'apiSearchRelated'])->name('api.admin.documents.search-related');
            Route::get('/admin/documents/fetch-external-meta', ['App\Http\Controllers\Admin\Document\DocumentController', 'apiFetchExternalMeta'])->name('api.admin.documents.fetch-external-meta');
        });
    });

    Route::get('/pengajuan-puu', [\App\Http\Controllers\Front\ERegulasiController::class, 'redirect']);

    Route::get('document/download/{type}/{id}', [DownloadFileController::class, 'getDocumentDownload'])->name('document.download');
    Route::get('api/document/download/{type}/{id}', [DownloadFileController::class, 'getAPIDocumentDownload'])->name('document-api.download');
    Route::get('document/stream/{type}/{id}', [DownloadFileController::class, 'getDocumentStream'])->name('document.stream');

    // [AUDIT FIX] Admin file preview must require admin login (unpublished documents were downloadable by guests).
    Route::get(ADMIN.'/file/download/{type}/{id}', ['App\Http\Controllers\Front\DownloadFileController', 'getAdminDownloadFile'])->middleware('auth')->name('admin.download.file');
    Route::get(ADMIN.'/project/download/{type}/{id}/{loop}', ['App\Http\Controllers\Front\DownloadFileController', 'getProjectDownload'])->name('admin.download.project');
    // [AUDIT FIX] Removed POST route pointing to non-existent DownloadFileController@deleteAdminFile (always HTTP 500).
});

Route::get('/api/visitor/get', [VisitorController::class, 'getVisitor'])->name('api.visitor');

Route::get('jdihn-json', [APIController::class, 'apiJDIH']);//->middleware('auth.basic.once');

// Fallback public storage serving for shared cPanel hosting without symlink (php artisan storage:link)
Route::get('/storage/{path}', function (string $path) {
    if (str_contains($path, "\0") || str_contains($path, '..')) {
        abort(404);
    }

    $baseDir = realpath(storage_path('app/public'));
    $filePath = $baseDir ? realpath($baseDir . DIRECTORY_SEPARATOR . ltrim($path, '/\\')) : false;

    if (
        !$baseDir ||
        !$filePath ||
        !str_starts_with($filePath, $baseDir . DIRECTORY_SEPARATOR) ||
        !is_file($filePath)
    ) {
        abort(404);
    }

    return response()->file($filePath, [
        'X-Frame-Options' => 'SAMEORIGIN',
        'X-Content-Type-Options' => 'nosniff',
    ]);
})->where('path', '.*')->name('storage.public');

// ==========================================
// E-REGULASI INTEGRATION ROUTES
// ==========================================

// Public Partisipasi Publik (integrated with JDIH Front middleware & EN multi-language prefix)
Route::middleware('front')->group(function () {
    Route::get('/partisipasi-publik', [\App\Http\Controllers\ERegulasi\PartisipasiPublikController::class, 'index'])->name('partisipasi-publik');
    Route::get('/partisipasi-publik/konsultasi', [\App\Http\Controllers\ERegulasi\PartisipasiPublikController::class, 'index'])->name('partisipasi-publik.index');
    Route::get('/partisipasi-publik/{id}', [\App\Http\Controllers\ERegulasi\PartisipasiPublikController::class, 'show'])->name('partisipasi-publik.show');
    Route::post('/partisipasi-publik/{id}/tanggapan', [\App\Http\Controllers\ERegulasi\TanggapanController::class, 'store'])->name('tanggapan.store');

    Route::prefix('{lang}')->where(['lang' => 'en'])->group(function () {
        Route::get('/partisipasi-publik', [\App\Http\Controllers\ERegulasi\PartisipasiPublikController::class, 'index']);
        Route::get('/partisipasi-publik/konsultasi', [\App\Http\Controllers\ERegulasi\PartisipasiPublikController::class, 'index']);
        Route::get('/partisipasi-publik/{id}', function($lang, $id) {
            return app(\App\Http\Controllers\ERegulasi\PartisipasiPublikController::class)->show($id);
        });
        Route::post('/partisipasi-publik/{id}/tanggapan', function(\Illuminate\Http\Request $request, $lang, $id) {
            return app(\App\Http\Controllers\ERegulasi\TanggapanController::class)->store($request, $id);
        });
    });
});

// Admin & Operator e-Regulasi
Route::middleware(['auth', 'role:admin_operator,operator_eregulasi,super_admin'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\ERegulasi\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/regulasi-lainnya', [\App\Http\Controllers\ERegulasi\RegulasiController::class, 'indexLainnya'])->name('regulasi.lainnya');
    Route::resource('/regulasi', \App\Http\Controllers\ERegulasi\RegulasiController::class);

    Route::post('/regulasi/{regulasi}/mulai-pembahasan', [\App\Http\Controllers\ERegulasi\RegulasiController::class, 'mulaiPembahasan'])
        ->name('regulasi.mulai-pembahasan');

    Route::post('/regulasi/{regulasi}/proses', [\App\Http\Controllers\ERegulasi\RegulasiController::class, 'tambahProses'])
        ->name('regulasi.proses.store');

    Route::put('/regulasi/{regulasi}/proses/{proses}', [\App\Http\Controllers\ERegulasi\RegulasiController::class, 'updateProses'])
        ->name('regulasi.proses.update');

    Route::delete('/regulasi/{regulasi}/proses/{proses}', [\App\Http\Controllers\ERegulasi\RegulasiController::class, 'destroyProses'])
        ->name('regulasi.proses.destroy');

    Route::post('/regulasi/{regulasi}/uji-publik/request', [\App\Http\Controllers\ERegulasi\RegulasiController::class, 'requestUjiPublik'])
        ->name('regulasi.uji-publik.request');

    Route::post('/regulasi/{regulasi}/uji-publik/approve', [\App\Http\Controllers\ERegulasi\RegulasiController::class, 'approveUjiPublik'])
        ->name('regulasi.uji-publik.approve');

    Route::post('/regulasi/{regulasi}/uji-publik/reject', [\App\Http\Controllers\ERegulasi\RegulasiController::class, 'rejectUjiPublik'])
        ->name('regulasi.uji-publik.reject');

    Route::post('/regulasi/{regulasi}/uji-publik/periode', [\App\Http\Controllers\ERegulasi\RegulasiController::class, 'updatePeriodeUjiPublik'])
        ->name('regulasi.uji-publik.update-periode');

    Route::post('/regulasi/{regulasi}/kembalikan-pembahasan', [\App\Http\Controllers\ERegulasi\RegulasiController::class, 'kembalikanKePembahasan'])
        ->name('regulasi.kembalikan-pembahasan');

    Route::post('/regulasi/{regulasi}/lanjut-pasca-partisipasi', [\App\Http\Controllers\ERegulasi\RegulasiController::class, 'lanjutPascaPartisipasi'])
        ->name('regulasi.lanjut-pasca-partisipasi');

    Route::post('/regulasi/{regulasi}/mulai-harmonisasi', [\App\Http\Controllers\ERegulasi\RegulasiController::class, 'mulaiHarmonisasi'])
        ->name('regulasi.mulai-harmonisasi');

    Route::post('/regulasi/{regulasi}/harmonisasi', [\App\Http\Controllers\ERegulasi\RegulasiController::class, 'updateHarmonisasi'])
        ->name('regulasi.harmonisasi.update');

    Route::post('/regulasi/{regulasi}/penetapan', [\App\Http\Controllers\ERegulasi\RegulasiController::class, 'updatePenetapan'])
        ->name('regulasi.penetapan.update');

    // Admin Partisipasi Publik
    Route::get('/admin/partisipasi-publik', [\App\Http\Controllers\ERegulasi\AdminPartisipasiController::class, 'index'])->name('admin.partisipasi.index');
    Route::get('/admin/partisipasi-publik/{id}', [\App\Http\Controllers\ERegulasi\AdminPartisipasiController::class, 'show'])->name('admin.partisipasi.show');
    Route::get('/admin/partisipasi-publik/{id}/export-csv', [\App\Http\Controllers\ERegulasi\TanggapanController::class, 'exportCsv'])->name('admin.partisipasi.export-csv');
    Route::post('/admin/partisipasi-publik/{id}/set', [\App\Http\Controllers\ERegulasi\AdminPartisipasiController::class, 'setUjiPublik'])->name('admin.partisipasi.set');
    Route::post('/admin/partisipasi-publik/{id}/takedown', [\App\Http\Controllers\ERegulasi\AdminPartisipasiController::class, 'takedown'])->name('admin.partisipasi.takedown');
    Route::post('/admin/partisipasi-publik/{id}/selesaikan', [\App\Http\Controllers\ERegulasi\AdminPartisipasiController::class, 'selesaikan'])->name('admin.partisipasi.selesaikan');

    // Moderasi & Tindak Lanjut Tanggapan
    Route::patch('/admin/tanggapan/{tanggapan}/moderation', [\App\Http\Controllers\ERegulasi\TanggapanController::class, 'updateModeration'])->name('admin.tanggapan.moderation');
    Route::patch('/admin/tanggapan/{tanggapan}/hide', [\App\Http\Controllers\ERegulasi\TanggapanController::class, 'toggleHide'])->name('admin.tanggapan.hide');
    Route::delete('/admin/tanggapan/{tanggapan}', [\App\Http\Controllers\ERegulasi\TanggapanController::class, 'destroy'])->name('admin.tanggapan.destroy');
});

// Super Admin User Management for e-Regulasi
Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->group(function () {
    Route::post('/partisipasi-publik/{id}/masukan-count', [\App\Http\Controllers\ERegulasi\AdminPartisipasiController::class, 'adjustMasukan'])->name('admin.partisipasi.adjust-masukan');
    Route::get('/users', [\App\Http\Controllers\ERegulasi\UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [\App\Http\Controllers\ERegulasi\UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\ERegulasi\UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\ERegulasi\UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\ERegulasi\UserManagementController::class, 'update'])->name('users.update');
    Route::get('/users/{user}/reset-password', [\App\Http\Controllers\ERegulasi\UserManagementController::class, 'showResetPassword'])->name('users.reset-password.show');
    Route::post('/users/{user}/reset-password', [\App\Http\Controllers\ERegulasi\UserManagementController::class, 'resetPassword'])->name('users.reset-password');
    Route::delete('/users/{user}', [\App\Http\Controllers\ERegulasi\UserManagementController::class, 'destroy'])->name('users.destroy');
});
