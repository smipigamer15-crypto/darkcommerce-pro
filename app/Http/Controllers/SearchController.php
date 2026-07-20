<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        
        $products = collect();
        
        if ($query) {
            $products = Product::where('is_active', true)
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhere('sku', 'like', "%{$query}%");
                })
                ->with(['brand', 'categories'])
                ->paginate(12);
                
            // Зберігаємо історію пошуку в сесії
            $history = session()->get('search_history', []);
            if (!in_array($query, $history)) {
                array_unshift($history, $query);
                $history = array_slice($history, 0, 10);
                session()->put('search_history', $history);
            }
        }
        
        $popularSearches = ['headphones', 'laptop', 'shoes', 'watch', 'keyboard', 'speaker'];
        $searchHistory = session()->get('search_history', []);

        return view('search.index', compact('products', 'query', 'popularSearches', 'searchHistory'));
    }
    
    public function suggest(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        $products = Product::where('is_active', true)
            ->where('name', 'like', "%{$query}%")
            ->select('id', 'name', 'slug', 'price', 'discount_price')
            ->take(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->final_price,
                    'url' => route('products.show', $product->slug),
                ];
            });
        
        return response()->json($products);
    }
}