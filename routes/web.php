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


Route::get('/', 'InvoiceController@showForm');
Route::post('/save', 'InvoiceController@saveInvoice');

Route::get('/invoices', 'InvoiceController@showInvoices');
Route::post('/pay', 'InvoiceController@payInvoices');
