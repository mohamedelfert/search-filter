<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'tags'])->orderByDesc('id')->paginate(9);
        return view('products.index', compact('products'));
    }
}
