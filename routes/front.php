<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::name('front.')->group(function () {

  Route::middleware(\App\Http\Middleware\Frontend::class)->group(function () {
    # Front Home
    Route::get('/', function () {
      $compact = [];
      return view('static.home', $compact);
    })->name('index');

    # Front Std Content
    Route::get('/content-pages', function () {
      $compact = [];
      return view('static.templates.example-template', $compact);
    })->name('content-pages');

    # Front Sample Plugin
    Route::get('/sample-plugin', function () {
      $compact = [];
      return view('static.templates.sample-plugin', $compact);
    })->name('sample-plugin');

    # About Page Landing
    Route::get('/about', function () {
      $compact = [];
      return view('static.pages.about', $compact);
    })->name('about');

    # About Visi Misi
    Route::get('/about-visimisi', function () {
      $compact = [];
      return view('static.pages.about-visimisi', $compact);
    })->name('about-visimisi');

    # About Struktur Organisasi
    Route::get('/about-struktur', function () {
      $compact = [];
      return view('static.pages.about-struktur', $compact);
    })->name('about-struktur');

    # About SOP
    Route::get('/about-sop', function () {
      $compact = [];
      return view('static.pages.about-sop', $compact);
    })->name('about-sop');

    # About Statistik
    Route::get('/about-statistik', function () {
      $compact = [];
      return view('static.pages.about-statistik', $compact);
    })->name('about-statistik');

     # About Contact Us
    Route::get('/about-contactus', function () {
      $compact = [];
      return view('static.pages.about-contactus', $compact);
    })->name('about-contactus');

    # Document Peraturan
    Route::get('/document-peraturan', function () {
      $compact = [];
      return view('static.pages.document-peraturan', $compact);
    })->name('document-peraturan');
    
  });
});
