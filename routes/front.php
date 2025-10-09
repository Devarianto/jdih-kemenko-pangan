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
  });
});
