@extends('admin.layouts.app')

@section('title', "Editanto Produto {$product->name}")

@section('content')
<h1>Editar o Produto {{ $product->name }}</h1>

    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        @include('admin.pages.products._partials.form')
    </form>
@endsection