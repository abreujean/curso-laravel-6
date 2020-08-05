<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateProductRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Storage;

class ProductController extends Controller
{   
    protected $request, $user;
    private $repository;

    public function __construct(Request $request, User $user, Product $products)
    {   
        //dd($request->prm1);
        $this->request = $request;
        $this->user = $request;
        $this->repository = $products;

        /** FILTROS DO LARAVEL **/
        /*$this->middleware('auth')->only([
            'create', 'store'
        ]);*/

        // $this->middleware('auth')->except([
        //     'index', 'show'
        // ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$teste = '<h1>Olá!</h1>';
        // $teste = 123;
        // $teste2 = 321;
        // $teste3 = [1,2,3,4,5];
        //$products = ['TV', 'Geladeira', 'Forno', 'Sofá'];

        $products = Product::paginate();
        //$products = Product::all();
        //$products = Product::get();

        return view('admin.pages.products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreUpdateProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateProductRequest $request)
    {   
        /*
        dd('ok');
        
        $request->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'nullable|min:3|max:10000',
            'photo' => 'required|image',
        ]);
        */

        /**FORMAS DE PEGAR DADOS DO FORMULÁRIO COM LARAVEL**/

        //dd($request->all());
        //dd($request->only(['name']));
        //dd($request->name);
        //dd($request->input('name', 'default'));
        //dd($request->except('_token', 'name'));

        /**FAZER UPLOAD DE ARQUIVOS COM LARAVEL**/

        //dd($request->file('photo')->isValid());

        // if ($request->file('photo')->isValid()) {
        //     //dd($request->photo->extension());
        //     //dd($request->photo->getClientOriginalName());
        //     //dd($request->file('photo')->store('products'));

        //     //nome custumizado
        //     $nameFile = $request->name . '.' . $request->photo->extension();
        //     dd($request->file('photo')->storeAs('products', $nameFile));
        // }
        $data = $request->only('name','description','price');

        if($request->hasFile('image') && $request->image->isValid()){
           $imagePath = $request->image->store('products');

           $data['image'] = $imagePath;
        }

        $this->repository->create($data);

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        //$product = Product::where('id', $id)->fist();
        //$product = Product::find($id);
        if(!$product = $this->repository->find($id))
            return redirect()->back();

        //dd($product);

        return view('admin.pages.products.show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        if(!$product = $this->repository->find($id))
            return redirect()->back();

        return view('admin.pages.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\StoreUpdateProductRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateProductRequest $request, $id)
    {   
        if(!$product = $this->repository->find($id))
            return redirect()->back();

        $data = $request->all();

        if($request->hasFile('image') && $request->image->isValid()){

            if($product->image && Storage::exists($product->image)){
                Storage::delete($product->image);
            }

            $imagePath = $request->image->store('products');
            $data['image'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $product = $this->repository->where('id', $id)->first();
        if(!$product)
            return redirect()->back();

            if($product->image && Storage::exists($product->image)){
                Storage::delete($product->image);
            }

        $product->delete();

        return redirect()->route('products.index');
    }

    /**
     * Search Products
     */
    public function search(Request $request)
    {
        $filters = $request->except('_token');

        $products = $this->repository->search($request->filter);

        return view('admin.pages.products.index', [
            'products' => $products,
            'filters' => $filters,
        ]);
    }
}