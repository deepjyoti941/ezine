<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//users auth
Route::controller('users', 'UsersController');

//category
Route::get('/category', 'CategoryController@showCategory');
Route::get('/category/add-new-category', 'CategoryController@addNewCategory');
Route::post('/add-category' , 'CategoryController@addCategory');
Route::get('/category/{id}/edit', 'CategoryController@editCategory');


//magazine
Route::get('/upload-image-pdf', 'MagazineController@uploadImagePdf');
Route::get('/list-available-magazines','MagazineController@listMagazines');
Route::get('/list-magazines/{id}/edit' , 'MagazineController@editMagazine');
Route::post('/add-magazine' , 'MagazineController@addMagazine');
Route::post('/upload-image' , 'MagazineUploadsController@uploadImage');
Route::post('/upload-pdf' 	, 'MagazineUploadsController@uploadPdfFile');

//home
Route::get('/','HomeController@index');
//Route::get('/magazine-details' , 'HomeController@magazineDetails' );
Route::get('/{magazine_slug_url}/{mag_id}' , 'HomeController@magazineDetails' );
Route::get('/{magazine_slug}/{issue}/{id}' , 'HomeController@showPdf');
Route::post('/search-magazine' , 'HomeController@search');


//Route::get('login' ,'MagzineController@getmagazine');

//search based on category and magazine
Route::post('/category/get-magazines-by-category' , 'SearchController@categorySearch');
Route::post('/get-magazines' , 'SearchController@magazineSearch');
Route::post('/get-all-magazines' , 'SearchController@getAllMagazines');
