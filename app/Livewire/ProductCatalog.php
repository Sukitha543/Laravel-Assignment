<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class ProductCatalog extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedBrands = [];
    public $selectedTypes = [];

    // Reset pagination when filtering
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedBrands()
    {
        $this->resetPage();
    }

    public function updatingSelectedTypes()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Get all brands for the filter list
        $brands = Product::where('quantity', '>', 0)
            ->select('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');

        $query = Product::where('quantity', '>', 0);

        // Search Filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('brand', 'like', '%' . $this->search . '%')
                  ->orWhere('model', 'like', '%' . $this->search . '%');
            });
        }

        // Brand Filter
        if (!empty($this->selectedBrands)) {
            $query->whereIn('brand', $this->selectedBrands);
        }

        // Gender/Type Filter
        if (!empty($this->selectedTypes)) {
            $query->whereIn('type', $this->selectedTypes);
        }

        $products = $query->latest()->paginate(9);

        return view('livewire.product-catalog', [
            'products' => $products,
            'brands' => $brands,
        ]);
    }
}
