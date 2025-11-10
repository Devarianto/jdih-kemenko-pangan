<?php

use Illuminate\Support\Facades\Route;

use Cactuar\Admin\Models\Permalink;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\AuthController;

Route::group(['middleware' => ['web','front']],function() {

    if ($permalink = Permalink::active()) {
        if ($permalink->module == 'menu'){
            Route::get($permalink->permalink, [PageController::class, 'getTemplate']);
        }

        if ($permalink->module == 'information-news'){
            Route::get($permalink->permalink, [PageController::class, 'getNewsDetail']);
        }
    }

    \Cactuar\Admin\Helpers\lang::routes(function() {
        Route::get('/', [PageController::class, 'home'])->name('home');
        Route::post('/contact/submit', [ContactController::class, 'postSubmit'])->name('contact.submit');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::post('/projects', [DashboardController::class, 'storeProject'])->middleware('auth:account')->name('projects.store');


        Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth:account')->name('dashboard');
        Route::get('/dashboard/formulir-usulan', [DashboardController::class, 'formUsulan'])->middleware('auth:account')->name('form.usulan');
        Route::get('/dashboard/detail-usulan/{id}', [DashboardController::class, 'detailUsulan'])->middleware('auth:account')->name('detail.usulan');
        Route::get('/dashboard/project', [DashboardController::class, 'listProject'])->middleware('auth:account')->name('project');
        Route::get('/dashboard/detail-project', [DashboardController::class, 'detailProject'])->middleware('auth:account')->name('detail.project');
    });
});