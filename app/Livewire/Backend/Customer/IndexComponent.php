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

    public $selectedCustomers = [];
    public $selectAll = false;
    public $currentPageCustomerIds = [];

    public function mount()
    {
        // Initialize with current page customer IDs
        $this->getCurrentPageCustomerIds();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Get all customer IDs from the current page
            $this->selectedCustomers = $this->getCurrentPageCustomerIds();
        } else {
            // Remove only current page IDs from selected
            $currentPageIds = $this->getCurrentPageCustomerIds();
            $this->selectedCustomers = array_diff($this->selectedCustomers, $currentPageIds);
        }
    }

    public function updatedSelectedCustomers()
    {
        // Update selectAll checkbox based on selected items
        $currentPageIds = $this->getCurrentPageCustomerIds();
        $selectedOnCurrentPage = array_intersect($this->selectedCustomers, $currentPageIds);
        $this->selectAll = count($selectedOnCurrentPage) === count($currentPageIds);
    }

    protected function getCurrentPageCustomerIds()
    {
        if (empty($this->currentPageCustomerIds)) {
            $customers = $this->customers()->get();
            $this->currentPageCustomerIds = $customers->pluck('id')->toArray();
        }

        return $this->currentPageCustomerIds;
    }

    // Reset currentPageCustomerIds when pagination or filters change
    public function updating($property, $value)
    {
        $resetProperties = ['search', 'perPage', 'statusFilter', 'sortField', 'sortDirection'];

        if (in_array($property, $resetProperties)) {
            $this->currentPageCustomerIds = [];
            $this->selectAll = false;

            if ($property !== 'perPage') {
                $this->resetPage();
            }
        }

        if ($property === 'page') {
            $this->currentPageCustomerIds = [];
            $this->selectAll = false;
        }
    }

    /**
     * Select all customers across all pages (filtered results)
     */
    public function selectAllCustomers()
    {
        $allCustomerIds = $this->customers()
            ->pluck('id')
            ->toArray();

        $this->selectedCustomers = $allCustomerIds;

        // Check if all current page items are selected
        $currentPageIds = $this->getCurrentPageCustomerIds();
        $selectedOnCurrentPage = array_intersect($this->selectedCustomers, $currentPageIds);
        $this->selectAll = count($selectedOnCurrentPage) === count($currentPageIds);
    }

    /**
     * Delete selected customers
     */
    public function deleteSelected()
    {
        if (!empty($this->selectedCustomers)) {
            Customer::whereIn('id', $this->selectedCustomers)->delete();
            $this->selectedCustomers = [];
            $this->selectAll = false;
            $this->currentPageCustomerIds = [];
            session()->flash('success', 'Selected customers deleted successfully.');
        }
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

        // Remove from selected customers if it was selected
        if (in_array($customerId, $this->selectedCustomers)) {
            $this->selectedCustomers = array_diff($this->selectedCustomers, [$customerId]);
        }

        // Clear cached IDs
        $this->currentPageCustomerIds = [];

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

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    // Helper method to get customers query
    protected function customers()
    {
        return Customer::withCount(['sales', 'prescriptions'])
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
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        $customers = $this->customers()->paginate($this->perPage);

        return view('livewire.backend.customer.index-component', [
            'customers' => $customers,
            'paginator' => $customers,
            'pageRange' => $this->getPageRange($customers),
        ])->layout('layouts.backend.app');
    }
}
