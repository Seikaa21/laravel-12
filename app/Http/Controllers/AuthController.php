<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ==================== LOGIN & REGISTER ====================
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // redirect sesuai role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.users.index');
            }
            return redirect()->route('welcome');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:admin,user',
        ]);

        User::create([
            'name'   => $request->name,
            'email'  => $request->email,
            'password' => Hash::make($request->password),
            'role'   => $request->role,
            // default izin semua false
            'can_access_konten'  => false,
            'can_access_kategori'=> false,
            'can_access_profil'  => false,
        ]);

        return redirect()->route('login')->with('success', 'Berhasil mendaftar. Silakan login.');
    }

    // ==================== DASHBOARD & PROFIL ====================
    public function dashboard()
    {
        return view('dashboard');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        $user = Auth::user();
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui.');
    }

    public function logout(Request $request) 
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('welcome');
    }

    // ==================== ADMIN: MANAJEMEN USER ====================
    public function listUsers()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function togglePermission(Request $request, User $user)
    {
        $permission = $request->input('permission');

        // Validasi supaya hanya kolom yang benar yang bisa diubah
        $validPermissions = ['can_access_konten', 'can_access_kategori', 'can_access_profil'];
        if (!in_array($permission, $validPermissions)) {
            return response()->json(['error' => 'Permission tidak valid'], 400);
        }

        // toggle boolean sesuai kolom
        $user->$permission = !$user->$permission;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => "Izin $permission berhasil diperbarui",
            'value'   => $user->$permission
        ]);
    }
}
