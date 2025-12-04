<?php

namespace App\Livewire\Backend\User;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use App\Traits\WithCustomPagination;
use Illuminate\Support\Facades\Hash;

class IndexComponent extends Component
{
    use WithPagination, WithCustomPagination;

    public $search = '';
    public $perPage = 10;
    public $roleFilter = '';
    public $statusFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $selectedUsers = [];
    public $selectAll = false;
    public $currentPageUserIds = [];

    // Modal properties
    public $showDeleteModal = false;
    public $userToDelete = null;
    public $isBulkDelete = false;

    public function mount()
    {
        // Initialize with current page user IDs
        $this->getCurrentPageUserIds();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Get all user IDs from the current page
            $this->selectedUsers = $this->getCurrentPageUserIds();
        } else {
            // Remove only current page IDs from selected
            $currentPageIds = $this->getCurrentPageUserIds();
            $this->selectedUsers = array_diff($this->selectedUsers, $currentPageIds);
        }
    }

    public function updatedSelectedUsers()
    {
        // Update selectAll checkbox based on selected items
        $currentPageIds = $this->getCurrentPageUserIds();
        $selectedOnCurrentPage = array_intersect($this->selectedUsers, $currentPageIds);
        $this->selectAll = count($selectedOnCurrentPage) === count($currentPageIds);
    }

    protected function getCurrentPageUserIds()
    {
        if (empty($this->currentPageUserIds)) {
            $users = $this->users()->get();
            $this->currentPageUserIds = $users->pluck('id')->toArray();
        }

        return $this->currentPageUserIds;
    }

    // Reset currentPageUserIds when pagination or filters change
    public function updating($property, $value)
    {
        $resetProperties = ['search', 'perPage', 'roleFilter', 'statusFilter', 'sortField', 'sortDirection'];

        if (in_array($property, $resetProperties)) {
            $this->currentPageUserIds = [];
            $this->selectAll = false;

            if ($property !== 'perPage') {
                $this->resetPage();
            }
        }

        if ($property === 'page') {
            $this->currentPageUserIds = [];
            $this->selectAll = false;
        }
    }

    /**
     * Select all users across all pages (filtered results)
     */
    public function selectAllUsers()
    {
        $allUserIds = $this->users()
            ->pluck('id')
            ->toArray();

        $this->selectedUsers = $allUserIds;

        // Check if all current page items are selected
        $currentPageIds = $this->getCurrentPageUserIds();
        $selectedOnCurrentPage = array_intersect($this->selectedUsers, $currentPageIds);
        $this->selectAll = count($selectedOnCurrentPage) === count($currentPageIds);
    }

    /**
     * Confirm deletion for a single user
     */
    public function confirmDelete($userId)
    {
        $this->userToDelete = $userId;
        $this->isBulkDelete = false;
        $this->showDeleteModal = true;
    }

    /**
     * Confirm deletion for selected users
     */
    public function confirmBulkDelete()
    {
        if (!empty($this->selectedUsers)) {
            $this->isBulkDelete = true;
            $this->showDeleteModal = true;
        }
    }

    /**
     * Close the delete modal
     */
    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->userToDelete = null;
        $this->isBulkDelete = false;
    }

    /**
     * Perform the actual deletion
     */
    public function performDelete()
    {
        // Prevent deleting the last admin
        $adminCount = User::where('role', 'admin')->count();

        if ($this->isBulkDelete && !empty($this->selectedUsers)) {
            // Check if we're trying to delete all admins
            $selectedAdmins = User::whereIn('id', $this->selectedUsers)
                ->where('role', 'admin')
                ->count();

            if ($adminCount - $selectedAdmins <= 0) {
                session()->flash('error', 'Cannot delete all admin users. At least one admin must remain.');
                $this->closeDeleteModal();
                return;
            }

            // Bulk delete selected users
            User::whereIn('id', $this->selectedUsers)->delete();
            $this->selectedUsers = [];
            $this->selectAll = false;
            $this->currentPageUserIds = [];
            session()->flash('success', 'Selected users deleted successfully.');
        } elseif ($this->userToDelete) {
            // Single user delete
            $user = User::find($this->userToDelete);

            if ($user) {
                // Check if this is the last admin
                if ($user->role === 'admin' && $adminCount === 1) {
                    session()->flash('error', 'Cannot delete the last admin user. At least one admin must remain.');
                    $this->closeDeleteModal();
                    return;
                }

                $user->delete();

                // Remove from selected users if it was selected
                if (in_array($this->userToDelete, $this->selectedUsers)) {
                    $this->selectedUsers = array_diff($this->selectedUsers, [$this->userToDelete]);
                }

                // Clear cached IDs
                $this->currentPageUserIds = [];

                session()->flash('message', 'User deleted successfully.');
            }
        }

        $this->closeDeleteModal();
    }

    public function toggleStatus($userId)
    {
        $user = User::findOrFail($userId);

        // Prevent deactivating the last active admin
        if ($user->role === 'admin' && !$user->is_active) {
            $activeAdminCount = User::where('role', 'admin')
                ->where('is_active', true)
                ->count();

            if ($activeAdminCount === 0) {
                session()->flash('error', 'Cannot deactivate the last active admin. At least one admin must remain active.');
                return;
            }
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        session()->flash('message', 'User status updated successfully.');
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

    // Helper method to get users query
    protected function users()
    {
        return User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role', $this->roleFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('is_active', $this->statusFilter === 'active');
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        $users = $this->users()->paginate($this->perPage);

        // Get user statistics
        $userStats = [
            'total' => $users->total(),
            'active' => $users->where('is_active', true)->count(),
            'admins' => $users->where('role', 'admin')->count(),
            'managers' => $users->where('role', 'manager')->count(),
        ];

        return view('livewire.backend.user.index-component', [
            'users' => $users,
            'userStats' => $userStats,
            'paginator' => $users,
            'pageRange' => $this->getPageRange($users),
        ])->layout('layouts.backend.app');
    }
}
