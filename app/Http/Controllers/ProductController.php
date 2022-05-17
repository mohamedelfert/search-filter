<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function productList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->get('keyword') : null;
        $selectedPrice = $request->has('price') ? $request->get('price') : null;
        $selectedCategory = $request->has('category') ? $request->get('category') : null;
        $selectedTag = $request->has('tags') ? $request->get('tags') : [];

        $categories = Category::all();
        $tags = Tag::all();
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

        $products = $products->orderByDesc('id')->paginate(9);
        return view('products.products_list', compact('categories', 'tags', 'products',
            'keyword', 'selectedPrice', 'selectedCategory', 'selectedTag'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('products.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:products',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'tags' => 'required',
            'image' => 'required|url',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $request->image,
        ]);

        $product->tags()->attach($request->tags);

        session()->flash('success', 'Product Add successfully');
        return redirect()->route('products.list');
    }

    public function edit($id)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product', 'categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|unique:products,title,' . $id,
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'tags' => 'required',
            'image' => 'required|url',
        ];
        $data = $this->validate($request, $rules);

        $product = Product::findOrFail($id);
        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $request->image,
        ]);

        $product->tags()->sync($request->tags);

        session()->flash('success', 'Product Updated Successfully');
        return redirect()->route('products.list');
    }

    public function destroy(Request $request)
    {
        Product::find($request->id)->delete();
        session()->flash('success', 'Product deleted successfully');
        return redirect()->back();
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
