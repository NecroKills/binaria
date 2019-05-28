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


//nome, apelido,controller, metodo

Route::get('/',['as'=>'home', 'uses'=>'RedeController@index']);
Route::get('/vendedor/adicionar',['as'=>'vendedor.adicionar','uses'=>'VendedorController@adicionar']);
Route::post('/vendedor/salvar', ['as' => 'vendedor.salvar', 'uses' => 'VendedorController@salvar']);


Route::post('/rede/buscarRelatorio',['as'=>'rede.buscarRelatorio','uses'=>'RedeController@buscarRelatorio']);
Route::get('/rede/buscar/{id}',        ['as' => 'rede.buscar', 'uses' => 'RedeController@criarArvore']);
