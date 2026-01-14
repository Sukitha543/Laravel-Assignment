<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

    use App\Models\Favorite;
    use App\Models\Product;
    use Illuminate\Support\Facades\Auth;

    class FavoriteController extends Controller
    {
        public function index()
        {
            $favorites = Favorite::with('product')->where('user_id', Auth::id())->get();
            return view('favorites', compact('favorites'));
        }

        public function store(Request $request, Product $product)
        {
            $exists = Favorite::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->exists();

            if ($exists) {
                return redirect()->route('favorites.index')->with('error', 'This item has already been added to your favorites.');
            }

            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ]);

            return redirect()->route('favorites.index')->with('success', 'Product added to favorites successfully!');
        }

        public function destroy(Favorite $favorite)
        {
            if ($favorite->user_id !== Auth::id()) {
                abort(403);
            }
            
            $favorite->delete();
            return redirect()->route('favorites.index')->with('success', 'Product removed from favorites successfully!');
        }
    }
