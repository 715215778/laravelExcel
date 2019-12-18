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
Route::get('/', function (){
    return view('welcome');
});
Route::get('excel/index', 'ExcelController@index')->name('admin.excel.index');
//Route::post('excel/init', 'ExcelController@excelInit')->name('excel.init');

Route::get('test/init', 'ExcelController@test');


Route::post('excel/test', 'ExcelController@excelInit');