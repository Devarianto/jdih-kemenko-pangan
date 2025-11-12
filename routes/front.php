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

    # Document Peraturan Detail
    Route::get('/document-peraturan-detail', function () {
      $compact = [];
      return view('static.pages.document-peraturan-detail', $compact);
    })->name('document-peraturan-detail');

    # Document Monografi
    Route::get('/document-monografi', function () {
      $compact = [];
      return view('static.pages.document-monografi', $compact);
    })->name('document-monografi');

    # Document Monografi Detail
    Route::get('/document-monografi-detail', function () {
      $compact = [];
      return view('static.pages.document-monografi-detail', $compact);
    })->name('document-monografi-detail');

    # Document article
    Route::get('/document-article', function () {
      $compact = [];
      return view('static.pages.document-article', $compact);
    })->name('document-article');

    # Document article Detail
    Route::get('/document-article-detail', function () {
      $compact = [];
      return view('static.pages.document-article-detail', $compact);
    })->name('document-article-detail');

    # Document Kipling
    Route::get('/document-kipling', function () {
      $compact = [];
      return view('static.pages.document-kipling', $compact);
    })->name('document-kipling');

    # Document Kipling
    Route::get('/document-kipling-detail', function () {
      $compact = [];
      return view('static.pages.document-kipling-detail', $compact);
    })->name('document-kipling-detail');

    # Document Putusan
    Route::get('/document-putusan', function () {
      $compact = [];
      return view('static.pages.document-putusan', $compact);
    })->name('document-putusan');

    # Document Putusan Detail
    Route::get('/document-putusan-detail', function () {
      $compact = [];
      return view('static.pages.document-putusan-detail', $compact);
    })->name('document-putusan-detail');

    # Document Lainnya Kamus Hukum
    Route::get('/documentlainnya-kamus-hukum', function () {
      $compact = [];
      return view('static.pages.documentlainnya-kamus-hukum', $compact);
    })->name('documentlainnya-kamus-hukum');

    # Document Lainnya Kamus Hukum detail
    Route::get('/documentlainnya-kamus-hukum-detail', function () {
      $compact = [];
      return view('static.pages.documentlainnya-kamus-hukum-detail', $compact);
    })->name('documentlainnya-kamus-hukum-detail');

    # Document Lainnya Info grafis
    Route::get('/documentlainnya-infografis', function () {
      $compact = [];
      return view('static.pages.documentlainnya-infografis', $compact);
    })->name('documentlainnya-infografis');

    # Document Lainnya Info grafis Detail
    Route::get('/documentlainnya-infografis-detail', function () {
      $compact = [];
      return view('static.pages.documentlainnya-infografis-detail', $compact);
    })->name('documentlainnya-infografis-detail');

    # Document Lainnya Berita
    Route::get('/documentlainnya-berita', function () {
      $compact = [];
      return view('static.pages.documentlainnya-berita', $compact);
    })->name('documentlainnya-berita');

    # Document Lainnya Berita Detail
    Route::get('/documentlainnya-berita-detail', function () {
      $compact = [];
      return view('static.pages.documentlainnya-berita-detail', $compact);
    })->name('documentlainnya-berita-detail');

    # Informasi Lainnya Galeri
    Route::get('/informasi-galeri', function () {
      $compact = [];
      return view('static.pages.informasi-galeri', $compact);
    })->name('informasi-galeri');

    # Informasi Lainnya Rancangan Hukum
    Route::get('/informasi-rancangan', function () {
      $compact = [];
      return view('static.pages.informasi-rancangan', $compact);
    })->name('informasi-rancangan');

    # Dashboard
    Route::get('/dashboard', function () {
      $compact = [];
      return view('static.pages.dashboard', $compact);
    })->name('dashboard');

    # Dashboard Usulan Detail
    Route::get('/dashboard-usulan-detail', function () {
      $compact = [];
      return view('static.pages.dashboard-usulan-detail', $compact);
    })->name('dashboard-usulan-detail');

    # Dashboard Formulir Usulan Project
    Route::get('/dashboard-formulir-usulan', function () {
      $compact = [];
      return view('static.pages.dashboard-formulir-usulan', $compact);
    })->name('dashboard-formulir-usulan');

    # Dashboard Daftar Project
    Route::get('/dashboard-daftar', function () {
      $compact = [];
      return view('static.pages.dashboard-daftar', $compact);
    })->name('dashboard-daftar');

    # Dashboard Daftar Detail
    Route::get('/dashboard-daftar-detail', function () {
      $compact = [];
      return view('static.pages.dashboard-daftar-detail', $compact);
    })->name('dashboard-daftar-detail');

    # Misc 404
    Route::get('/page-404', function () {
      $compact = [];
      return view('static.pages.page-404', $compact);
    })->name('page-404');

    # Undermaintenance
    Route::get('/undermaintenance', function () {
      $compact = [];
      return view('static.pages.undermaintenance', $compact);
    })->name('undermaintenance');

    # FAQ
    Route::get('/faq', function () {
      $compact = [];
      return view('static.pages.faq', $compact);
    })->name('faq');
  });
});
