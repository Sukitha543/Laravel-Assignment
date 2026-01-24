<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;

class ManageOrders extends Component
{
    public $filterAccepted = false;
    public $filterUnaccepted = false; // "Not Accepted" usually means Paid/Pending
    public $filterRejected = false;
    public $filterAll = true;
    public $search = '';

    // Reset other filters when 'All' is updated
    public function updatedFilterAll($value)
    {
        if ($value) {
            $this->filterAccepted = false;
            $this->filterUnaccepted = false;
            $this->filterRejected = false;
        }
    }

    // Toggle 'All' off if a specific filter is selected
    public function updatedFilterAccepted($value)
    {
        if ($value) $this->filterAll = false;
        $this->checkAllFilterStatus();
    }

    public function updatedFilterUnaccepted($value)
    {
        if ($value) $this->filterAll = false;
        $this->checkAllFilterStatus();
    }

    public function updatedFilterRejected($value)
    {
        if ($value) $this->filterAll = false;
        $this->checkAllFilterStatus();
    }

    protected function checkAllFilterStatus()
    {
        if (!$this->filterAccepted && !$this->filterUnaccepted && !$this->filterRejected) {
            $this->filterAll = true;
        }
    }

    public function accept($orderId)
    {
        $order = Order::find($orderId);
        if ($order && $order->status !== 'accepted') {
            $order->update(['status' => 'accepted']);
            session()->flash('success', 'Order accepted successfully.');
        }
    }

    public function reject($orderId)
    {
        $order = Order::find($orderId);
        if ($order && $order->status !== 'rejected') {
            // Restore inventory
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('quantity', $item->quantity);
                }
            }

            $order->update(['status' => 'rejected']);
            session()->flash('success', 'Order rejected and inventory restocked.');
        }
    }

    public function render()
    {
        $query = Order::with(['user', 'items.product']);

        if ($this->search) {
             $query->where('id', 'like', '%' . $this->search . '%');
        }

        if (!$this->filterAll) {
            $statuses = [];
            if ($this->filterAccepted) $statuses[] = 'accepted';
            if ($this->filterUnaccepted) {
                // $statuses[] = 'paid'; // User requested to remove 'paid' from unaccepted logic
                $statuses[] = 'pending';
            }
            if ($this->filterRejected) $statuses[] = 'rejected';
            
            if (!empty($statuses)) {
                $query->whereIn('status', $statuses);
            }
        }

        return view('livewire.admin.manage-orders', [
            'orders' => $query->latest()->get()
        ]);
    }
}
