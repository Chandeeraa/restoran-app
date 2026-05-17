<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public $name = '';

    public $email = '';

    public $password = '';

    public $role = 'waiter';

    public $userId = null;

    public $isEditMode = false;

    public function mount()
    {
        abort_if(auth()->user()->role !== 'admin', 403);
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['cashier', 'kitchen', 'waiter', 'customer'])],
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        $this->resetFields();
        session()->flash('message', 'User created successfully.');
    }

    public function edit($id)
    {
        if ($id == auth()->id()) {
            session()->flash('error', 'Gunakan menu Profile untuk mengedit akun Anda sendiri.');

            return;
        }

        $user = User::findOrFail($id);

        // Blokir edit akun Admin
        if ($user->role === 'admin') {
            session()->flash('error', 'Akun Admin tidak dapat diedit melalui halaman ini.');

            return;
        }

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = '';
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($this->userId)],
            'password' => 'nullable|string|min:8',
            'role' => ['required', Rule::in(['cashier', 'kitchen', 'waiter', 'customer'])],
        ]);

        $user = User::findOrFail($this->userId);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if (! empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        $user->update($data);

        $this->resetFields();
        session()->flash('message', 'User updated successfully.');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        // Blokir hapus diri sendiri
        if ($user->id === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');

            return;
        }

        // Blokir hapus akun Admin
        if ($user->role === 'admin') {
            session()->flash('error', 'Akun Admin tidak dapat dihapus melalui halaman ini.');

            return;
        }

        $user->delete();
        session()->flash('message', 'User berhasil dihapus.');
    }

    public function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'waiter';
        $this->userId = null;
        $this->isEditMode = false;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.user-manager', [
            'users' => User::orderByRaw("CASE WHEN role = 'admin' THEN 1 ELSE 2 END")
                ->latest()
                ->paginate(10),
        ])->layout('layouts.app', ['header' => 'Staff & Users Management']);
    }
}
