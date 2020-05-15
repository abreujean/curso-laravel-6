<?php

use Illuminate\Support\Facades\Route;

Route::resource('products', 'ProductController');

/*
Route::delete('products/{id}', 'ProductController@destroy')->name('products.destroy');
Route::put('products/{id}', 'ProductController@update')->name('products.update');
Route::get('products/{id}/edit', 'ProductController@edit')->name('products.edit');
Route::get('products/create', 'ProductController@create')->name('products.create');
Route::get('products/{id?}', 'ProductController@show')->name('products.show');
Route::get('products', 'ProductController@index')->name('products.index');
Route::post('products', 'ProductController@store')->name('products.store');
*/

Route::get('/login', function(){
    return 'login';
})->name('login');

/*
//pode passar mais de um middleware por array
Route::middleware([])->group(function (){

    Route::prefix('admin')->group(function () {

        Route::namespace('Admin')->group(function(){

            Route::name('admin.')->group(function(){

                Route::get('/dashboard', 'TesteController@teste')->name('dashboard');
        
                Route::get('/financeiro', 'TesteController@teste'->name('financeiro'));
                
                Route::get('/produtos', 'TesteController@teste')->name('produtos');

                Route::get('/',function(){
                    return redirect()->route('admin.dashboard');
                })->name('home');

            });
            
        });
    });
});
*/

Route::group([
    'middleware' => [], 
    'prerfix' => 'admin',
    'namespace' => 'Admin',
    'name' => 'admin'
], function() {

            Route::get('/dashboard', 'TesteController@teste')->name('dashboard');
        
            Route::get('/financeiro', 'TesteController@teste')->name('financeiro');
                
            Route::get('/produtos', 'TesteController@teste')->name('produtos');

            Route::get('/',function(){
                    return redirect()->route('admin.dashboard');
                })->name('home');
    });


Route::get ('redirect3', function(){
    return redirect()->route('url.name');
});

Route::get('/nome-url', function(){
    return 'Hey hey hey';
})->name('url.name');

Route::view('/view', 'welcome', ['id' => 'teste']);

Route::redirect('/redirect1', '/redirect2');

// Route::get ('redirect1', function(){
//     return redirect('/redirect2');
// });

Route::get ('redirect2', function(){
    return 'Redirect 02';
});

//é obrigatorio passar o id do produto, pode ter prefixo depois como o anterior
Route::get('/produtos/{idProduct?}', function ($idProduct =""){
    return "Produto(s) {$idProduct}";
});

//obrigatorioo nome da variavel ser igual
Route::get('/categorias/{flag}/posts', function ($flag){
    return "Posts da categoria: {$flag}";
});

Route::get('/categorias/{flag}', function ($prm1){
    return "Produtos da categoria: {$prm1}";
});

Route::match(['get', 'post'],'/match', function(){
    return 'match';
});

Route::any('/any', function(){
    return 'Any';
});

Route::post('/register', function(){
    return '';
});

Route::get('/empresa', function(){
    return 'Sobre a empresa';
});

Route::get('/contato', function(){
    return view('site.contact');
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
