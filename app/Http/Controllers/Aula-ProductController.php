<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {   
        $products = ['Products 01','Products 02', 'Products 03'];

        return $products;
    }

    public function show($id = '')
    {  
        return "Exibindo o produto de id: {$id}";
    }

    public function create()
    {  
        return "Exibindo o form de cadasro de um novo produto";
    }

    public function edit($id)
    {  
        return "Form para editar o produto de id: {$id}";
    }

    public function store()
    {  
        return "Cadastrando um novo produto";
    }

    public function update($id)
    {  
        return "Editando o produto de id: {$id}";
    }

    public function destroy($id)
    {  
        return "Deletando o produto de id: {$id}";
    }
}
