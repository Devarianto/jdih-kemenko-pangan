<?php

use Illuminate\Support\Facades\Route;

use Cactuar\Admin\Models\Permalink;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\ContactController;

Route::group(['middleware' => ['web','front']],function() {

    if ($permalink = Permalink::active()) {
        if ($permalink->module == 'menu'){
            Route::get($permalink->permalink, [PageController::class, 'getTemplate']);
        }

        if ($permalink->module == 'information-news'){
            Route::get($permalink->permalink, [PageController::class, 'getNewsDetail']);
        }
    }

    lang::routes(function() {
        Route::get('/', [PageController::class, 'home'])->name('home');
        Route::post('/contact/submit', [ContactController::class, 'postSubmit'])->name('contact.submit');
    });
});