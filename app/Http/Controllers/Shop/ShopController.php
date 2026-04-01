<?php
// app/Http/Controllers/Shop/ShopController.php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ShopController extends Controller
{
    public function home()
    {
        $categories  = Category::where('actif', 1)->orderBy('ordre')->withCount(['products' => fn($q) => $q->where('actif', 1)])->get();
        $en_vedette  = Product::with(['category','variants' => fn($q) => $q->where('actif',1)])
            ->where('actif', 1)->where('en_vedette', 1)->latest('cree_le')->take(6)->get();
        $nouveautes  = Product::with(['category','variants' => fn($q) => $q->where('actif',1)])
            ->where('actif', 1)->latest('cree_le')->take(4)->get();
        return view('shop.home', compact('categories','en_vedette','nouveautes'));
    }

    public function catalog()
    {
        $categories = Category::where('actif', 1)->orderBy('ordre')->get();
        $products   = Product::with(['category','variants' => fn($q) => $q->where('actif',1)])
            ->where('actif', 1)->orderBy('en_vedette','desc')->latest('cree_le')->paginate(12);
        return view('shop.catalog', compact('categories','products'));
    }

    public function category(string $slug)
    {
        $category   = Category::where('slug', $slug)->where('actif', 1)->firstOrFail();
        $categories = Category::where('actif', 1)->orderBy('ordre')->get();
        $products   = Product::with(['category','variants' => fn($q) => $q->where('actif',1)])
            ->where('actif', 1)->where('categorie_id', $category->id)
            ->orderBy('en_vedette','desc')->latest('cree_le')->paginate(12);
        return view('shop.catalog', compact('categories','products','category'));
    }

    public function product(string $slug)
    {
        $product    = Product::with(['category','variants' => fn($q) => $q->where('actif',1),'images'])
            ->where('slug', $slug)->where('actif', 1)->firstOrFail();
        $relacionados = Product::with(['variants' => fn($q) => $q->where('actif',1)])
            ->where('actif', 1)->where('categorie_id', $product->categorie_id)
            ->where('id', '!=', $product->id)->take(4)->get();
        return view('shop.product', compact('product','relacionados'));
    }
}
