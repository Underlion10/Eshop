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

Route::get('/', function () {
    $categories = App\Category::all();
    return view('welcome')->with(['categories' => $categories]);
});

Route::post('/search', 'BookController@show');

Route::get('add/{id}', 'BookController@store');

Route::post('update/{id}', 'BookController@update');

Route::get('/cart', function() {
    $categories = App\Category::all();
    if (session()->has('cart'))
        if (sizeof(session('cart')) > 0)
            return view('cart')->with('categories', $categories);
        else {
            session()->remove('cart');
            return redirect()->to('/');
        }
   else {
       abort(404);
   }
});

Route::get('/buy', 'BookController@buy');

Route::post('/buy/confirm', 'BookController@confirm');
