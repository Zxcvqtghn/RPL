<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        return view('admin.staff.index', [
            'staff' => User::whereIn('role', ['admin', 'writer'])->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('admin.staff.form', ['member' => new User()]);
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('admin.staff.index')->with('status', 'Staff berhasil ditambahkan.');
    }

    public function edit(User $staff)
    {
        return view('admin.staff.form', ['member' => $staff]);
    }

    public function update(Request $request, User $staff)
    {
        $validated = $this->validated($request, $staff);
        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        $staff->update($validated);

        return redirect()->route('admin.staff.index')->with('status', 'Staff berhasil diperbarui.');
    }

    public function destroy(User $staff)
    {
        abort_if($staff->is(request()->user()), 403);
        $staff->delete();

        return redirect()->route('admin.staff.index')->with('status', 'Staff berhasil dihapus.');
    }

    private function validated(Request $request, ?User $staff = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160', 'unique:users,email,'.($staff?->id ?? 'NULL')],
            'role' => ['required', 'in:admin,writer'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => [$staff ? 'nullable' : 'required', 'confirmed', 'min:8'],
        ]);
    }
}
