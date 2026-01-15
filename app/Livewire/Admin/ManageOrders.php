<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Request;

class ManageOrders extends Component
{
    public $filterAccepted = false;
    public $filterUnaccepted = false;
    public $filterAll = true;

    // Actions removed as per request to use controller methods.

    // Logic to enforce single selection behavior if desired, or mixed. 
    // The user requested: "checkboxes to filter orders by their acceptance status (accepted, not accepted, or all)"
    // Typically "All" overrides others. 
    public function updatedFilterAll($value)
    {
        if ($value) {
            $this->filterAccepted = false;
            $this->filterUnaccepted = false;
        }
    }

    public function updatedFilterAccepted($value)
    {
        if ($value) {
            $this->filterAll = false;
            // $this->filterUnaccepted = false; // Optional: Enforce single selection
        } else {
             // If both become unchecked, maybe default to all? logic choice
             if(!$this->filterUnaccepted) $this->filterAll = true;
        }

    }

    public function updatedFilterUnaccepted($value)
    {
        if ($value) {
            $this->filterAll = false;
        } else {
            if(!$this->filterAccepted) $this->filterAll = true;
        }
    }

    public function render()
    {
        $query = Order::with(['user', 'items.product'])
            ->whereIn('status', ['paid', 'accepted']);

        if ($this->filterAll) {
            // No extra filter
        } else {
            // If we are not in 'All' mode, look at specific checkboxes
            // If Both are checked, we show both (effectively All)
            if ($this->filterAccepted && $this->filterUnaccepted) {
                // Show both
            } elseif ($this->filterAccepted) {
                $query->where('status', 'accepted');
            } elseif ($this->filterUnaccepted) {
                $query->where('status', 'paid');
            } else {
                // Neither checked, but 'All' is unchecked? Edge case. Show nothing or everything.
                // Let's show existing query (everything) or logic below
            }
        }

        return view('livewire.admin.manage-orders', [
            'orders' => $query->latest()->get()
        ]);
    }
}
