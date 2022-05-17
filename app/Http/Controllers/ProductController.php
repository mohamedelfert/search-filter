<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->get('keyword') : null;
        $selectedPrice = $request->has('price') ? $request->get('price') : null;
        $selectedCategory = $request->has('category') ? $request->get('category') : null;
        $selectedTag = $request->has('tags') ? $request->get('tags') : [];

        $categories = Category::all();
        $tags = Tag::all();
//        $products = Product::with(['category', 'tags'])->orderByDesc('id')->paginate(9); or use inRandomOrder()
        $products = Product::with(['category', 'tags']);

        if ($keyword !== null) {
            $products = $products->where('title', 'LIKE', '%' . $keyword . '%')
                ->orWhere('description', 'LIKE', '%' . $keyword . '%')
                ->orWhere('price', 'LIKE', '%' . $keyword . '%');
        }

        if ($selectedPrice != null) {
            $products = $products->when($selectedPrice, function ($query) use ($selectedPrice) {
                if ($selectedPrice == 'price_0_500') {
                    $query->whereBetween('price', [0, 500]);
                } elseif ($selectedPrice == 'price_501_1500') {
                    $query->whereBetween('price', [501, 1500]);
                } elseif ($selectedPrice == 'price_1501_3000') {
                    $query->whereBetween('price', [1501, 3000]);
                } elseif ($selectedPrice == 'price_3001_5000') {
                    $query->whereBetween('price', [3001, 5000]);
                }
            });
        }

        if ($selectedCategory != null) {
            $products = $products->whereCategoryId($selectedCategory);
        }

        if (is_array($selectedTag) && count($selectedTag) > 0) {
            $products = $products->whereHas('tags', function ($query) use ($selectedTag) {
                $query->whereIn('product_tag.tag_id', $selectedTag);
            });
        }

        $products = $products->inRandomOrder()->paginate(9);
        return view('products.index', compact('categories', 'tags', 'products',
            'keyword', 'selectedPrice', 'selectedCategory', 'selectedTag'));
    }

//    public function reset()
//    {
//        $keyword = null;
//        $selectedPrice = null;
//        $selectedCategory = null;
//        $selectedTag = [];
//
//        return redirect(route('products.index'));
//    }
}
