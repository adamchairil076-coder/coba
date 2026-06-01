<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|numeric|digits_between:10,13|unique:users,phone',
            'password' => 'required|string|confirmed|min:8',
    ], [
            'phone.digits_between' => 'Nomor HP maksimal 13 digit.',
            'phone.numeric' => 'Nomor HP hanya boleh berisi angka.',
    ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Role::firstOrCreate(['name' => 'Donatur']);

        $user->assignRole('Donatur');

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil! Silakan cek email untuk verifikasi akun, lalu login.');
    }
}