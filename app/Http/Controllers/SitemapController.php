<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();

        return response()->view('sitemap', compact('products', 'categories'))
            ->header('Content-Type', 'text/xml');
    }
}