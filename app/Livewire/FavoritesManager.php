<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoritesManager extends Component
{
    public function remove($favoriteId)
    {
        $favorite = Favorite::find($favoriteId);

        if ($favorite && $favorite->user_id === Auth::id()) {
            $favorite->delete();
            session()->flash('success', 'Product removed from favorites successfully!');
        }
    }

    public function render()
    {
        $favorites = Favorite::with('product')->where('user_id', Auth::id())->get();
        return view('livewire.favorites-manager', compact('favorites'));
    }
}
