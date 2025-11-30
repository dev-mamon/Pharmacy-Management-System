<?php

namespace App\Livewire\Backend\Customer;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use App\Traits\WithCustomPagination;

class IndexComponent extends Component
{
    use WithPagination, WithCustomPagination;

    public $search = '';
    public $perPage = 10;
    public $statusFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function deleteCustomer($customerId)
    {
        $customer = Customer::findOrFail($customerId);

        // Check if customer has sales or prescriptions
        if ($customer->sales()->count() > 0 || $customer->prescriptions()->count() > 0) {
            session()->flash('error', 'Cannot delete customer. It has associated sales or prescription records.');
            return;
        }

        $customer->delete();
        session()->flash('message', 'Customer deleted successfully.');
    }

    public function toggleStatus($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $customer->update([
            'is_active' => !$customer->is_active
        ]);

        session()->flash('message', 'Customer status updated successfully.');
    }

    public function render()
    {
        $customers = Customer::withCount(['sales', 'prescriptions'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('customer_id', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('is_active', $this->statusFilter === 'active');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.customer.index-component', [
            'customers' => $customers,
            'paginator' => $customers,
            'pageRange' => $this->getPageRange($customers),
        ])->layout('layouts.backend.app');
    }
}
