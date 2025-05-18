<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        $product = Product::all();
         return view('products.index',['product' => $product]);
    }
    public function create(){
        return view('products.create');
    }
    public function store(Request $request){
        // dd($request);
        $data = $request->validate([
            'name'=>'required',
            'qty'=>'required',
            'price'=>'required',
            'description'=>'required'
        ]);
        $newProduct = Product::create($data);
        return redirect(route('product.index'));
    }
    public function edit(Product $product){
        
    }
}
