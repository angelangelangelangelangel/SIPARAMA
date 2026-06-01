<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;

        $query = User::with('role');

        if ($status) {
            $query->where('status', $status);
        }

        $data = $query->latest()
                    ->paginate(10)
                    ->withQueryString();

        $roles = Role::all();

        return view('users.index', compact(
            'data',
            'roles',
            'status'
        ));
    }

    /* STORE */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'status' => $request->status,
        ]);

        logActivity(
            'Users',
            'Menambahkan user ' . $request->username
        );

        return redirect('/users')
            ->with('success', 'User berhasil ditambahkan');
    }

    /* UPDATE */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $updateData = [
            'name' => $request->name,
            'username' => $request->username,
            'role_id' => $request->role_id,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        logActivity(
            'Users',
            'Memperbarui user ' . $user->username
        );

        return redirect('/users')
            ->with('success', 'User berhasil diperbarui');
    }

    /* TOGGLE STATUS */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() == $user->id) {
            return redirect('/users')
                ->with('error', 'Tidak bisa mengubah status akun sendiri');
        }

        $newStatus = $user->status == 'Aktif'
            ? 'Nonaktif'
            : 'Aktif';

        $user->update([
            'status' => $newStatus
        ]);

        logActivity(
            'Users',
            'Mengubah status user ' . $user->username . ' menjadi ' . $newStatus
        );

        return redirect('/users')
            ->with('success', 'Status user berhasil diubah');
    }

    /* DELETE */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() == $user->id) {
            return redirect('/users')
                ->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $username = $user->username;

        $user->delete();

        logActivity(
            'Users',
            'Menghapus user ' . $username
        );

        return redirect('/users')
            ->with('success', 'User berhasil dihapus');
    }
}